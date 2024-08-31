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

        return TrackerCollection::make(
            $response->collect('data.trackers')
                ->map(fn ($tracker) => TrackerData::from($tracker))->all()
        );
    }
}
