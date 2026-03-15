<?php

namespace Wheesnoza\Ship24\Requests;

use GuzzleHttp\Psr7\Response as PsrResponse;
use Illuminate\Http\Client\Response;
use Wheesnoza\Ship24\Data\CacheEntry;
use Wheesnoza\Ship24\Data\CacheKeyInput;
use Wheesnoza\Ship24\Repositories\CacheRepository;
use Wheesnoza\Ship24\Services\CacheKeyFactory;
use Wheesnoza\Ship24\Services\CachePolicy;

class CacheAwareTransport
{
    public function __construct(
        private readonly CachePolicy $policy,
        private readonly CacheKeyFactory $keyFactory,
        private readonly CacheRepository $repository,
        private readonly RequestTransport $transport,
        private readonly ?RateLimitHandler $rateLimitHandler = null,
    ) {
    }

    /**
     * @param array<string, mixed> $query
     */
    public function get(string $url, array $query = []): Response
    {
        if (! $this->policy->isEnabled()) {
            return $this->send(fn () => $this->transport->get($url, $query));
        }

        $cacheKey = $this->keyFactory->make($this->inputFromUrl('GET', $url, $query, []));
        $cached = $this->repository->get($cacheKey);
        if ($cached) {
            return new Response(new PsrResponse(200, [], json_encode($cached->value)));
        }

        $response = $this->send(fn () => $this->transport->get($url, $query));

        if ($response->successful()) {
            $this->repository->put(
                $cacheKey,
                new CacheEntry($response->json(), 1, time()),
                $this->policy->ttlSeconds()
            );
        }

        return $response;
    }

    /**
     * @param array<string, mixed> $payload
     */
    public function post(string $url, array $payload = []): Response
    {
        return $this->send(fn () => $this->transport->post($url, $payload));
    }

    /**
     * @param array<string, mixed> $query
     * @param array<string, mixed> $payload
     */
    private function inputFromUrl(string $method, string $url, array $query, array $payload): CacheKeyInput
    {
        $parts = parse_url($url);
        $scheme = $parts['scheme'] ?? 'https';
        $host = $parts['host'] ?? '';
        $port = isset($parts['port']) ? ":{$parts['port']}" : '';
        $baseUri = "{$scheme}://{$host}{$port}";
        $path = $parts['path'] ?? '';

        return new CacheKeyInput($method, $baseUri, $path, $query, $payload);
    }

    private function send(callable $request): Response
    {
        if ($this->rateLimitHandler) {
            return $this->rateLimitHandler->handle($request);
        }

        return $request();
    }

}
