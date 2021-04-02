<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
          'name' => $this->name,
          'email' => $this->email,
          'business_name' => $this->business_name,
          'description' => $this->business_description,
          'registered' => $this->created_at->diffForHumans(),
        ];
    }
}
