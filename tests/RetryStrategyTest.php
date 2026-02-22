<?php

namespace Tests;

use GuzzleHttp\Psr7\Response as PsrResponse;
use Illuminate\Http\Client\Response;
use Wheesnoza\Ship24\RateLimit\RateLimitConfig;
use Wheesnoza\Ship24\RateLimit\RateLimitContext;
use Wheesnoza\Ship24\RateLimit\RetryStrategy;

class RetryStrategyTest extends TestCase
{
    public function test_uses_retry_after_when_available(): void
    {
        $config = new RateLimitConfig(true, 3, 2, 10);
        $strategy = new RetryStrategy($config);

        $response = new Response(new PsrResponse(429, ['Retry-After' => ['7']]));
        $context = RateLimitContext::fromResponse($response);

        $this->assertSame(7, $strategy->backoffSeconds(1, $context));
    }

    public function test_falls_back_to_default_backoff_when_retry_after_missing(): void
    {
        $config = new RateLimitConfig(true, 3, 5, 10);
        $strategy = new RetryStrategy($config);

        $response = new Response(new PsrResponse(429, []));
        $context = RateLimitContext::fromResponse($response);

        $this->assertSame(5, $strategy->backoffSeconds(1, $context));
    }

    public function test_should_retry_respects_max_attempts(): void
    {
        $config = new RateLimitConfig(true, 2, 1, 10);
        $strategy = new RetryStrategy($config);

        $this->assertTrue($strategy->shouldRetry(1, null));
        $this->assertFalse($strategy->shouldRetry(2, null));
    }
}
