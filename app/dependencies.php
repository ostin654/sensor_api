<?php

declare(strict_types=1);

use DI\ContainerBuilder;
use Laminas\Diactoros\Response;
use Laminas\Diactoros\ServerRequestFactory;
use League\Route\Router;
use League\Route\Strategy\ApplicationStrategy;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        \PDO::class => function (ContainerInterface $container) {
            $dbtype = env('DB_TYPE', 'pgsql');
            $dbhost = env('DB_HOST', 'db');
            $dbport = env('DB_PORT', '5432');
            $dbname = env('DB_NAME', 'db');
            $dbuser = env('DB_USER', 'db');
            $dbpass = env('DB_PASS', 'db');

            $dsn = "{$dbtype}:host={$dbhost};port={$dbport};dbname={$dbname};user={$dbuser};password={$dbpass}";
            $username = null;
            $password = null;

            $db = new \PDO($dsn, $username, $password);
            $db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

            return $db;
        },
        Router::class => function (ContainerInterface $container) {
            $strategy = $container->get(ApplicationStrategy::class);
            $strategy->setContainer($container);

            return (new Router())->setStrategy($strategy);
        },
        ServerRequestInterface::class => function (ContainerInterface $container) {
            $request = ServerRequestFactory::fromGlobals($_SERVER, $_GET, $_POST, $_COOKIE, $_FILES);

            return $request;
        },
        ResponseInterface::class => DI\create(Response::class),
    ]);
};
