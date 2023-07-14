<?php

declare(strict_types=1);

use App\Middleware\JsonBodyParserMiddleware;
use League\Route\Router;

return function (Router $router) {
    $router->middleware(new JsonBodyParserMiddleware());
};
