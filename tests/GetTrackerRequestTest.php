<?php

namespace Tests;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Wheesnoza\Ship24\Collections\TrackerCollection;
use Wheesnoza\Ship24\Collections\TrackingCollection;
use Wheesnoza\Ship24\Data\CreateTrackerData;
use Wheesnoza\Ship24\Data\TrackerData;
use Wheesnoza\Ship24\Data\TrackingData;
use Wheesnoza\Ship24\Facades\Ship24;

class GetTrackerRequestTest extends TestCase
{
    public function test_should_can_retrieve_a_tracker_by_id(): void
    {
        Config::set('ship24.access_token', 'accessToken');

        Http::fake([
            'https://api.ship24.com/*' => Http::response([
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

        Http::fake([
            'https://api.ship24.com/*' => Http::response([
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

        Http::fake([
            'https://api.ship24.com/*' => Http::response([
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

        Http::fake([
            'https://api.ship24.com/*' => Http::response([
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

    public function test_should_can_create_a_tracker_and_get_tracking_results_using_data_class(): void
    {
        Config::set('ship24.access_token', 'accessToken');

        Http::fake([
            'https://api.ship24.com/*' => Http::response([
                'data' => [
                    'trackings' => [
                        [
                            'tracker' => [
                                'trackerId' => '26148317-7502-d3ac-44a9-546d240ac0dd',
                                'trackingNumber' => 'S24DEMO456393',
                                'isSubscribed' => true,
                                'createdAt' => '2021-03-10T05:13:00.000Z',
                            ],
                            'shipment' => [
                                'shipmentId' => 'f4f888d7-d140-423f-9a48-e0689d27e098',
                                'statusCode' => 'delivery_delivered',
                                'statusCategory' => 'delivery',
                                'statusMilestone' => 'delivered',
                                'originCountryCode' => 'US',
                                'destinationCountryCode' => 'CN',
                                'delivery' => [
                                    'estimatedDeliveryDate' => null,
                                    'service' => null,
                                    'signedBy' => null,
                                ],
                                'trackingNumbers' => [
                                    [
                                        'tn' => 'S24DEMO456393',
                                    ],
                                    [
                                        'tn' => 'S24DEMO169411',
                                    ],
                                ],
                                'recipient' => [
                                    'name' => null,
                                    'address' => null,
                                    'postCode' => '94901',
                                    'city' => null,
                                    'subdivision' => null,
                                ],
                            ],
                            'events' => [
                                [
                                    'eventId' => 'ee8ebe96-4eae-4a91-9a99-8f3afa6a0f46',
                                    'trackingNumber' => 'S24DEMO169411',
                                    'eventTrackingNumber' => 'S24DEMO169411',
                                    'status' => 'Delivered to the addressee',
                                    'occurrenceDatetime' => '2021-03-04T17:12:57',
                                    'order' => null,
                                    'location' => 'SAN RAFAEL, CA 94901',
                                    'sourceCode' => 'usps-tracking',
                                    'courierCode' => 'us-post',
                                    'statusCode' => 'delivery_delivered',
                                    'statusCategory' => 'delivery',
                                    'statusMilestone' => 'delivered',
                                ],
                                [
                                    'eventId' => 'ee8ebe96-4eae-4a91-9a99-8f3afa6a00ja',
                                    'trackingNumber' => 'S24DEMO169411',
                                    'eventTrackingNumber' => 'S24DEMO169411',
                                    'status' => 'Out for Delivery',
                                    'occurrenceDatetime' => '2021-03-04T10:12:57',
                                    'order' => null,
                                    'location' => 'SAN RAFAEL, CA 94901',
                                    'sourceCode' => 'usps-tracking',
                                    'courierCode' => 'us-post',
                                    'statusCode' => 'delivery_out_for_delivery',
                                    'statusCategory' => 'delivery',
                                    'statusMilestone' => 'out_for_delivery',
                                ],
                                [
                                    'eventId' => 'ee8ebe96-4eae-4a91-9a99-8f3afa6a0765',
                                    'trackingNumber' => 'S24DEMO169411',
                                    'eventTrackingNumber' => 'S24DEMO169411',
                                    'status' => 'Arrived at Hub, Your item arrived at the hub.',
                                    'occurrenceDatetime' => '2021-03-04T06:12:57',
                                    'order' => null,
                                    'location' => 'SAN RAFAEL, CA 94901',
                                    'sourceCode' => 'usps-tracking',
                                    'courierCode' => 'us-post',
                                    'statusCode' => null,
                                    'statusCategory' => null,
                                    'statusMilestone' => 'in_transit',
                                ],
                                [
                                    'eventId' => 'ee8ebe96-4eae-4a91-9a99-8f3afa6a0f67',
                                    'trackingNumber' => 'S24DEMO169411',
                                    'eventTrackingNumber' => 'S24DEMO169411',
                                    'status' => 'Processed Through Regional Facility',
                                    'occurrenceDatetime' => '2021-03-03T17:12:57',
                                    'order' => null,
                                    'location' => 'LOS ANGELES CA INTERNATIONAL DISTRIBUTION CENTER',
                                    'sourceCode' => 'usps-tracking',
                                    'courierCode' => 'us-post',
                                    'statusCode' => null,
                                    'statusCategory' => null,
                                    'statusMilestone' => 'in_transit',
                                ],
                                [
                                    'eventId' => 'ee8ebe96-4eae-4a91-9a99-8f3afa6a0f24',
                                    'trackingNumber' => 'S24DEMO169411',
                                    'eventTrackingNumber' => 'S24DEMO169411',
                                    'status' => 'Arrived at Regional Facility',
                                    'occurrenceDatetime' => '2021-03-03T15:38:57',
                                    'order' => null,
                                    'location' => 'LOS ANGELES CA INTERNATIONAL DISTRIBUTION CENTER',
                                    'sourceCode' => 'usps-tracking',
                                    'courierCode' => 'us-post',
                                    'statusCode' => null,
                                    'statusCategory' => null,
                                    'statusMilestone' => 'in_transit',
                                ],
                                [
                                    'eventId' => '5adff7f7-c370-4026-9ff5-2ff4156ff2ff',
                                    'trackingNumber' => 'S24DEMO169411',
                                    'eventTrackingNumber' => 'S24DEMO456393',
                                    'status' => 'Flight Departure',
                                    'occurrenceDatetime' => '2021-03-02T23:24:50',
                                    'order' => null,
                                    'location' => 'Beijing airport',
                                    'sourceCode' => 'china-post-tracking',
                                    'courierCode' => 'cn-post',
                                    'statusCode' => null,
                                    'statusCategory' => null,
                                    'statusMilestone' => 'in_transit',
                                ],
                                [
                                    'eventId' => '918c20dc-9a9b-4588-bf62-ded9761d9621',
                                    'trackingNumber' => 'S24DEMO169411',
                                    'eventTrackingNumber' => 'S24DEMO456393',
                                    'status' => 'Dispatched from Office of Exchange',
                                    'occurrenceDatetime' => '2021-03-02T22:23:41',
                                    'order' => null,
                                    'location' => 'Beijing',
                                    'sourceCode' => 'china-post-tracking',
                                    'courierCode' => 'cn-post',
                                    'statusCode' => null,
                                    'statusCategory' => null,
                                    'statusMilestone' => 'in_transit',
                                ],
                                [
                                    'eventId' => 'b8dabe5f-1022-41c5-ad3a-8c8e4aacc965',
                                    'trackingNumber' => 'S24DEMO169411',
                                    'eventTrackingNumber' => 'S24DEMO456393',
                                    'status' => 'Departure from Local Sorting Center',
                                    'occurrenceDatetime' => '2021-03-02T19:24:57',
                                    'order' => null,
                                    'location' => 'Beijing',
                                    'sourceCode' => 'china-post-tracking',
                                    'courierCode' => 'cn-post',
                                    'statusCode' => null,
                                    'statusCategory' => null,
                                    'statusMilestone' => 'in_transit',
                                ],
                                [
                                    'eventId' => 'ee8ebe96-4eae-4a91-9a99-6f3afa6a0f45',
                                    'trackingNumber' => 'S24DEMO169411',
                                    'eventTrackingNumber' => 'S24DEMO456393',
                                    'status' => 'Package Received',
                                    'occurrenceDatetime' => '2021-03-02T15:38:57',
                                    'order' => null,
                                    'location' => 'Beijing',
                                    'sourceCode' => 'china-post-tracking',
                                    'courierCode' => 'cn-post',
                                    'statusCode' => null,
                                    'statusCategory' => 'transit',
                                    'statusMilestone' => 'in_transit',
                                ],
                            ],
                            'statistics' => [
                                'timestamps' => [
                                    'infoReceivedDatetime' => '2021-03-02T15:38:57',
                                    'inTransitDatetime' => '2021-03-02T15:38:57',
                                    'outForDeliveryDatetime' => '2021-03-04T10:12:57',
                                    'failedAttemptDatetime' => null,
                                    'availableForPickupDatetime' => null,
                                    'exceptionDatetime' => null,
                                    'deliveredDatetime' => '2021-03-04T17:12:57',
                                ],
                            ],
                        ],
                    ],
                ],
            ], 200),
        ]);

        $trackings = Ship24::createTrackerAndGetTrackingResults(new CreateTrackerData('S24DEMO456393'));

        $this->assertInstanceOf(TrackingCollection::class, $trackings);
        $this->assertInstanceOf(TrackingData::class, $tracking = $trackings->first());
    }

    public function test_should_can_create_a_tracker_and_get_tracking_results_using_tracking_number_string(): void
    {
        Config::set('ship24.access_token', 'accessToken');

        Http::fake([
            'https://api.ship24.com/*' => Http::response([
                'data' => [
                    'trackings' => [
                        [
                            'tracker' => [
                                'trackerId' => '26148317-7502-d3ac-44a9-546d240ac0dd',
                                'trackingNumber' => 'S24DEMO456393',
                                'isSubscribed' => true,
                                'createdAt' => '2021-03-10T05:13:00.000Z',
                            ],
                            'shipment' => [
                                'shipmentId' => 'f4f888d7-d140-423f-9a48-e0689d27e098',
                                'statusCode' => 'delivery_delivered',
                                'statusCategory' => 'delivery',
                                'statusMilestone' => 'delivered',
                                'originCountryCode' => 'US',
                                'destinationCountryCode' => 'CN',
                                'delivery' => [
                                    'estimatedDeliveryDate' => null,
                                    'service' => null,
                                    'signedBy' => null,
                                ],
                                'trackingNumbers' => [
                                    [
                                        'tn' => 'S24DEMO456393',
                                    ],
                                    [
                                        'tn' => 'S24DEMO169411',
                                    ],
                                ],
                                'recipient' => [
                                    'name' => null,
                                    'address' => null,
                                    'postCode' => '94901',
                                    'city' => null,
                                    'subdivision' => null,
                                ],
                            ],
                            'events' => [
                                [
                                    'eventId' => 'ee8ebe96-4eae-4a91-9a99-8f3afa6a0f46',
                                    'trackingNumber' => 'S24DEMO169411',
                                    'eventTrackingNumber' => 'S24DEMO169411',
                                    'status' => 'Delivered to the addressee',
                                    'occurrenceDatetime' => '2021-03-04T17:12:57',
                                    'order' => null,
                                    'location' => 'SAN RAFAEL, CA 94901',
                                    'sourceCode' => 'usps-tracking',
                                    'courierCode' => 'us-post',
                                    'statusCode' => 'delivery_delivered',
                                    'statusCategory' => 'delivery',
                                    'statusMilestone' => 'delivered',
                                ],
                                [
                                    'eventId' => 'ee8ebe96-4eae-4a91-9a99-8f3afa6a00ja',
                                    'trackingNumber' => 'S24DEMO169411',
                                    'eventTrackingNumber' => 'S24DEMO169411',
                                    'status' => 'Out for Delivery',
                                    'occurrenceDatetime' => '2021-03-04T10:12:57',
                                    'order' => null,
                                    'location' => 'SAN RAFAEL, CA 94901',
                                    'sourceCode' => 'usps-tracking',
                                    'courierCode' => 'us-post',
                                    'statusCode' => 'delivery_out_for_delivery',
                                    'statusCategory' => 'delivery',
                                    'statusMilestone' => 'out_for_delivery',
                                ],
                                [
                                    'eventId' => 'ee8ebe96-4eae-4a91-9a99-8f3afa6a0765',
                                    'trackingNumber' => 'S24DEMO169411',
                                    'eventTrackingNumber' => 'S24DEMO169411',
                                    'status' => 'Arrived at Hub, Your item arrived at the hub.',
                                    'occurrenceDatetime' => '2021-03-04T06:12:57',
                                    'order' => null,
                                    'location' => 'SAN RAFAEL, CA 94901',
                                    'sourceCode' => 'usps-tracking',
                                    'courierCode' => 'us-post',
                                    'statusCode' => null,
                                    'statusCategory' => null,
                                    'statusMilestone' => 'in_transit',
                                ],
                                [
                                    'eventId' => 'ee8ebe96-4eae-4a91-9a99-8f3afa6a0f67',
                                    'trackingNumber' => 'S24DEMO169411',
                                    'eventTrackingNumber' => 'S24DEMO169411',
                                    'status' => 'Processed Through Regional Facility',
                                    'occurrenceDatetime' => '2021-03-03T17:12:57',
                                    'order' => null,
                                    'location' => 'LOS ANGELES CA INTERNATIONAL DISTRIBUTION CENTER',
                                    'sourceCode' => 'usps-tracking',
                                    'courierCode' => 'us-post',
                                    'statusCode' => null,
                                    'statusCategory' => null,
                                    'statusMilestone' => 'in_transit',
                                ],
                                [
                                    'eventId' => 'ee8ebe96-4eae-4a91-9a99-8f3afa6a0f24',
                                    'trackingNumber' => 'S24DEMO169411',
                                    'eventTrackingNumber' => 'S24DEMO169411',
                                    'status' => 'Arrived at Regional Facility',
                                    'occurrenceDatetime' => '2021-03-03T15:38:57',
                                    'order' => null,
                                    'location' => 'LOS ANGELES CA INTERNATIONAL DISTRIBUTION CENTER',
                                    'sourceCode' => 'usps-tracking',
                                    'courierCode' => 'us-post',
                                    'statusCode' => null,
                                    'statusCategory' => null,
                                    'statusMilestone' => 'in_transit',
                                ],
                                [
                                    'eventId' => '5adff7f7-c370-4026-9ff5-2ff4156ff2ff',
                                    'trackingNumber' => 'S24DEMO169411',
                                    'eventTrackingNumber' => 'S24DEMO456393',
                                    'status' => 'Flight Departure',
                                    'occurrenceDatetime' => '2021-03-02T23:24:50',
                                    'order' => null,
                                    'location' => 'Beijing airport',
                                    'sourceCode' => 'china-post-tracking',
                                    'courierCode' => 'cn-post',
                                    'statusCode' => null,
                                    'statusCategory' => null,
                                    'statusMilestone' => 'in_transit',
                                ],
                                [
                                    'eventId' => '918c20dc-9a9b-4588-bf62-ded9761d9621',
                                    'trackingNumber' => 'S24DEMO169411',
                                    'eventTrackingNumber' => 'S24DEMO456393',
                                    'status' => 'Dispatched from Office of Exchange',
                                    'occurrenceDatetime' => '2021-03-02T22:23:41',
                                    'order' => null,
                                    'location' => 'Beijing',
                                    'sourceCode' => 'china-post-tracking',
                                    'courierCode' => 'cn-post',
                                    'statusCode' => null,
                                    'statusCategory' => null,
                                    'statusMilestone' => 'in_transit',
                                ],
                                [
                                    'eventId' => 'b8dabe5f-1022-41c5-ad3a-8c8e4aacc965',
                                    'trackingNumber' => 'S24DEMO169411',
                                    'eventTrackingNumber' => 'S24DEMO456393',
                                    'status' => 'Departure from Local Sorting Center',
                                    'occurrenceDatetime' => '2021-03-02T19:24:57',
                                    'order' => null,
                                    'location' => 'Beijing',
                                    'sourceCode' => 'china-post-tracking',
                                    'courierCode' => 'cn-post',
                                    'statusCode' => null,
                                    'statusCategory' => null,
                                    'statusMilestone' => 'in_transit',
                                ],
                                [
                                    'eventId' => 'ee8ebe96-4eae-4a91-9a99-6f3afa6a0f45',
                                    'trackingNumber' => 'S24DEMO169411',
                                    'eventTrackingNumber' => 'S24DEMO456393',
                                    'status' => 'Package Received',
                                    'occurrenceDatetime' => '2021-03-02T15:38:57',
                                    'order' => null,
                                    'location' => 'Beijing',
                                    'sourceCode' => 'china-post-tracking',
                                    'courierCode' => 'cn-post',
                                    'statusCode' => null,
                                    'statusCategory' => 'transit',
                                    'statusMilestone' => 'in_transit',
                                ],
                            ],
                            'statistics' => [
                                'timestamps' => [
                                    'infoReceivedDatetime' => '2021-03-02T15:38:57',
                                    'inTransitDatetime' => '2021-03-02T15:38:57',
                                    'outForDeliveryDatetime' => '2021-03-04T10:12:57',
                                    'failedAttemptDatetime' => null,
                                    'availableForPickupDatetime' => null,
                                    'exceptionDatetime' => null,
                                    'deliveredDatetime' => '2021-03-04T17:12:57',
                                ],
                            ],
                        ],
                    ],
                ],
            ], 200),
        ]);

        $trackings = Ship24::createTrackerAndGetTrackingResults('S24DEMO456393');

        $this->assertInstanceOf(TrackingCollection::class, $trackings);
        $this->assertInstanceOf(TrackingData::class, $tracking = $trackings->first());
    }
}
