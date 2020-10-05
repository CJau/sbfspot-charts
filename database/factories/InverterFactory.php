<?php

namespace Database\Factories;

use App\Inverter;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Testing\WithFaker;

class InverterFactory extends Factory
{
    use WithFaker;

    protected $model = Inverter::class;

    public function definition()
    {
        return [
            'Serial' => $this->faker->unique()->numberBetween(1000000, 2000000),
            'Name' => $this->faker->name,
            'Type' => 'SB 2000',
            'SW_Version' => '12.34.567',
            'TimeStamp' => time(),
            'TotalPac' => 0,
            'EToday' => $this->faker->numberBetween(0, 10000),
            'ETotal' => $this->faker->numberBetween(100000, 900000000),
            'OperatingTime' => $this->faker->numberBetween(100, 50000),
            'FeedInTime' => $this->faker->numberBetween(100, 50000),
            'Status' => 'OK',
            'GridRelay' => '?',
            'Temperature' => 0,
        ];
    }
}
