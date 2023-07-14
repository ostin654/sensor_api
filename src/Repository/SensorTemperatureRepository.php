<?php

declare(strict_types=1);

namespace App\Repository;

class SensorTemperatureRepository
{
    public function __construct(private readonly \PDO $db)
    {
    }

    public function insertRecord(string $sensorUuid, float $temperature): void
    {
        $sql = "INSERT INTO sensor_temperature (sensor_uuid, temperature) VALUES (:sensorUuid, :temperature)";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':sensorUuid', $sensorUuid);
        $stmt->bindParam(':temperature', $temperature);
        $stmt->execute();
    }
}