<?php

namespace Wheesnoza\Ship24;

use Wheesnoza\Ship24\Collections\TrackerCollection;
use Wheesnoza\Ship24\Data\TrackerData;
use Wheesnoza\Ship24\Requests\GetTrackerRequest;
use Wheesnoza\Ship24\Requests\GetTrackersRequest;

class Ship24Service
{
    public function tracker(string $trackerId): TrackerData
    {
        return app(GetTrackerRequest::class)->send($trackerId);
    }

    public function trackers(): TrackerCollection
    {
        return app(GetTrackersRequest::class)->send();
    }
}
