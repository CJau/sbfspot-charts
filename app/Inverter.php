<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inverter extends Model
{
    protected $table = 'Inverters';
    protected $primaryKey = 'Serial';
    public $incrementing = false;

    public $timestamps = false;

    public function dataPoints()
    {
        return $this->hasMany(DayDataPoint::class, 'Serial', 'Serial');
    }
}
