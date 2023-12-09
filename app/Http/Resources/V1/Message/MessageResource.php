<?php

namespace App\Http\Resources\V1\Message;

use App\Http\Resources\V1\User\CustomerResource;
use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
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
            'messageType' => $this->message_type,
            'message' => $this->message,
            'isMine' => $this->from_customer_id == auth()->user()->id ? true : false,
            'createdBy' => new CustomerResource($this->createdBy),
            'timeDiff' => $this->created_at->diffForHumans()
        ];
    }
}
