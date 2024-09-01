<?php

namespace Wheesnoza\Ship24\Data;

use Spatie\LaravelData\Data;
use Wheesnoza\Ship24\Collections\EventCollection;

class Tracking extends Data
{
    public function __construct(
        public readonly Tracker $tracker,
        public readonly Shipment $shipment,
        public readonly EventCollection $events
    ) {
    }
}
