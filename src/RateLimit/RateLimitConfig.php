<?php

namespace Wheesnoza\Ship24\RateLimit;

class RateLimitConfig
{
    public function __construct(
        public readonly bool $enabled,
        public readonly int $maxAttempts,
        public readonly int $baseDelaySeconds,
        public readonly int $maxDelaySeconds,
    ) {
    }

    public static function fromConfig(): self
    {
        $enabled = config()->boolean('ship24.rate_limit.enabled', true);
        $maxAttempts = config()->integer('ship24.rate_limit.max_attempts', 3);
        $baseDelay = config()->integer('ship24.rate_limit.base_delay_seconds', 2);
        $maxDelay = config()->integer('ship24.rate_limit.max_delay_seconds', 60);

        return new self($enabled, $maxAttempts, $baseDelay, $maxDelay);
    }
}
