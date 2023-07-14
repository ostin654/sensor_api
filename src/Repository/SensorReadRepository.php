<?php

declare(strict_types=1);

namespace App\Repository;

class SensorReadRepository
{
    public function __construct(private readonly \PDO $db)
    {
    }

    public function getLastReadingId(string $sensorIp): int
    {
        $sql = "INSERT INTO sensor_reading (sensor_ip, last_reading_id) VALUES (:sensorIp, 0) ON CONFLICT DO NOTHING";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':sensorIp', $sensorIp);
        $stmt->execute();

        $sql = "UPDATE sensor_reading SET last_reading_id = last_reading_id + 1 WHERE sensor_ip = :sensorIp";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':sensorIp', $sensorIp);
        $stmt->execute();

        $sql = "SELECT last_reading_id FROM sensor_reading WHERE sensor_ip = :sensorIp";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':sensorIp', $sensorIp);
        $stmt->execute();

        return $stmt->fetchColumn();
    }
}
