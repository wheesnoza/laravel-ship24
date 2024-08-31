<?php

namespace Wheesnoza\Ship24\Requests;

use Wheesnoza\Ship24\Collections\TrackerCollection;
use Wheesnoza\Ship24\Data\TrackerData;

class GetTrackersRequest extends Request
{
    public function send(int $page = 1, int $limit = 40): TrackerCollection
    {
        $response = $this->http()
            ->get($this->url("trackers"), $this->query(['page' => $page, 'limit' => $limit]))
             ->throw();

        /** @var TrackerCollection $trackers */
        $trackers = TrackerData::collect($response->collect('data.trackers'), TrackerCollection::class);

        return $trackers;
    }
}
