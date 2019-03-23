<?php

namespace App\Charts;

use App\DayDataPoint;
use ConsoleTVs\Charts\Classes\Frappe\Chart;

class DailyChart extends Chart
{
    /**
     * Initializes the chart.
     *
     * @return void
     */
    public function __construct($dailyData)
    {
      // Prepare labels (X-axis) data
      $labels = $dailyData->map(function ($item) use ($dailyData) {
        $item->time = date('H:i', $item->TimeStamp);
        return $item;
      })->unique('TimeStamp')->pluck('time')->all();

      // Prepare Chart Data for each 5 minutes, ensure none are skipped.
      $inverterData = $dailyData->groupBy('Serial');
      foreach ($dailyData->unique('TimeStamp')->pluck('TimeStamp') as $ts) {
        foreach ($inverterData as $serial => $inverter) {
          if (!$inverter->contains('TimeStamp',$ts)) {
            $dummyPoint = new DayDataPoint;
            $dummyPoint->TimeStamp = $ts;
            $dummyPoint->Power = null;
            $dummyPoint->TotalYield = null;
            $dummyPoint->Serial = $serial;
            $inverter->push($dummyPoint);
          }
        }
      }

      // Sort inverters so any of the dummy points are in the right spot and we don't need to do it later
      $inverterData = $inverterData->map(function ($item) {
        return $item->sortBy('TimeStamp');
      });

      // Build chart
      $this->labels($labels);
      foreach ($inverterData as $serial => $data) {
        $this->dataset($serial, 'line', $data->pluck('Power')->all());
      }
      $this->hideDots(true);
      $this->options([
        'axisOptions' => [
          'xIsSeries' => true,
        ],
      ]);

      parent::__construct();
    }
}
