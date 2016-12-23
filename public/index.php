<?php

use Zend\Stratigility\NoopFinalHandler;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Zend\Diactoros\Server;
use Zend\Diactoros\ServerRequestFactory;
use Zend\Stratigility\MiddlewarePipe;

// Delegate static file requests back to the PHP built-in webserver
if (php_sapi_name() === 'cli-server'
    && is_file(__DIR__ . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH))
) {
    return false;
}

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

/** @var \Interop\Container\ContainerInterface $container */
$container = require 'config/container.php';

$app = new \Zend\Stratigility\MiddlewarePipe();
$app->raiseThrowables();

// ui root Route
$app->pipe('/',function(Request $request,Response $response, callable $next = null) use ($container){
if ($request->getUri()->getPath() === '/') {
  $ui = $container->get(\CanExpressive\UI\Main::class);

  return $ui($request,$response,$next);
}

  return $next($request, $response);

});

$api = $container->get('CanExpressive\Api');

$app->pipe('/api',$api);

$server = Server::createServer($app,
    $_SERVER,
    $_GET,
    $_POST,
    $_COOKIE,
    $_FILES
);
$server->listen(new NoopFinalHandler);
