<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\DayDataPoint;
use App\Inverter;
use App\Charts\DailyChart;
use App\Http\Requests;
use Carbon\Carbon;

class GraphController extends Controller
{
    public function day($date = null) {
      if (is_null($date)) $date = Carbon::now();
      else $date = Carbon::createFromFormat('Y-m-d',$date);

      // Retrieve data
      $start = $date->startOfDay()->timestamp;
      $end = $date->endOfDay()->timestamp;
      $data = DayDataPoint::whereBetween('TimeStamp',[$start,$end])->with('inverter')->get();
      $inverters = $data->unique('Serial')->pluck('inverter');

      // Determine next/prev dates
      $prev = DayDataPoint::where('TimeStamp','<',$start)->orderBy('TimeStamp','DESC')->first();
      if (!is_null($prev)) $prev = date('Y-m-d',$prev->TimeStamp);
      $next = DayDataPoint::where('TimeStamp','>',$end)->orderBy('TimeStamp','ASC')->first();
      if (!is_null($next)) $next = date('Y-m-d',$next->TimeStamp);

      // Display
      return view('graphs.day', compact('date','next','prev','data','inverters'));
    }

    public function month($date = null) {
      if (is_null($date)) $date = Carbon::now();
      else $date = Carbon::createFromFormat('Y-m-d',$date);

    }

    public function year($date = null) {
      if (is_null($date)) $date = Carbon::now();
      else $date = Carbon::createFromFormat('Y-m-d',$date);

    }
}
