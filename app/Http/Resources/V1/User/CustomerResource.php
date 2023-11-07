<?php

namespace App\Http\Resources\V1\User;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
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
            'username' => $this->username,
            'email' => $this->email,
            'phone' => $this->phone,
            'image' => $this->fileable?->path,
            'follower_count' => $this->followers->count(),
            'follow_count' => $this->follows->count(),
            'post_count' => $this->posts->count(),
            'thumbnail_image' => $this->fileable?->thumbnail_path,
            'followed' => $this->followed
        ];
    }
}
