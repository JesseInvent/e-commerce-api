<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
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
            'body' => $this->body,
            'link' => route('review.update', $this->id),
            'likes' => $this->likes()->count(),
            'replies' => ReplyResource::collection($this->replies),
            'created' => $this->created_at->diffForHumans()
        ];
    }
}
