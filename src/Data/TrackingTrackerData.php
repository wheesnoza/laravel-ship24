<?php

namespace Wheesnoza\Ship24\Data;

use Spatie\LaravelData\Data;

class TrackingTrackerData extends Data
{
    public function __construct(
        public readonly string $trackerId,
        public readonly string $trackingNumber,
        public readonly ?string $shipmentReference
    ) {
    }
}
