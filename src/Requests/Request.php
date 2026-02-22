<?php

namespace Wheesnoza\Ship24\Requests;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Wheesnoza\Ship24\Exceptions\RateLimitExceededException;
use Wheesnoza\Ship24\RateLimit\RateLimitConfig;
use Wheesnoza\Ship24\RateLimit\RateLimitContext;
use Wheesnoza\Ship24\RateLimit\RateLimitState;
use Wheesnoza\Ship24\RateLimit\RetryStrategy;

abstract class Request
{
    public function __construct(
        protected readonly string $accessToken,
        protected readonly string $uri,
    ) {
    }

    protected function http(): PendingRequest
    {
        return Http::withToken($this->accessToken);
    }

    /**
     * @param array<string, mixed> $extra
     * @return array<string, mixed>
     */
    protected function query(array $extra = []): array
    {
        return [
          ...$extra,
        ];
    }

    protected function url(string $path): string
    {
        return "{$this->uri}/public/v1/$path";
    }

    /**
     * @param callable(): Response $request
     */
    protected function sendWithRateLimit(callable $request): Response
    {
        $config = RateLimitConfig::fromConfig();
        $strategy = new RetryStrategy($config);
        $attempt = 1;

        while (true) {
            $response = $request();
            $context = RateLimitContext::fromResponse($response);
            RateLimitState::set($context);

            if ($response->status() !== 429) {
                return $response->throw();
            }

            if (!$strategy->shouldRetry($attempt, $context)) {
                throw new RateLimitExceededException($context);
            }

            $delay = $strategy->backoffSeconds($attempt, $context);
            if ($delay > 0) {
                sleep($delay);
            }

            $attempt++;
        }
    }
}
