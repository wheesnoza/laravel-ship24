<?php

namespace Wheesnoza\Ship24\Requests;

use Illuminate\Http\Client\Response;
use Wheesnoza\Ship24\Exceptions\RateLimitExceededException;
use Wheesnoza\Ship24\RateLimit\RateLimitConfig;
use Wheesnoza\Ship24\RateLimit\RateLimitContext;
use Wheesnoza\Ship24\RateLimit\RateLimitState;
use Wheesnoza\Ship24\RateLimit\RetryStrategy;

class RateLimitHandler
{
    private RetryStrategy $strategy;

    public function __construct(
        private readonly RateLimitConfig $config,
        private readonly DelayStrategy $delayStrategy
    ) {
        $this->strategy = new RetryStrategy($this->config);
    }

    /**
     * @param callable(): Response $request
     */
    public function handle(callable $request): Response
    {
        $attempt = 1;

        while (true) {
            $response = $request();
            $context = RateLimitContext::fromResponse($response);
            RateLimitState::set($context);

            if ($response->status() !== 429) {
                return $response->throw();
            }

            if (!$this->strategy->shouldRetry($attempt, $context)) {
                throw new RateLimitExceededException($context);
            }

            $delay = $this->strategy->backoffSeconds($attempt, $context);
            $this->delayStrategy->sleep($delay);

            $attempt++;
        }
    }
}
