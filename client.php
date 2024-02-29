<?php

require __DIR__ . '/vendor/autoload.php';
use React\EventLoop\Factory;
use Ratchet\Client\Connector;
use Ratchet\Client\WebSocket;



$connector = new Connector();
$connector('ws://192.168.1.7:8080/echo')->then( 
    function (WebSocket $conn) 
 {
    
       $conn->on('message', function ($msg) use ($conn) {
          echo "Received: {$msg}\n";
        
         });
        
   
        $sendMessage = function () use ($conn) {
            $message = readline("Enter message: ");
            $conn->send($message);
        };

        $sendMessage();
        
   },
    function (\Throwable $e) {
        echo "Could not connect: {$e->getMessage()}\n";
    }
);

// $loop->run();
