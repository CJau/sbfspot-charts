<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\DayDataPoint;
use App\Inverter;
use Faker\Generator as Faker;

$factory->define(DayDataPoint::class, function (Faker $faker) {
    return [
        'TimeStamp' => $faker->time('U'),
        'Serial' => factory(Inverter::class)->create()->Serial,
        'TotalYield' => $faker->numberBetween(0, 90000000),
        'Power' => $faker->numberBetween(0, 2000),
        'PVOutput' => 0,
    ];
});
