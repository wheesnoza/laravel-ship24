<?php

namespace Wheesnoza\Ship24\Data;

use Spatie\LaravelData\Data;

final class RateLimitHeaders extends Data
{
    public function __construct(
        public readonly ?int $limit,
        public readonly ?int $remaining,
        public readonly ?int $reset,
        public readonly ?string $retryAfter,
    ) {
    }
}
