<?php

namespace Tests;

use PHPUnit\Framework\Attributes\CoversClass;
use Wheesnoza\Ship24\Data\CacheOptions;
use Wheesnoza\Ship24\Services\CacheOptionsResolver;
use Wheesnoza\Ship24\Services\CachePolicy;

#[CoversClass(CachePolicy::class)]
class CachePolicyTest extends TestCase
{
    public function test_returns_disabled_when_cache_is_off(): void
    {
        $options = new CacheOptions(false, 300, null, 'ship24');
        $resolver = $this->fakeResolver($options);

        $policy = new CachePolicy($resolver);

        $this->assertFalse($policy->isEnabled());
    }

    public function test_returns_cacheable_for_allowed_operations(): void
    {
        $options = new CacheOptions(true, 300, null, 'ship24');
        $resolver = $this->fakeResolver($options);

        $policy = new CachePolicy($resolver);

        $this->assertTrue($policy->isEnabled());
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
