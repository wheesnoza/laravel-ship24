<?php

namespace Tests;

use GuzzleHttp\Psr7\Response as Psr7Response;
use Illuminate\Http\Client\Response;
use Wheesnoza\Ship24\Data\RateLimitConfig;
use Wheesnoza\Ship24\Exceptions\RateLimitExceededException;
use Wheesnoza\Ship24\Requests\DelayStrategy;
use Wheesnoza\Ship24\Requests\RateLimitHandler;
use Wheesnoza\Ship24\Support\RateLimitState;

class RateLimitHandlerTest extends TestCase
{
    public function test_retries_on_rate_limit_and_returns_response(): void
    {
        $config = new RateLimitConfig(true, 2, 1, 10);
        $delay = new FakeDelayStrategy();
        $handler = new RateLimitHandler($config, $delay);

        $responses = [
            $this->response(429, ['Retry-After' => ['2']]),
            $this->response(200, [], ['ok' => true]),
        ];
        $index = 0;

        $response = $handler->handle(function () use (&$responses, &$index) {
            return $responses[$index++];
        });

        $this->assertSame(200, $response->status());
        $this->assertSame([2], $delay->slept);
        $this->assertNotNull(RateLimitState::latest());
    }

    public function test_throws_when_retry_disabled(): void
    {
        $config = new RateLimitConfig(false, 1, 1, 10);
        $handler = new RateLimitHandler($config, new FakeDelayStrategy());

        $this->expectException(RateLimitExceededException::class);

        $handler->handle(fn () => $this->response(429, ['Retry-After' => ['0']]));
    }

    /**
     * @param array<string, array<int, string>> $headers
     * @param array<string, mixed> $body
     */
    private function response(int $status, array $headers = [], array $body = []): Response
    {
        return new Response(
            new Psr7Response($status, $headers, json_encode($body))
        );
    }
}

class FakeDelayStrategy implements DelayStrategy
{
    /** @var list<int> */
    public array $slept = [];

    public function sleep(int $seconds): void
    {
        $this->slept[] = $seconds;
    }
}
