<?php

declare(strict_types=1);

namespace App\Actions;

use App\Repository\SensorReadRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class SensorReadAction
{
    public function __construct(
        private readonly ResponseInterface $response,
        private readonly SensorReadRepository $repository
    ) {
    }

    public function __invoke(Request $request, array $args): Response
    {
        $lastReadingId = $this->repository->getLastReadingId((string)$args['sensorIp']);

        $temperature = number_format(mt_rand(-1000, 8000) / 100, 2);

        $this->response->withHeader('Content-Type', 'text/csv');
        $this->response->getBody()->write("{$lastReadingId},{$temperature}");

        return $this->response;
    }
}
