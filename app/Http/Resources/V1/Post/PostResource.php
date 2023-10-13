<?php

namespace App\Http\Resources\V1\Post;

use App\Http\Resources\V1\MediaResource;
use App\Http\Resources\V1\User\CustomerResource;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'description' => $this->description,
            'likes' => $this->likes->count(),
            'comments' => $this->comments->count(),
            'liked' => $this->liked,
            'user' => new CustomerResource($this->customer),
            'media' => MediaResource::collection($this->media)
        ];
    }
}
