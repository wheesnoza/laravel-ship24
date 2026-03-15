<?php

namespace Wheesnoza\Ship24\Data;

use Spatie\LaravelData\Data;

final class CacheKey extends Data
{
    public function __construct(public readonly string $value)
    {
    }
}
