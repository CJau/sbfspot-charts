<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SpotDataPoint extends Model
{
    protected $table = 'SpotData';
    // protected $primaryKey = [
    //     'TimeStamp',
    //     'Serial',
    // ];
    protected $primaryKey = null;
    public $incrementing = false;

    public $timestamps = false;

    protected $dates = [
        'TimeStamp',
    ];
    protected $dateFormat = 'U';

    public $appends = [
        'time',
    ];

    public function inverter()
    {
        return $this->belongsTo(Inverter::class, 'Serial');
    }

    public function getTimeAttribute()
    {
        return $this->TimeStamp->format('H:i');
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
