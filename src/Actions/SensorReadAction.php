<?php

declare(strict_types=1);

namespace App\Actions;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class SensorReadAction
{
    public function __construct(private readonly \PDO $db)
    {
    }

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $sensorIP = $args['sensorIp'];

        $sql = "INSERT INTO sensor_reading (sensor_ip, last_reading_id) VALUES (:sensorIp, 0) ON CONFLICT DO NOTHING";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':sensorIp', $sensorIP);
        $stmt->execute();

        $sql = "UPDATE sensor_reading SET last_reading_id = last_reading_id + 1 WHERE sensor_ip = :sensorIp";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':sensorIp', $sensorIP);
        $stmt->execute();

        $sql = "SELECT last_reading_id FROM sensor_reading WHERE sensor_ip = :sensorIp";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':sensorIp', $sensorIP);
        $stmt->execute();

        $lastReadingId = $stmt->fetchColumn();

        $temperature = number_format(mt_rand(-1000, 8000) / 100, 2);

        $csvString = "{$lastReadingId},{$temperature}";

        $response = $response->withHeader('Content-Type', 'text/csv');
        $response->getBody()->write($csvString);

        return $response;
    }
}
