<?php

namespace Wheesnoza\Ship24\Data;

use Spatie\LaravelData\Data;

class CreateTrackerRecipientData extends Data
{
    public function __construct(
        public string $email,
        public string $name
    ) {
    }
}
