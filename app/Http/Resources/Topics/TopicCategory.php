<?php

namespace App\Http\Resources\Topics;

use Illuminate\Http\Resources\Json\JsonResource;

class TopicCategory extends JsonResource
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
