<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DayDataPoint extends Model
{
    protected $table = 'DayData';
    // protected $primaryKey = [
    //     'TimeStamp',
    //     'Serial',
    // ];
    protected $primaryKey = null;
    public $incrementing = false;

    public $timestamps = false;

    public $appends = [
        'time',
    ];

    public function inverter()
    {
        return $this->belongsTo(Inverter::class, 'Serial');
    }

    public function getTimeAttribute()
    {
        return date('H:i', $this->TimeStamp);
    }

    public function update(array $attributes = [], array $options = []) {
        // So we don't accidentally call eloquent update when eloquent doesn't 
        // support composite primary keys
    }

    public function save(array $options = []) {
        // So we don't accidentally call eloquent update when eloquent doesn't 
        // support composite primary keys
    }
}
