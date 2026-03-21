<?php

namespace Wheesnoza\Ship24\Repositories;

use Illuminate\Contracts\Cache\Repository;
use Illuminate\Support\Facades\Cache;
use Throwable;
use Wheesnoza\Ship24\Data\CacheEntry;
use Wheesnoza\Ship24\Data\CacheKey;
use Wheesnoza\Ship24\Data\CacheOptions;
use Wheesnoza\Ship24\Services\CacheOptionsResolver;

class CacheRepository
{
    private ?CacheOptions $options = null;

    public function __construct(
        private readonly CacheOptionsResolver $resolver,
    ) {
    }

    public function get(CacheKey $key): ?CacheEntry
    {
        try {
            $store = $this->store();
            $payload = $store->get($key->value);
            if (! is_array($payload)) {
                return null;
            }

            return CacheEntry::from($payload);
        } catch (Throwable $exception) {
            report($exception);

            return null;
        }
    }

    public function put(CacheKey $key, CacheEntry $entry, int $ttlSeconds): void
    {
        try {
            $store = $this->store();
            $store->put($key->value, $entry->toArray(), $ttlSeconds);
        } catch (Throwable $exception) {
            report($exception);
        }
    }

    private function store(): Repository
    {
        $options = $this->options();

        if ($options->store) {
            return Cache::store($options->store);
        }

        return Cache::store();
    }

    private function options(): CacheOptions
    {
        if ($this->options === null) {
            $this->options = $this->resolver->resolve();
        }

        return $this->options;
    }
}
