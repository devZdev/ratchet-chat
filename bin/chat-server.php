<?php
$app = new \Ratchet\Http\HttpServer(
    new \Ratchet\WebSocket\WsServer(
        new \MyApp\Chat()
    )
);

$loop = \React\EventLoop\Factory::create();

$secure_websockets = new \React\Socket\Server('0.0.0.0:8083', $loop);
$secure_websockets = new \React\Socket\SecureServer($secure_websockets, $loop, [
    'local_cert' => 'path-to/public.pem',
    'local_pk' => 'path-to/private.pem',
    'verify_peer' => false
]);

$secure_websockets_server = new \Ratchet\Server\IoServer($app, $secure_websockets, $loop);
$secure_websockets_server->run();


/*
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use MyApp\Chat;

    require dirname(__DIR__) . '/vendor/autoload.php';

    $server = IoServer::factory(
        new HttpServer(
            new WsServer(
                new Chat()
            )
        ),
        8083
    );

    $server->run();
    */
