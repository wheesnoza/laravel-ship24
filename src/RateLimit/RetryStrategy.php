<?php

namespace Wheesnoza\Ship24\RateLimit;

class RetryStrategy
{
    public function __construct(private readonly RateLimitConfig $config)
    {
    }

    public function shouldRetry(int $attempt, ?RateLimitContext $context): bool
    {
        if (!$this->config->enabled) {
            return false;
        }

        return $attempt < $this->config->maxAttempts;
    }

    public function backoffSeconds(int $attempt, ?RateLimitContext $context): int
    {
        $delay = $context?->retryAfterSeconds();

        if ($delay === null) {
            $delay = $this->config->baseDelaySeconds;
        }

        if ($delay > $this->config->maxDelaySeconds) {
            return $this->config->maxDelaySeconds;
        }

        if ($delay < 0) {
            return 0;
        }

        return $delay;
    }

    public function maxAttempts(): int
    {
        return $this->config->maxAttempts;
    }
}
