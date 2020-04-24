<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Inverter;
use Faker\Generator as Faker;

$factory->define(Inverter::class, function (Faker $faker) {
    return [
        'Serial' => $faker->unique()->numberBetween(1000000, 2000000),
        'Name' => $faker->name,
        'Type' => 'SB 2000',
        'SW_Version' => '12.34.567',
        'TimeStamp' => time(),
        'TotalPac' => 0,
        'EToday' => $faker->numberBetween(0, 10000),
        'ETotal' => $faker->numberBetween(100000, 900000000),
        'OperatingTime' => $faker->numberBetween(100, 50000),
        'FeedInTime' => $faker->numberBetween(100, 50000),
        'Status' => 'OK',
        'GridRelay' => '?',
        'Temperature' => 0,
    ];
});
