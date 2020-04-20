<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\DayDataPoint;
use Faker\Generator as Faker;

$factory->define(DayDataPoint::class, function (Faker $faker) {
    return [
        'TimeStamp' => $faker->time('U'),
        'Serial' => $faker->unique()->word,
        'TotalYield' => $faker->numberBetween(0, 90000000),
        'Power' => $faker->numberBetween(0, 2000),
        'PVOutput' => 0,
    ];
});
