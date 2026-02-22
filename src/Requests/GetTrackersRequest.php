<?php

namespace Wheesnoza\Ship24\Requests;

use Wheesnoza\Ship24\Collections\TrackerCollection;
use Wheesnoza\Ship24\Data\Tracker;

class GetTrackersRequest extends Request
{
    public function send(int $page = 1, int $limit = 40): TrackerCollection
    {
        $response = $this->sendWithRateLimit(fn () => $this->http()
            ->get($this->url("trackers"), $this->query(['page' => $page, 'limit' => $limit])));

        /** @var TrackerCollection $trackers */
        $trackers = Tracker::collect($response->collect('data.trackers'), TrackerCollection::class);

        return $trackers;
    }
}
