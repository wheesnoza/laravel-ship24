<?php

namespace Wheesnoza\Ship24\Data;

use Illuminate\Support\Carbon;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Attributes\WithTransformer;
use Spatie\LaravelData\Casts\DateTimeInterfaceCast;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Transformers\DateTimeInterfaceTransformer;

class Event extends Data
{
    public function __construct(
        public readonly string $eventId,
        public readonly string $trackingNumber,
        public readonly string $eventTrackingNumber,
        #[WithCast(DateTimeInterfaceCast::class, format: 'Y-m-d\TH:i:s')]
        #[WithTransformer(DateTimeInterfaceTransformer::class, format: 'Y-m-d\TH:i:s')]
        public readonly Carbon $occurrenceDatetime,
        public readonly string $statusMilestone,
        public readonly ?string $status = null,
        public readonly ?int $order = null,
        public readonly ?string $location = null,
        public readonly ?string $sourceCode = null,
        public readonly ?string $courierCode = null,
        public readonly ?string $statusCode = null,
        public readonly ?string $statusCategory = null
    ) {
    }
}
