<?php

namespace Wheesnoza\Ship24\Data;

use Spatie\LaravelData\Data;

final class CacheOptions extends Data
{
    public function __construct(
        public readonly bool $enabled,
        public readonly int $ttlSeconds,
        public readonly ?string $store,
        public readonly string $prefix,
    ) {
    }
}
