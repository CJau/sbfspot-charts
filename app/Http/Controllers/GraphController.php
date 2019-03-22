<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\DayDataPoint;
use App\Http\Requests;
use Carbon\Carbon;

class GraphController extends Controller
{
    public function day($date = null) {
      if (is_null($date)) $date = Carbon::now();
      else $date = Carbon::createFromFormat('Y-m-d',$date);

      $start = $date->startOfDay()->timestamp;
      $end = $date->endOfDay()->timestamp;
      $data = DayDataPoint::whereBetween('timestamp',[$start,$end])->with('inverter')->get();

      return view('graphs.day', compact('date','data'));
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
