<?php

namespace App\Http\Resources\Auction;

use Illuminate\Http\Resources\Json\JsonResource;

class AuctionObject extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
