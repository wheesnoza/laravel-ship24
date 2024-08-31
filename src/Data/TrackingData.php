<?php

namespace Wheesnoza\Ship24\Data;

use Spatie\LaravelData\Data;

class TrackingData extends Data
{
    /**
     * @param array<int, EventData> $events
     */
    public function __construct(
        public readonly TrackingTrackerData $tracker,
        public readonly ShipmentData $shipment,
        public readonly array $events
    ) {
    }
}
