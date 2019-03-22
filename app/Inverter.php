<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inverter extends Model
{
    protected $primaryKey = 'serial';
    public $incrementing = false;

    public function data_points() {
        return $this->hasMany('App\DayDataPoint','Serial','Serial');
    }
}
