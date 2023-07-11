<?php

declare(strict_types=1);

use App\Actions\ApiPushAction;
use App\Actions\SensorReadAction;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
    $app->group('/api', function (Group $group) {
        $group->post('/push', ApiPushAction::class);
    });
    $app->group('/sensor', function (Group $group) {
        $group->get('/read/{sensorIp}', SensorReadAction::class);
    });
};
