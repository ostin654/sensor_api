<?php

use Phinx\Migration\AbstractMigration;

class SensorTemperature extends AbstractMigration
{
    public function up()
    {
        $table = $this->table('sensor_temperature');
        $table
            ->addColumn('sensor_uuid', 'string')
            ->addColumn('temperature', 'decimal', ['precision' => 5, 'scale' => 2])
            ->addColumn('created_at', 'datetime', ['default' => 'CURRENT_TIMESTAMP'])
            ->create();
    }

    public function down()
    {
        $this->table('sensor_temperature')->drop()->save();
    }
}
