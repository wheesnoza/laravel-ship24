<?php

namespace Tests;

use Illuminate\Support\Facades\Config;
use PHPUnit\Framework\Attributes\CoversClass;
use Wheesnoza\Ship24\Exceptions\InvalidCacheConfigurationException;
use Wheesnoza\Ship24\Services\CacheOptionsResolver;

#[CoversClass(CacheOptionsResolver::class)]
class CacheOptionsResolverTest extends TestCase
{
    public function test_resolves_default_cache_options(): void
    {
        Config::set('ship24.cache', []);

        $resolver = new CacheOptionsResolver();
        $options = $resolver->resolve();

        $this->assertFalse($options->enabled);
        $this->assertSame(300, $options->ttlSeconds);
        $this->assertNull($options->store);
        $this->assertSame('ship24', $options->prefix);
    }

    public function test_resolves_custom_cache_options(): void
    {
        Config::set('ship24.cache', [
            'enabled' => true,
            'ttl_seconds' => 120,
            'store' => 'array',
            'prefix' => 'custom',
        ]);

        $resolver = new CacheOptionsResolver();
        $options = $resolver->resolve();

        $this->assertTrue($options->enabled);
        $this->assertSame(120, $options->ttlSeconds);
        $this->assertSame('array', $options->store);
        $this->assertSame('custom', $options->prefix);
    }

    public function test_throws_when_ttl_is_invalid(): void
    {
        Config::set('ship24.cache', [
            'ttl_seconds' => 0,
        ]);

        $resolver = new CacheOptionsResolver();

        $this->expectException(InvalidCacheConfigurationException::class);
        $resolver->resolve();
    }

    public function test_throws_when_store_is_not_string(): void
    {
        Config::set('ship24.cache', [
            'store' => ['array'],
        ]);

        $resolver = new CacheOptionsResolver();

        $this->expectException(InvalidCacheConfigurationException::class);
        $resolver->resolve();
    }
}
