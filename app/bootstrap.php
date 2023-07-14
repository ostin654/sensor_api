<?php

declare(strict_types=1);

use DI\ContainerBuilder;
use Dotenv\Dotenv;
use Dotenv\Exception\InvalidPathException;

require __DIR__ . '/../vendor/autoload.php';

try {
    $dotenv = Dotenv::createImmutable(__DIR__ . '/../');
    $dotenv->load();
} catch (InvalidPathException $exception) {
}

$containerBuilder = new ContainerBuilder();

$dependencies = require __DIR__ . '/../app/dependencies.php';
$dependencies($containerBuilder);

return $containerBuilder->build();
