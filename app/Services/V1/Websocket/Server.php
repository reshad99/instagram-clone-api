<?php

namespace App\Services\V1\Websocket;

use App\Traits\ApiResponse;
use Exception;
use Illuminate\Support\Facades\Log;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Tymon\JWTAuth\Facades\JWTAuth;

class Server implements MessageComponentInterface
{
    use ApiResponse;
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
                        $this->joinRoom($from, $data->room, $data->userId ?? null);
                        break;
                    case 'leave_room':
                        $this->leaveRoom($from, $data->room, $data->userId ?? null);
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
                    // Doğrulama başarılı, kullanıcıya başarılı yanıt gönderin
                    $conn->send(json_encode(['success' => 'Authenticated']));
                } else {
                    $conn->send(json_encode(['error' => 'Unauthorized']));
                    $conn->close();
                }
            } catch (Exception $e) {
                $conn->send(json_encode(['error' => 'Unauthorized']));
                $conn->close();
            }
        } else {
            $conn->send(json_encode(['error' => 'Token not provided']));
            $conn->close();
        }
    }

    private function joinRoom(ConnectionInterface $conn, $roomId, $userId)
    {
        if ($userId) {
            $this->chatRooms[$roomId][$userId] = $conn;
        }
    }

    private function leaveRoom(ConnectionInterface $conn, $roomId, $userId)
    {
        if ($userId && isset($this->chatRooms[$roomId][$userId])) {
            unset($this->chatRooms[$roomId][$userId]);
        }
    }

    private function broadcastToRoom(ConnectionInterface $from, $roomId, $message)
    {
        if (isset($this->chatRooms[$roomId])) {
            foreach ($this->chatRooms[$roomId] as $userId => $client) {
                if ($from !== $client && $client->resourceId !== $from->resourceId) {
                    $client->send(json_encode(['message' => $message]));
                }
            }
        }
    }

    private function sendDirectMessage(ConnectionInterface $from, $toUserId, $message)
    {
        if (isset($this->userConnections[$toUserId])) {
            $this->userConnections[$toUserId]->send(json_encode(['message' => $message]));
        }
    }
}