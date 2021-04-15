<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'units' => $this->units,
            'cost' => $this->total_price,
            'status' => $this->status,
            'ordered_at' => $this->created_at->diffForHumans()
        ];
    }
}
