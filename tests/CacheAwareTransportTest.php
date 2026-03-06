<?php

namespace Tests;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Psr7\Response as PsrResponse;
use PHPUnit\Framework\Attributes\CoversClass;
use Wheesnoza\Ship24\Requests\CacheAwareTransport;
use Wheesnoza\Ship24\Data\CacheEntry;
use Wheesnoza\Ship24\Data\CacheKey;
use Wheesnoza\Ship24\Data\CacheKeyInput;
use Wheesnoza\Ship24\Data\CacheOptions;
use Wheesnoza\Ship24\Repositories\CacheRepository;
use Wheesnoza\Ship24\Services\CacheKeyFactory;
use Wheesnoza\Ship24\Services\CacheOptionsResolver;
use Wheesnoza\Ship24\Services\CachePolicy;
use Wheesnoza\Ship24\Requests\RequestTransport;

#[CoversClass(CacheAwareTransport::class)]
class CacheAwareTransportTest extends TestCase
{
    public function test_returns_cached_response_on_hit(): void
    {
        $repository = new FakeCacheRepository(new CacheEntry(['data' => ['tracker' => ['id' => '1']]], 1, 1));
        $policy = new CachePolicy($this->fakeResolver(new CacheOptions(true, 300, null, 'ship24')));
        $factory = new CacheKeyFactory($this->fakeResolver(new CacheOptions(true, 300, null, 'ship24')));
        $transport = new FakeRequestTransport($this->response(['data' => ['tracker' => ['id' => 'live']]], 200));

        $cacheTransport = new CacheAwareTransport($policy, $factory, $repository, $transport);

        $response = $cacheTransport->get('https://example.test/trackers/1', []);

        $this->assertSame('1', $response->json('data.tracker.id'));
        $this->assertSame(0, $transport->calls);
    }

    public function test_calls_transport_and_stores_on_miss(): void
    {
        $repository = new FakeCacheRepository(null);
        $policy = new CachePolicy($this->fakeResolver(new CacheOptions(true, 300, null, 'ship24')));
        $factory = new CacheKeyFactory($this->fakeResolver(new CacheOptions(true, 300, null, 'ship24')));
        $transport = new FakeRequestTransport($this->response(['data' => ['tracker' => ['id' => 'live']]], 200));

        $cacheTransport = new CacheAwareTransport($policy, $factory, $repository, $transport);

        $response = $cacheTransport->get('https://example.test/trackers/1', []);

        $this->assertSame('live', $response->json('data.tracker.id'));
        $this->assertSame(1, $transport->calls);
        $this->assertSame(1, $repository->puts);
    }

    public function test_skips_cache_when_disabled(): void
    {
        $repository = new FakeCacheRepository(null);
        $policy = new CachePolicy($this->fakeResolver(new CacheOptions(false, 300, null, 'ship24')));
        $factory = new CacheKeyFactory($this->fakeResolver(new CacheOptions(false, 300, null, 'ship24')));
        $transport = new FakeRequestTransport($this->response(['data' => ['tracker' => ['id' => 'live']]], 200));

        $cacheTransport = new CacheAwareTransport($policy, $factory, $repository, $transport);

        $cacheTransport->get('https://example.test/trackers/1', []);

        $this->assertSame(1, $transport->calls);
        $this->assertSame(0, $repository->gets);
    }

    private function fakeResolver(CacheOptions $options): CacheOptionsResolver
    {
        return new class($options) extends CacheOptionsResolver {
            public function __construct(private CacheOptions $options)
            {
            }

            public function resolve(): CacheOptions
            {
                return $this->options;
            }
        };
    }

    /**
     * @param array<string, mixed> $payload
     */
    private function response(array $payload, int $status): Response
    {
        return new Response(new PsrResponse($status, [], json_encode($payload)));
    }
}

final class FakeRequestTransport extends RequestTransport
{
    public int $calls = 0;

    public function __construct(private Response $response)
    {
        parent::__construct(Http::withToken('test'));
    }

    public function get(string $url, array $payload = []): Response
    {
        $this->calls++;

        return $this->response;
    }

    public function post(string $url, array $payload = []): Response
    {
        $this->calls++;

        return $this->response;
    }
}

final class FakeCacheRepository extends CacheRepository
{
    public int $gets = 0;
    public int $puts = 0;

    public function __construct(private ?CacheEntry $entry)
    {
        parent::__construct(new class(new CacheOptions(false, 300, null, 'ship24')) extends CacheOptionsResolver {
            public function __construct(private CacheOptions $options)
            {
            }

            public function resolve(): CacheOptions
            {
                return $this->options;
            }
        });
    }

    public function get(CacheKey $key): ?CacheEntry
    {
        $this->gets++;

        return $this->entry;
    }

    public function put(CacheKey $key, CacheEntry $entry, int $ttlSeconds): void
    {
        $this->puts++;
    }
}
