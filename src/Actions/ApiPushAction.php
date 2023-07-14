<?php

declare(strict_types=1);

namespace App\Actions;

use App\Repository\SensorTemperatureRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ApiPushAction
{
    use JsonTrait;

    public function __construct(
        private readonly ResponseInterface $response,
        private readonly SensorTemperatureRepository $repository
    ) {
    }

    public function __invoke(Request $request): Response
    {
        $data = $request->getParsedBody();

        if (!isset($data['reading']['sensor_uuid']) || !isset($data['reading']['temperature'])) {
            return $this->json([
                'status' => false,
                'message' => 'Invalid request data',
            ], 400);
        }

        try {
            $this->repository->insertRecord(
                (string)$data['reading']['sensor_uuid'],
                (float)$data['reading']['temperature']
            );

            return $this->json([
                'status' => true,
                'message' => 'OK',
            ]);
        } catch (\PDOException $exception) {
            return $this->json([
                'status' => false,
                'message' => 'Failed to save data',
            ], 500);
        }
    }
}
