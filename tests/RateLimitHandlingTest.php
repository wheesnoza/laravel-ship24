<?php

namespace Tests;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Wheesnoza\Ship24\Exceptions\RateLimitExceededException;
use Wheesnoza\Ship24\Facades\Ship24;
use Wheesnoza\Ship24\RateLimit\RateLimitContext;

class RateLimitHandlingTest extends TestCase
{
    public function test_retries_on_rate_limit_and_returns_result(): void
    {
        Config::set('ship24.access_token', 'accessToken');
        Config::set('ship24.rate_limit.enabled', true);
        Config::set('ship24.rate_limit.max_attempts', 2);
        Config::set('ship24.rate_limit.base_delay_seconds', 0);
        Config::set('ship24.rate_limit.max_delay_seconds', 0);

        $trackerBody = $this->fixture('tracker');

        Http::fakeSequence()
            ->push([], 429, ['Retry-After' => ['0']])
            ->push($trackerBody, 200);

        $tracker = Ship24::tracker('26148317-7502-d3ac-44a9-546d240ac0dd');

        $this->assertNotNull($tracker);
        $this->assertInstanceOf(RateLimitContext::class, Ship24::rateLimit());
    }

    public function test_throws_exception_when_rate_limit_retries_disabled(): void
    {
        Config::set('ship24.access_token', 'accessToken');
        Config::set('ship24.rate_limit.enabled', false);

        Http::fake(['https://api.ship24.com/*' => Http::response([], 429, ['Retry-After' => ['0']])]);

        $this->expectException(RateLimitExceededException::class);

        Ship24::tracker('26148317-7502-d3ac-44a9-546d240ac0dd');
    }
}
