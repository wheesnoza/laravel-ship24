<?php

namespace Wheesnoza\Ship24\Data;

use Spatie\LaravelData\Data;

class ShipmentRecipientData extends Data
{
    public function __construct(
        public ?string $name = null,
        public ?string $address = null,
        public ?string $postCode = null,
        public ?string $city = null,
        public ?string $subdivision = null,
    ) {
    }
}
