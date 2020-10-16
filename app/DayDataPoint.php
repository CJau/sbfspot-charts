<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DayDataPoint extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'DayData';
    // protected $primaryKey = [
    //     'TimeStamp',
    //     'Serial',
    // ];

    /**
     * @var null
     */
    protected $primaryKey = null;

    /**
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var string[]
     */
    public $appends = [
        'time',
    ];

    /**
     * @var string[]
     */
    protected $dates = [
        'TimeStamp',
    ];

    /**
     * @var string
     */
    protected $dateFormat = 'U';

    /**
     * @return mixed
     */
    public function inverter()
    {
        return $this->belongsTo(Inverter::class, 'Serial');
    }

    /**
     * @return mixed
     */
    public function getTimeAttribute()
    {
        return $this->TimeStamp->format('H:i');
    }

    /**
     * @param array $attributes
     * @param array $options
     */
    public function update(array $attributes = [], array $options = [])
    {
        // So we don't accidentally call eloquent update when eloquent doesn't
        // support composite primary keys
    }

    /**
     * @param array $options
     */
    public function save(array $options = [])
    {
        // So we don't accidentally call eloquent update when eloquent doesn't
        // support composite primary keys
    }
}
