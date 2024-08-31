<?php

namespace Tests;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Wheesnoza\Ship24\Collections\TrackerCollection;
use Wheesnoza\Ship24\Data\CreateTrackerData;
use Wheesnoza\Ship24\Data\TrackerData;
use Wheesnoza\Ship24\Facades\Ship24;

class GetTrackerRequestTest extends TestCase
{
    public function test_should_can_retrieve_a_tracker_by_id(): void
    {
        Config::set('ship24.access_token', 'accessToken');
        Config::set('ship24.uri', 'https://api.ship24.com/public/v1');

        Http::fake([
            'https://api.ship24.com/public/v1/*' => Http::response([
                'data' => [
                    'tracker' => [
                        'trackerId' => '26148317-7502-d3ac-44a9-546d240ac0dd',
                        'trackingNumber' => 'S24DEMO456393',
                        'isSubscribed' => true,
                        'createdAt' => '2021-03-10T05:13:00.000Z',
                    ],
                ],
            ], 200),
        ]);

        $tracker = Ship24::tracker('1');

        $this->assertInstanceOf(TrackerData::class, $tracker);
    }

    public function test_should_can_retrieve_trackers(): void
    {
        Config::set('ship24.access_token', 'accessToken');
        Config::set('ship24.uri', 'https://api.ship24.com/public/v1');

        Http::fake([
            'https://api.ship24.com/public/v1/*' => Http::response([
                'data' => [
                    'trackers' => [
                        [
                            'trackerId' => '26148317-7502-d3ac-44a9-546d240ac0dd',
                             'trackingNumber' => 'S24DEMO456393',
                              'isSubscribed' => true,
                               'createdAt' => '2021-03-10T05:13:00.000Z',
                        ],
                    ],
                ],
            ], 200),
        ]);

        $trackers = Ship24::trackers();

        $this->assertInstanceOf(TrackerCollection::class, $trackers);
    }

    public function test_should_can_create_a_tracker_using_data_class(): void
    {
        Config::set('ship24.access_token', 'accessToken');
        Config::set('ship24.uri', 'https://api.ship24.com/public/v1');

        Http::fake([
            'https://api.ship24.com/public/v1/*' => Http::response([
                'data' => [
                    'tracker' => [
                        'trackerId' => '26148317-7502-d3ac-44a9-546d240ac0dd',
                        'trackingNumber' => 'S24DEMO456393',
                        'isSubscribed' => true,
                        'createdAt' => '2021-03-10T05:13:00.000Z',
                    ],
                ],
            ], 200),
        ]);

        $tracker = Ship24::createTracker(new CreateTrackerData('S24DEMO456393'));

        $this->assertInstanceOf(TrackerData::class, $tracker);
    }

    public function test_should_can_create_a_tracker_using_a_tracking_number_string(): void
    {
        Config::set('ship24.access_token', 'accessToken');
        Config::set('ship24.uri', 'https://api.ship24.com/public/v1');

        Http::fake([
            'https://api.ship24.com/public/v1/*' => Http::response([
                'data' => [
                    'tracker' => [
                        'trackerId' => '26148317-7502-d3ac-44a9-546d240ac0dd',
                        'trackingNumber' => 'S24DEMO456393',
                        'isSubscribed' => true,
                        'createdAt' => '2021-03-10T05:13:00.000Z',
                    ],
                ],
            ], 200),
        ]);

        $tracker = Ship24::createTracker('S24DEMO456393');

        $this->assertInstanceOf(TrackerData::class, $tracker);
    }
}
