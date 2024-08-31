<?php

namespace Wheesnoza\Ship24\Requests;

use Illuminate\Support\Facades\Http;
use Wheesnoza\Ship24\Data\CreateTrackerData;
use Wheesnoza\Ship24\Data\TrackerData;

class CreateTrackerRequest extends Request
{
    public function send(CreateTrackerData|string $tracker): TrackerData
    {
    	$data = $tracker instanceof CreateTrackerData ? $tracker : new CreateTrackerData($tracker);
        $response = Http::post(
            $this->url("/trackers"),
            $data->toArray(),
        )->throw();

        return TrackerData::from($response->json('data.tracker'));
    }
}
