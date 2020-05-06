<?php

namespace App\Http\Resources\Offers;

use Illuminate\Http\Resources\Json\JsonResource;

class OfferCategory extends JsonResource
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
            'label' => $this->label
        ];
    }
}
