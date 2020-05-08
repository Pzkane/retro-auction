<?php

namespace App\Http\Resources\Auction;

use Illuminate\Http\Resources\Json\JsonResource;

class CommercialAuction extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'object_id' => $this->object_id,
            'start_bid' => $this->start_bid | 0,
            'highest_bid' => $this->highest_bid | 0,
            'days_to_finish' => $this->days_to_finish | 0,
            'started_at' => $this->started_at,
            'finished_at' => $this->finished_at,
        ];
    }
}
