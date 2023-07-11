<?php

declare(strict_types=1);

use App\Middleware\JsonBodyParserMiddleware;
use Slim\App;

return function (App $app) {
    $app->add(JsonBodyParserMiddleware::class);
};
