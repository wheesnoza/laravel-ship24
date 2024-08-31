<?php

namespace Wheesnoza\Ship24\Facades;

use Illuminate\Support\Facades\Facade;
use Wheesnoza\Ship24\Collections\TrackerCollection;
use Wheesnoza\Ship24\Data\TrackerData;
use Wheesnoza\Ship24\Ship24Service;
use Wheesnoza\Ship24\Data\CreateTrackerData;

/**
 * @method static TrackerData tracker(string $trackerId)
 * @method static TrackerCollection trackers(int $page, int $limit)
 * @method static TrackerData createTracker(CreateTrackerData|string $tracker)
 */
class Ship24 extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return Ship24Service::class;
    }
}
