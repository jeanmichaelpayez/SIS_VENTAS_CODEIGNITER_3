// application/libraries/WebSocketServer.php
<?php
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class WebSocketServer implements MessageComponentInterface {
    protected $clients;
    protected $users = [];

    public function __construct() {
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn) {
        $this->clients->attach($conn);
        echo "Nueva conexión: {$conn->resourceId}\n";
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        $data = json_decode($msg);
        
        if ($data->type === 'register') {
            // Registrar usuario
            $this->users[$data->userId] = $from;
        } else if ($data->type === 'message') {
            // Enviar mensaje
            if (isset($this->users[$data->to])) {
                $this->users[$data->to]->send(json_encode([
                    'type' => 'message',
                    'from' => $data->from,
                    'message' => $data->message,
                    'timestamp' => date('Y-m-d H:i:s')
                ]));
            }
        }
    }

    public function onClose(ConnectionInterface $conn) {
        $this->clients->detach($conn);
        // Eliminar usuario de la lista
        foreach ($this->users as $userId => $connection) {
            if ($connection === $conn) {
                unset($this->users[$userId]);
                break;
            }
        }
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "Error: {$e->getMessage()}\n";
        $conn->close();
    }
}