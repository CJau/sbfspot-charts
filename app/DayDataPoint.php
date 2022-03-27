<?php

namespace App;

class DayDataPoint extends Model
{
    protected $table = 'DayData';

    protected $primaryKey = [
        'TimeStamp',
        'Serial',
    ];

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

    protected function setKeysForSaveQuery($query)
    {
        $query
            ->where('TimeStamp', '=', $this->getRawOriginal('TimeStamp'))
            ->where('Serial', '=', $this->getAttribute('Serial'));

        return $query;
    }
}
