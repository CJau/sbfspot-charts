<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inverter extends Model
{
    use HasFactory;

    protected $table = 'Inverters';
    protected $primaryKey = 'Serial';
    public $incrementing = false;

    public $timestamps = false;

    public function dataPoints()
    {
        return $this->hasMany(DayDataPoint::class, 'Serial', 'Serial');
    }
}
