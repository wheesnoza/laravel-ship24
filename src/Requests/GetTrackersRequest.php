<?php

namespace Wheesnoza\Ship24\Requests;

use Illuminate\Support\Facades\Http;
use Wheesnoza\Ship24\Collections\TrackerCollection;
use Wheesnoza\Ship24\Data\TrackerData;

class GetTrackersRequest extends Request
{
	public function send()
	{
		$data = Http::get(
            $this->url("/trackers"),
            $this->query(),
        )->throw();

        return TrackerCollection::make($data->collect('data.trackers')->mapInto(TrackerData::class));
	}
}
