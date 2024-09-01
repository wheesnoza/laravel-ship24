<?php

namespace Wheesnoza\Ship24\Facades;

use Illuminate\Support\Facades\Facade;
use Wheesnoza\Ship24\Collections\TrackerCollection;
use Wheesnoza\Ship24\Collections\TrackingCollection;
use Wheesnoza\Ship24\Data\CreateTracker;
use Wheesnoza\Ship24\Data\Tracker;
use Wheesnoza\Ship24\Ship24Service;

/**
 * @method static Tracker tracker(string $trackerId)
 * @method static TrackerCollection trackers(int $page, int $limit)
 * @method static Tracker createTracker(CreateTracker|string $trackerOrTrackingNumber)
 * @method static TrackingCollection createTrackerAndGetTrackingResults(CreateTracker|string $trackerOrTrackingNumber)
 * @method static TrackingCollection getTrackingResultsByTrackerId(string $trackerId)
 * @method static TrackingCollection getTrackingResultsByTrackingNumber(string $trackingNumber)
 */
class Ship24 extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return Ship24Service::class;
    }
}
