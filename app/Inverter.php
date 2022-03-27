<?php

namespace App;

class Inverter extends Model
{
    protected $table = 'Inverters';
    protected $primaryKey = 'Serial';

    public function dataPoints()
    {
        return $this->hasMany(DayDataPoint::class, 'Serial', 'Serial');
    }
}
