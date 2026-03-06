<?php

namespace Tests;

use Illuminate\Support\Facades\Cache;
use PHPUnit\Framework\Attributes\CoversClass;
use Wheesnoza\Ship24\Data\CacheEntry;
use Wheesnoza\Ship24\Data\CacheKey;
use Wheesnoza\Ship24\Data\CacheOptions;
use Wheesnoza\Ship24\Repositories\CacheRepository;
use Wheesnoza\Ship24\Services\CacheOptionsResolver;

#[CoversClass(CacheRepository::class)]
class CacheRepositoryTest extends TestCase
{
    public function test_put_and_get_returns_entry(): void
    {
        Cache::store('array')->flush();

        $resolver = $this->fakeResolver(new CacheOptions(true, 300, 'array', 'ship24'));
        $repository = new CacheRepository($resolver);

        $key = new CacheKey('ship24:test');
        $entry = new CacheEntry(['foo' => 'bar'], 1, 123);

        $repository->put($key, $entry, 60);

        $fetched = $repository->get($key);

        $this->assertInstanceOf(CacheEntry::class, $fetched);
        $this->assertSame($entry->value, $fetched->value);
    }

    public function test_returns_null_when_store_is_invalid(): void
    {
        $resolver = $this->fakeResolver(new CacheOptions(true, 300, 'missing', 'ship24'));
        $repository = new CacheRepository($resolver);

        $key = new CacheKey('ship24:test');

        $this->assertNull($repository->get($key));
        $repository->put($key, new CacheEntry(['foo' => 'bar'], 1, 1), 60);

        $this->assertTrue(true);
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
}
