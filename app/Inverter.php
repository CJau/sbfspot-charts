<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inverter extends Model
{
    protected $primaryKey = 'Serial';
    protected $table = 'Inverters';

    public $timestamps = false;
    public $incrementing = false;

    public function dataPoints()
    {
        return $this->hasMany(DayDataPoint::class, 'Serial', 'Serial');
    }
}
