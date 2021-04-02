<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            "id" => $this->id,
            "product_name" => $this->name,
            "slug" => $this->slug,
            "price" => $this->price,
            "description" => $this->description,
            "link" => route('product.show', $this->id),
            "created" => $this->created_at->diffForHumans()
        ];
    }
}
