<?php

namespace ChatApp;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use ChatApp\Entities\Message;

//require "Entities/message.php";
class Chat implements MessageComponentInterface
{
    protected $clients;

    public function __construct()
    {
        $this->clients = new \SplObjectStorage();

    }

    public function onOpen(ConnectionInterface $conn)
    {
        // Store the new connection to send messages to later
        $this->clients->attach($conn);
        echo "New Connection !({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        $msg = json_decode($msg);
        switch ($msg->type) {
            case 'message':
                foreach ($this->clients as $client) {
                    if ($client !== $from) {
                        $this->send($client,"message",$msg->text);
                    }
                }
                Message::create([
                    'text' => $msg->text,
                    'sender' =>$msg->sender
                ]);
                break;
           case 'typing':
                foreach ($this->clients as $client) {
                    if ($client !== $from) {
                        $this->send($client,"typing",$msg->sender);
                    }
                }
                break;
            default:
                break;
        }


    }


    public function onClose(ConnectionInterface $conn)
    {
        $this->clients->detach($conn);
        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "An error has occurred: {$e->getMessage()}";
        $conn->close();

    }

    public function send($client, $type, $data){
        $send = array(
            "type" => $type,
            "data" => $data
        );
        $send = json_encode($send, true);
        $client->send($send);
    }
}