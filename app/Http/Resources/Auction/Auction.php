<?php

namespace App\Http\Resources\Auction;

use Illuminate\Http\Resources\Json\JsonResource;

class Auction extends JsonResource
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
            'started_at' => $this->started_at,
            'finished_at' => $this->finished_at,
            'status' => $this->status,
            'type' => $this->type
        ];
    }
}
