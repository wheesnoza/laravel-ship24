<?php

namespace Wheesnoza\Ship24\Data;

use Spatie\LaravelData\Data;

class Shipment extends Data
{
    /**
     * @param array<string, string> $trackingNumbers
     */
    public function __construct(
        public readonly string $statusMilestone,
        public readonly ShipmentDelivery $delivery,
        public readonly ShipmentRecipient $recipient,
        public readonly array $trackingNumbers,
        public readonly ?string $shipmentId = null,
        public readonly ?string $statusCode = null,
        public readonly ?string $statusCategory = null,
        public readonly ?string $originCountryCode = null,
        public readonly ?string $destinationCountryCode = null
    ) {
    }
}
