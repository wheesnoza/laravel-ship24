<?php

namespace Wheesnoza\Ship24\Requests;

use Wheesnoza\Ship24\Data\Tracker;

class GetTrackerRequest extends Request
{
    public function send(string $trackerId): Tracker
    {
        $response = $this->http()
            ->get($this->url("trackers/$trackerId"), $this->query())
            ->throw();

        return Tracker::from($response->json('data.tracker'));
    }
}
