<?php

namespace Wheesnoza\Ship24\Data;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapName(SnakeCaseMapper::class)]
final class CacheEntry extends Data
{
    /**
     * @param array<string, mixed> $value
     */
    public function __construct(
        public readonly array $value,
        public readonly int $version,
        public readonly int $storedAt,
    ) {}
}
