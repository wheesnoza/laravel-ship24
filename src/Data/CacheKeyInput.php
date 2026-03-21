<?php

namespace Wheesnoza\Ship24\Data;

use Spatie\LaravelData\Attributes\WithTransformer;
use Spatie\LaravelData\Data;
use Wheesnoza\Ship24\Transformers\SortedArrayTransformer;

final class CacheKeyInput extends Data
{
    /**
     * @param array<string, mixed> $query
     * @param array<string, mixed> $payload
     */
    public function __construct(
        public readonly string $method,
        public readonly string $baseUri,
        public readonly string $path,
        #[WithTransformer(SortedArrayTransformer::class)]
        public readonly array $query,
        #[WithTransformer(SortedArrayTransformer::class)]
        public readonly array $payload,
    ) {
    }
}
