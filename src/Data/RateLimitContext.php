<?php

namespace Wheesnoza\Ship24\Data;

use Spatie\LaravelData\Data;

final class RateLimitContext extends Data
{
    public function __construct(
        public readonly ?int $limit,
        public readonly ?int $remaining,
        public readonly ?int $resetSeconds,
        public readonly ?int $retryAfterSeconds,
        public readonly string $headerSource,
        public readonly RateLimitHeaders $headers,
    ) {
    }
}
