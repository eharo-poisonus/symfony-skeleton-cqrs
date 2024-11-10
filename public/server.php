<?php

use OpensSwoole\Http\Server as SwooleHttpServer;
use Symfony\Component\HttpFoundation\Request;

require __DIR__ . '/../vendor/autoload.php';

$kernel = new App\Kernel('pre', false);
$server = new SwooleHttpServer('0.0.0.0', 9501);

$server->on('start', function () { echo "Open Swoole http server start at http://0.0.0.0:9501 \n";});
$server->on('request', function ($swooleRequest, $swooleResponse) use ($kernel) {
    $swooleHeaders = $swooleRequest->header;
    $_SERVER = array_change_key_case($swooleRequest->server, CASE_UPPER);
    foreach ($swooleHeaders as $key => $value) {
        $formattedKey = 'HTTP_' . strtoupper(str_replace('-', '_', $key));
        $_SERVER[$formattedKey] = $value;
    }
    if (isset($swooleHeaders['content-type'])) {
        $_SERVER['CONTENT_TYPE'] = $swooleHeaders['content-type'];
    }
    if (isset($swooleHeaders['content-length'])) {
        $_SERVER['CONTENT_LENGTH'] = $swooleHeaders['content-length'];
    }
    $_SERVER = array_merge($_SERVER, $swooleHeaders);
    $_SERVER['REQUEST_METHOD'] = $swooleRequest->server['request_method'];
    $_SERVER['REQUEST_URI'] = $swooleRequest->server['request_uri'];

    $request = new Request(
        $swooleRequest->get ?? [],
        $swooleRequest->post ?? [],
        [],
        $swooleRequest->cookie ?? [],
        $swooleRequest->files ?? [],
        $_SERVER,
        $swooleRequest->rawContent()
    );
    $response = $kernel->handle($request);
    $swooleResponse->status($response->getStatusCode());
    foreach ($response->headers->allPreserveCase() as $key => $values) {
        foreach ($values as $value) {
            $swooleResponse->header($key, $value);
        }
    }
    $swooleResponse->end($response->getContent());
    $kernel->terminate($request, $response);
});
$server->start();
