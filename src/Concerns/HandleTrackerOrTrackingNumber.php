<?php

namespace Wheesnoza\Ship24\Concerns;

use Wheesnoza\Ship24\Data\CreateTrackerData;

class HandleTrackerOrTrackingNumber
{
    public static function handle(CreateTrackerData|string $trackerOrTrackingNumber): CreateTrackerData
    {
        return $trackerOrTrackingNumber instanceof CreateTrackerData ? $trackerOrTrackingNumber : new CreateTrackerData($trackerOrTrackingNumber);
    }
}
