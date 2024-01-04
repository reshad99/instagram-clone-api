<?php

namespace App\Services\V1\Websocket;

use App\Http\Resources\V1\Message\RoomResource;
use App\Models\Customer;
use App\Models\Message;
use App\Models\Room;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Support\Facades\Log;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Tymon\JWTAuth\Facades\JWTAuth;

class Server implements MessageComponentInterface
{
    protected $clients;
    protected $userConnections; // Map user IDs to connections
    protected $chatRooms; // Map room IDs to connections

    public function __construct()
    {
        $this->clients = new \SplObjectStorage;
        $this->userConnections = [];
        $this->chatRooms = [];
    }

    public function onOpen(ConnectionInterface $conn)
    {
        $this->clients->attach($conn);
        $conn->isAuthenticated = false;
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {

        $data = json_decode($msg);

        if (!$from->isAuthenticated) {
            $this->authenticateUser($from, $data);
        } else {
            if (isset($data->type)) {
                switch ($data->type) {
                    case 'join_room':
                        $this->joinRoom($from, $data->room);
                        break;
                    case 'create_room':
                        $this->createRoom($from, $data->toUserId);
                        break;
                    case 'leave_room':
                        $this->leaveRoom($from, $data->room);
                        break;
                    case 'message':
                        $this->broadcastToRoom($from, $data->room, $data->message);
                        break;
                    case 'direct_message':
                        $this->sendDirectMessage($from, $data->toUserId, $data->message);
                        break;
                    // Add other cases as needed
                }
            }
        }

    }

    public function onClose(ConnectionInterface $conn)
    {
        $this->clients->detach($conn);
        if (isset($conn->userId)) {
            unset($this->userConnections[$conn->userId]);
            // Remove user from all rooms they are part of
            foreach ($this->chatRooms as $roomId => $members) {
                unset($this->chatRooms[$roomId][$conn->resourceId]);
            }
        }
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        $conn->send(json_encode(['event' => 'Error', 'error' => $e->getMessage(), 'line' => $e->getLine()]));
        $conn->close();
    }

    private function authenticateUser(ConnectionInterface $conn, $data)
    {
        if (isset($data->token)) {
            try {
                $user = JWTAuth::setToken($data->token)->authenticate();
                if ($user) {
                    $conn->isAuthenticated = true;
                    $conn->userId = $user->id;
                    //if you want to connect only just one client side change $conn->resourceId to $conn->userId
                    $this->userConnections[$conn->resourceId] = $conn;
                    // Doğrulama başarılı, kullanıcıya başarılı yanıt gönderin
                    $conn->send(json_encode(['event' => 'Authentication', 'success' => 'Authenticated']));
                } else {
                    $conn->send(json_encode(['event' => 'Authentication', 'error' => 'Unauthorized']));
                    $conn->close();
                }
            } catch (Exception $e) {
                $conn->send(json_encode(['event' => 'Authentication', 'error' => 'Unauthorized']));
                $conn->close();
            }
        } else {
            $conn->send(json_encode(['event' => 'Authentication', 'error' => 'Token not provided']));
            $conn->close();
        }
    }

    private function joinRoom(ConnectionInterface $conn, $roomId)
    {
        $this->checkRoomPermission($conn, $roomId);

        if ($conn->userId) {
            //if you want to connect only just one client side change $conn->resourceId to $conn->userId
            $this->chatRooms[$roomId][$conn->resourceId] = $conn;
            $conn->send(json_encode(['event' => 'Joining', 'success' => 'JoinedRoom']));
        }
    }

    private function createRoom(ConnectionInterface $conn, $toUserId)
    {
        $uid = $this->generateRoom($conn->userId, $toUserId);
        Log::channel('websocket')->info('create rooma girildi');
        $checkRoom = Room::where('uid', $uid)->first();
        if ($checkRoom) {
            Log::channel('websocket')->info('checkroom tapildi');
            $uid = $checkRoom->uid;
            $conn->send(json_encode(['event' => 'RoomCreated', 'room' => new RoomResource($checkRoom)]));
        } else {
            Log::channel('websocket')->info('room generate olundu. ' . $uid);
            $room = Room::create(['uid' => $uid]);
            $room->roomMates()->attach([$conn->userId, $toUserId]);
            $conn->send(json_encode(['event' => 'RoomCreated', 'room' => new RoomResource($room)]));
        }

        $this->joinRoom($conn, $uid, $conn->userId);
    }

    private function leaveRoom(ConnectionInterface $conn, $roomId, )
    {
        if ($conn->userId && isset($this->chatRooms[$roomId][$conn->userId])) {
            unset($this->chatRooms[$roomId][$conn->userId]);
        }
    }

    private function broadcastToRoom(ConnectionInterface $from, $roomUid, $message)
    {
        if (isset($this->chatRooms[$roomUid]) && isset($this->chatRooms[$roomUid][$from->resourceId])) {
            foreach ($this->chatRooms[$roomUid] as $userId => $client) {
                if ($from !== $client && $client->resourceId !== $from->resourceId) {
                    $client->send(json_encode(['event' => 'MessageReceived', 'message' => $message, 'timeDiff' => now()->diffForHumans()]));
                    $from->send(json_encode(['event' => 'MessageSended', 'message' => $message, 'timeDiff' => now()->diffForHumans()]));
                    $roomId = Room::where('uid', $roomUid)->first()->id;
                    $this->saveMessage($message, 'text', $from->userId, null, $roomId);
                }
            }
        } else {
            throw new Exception('You are not a part of this room now. You have to join it before you write a message');
        }
    }

    private function sendDirectMessage(ConnectionInterface $from, $toUserId, $message)
    {
        if (isset($this->userConnections[$toUserId])) {
            $this->userConnections[$toUserId]->send(json_encode(['event' => 'DirectMessageReceived', 'message' => $message]));
        }

        $this->saveMessage($message, 'text', $from->userId, $toUserId);
    }

    private function checkRoomPermission(ConnectionInterface $conn, $roomId)
    {
        $room = Room::where('uid', $roomId)->first();

        if ($room) {
            Log::channel('websocket')->info('room var. room json: ' . json_encode($room));
            if (in_array($conn->userId, $room->roomMates->pluck('id')->toArray())) {
                Log::channel('websocket')->info('in array true');
                return true;
            }
        }

        $conn->send(json_encode(['event' => 'PermissionDenied', 'error' => 'You have no permission to join this room']));
        $conn->close();
    }

    private function saveMessage(string $messageText, string $messageType, int $fromUserId, int $toUserId = null, $roomId = null)
    {
        $message = new Message;
        $message->message = $messageText;
        $message->message_type = $messageType;
        $message->from_customer_id = $fromUserId;
        $message->to_customer_id = $toUserId;
        $message->room_id = $roomId;
        $message->save();
    }

    private function generateRoom($byUserId, $toUserId)
    {
        $users = [$byUserId, $toUserId];

        rsort($users);

        return "room_{$users[0]}_{$users[1]}";
    }
}
