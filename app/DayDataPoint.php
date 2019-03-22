<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DayDataPoint extends Model
{
    protected $primaryKey = null;
    protected $table = 'DayData';
    protected $timestamps = false;

    public function inverter() {
        return $this->belongsTo('App\Inverter','Serial');
    }
}
