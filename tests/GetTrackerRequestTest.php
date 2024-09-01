<?php

namespace Tests;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Wheesnoza\Ship24\Collections\TrackerCollection;
use Wheesnoza\Ship24\Collections\TrackingCollection;
use Wheesnoza\Ship24\Data\CreateTrackerData;
use Wheesnoza\Ship24\Data\Tracker;
use Wheesnoza\Ship24\Data\Tracking;
use Wheesnoza\Ship24\Facades\Ship24;

class GetTrackerRequestTest extends TestCase
{
    public function test_should_can_retrieve_a_tracker_by_id(): void
    {
        Config::set('ship24.access_token', 'accessToken');
        $body = file_get_contents('Fixtures/tracker.json', true);

        Http::fake(['https://api.ship24.com/*' => Http::response($body, 200),]);

        $tracker = Ship24::tracker('26148317-7502-d3ac-44a9-546d240ac0dd');

        $this->assertInstanceOf(Tracker::class, $tracker);
    }

    public function test_should_can_retrieve_trackers(): void
    {
        Config::set('ship24.access_token', 'accessToken');
        $body = file_get_contents('Fixtures/tracker.json', true);

        Http::fake(['https://api.ship24.com/*' => Http::response($body, 200)]);

        $trackers = Ship24::trackers();

        $this->assertInstanceOf(TrackerCollection::class, $trackers);
    }

    public function test_should_can_create_a_tracker_using_data_class(): void
    {
        Config::set('ship24.access_token', 'accessToken');
        $body = file_get_contents('Fixtures/tracker.json', true);

        Http::fake(['https://api.ship24.com/*' => Http::response($body, 200)]);

        $tracker = Ship24::createTracker(new CreateTrackerData('S24DEMO456393'));

        $this->assertInstanceOf(Tracker::class, $tracker);
    }

    public function test_should_can_create_a_tracker_using_a_tracking_number_string(): void
    {
        Config::set('ship24.access_token', 'accessToken');
        $body = file_get_contents('Fixtures/tracker.json', true);

        Http::fake(['https://api.ship24.com/*' => Http::response($body, 200)]);

        $tracker = Ship24::createTracker('S24DEMO456393');

        $this->assertInstanceOf(Tracker::class, $tracker);
    }

    public function test_should_can_create_a_tracker_and_get_tracking_results_using_data_class(): void
    {
        Config::set('ship24.access_token', 'accessToken');
        $body = file_get_contents('Fixtures/trackings.json', true);

        Http::fake(['https://api.ship24.com/*' => Http::response($body, 200),]);

        $trackings = Ship24::createTrackerAndGetTrackingResults(new CreateTrackerData('S24DEMO456393'));

        $this->assertInstanceOf(TrackingCollection::class, $trackings);
        $this->assertInstanceOf(Tracking::class, $tracking = $trackings->first());
    }

    public function test_should_can_create_a_tracker_and_get_tracking_results_using_tracking_number_string(): void
    {
        Config::set('ship24.access_token', 'accessToken');
        $body = file_get_contents('Fixtures/trackings.json', true);

        Http::fake(['https://api.ship24.com/*' => Http::response($body, 200),]);

        $trackings = Ship24::createTrackerAndGetTrackingResults('S24DEMO456393');

        $this->assertInstanceOf(TrackingCollection::class, $trackings);
        $this->assertInstanceOf(Tracking::class, $tracking = $trackings->first());
    }

    public function test_should_can_get_tracking_results_by_tracker_id(): void
    {
        Config::set('ship24.access_token', 'accessToken');
        $body = file_get_contents('Fixtures/trackings.json', true);

        Http::fake(['https://api.ship24.com/*' => Http::response($body, 200),]);

        $trackings = Ship24::getTrackingResultsByTrackerId('26148317-7502-d3ac-44a9-546d240ac0dd');

        $this->assertInstanceOf(TrackingCollection::class, $trackings);
        $this->assertInstanceOf(Tracking::class, $tracking = $trackings->first());
    }

    public function test_should_can_get_tracking_results_by_tracking_number(): void
    {
        Config::set('ship24.access_token', 'accessToken');
        $body = file_get_contents('Fixtures/trackings.json', true);

        Http::fake(['https://api.ship24.com/*' => Http::response($body, 200),]);

        $trackings = Ship24::getTrackingResultsByTrackingNumber('S24DEMO456393');

        $this->assertInstanceOf(TrackingCollection::class, $trackings);
        $this->assertInstanceOf(Tracking::class, $tracking = $trackings->first());
    }
}
