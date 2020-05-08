<?php

namespace App\Http\Resources\Auction;

use Illuminate\Http\Resources\Json\JsonResource;

class CharityAuction extends JsonResource
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
            'highest_bid' => $this->highest_bid | 0,
            'goal' => $this->goal | 0,
            'current_amount' => $this->current_amount | 0,
            'started_at' => $this->started_at,
            'finished_at' => $this->finished_at,
        ];
    }
}
