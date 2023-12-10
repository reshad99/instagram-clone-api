<?php

namespace App\Http\Resources\V1\Message;

use App\Http\Resources\V1\User\CustomerResource;
use Illuminate\Http\Resources\Json\JsonResource;

class RoomResource extends JsonResource
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
            'uid' => $this->uid,
            'myMate' => new CustomerResource($this->myMate),
            'lastMessage' => new MessageResource($this->lastMessage)
        ];
    }
}
