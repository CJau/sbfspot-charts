<?php

namespace App;

class SpotDataPoint extends Model
{
    protected $table = 'SpotData';
    
    protected $primaryKey = [
        'TimeStamp',
        'Serial',
    ];

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

    protected function setKeysForSaveQuery($query)
    {
        $query
            ->where('TimeStamp', '=', $this->getRawOriginal('TimeStamp'))
            ->where('Serial', '=', $this->getAttribute('Serial'));

        return $query;
    }
}
