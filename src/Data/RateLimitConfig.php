<?php

namespace Wheesnoza\Ship24\Data;

use Spatie\LaravelData\Data;

final class RateLimitConfig extends Data
{
    public function __construct(
        public readonly bool $enabled,
        public readonly int $maxAttempts,
        public readonly int $baseDelaySeconds,
        public readonly int $maxDelaySeconds,
    ) {
    }
}
