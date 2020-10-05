<?php
namespace Database\Factories;

use App\DayDataPoint;
use App\Inverter;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Testing\WithFaker;

class DayDataPointFactory extends Factory {
    use WithFaker;

    protected $model = DayDataPoint::class;

    public function definition() {
        return [
            'TimeStamp' => $this->faker->time('U'),
            'Serial' => factory(Inverter::class)->create()->Serial,
            'TotalYield' => $this->faker->numberBetween(0, 90000000),
            'Power' => $this->faker->numberBetween(0, 2000),
            'PVOutput' => 0,
        ];
}
