<?php

namespace App\Http\Controllers\V1\Api\Message;

use App\Http\Controllers\V1\Controller;
use App\Models\Room;
use App\Services\V1\Api\MessageService;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    protected MessageService $messageService;
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->messageService = new MessageService(auth()->guard('customer')->user());
            return $next($request);
        });
    }

    public function getRooms()
    {
        return $this->messageService->getRooms();
    }

    public function getMessages(Room $room)
    {
        return $this->messageService->getMessages($room);
    }
}
