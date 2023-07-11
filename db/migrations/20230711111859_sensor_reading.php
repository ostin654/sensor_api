<?php

use Phinx\Migration\AbstractMigration;

class SensorReading extends AbstractMigration
{
    public function up()
    {
        $table = $this->table('sensor_reading');
        $table
            ->addColumn('sensor_ip', 'string')
            ->addColumn('last_reading_id', 'integer')
            ->addIndex(['sensor_ip'], ['unique' => true])
            ->create();
    }

    public function down()
    {
        $this->table('sensor_temperature')->drop()->save();
    }
}
