<?php

namespace Wheesnoza\Ship24\Data;

use Illuminate\Support\Carbon;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Attributes\WithTransformer;
use Spatie\LaravelData\Casts\DateTimeInterfaceCast;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Transformers\DateTimeInterfaceTransformer;

class ShipmentDeliveryData extends Data
{
    public function __construct(
        #[WithCast(DateTimeInterfaceCast::class, format: 'Y-m-d\TH:i:s.u\Z')]
        #[WithTransformer(DateTimeInterfaceTransformer::class, format: 'Y-m-d\TH:i:s.u\Z')]
        public readonly ?Carbon $estimatedDeliveryDate,
        public readonly ?string $service,
        public readonly ?string $signedBy,
    ) {
    }
}
