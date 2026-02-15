<?php

namespace Tests;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Wheesnoza\Ship24\Data\Tracker;
use Wheesnoza\Ship24\Facades\Ship24;

class RequestConfigurationTest extends TestCase
{
    public function test_requests_use_configured_base_uri_and_token(): void
    {
        Config::set('ship24.access_token', 'accessToken');
        Config::set('ship24.uri', 'https://example.test');
        $body = $this->fixture('tracker');

        Http::fake(['https://example.test/*' => Http::response($body, 200)]);

        Ship24::tracker('26148317-7502-d3ac-44a9-546d240ac0dd');

        Http::assertSent(function ($request) {
            return $request->url() === 'https://example.test/public/v1/trackers/26148317-7502-d3ac-44a9-546d240ac0dd'
                && $request->hasHeader('Authorization', 'Bearer accessToken');
        });
    }

    public function test_tracker_dto_maps_basic_fields(): void
    {
        Config::set('ship24.access_token', 'accessToken');
        $body = $this->fixture('tracker');

        Http::fake(['https://api.ship24.com/*' => Http::response($body, 200)]);

        $tracker = Ship24::tracker('26148317-7502-d3ac-44a9-546d240ac0dd');

        $this->assertInstanceOf(Tracker::class, $tracker);
        $this->assertSame('26148317-7502-d3ac-44a9-546d240ac0dd', $tracker->trackerId);
        $this->assertSame('S24DEMO456393', $tracker->trackingNumber);
    }
}
