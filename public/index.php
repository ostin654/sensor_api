<?php

declare(strict_types=1);

use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use League\Route\Router;
use Psr\Http\Message\ServerRequestInterface;

$container = require __DIR__ . '/../app/bootstrap.php';

$router = $container->get(Router::class);

$middleware = require __DIR__ . '/../app/middleware.php';
$middleware($router);

$routes = require __DIR__ . '/../app/routes.php';
$routes($router);

$response = $router->dispatch($container->get(ServerRequestInterface::class));

$container->get(SapiEmitter::class)->emit($response);
