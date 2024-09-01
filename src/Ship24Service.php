<?php

namespace Wheesnoza\Ship24;

use Wheesnoza\Ship24\Collections\TrackerCollection;
use Wheesnoza\Ship24\Collections\TrackingCollection;
use Wheesnoza\Ship24\Concerns\HandleTrackerOrTrackingNumber;
use Wheesnoza\Ship24\Data\CreateTrackerData;
use Wheesnoza\Ship24\Data\Tracker;
use Wheesnoza\Ship24\Requests\CreateTrackerAndGetTrackingResults;
use Wheesnoza\Ship24\Requests\CreateTrackerRequest;
use Wheesnoza\Ship24\Requests\GetTrackerRequest;
use Wheesnoza\Ship24\Requests\GetTrackersRequest;
use Wheesnoza\Ship24\Requests\GetTrackingResultsByTrackerIdRequest;
use Wheesnoza\Ship24\Requests\GetTrackingResultsByTrackingNumberRequest;

class Ship24Service
{
    public function tracker(string $trackerId): Tracker
    {
        return app(GetTrackerRequest::class)->send($trackerId);
    }

    public function trackers(int $page = 1, int $limit = 40): TrackerCollection
    {
        return app(GetTrackersRequest::class)->send($page, $limit);
    }

    public function createTracker(CreateTrackerData|string $trackerOrTrackingNumber): Tracker
    {
        return app(CreateTrackerRequest::class)->send(HandleTrackerOrTrackingNumber::handle($trackerOrTrackingNumber));
    }

    public function createTrackerAndGetTrackingResults(CreateTrackerData|string $trackerOrTrackingNumber): TrackingCollection
    {
        return app(CreateTrackerAndGetTrackingResults::class)->send(HandleTrackerOrTrackingNumber::handle($trackerOrTrackingNumber));
    }

    public function getTrackingResultsByTrackerId(string $trackerId): TrackingCollection
    {
        return app(GetTrackingResultsByTrackerIdRequest::class)->send($trackerId);
    }

    public function getTrackingResultsByTrackingNumber(string $trackingNumber): TrackingCollection
    {
        return app(GetTrackingResultsByTrackingNumberRequest::class)->send($trackingNumber);
    }
}
