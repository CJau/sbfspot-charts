<?php
namespace Database\Seeders;

use App\DayDataPoint;
use App\Inverter;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class DayDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $inverter1 = factory(Inverter::class)->create();
        $inverter2 = factory(Inverter::class)->create();

        $time = Carbon::createFromFormat('Y-m-d h:i', '2020-01-01 06:00');

        $data = [];
        for ($i = 0; $i < 144; $i++) {
            $this->buildData($i, $data, $time, $inverter1->Serial);
            $this->buildData($i, $data, $time, $inverter2->Serial);

            $time->addMinutes(5);
        }

        DayDataPoint::insert($data);
    }

    private function buildData($factor, &$data, $time, $serial)
    {
        $power = (rand(7, 9) / 10) * (-0.2 * pow($factor, 2) + ($factor * 28.8));

        $data[] = [
            'TimeStamp' => $time->format('U'),
            'Serial' => $serial,
            'TotalYield' => $power/12 + ($factor > 0 ? $data[2 * ($factor-1)]['TotalYield'] : 0),
            'Power' => $power,
            'PVOutput' => 0,
        ];
    }
}
