<?php

namespace App\Services\V1\Websocket;

use App\Traits\ApiResponse;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Tymon\JWTAuth\Facades\JWTAuth;

class CustomServer implements MessageComponentInterface
{
    protected $clients;

    public function __construct()
    {
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $connectionInterface)
    {
        $this->clients->attach($connectionInterface);
    }

    public function onMessage(ConnectionInterface $connectionInterface, $msg)
    {

    }

    public function onClose(ConnectionInterface $connectionInterface)
    {
        $this->clients->detach($connectionInterface);

    }

    public function onError(ConnectionInterface $connectionInterface, \Exception $e)
    {
        echo 'An error has been occurred: '.$e->getMessage();
        $connectionInterface->close();
    }

}