<?php

namespace Wheesnoza\Ship24\Data;

use Spatie\LaravelData\Data;

class CreateTrackerData extends Data
{
    /**
     * @param ?string[] $courierCodes
     */
    public function __construct(
        public readonly string $trackingNumber,
        public ?string $shipmentReference = null,
        public ?string $originCountryCode = null,
        public ?string $destinationCountryCode = null,
        public ?string $destinationPostCode = null,
        public ?string $shippingDate = null,
        public ?array $courierCode = null,
        public ?string $courierName = null,
        public ?string $trackingUrl = null,
        public ?string $orderNumber = null,
        public ?string $title = null,
        public ?CreateTrackerRecipientData $recipient = null
    ) {
    }
}
