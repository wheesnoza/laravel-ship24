<?php

namespace Wheesnoza\Ship24\Data;

use Illuminate\Support\Carbon;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Attributes\WithTransformer;
use Spatie\LaravelData\Casts\DateTimeInterfaceCast;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Transformers\DateTimeInterfaceTransformer;

class TrackerData extends Data
{
    public function __construct(
        public readonly string $trackerId,
        public readonly string $trackingNumber,
        public readonly string $isSubscribed,
        #[WithCast(DateTimeInterfaceCast::class, format: 'Y-m-d\TH:i:s.u\Z')]
        #[WithTransformer(DateTimeInterfaceTransformer::class, format: 'Y-m-d\TH:i:s.u\Z')]
        public readonly Carbon $createdAt
    ) {
    }
}
