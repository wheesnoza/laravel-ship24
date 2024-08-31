<?php

namespace Wheesnoza\Ship24\Facades;

use Illuminate\Support\Facades\Facade;
use Wheesnoza\Ship24\Collections\TrackerCollection;
use Wheesnoza\Ship24\Collections\TrackingCollection;
use Wheesnoza\Ship24\Data\CreateTrackerData;
use Wheesnoza\Ship24\Data\TrackerData;
use Wheesnoza\Ship24\Ship24Service;

/**
 * @method static TrackerData tracker(string $trackerId)
 * @method static TrackerCollection trackers(int $page, int $limit)
 * @method static TrackerData createTracker(CreateTrackerData|string $trackerOrTrackingNumber)
 * @method static TrackingCollection createTrackerAndGetTrackingResults(CreateTrackerData|string $trackerOrTrackingNumber)
 */
class Ship24 extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return Ship24Service::class;
    }
}
