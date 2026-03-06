<?php

namespace Tests;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use PHPUnit\Framework\Attributes\CoversClass;
use Wheesnoza\Ship24\Data\Tracker;
use Wheesnoza\Ship24\Facades\Ship24;
use Wheesnoza\Ship24\Data\CacheEntry;
use Wheesnoza\Ship24\Data\CacheKeyInput;
use Wheesnoza\Ship24\Services\CacheKeyFactory;
use Wheesnoza\Ship24\Services\CacheOptionsResolver;

#[CoversClass(Ship24::class)]
class CacheDtoCompatibilityTest extends TestCase
{
    public function test_tracker_returns_dto_from_cache(): void
    {
        $trackerId = '26148317-7502-d3ac-44a9-546d240ac0dd';

        Config::set('ship24.access_token', 'accessToken');
        Config::set('ship24.uri', 'https://example.test');
        Config::set('ship24.cache', [
            'enabled' => true,
            'ttl_seconds' => 300,
            'store' => 'array',
            'prefix' => 'ship24',
        ]);

        Cache::store('array')->flush();

        $payload = json_decode($this->fixture('tracker'), true);
        $factory = new CacheKeyFactory(new CacheOptionsResolver());
        $input = new CacheKeyInput(
            'GET',
            'https://example.test',
            "/public/v1/trackers/{$trackerId}",
            [],
            []
        );
        $key = $factory->make($input);

        $entry = new CacheEntry($payload, 1, time());
        Cache::store('array')->put($key->value, $entry->toArray(), 300);

        Http::fake();

        $tracker = Ship24::tracker($trackerId);

        $this->assertInstanceOf(Tracker::class, $tracker);
        $this->assertSame($trackerId, $tracker->trackerId);
        Http::assertNothingSent();
    }
}
