<?php

declare(strict_types=1);

use App\Actions\ApiPushAction;
use App\Actions\SensorReadAction;
use League\Route\RouteGroup;
use League\Route\Router;

return function (Router $router) {
    $router->group('/api', function (RouteGroup $group) {
        $group->map('POST', '/push', ApiPushAction::class);
    });
    $router->group('/sensor', function (RouteGroup $group) {
        $group->map('GET', '/read/{sensorIp}', SensorReadAction::class);
    });
};
