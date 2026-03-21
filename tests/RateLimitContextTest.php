<?php

namespace Tests;

use GuzzleHttp\Psr7\Response as PsrResponse;
use Illuminate\Http\Client\Response;
use Wheesnoza\Ship24\Requests\RateLimitContextFactory;

class RateLimitContextTest extends TestCase
{
    public function test_reads_standard_ratelimit_headers(): void
    {
        $response = new Response(new PsrResponse(200, [
            'RateLimit-Limit' => ['200'],
            'RateLimit-Remaining' => ['150'],
            'RateLimit-Reset' => ['12'],
            'Retry-After' => ['5'],
        ]));

        $context = $this->factory()->fromResponse($response);

        $this->assertSame(200, $context->limit);
        $this->assertSame(150, $context->remaining);
        $this->assertSame(12, $context->resetSeconds);
        $this->assertSame(5, $context->retryAfterSeconds);
        $this->assertSame('ratelimit', $context->headerSource);
        $this->assertSame(200, $context->headers->limit);
        $this->assertSame('5', $context->headers->retryAfter);
    }

    public function test_handles_invalid_retry_after_as_null(): void
    {
        $response = new Response(new PsrResponse(200, [
            'Retry-After' => ['Wed, 21 Oct 2015 07:28:00 GMT'],
        ]));

        $context = $this->factory()->fromResponse($response);

        $this->assertNull($context->retryAfterSeconds);
    }

    public function test_exposes_rate_limit_headers_dto(): void
    {
        $response = new Response(new PsrResponse(200, [
            'RateLimit-Limit' => ['200'],
            'RateLimit-Remaining' => ['150'],
            'Retry-After' => ['5'],
        ]));

        $context = $this->factory()->fromResponse($response);

        $this->assertSame(200, $context->headers->limit);
        $this->assertSame(150, $context->headers->remaining);
        $this->assertSame('5', $context->headers->retryAfter);
    }

    public function test_handles_missing_headers(): void
    {
        $response = new Response(new PsrResponse(200, []));

        $context = $this->factory()->fromResponse($response);

        $this->assertNull($context->limit);
        $this->assertNull($context->remaining);
        $this->assertNull($context->resetSeconds);
        $this->assertSame('none', $context->headerSource);
    }

    private function factory(): RateLimitContextFactory
    {
        return new RateLimitContextFactory();
    }
}
