<?php

namespace Wheesnoza\Ship24\Services;

use Illuminate\Support\Facades\Config;
use Wheesnoza\Ship24\Data\CacheOptions;
use Wheesnoza\Ship24\Exceptions\InvalidCacheConfigurationException;

class CacheOptionsResolver
{
    public function resolve(): CacheOptions
    {
        $keyPrefix = 'ship24.cache';

        $enabled = Config::boolean(sprintf('%s.enabled', $keyPrefix), false);
        $ttlSeconds = Config::integer(
            sprintf('%s.ttl_seconds', $keyPrefix),
            300,
        );
        $store = Config::get(sprintf('%s.store', $keyPrefix), null);
        if ($store !== null && ! is_string($store)) {
            throw new InvalidCacheConfigurationException(
                'Cache store must be a string or null.',
            );
        }

        $prefix = Config::string(sprintf('%s.prefix', $keyPrefix), 'ship24');
        if ($ttlSeconds <= 0) {
            throw new InvalidCacheConfigurationException(
                'Cache TTL must be a positive integer.',
            );
        }

        return new CacheOptions(
            $enabled,
            $ttlSeconds,
            $store,
            $prefix,
        );
    }
}
