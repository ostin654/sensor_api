<?php

declare(strict_types=1);

namespace App\Actions;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ApiPushAction
{
    public function __construct(private readonly \PDO $db)
    {
    }

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $data = $request->getParsedBody();

        if (!isset($data['reading']['sensor_uuid']) || !isset($data['reading']['temperature'])) {
            $response->getBody()->write(\json_encode([
                'status' => false,
                'message' => 'Invalid request data',
            ]));

            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(400);
        }

        $sensorUuid = $data['reading']['sensor_uuid'];
        $temperature = $data['reading']['temperature'];

        $sql = "INSERT INTO sensor_temperature (sensor_uuid, temperature) VALUES (:sensorUuid, :temperature)";

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':sensorUuid', $sensorUuid);
            $stmt->bindParam(':temperature', $temperature);
            $stmt->execute();

            $response->getBody()->write(\json_encode([
                'status' => true,
                'message' => 'OK',
            ]));

            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(200);
        } catch (\PDOException $e) {
            $response->getBody()->write(\json_encode([
                'status' => false,
                'message' => 'Failed to save data',
            ]));

            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(500);
        }
    }
}
