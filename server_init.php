<?php

require __DIR__ . '/vendor/autoload.php' ; 
require_once 'server_class.php' ;

use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;

$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new MyWebSocketServer()
        )
    ),
    8080
);

$server->run();