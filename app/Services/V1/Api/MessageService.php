<?php

namespace App\Services\V1\Api;

use App\Http\Resources\V1\Message\MessageResource;
use App\Http\Resources\V1\Message\RoomResource;
use App\Models\Customer;
use App\Models\Room;
use App\Services\V1\CommonService;
use App\Traits\ApiResponse;

class MessageService extends CommonService
{
    use ApiResponse;
    protected Customer $customer;
    public function __construct(Customer $customer)
    {
        parent::__construct(null, [], 'message');
        $this->customer = $customer;
    }

    public function getRooms()
    {
        try {
            $rooms = Room::all();
            $rooms = $rooms->filter(function ($room) {
                $roomMatesIds = $room->roomMates->pluck('id')->toArray();
                if (in_array($this->customer->id, $roomMatesIds)) {
                    return true;
                }
                return false;
            });

            return $this->dataResponse('Rooms', RoomResource::collection($rooms));
        } catch (\Exception $e) {
            $this->logError($e);
            throw $e;
        }
    }

    public function getMessages(Room $room)
    {
        try {
            $messages = $room->messages;
            return $this->dataResponse('Rooms', MessageResource::collection($messages));
        } catch (\Exception $e) {
            $this->logError($e);
            throw $e;
        }
    }
}
