<?php

namespace MyApp;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Users;

require __DIR__ . '/../database/users.php';
require __DIR__ . '/../database/chatrooms.php';


class Chat implements MessageComponentInterface
{
    protected $clients;

    public function __construct()
    {
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn)
    {
        // Store the new connection to send messages to later
        $this->clients->attach($conn);

        echo "New connection! ({$conn->resourceId})\n";
    }
    public function onMessage(ConnectionInterface $from, $msg)
    {
        $numRecv = count($this->clients) - 1;
        echo sprintf(
            'Connection %d sending message "%s" to %d other connection%s' . "\n",
            $from->resourceId,
            $msg,
            $numRecv,
            $numRecv == 1 ? '' : 's'
        );

        $data = json_decode($msg, true);

        // Check if userId is set
        if (!isset($data['userId'])) {
            echo "User ID is not set in message data.\n";
            return;
        }


        // save chat to database
        $objChatroom = new \chatrooms();
        $objChatroom->setUserId($data['userId']);
        $objChatroom->setMsg($data['msg']);


        if ($objChatroom->saveChatroom()) {



            // for name
            $objUser = new \Users();
            $user = $objUser->getUserByid($data['userId']);

            // Check if user is found
            if ($user) {
                $data['from'] = $user['name'] ?? 'Unknown'; // Use null coalescing operator to handle missing data
                $data['msg'] = $data['msg'] ?? 'No message'; // Use null coalescing operator to handle missing message
            } else {
                $data['from'] = 'Unknown';
                $data['msg'] = 'No user data found';
            }

            $data['dt'] = date("d-m-Y h:i:s");
        }
        foreach ($this->clients as $client) {
            if ($from !== $client) {
                // For all other clients
                $data['from'] = $user['name'] ?? 'Unknown'; // Sender's actual name for other clients
            } else {
                // For the sender
                $data['from'] = 'Me'; // Sender's view shows "Me"
            }
            $client->send(json_encode($data));
        }
    }


    public function onClose(ConnectionInterface $conn)
    {
        // The connection is closed, remove it, as we can no longer send it messages
        $this->clients->detach($conn);

        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "An error has occurred: {$e->getMessage()}\n";

        $conn->close();
    }
}
