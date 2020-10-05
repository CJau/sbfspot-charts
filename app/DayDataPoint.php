<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DayDataPoint extends Model
{
    use HasFactory;

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

    protected $dates = [
        'TimeStamp',
    ];
    protected $dateFormat = 'U';

    public function inverter()
    {
        return $this->belongsTo(Inverter::class, 'Serial');
    }

    public function getTimeAttribute()
    {
        return $this->TimeStamp->format('H:i');
    }

    public function update(array $attributes = [], array $options = [])
    {
        // So we don't accidentally call eloquent update when eloquent doesn't
        // support composite primary keys
    }

    public function save(array $options = [])
    {
        // So we don't accidentally call eloquent update when eloquent doesn't
        // support composite primary keys
    }
}
