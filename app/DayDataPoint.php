<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DayDataPoint extends Model
{
    protected $primaryKey = null;
    protected $table = 'DayData';

    public $timestamps = false;
    
    public $appends = [
        'time',
    ];

    public function inverter() {
        return $this->belongsTo(Inverter::class, 'Serial');
    }

    public function getTimeAttribute() {
      return date('H:i', $this->TimeStamp);
    }
}
