<?php

namespace Wheesnoza\Ship24\Data;

use Spatie\LaravelData\Data;
use Wheesnoza\Ship24\Collections\EventCollection;

class TrackingData extends Data
{
    public function __construct(
        public readonly TrackingTrackerData $tracker,
        public readonly ShipmentData $shipment,
        public readonly EventCollection $events
    ) {
    }
}
