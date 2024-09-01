<?php

namespace Wheesnoza\Ship24\Requests;

use Wheesnoza\Ship24\Collections\TrackingCollection;
use Wheesnoza\Ship24\Data\TrackingData;

class GetTrackingResultsByTrackerIdRequest extends Request
{
    public function send(string $trackerId): TrackingCollection
    {
        $response = $this->http()
            ->get($this->url("trackers/$trackerId/results"), $this->query())
            ->throw();

        /** @var TrackingCollection $trackings */
        $trackings = TrackingData::collect($response->collect('data.trackings'), TrackingCollection::class);

        return $trackings;
    }
}
