<?php

namespace Wheesnoza\Ship24\Requests;

use Wheesnoza\Ship24\Data\TrackerData;
use Illuminate\Support\Facades\Http;

class GetTrackerRequest extends Request
{
    public function send(string $id): TrackerData
    {
        $data = Http::get(
            $this->url("trackers/$id"),
            $this->query(),
        )->throw();

        return TrackerData::from($data->json('data.tracker'));
    }
}