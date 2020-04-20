<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inverter extends Model
{
    protected $primaryKey = 'Serial';
    protected $table = 'Inverters';
    
    public $incrementing = false;

    public function data_points() {
        return $this->hasMany(DayDataPoint::class, 'Serial', 'Serial');
    }
}
