<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\DayDataPoint;
use Illuminate\Support\Carbon as Carbon;
use Illuminate\Support\Facades\DB;

class GraphController extends Controller
{
    public function day($date = null)
    {
        $date = $date ? Carbon::createFromFormat('Y-m-d', $date) : today();

        // Retrieve data
        $start = $date->startOfDay()->timestamp;
        $end = $date->endOfDay()->timestamp;
        $data = DayDataPoint::whereBetween('TimeStamp', [$start,$end])->with('inverter')->get();

        // Get inverter serials for day
        $inverters = $data->unique('Serial')->pluck('inverter');

        // Get starting values for each inverter
        $startpower = $data->sortBy('TimeStamp')->unique('Serial');

        // Determine next/prev dates
        $prev = DayDataPoint::where('TimeStamp', '<', $start)->orderBy('TimeStamp', 'DESC')->first();
        if (!is_null($prev)) {
            $prev = $prev->TimeStamp->format('Y-m-d');
        }

        $next = DayDataPoint::where('TimeStamp', '>', $end)->orderBy('TimeStamp', 'ASC')->first();
        if (!is_null($next)) {
            $next = $next->TimeStamp->format('Y-m-d');
        }

        // Display
        return view('graphs.day', compact('date', 'next', 'prev', 'data', 'inverters', 'startpower'));
    }

    public function month($date = null)
    {
        $date = $date ? Carbon::createFromFormat('Y-m-d', $date) : today();

        // Retrieve data
        $start = $date->startOfMonth()->timestamp;
        $end = $date->endOfMonth()->timestamp;
        $data = DayDataPoint::whereBetween('TimeStamp', [$start,$end])
            ->select([
                DB::raw('DATE_FORMAT(FROM_UNIXTIME(TimeStamp), \'%Y-%m-%d\') as DayDate'),
                'Serial',
                DB::raw('(MAX(TotalYield) - MIN(TotalYield)) / 1000 as Generation'),
            ])
            ->groupBy('DayDate', 'Serial')
            ->with('inverter')
            ->get();

        // Get inverter serials for day
        $inverters = $data->unique('Serial')->pluck('inverter');

        // Determine next/prev dates
        $prev = DayDataPoint::where('TimeStamp', '<', $start)->orderBy('TimeStamp', 'DESC')->first();
        if (!is_null($prev)) {
            $prev = $prev->TimeStamp->format('Y-m-d');
        }

        $next = DayDataPoint::where('TimeStamp', '>', $end)->orderBy('TimeStamp', 'ASC')->first();
        if (!is_null($next)) {
            $next = $next->TimeStamp->format('Y-m-d');
        }

        // Display
        return view('graphs.month', compact('date', 'next', 'prev', 'data', 'inverters'));
    }

    public function year($date = null)
    {
        $date = $date ? Carbon::createFromFormat('Y-m-d', $date) : today();
        
        // Retrieve data
        $start = $date->startOfYear()->timestamp;
        $end = $date->endOfYear()->timestamp;
        $data = DayDataPoint::whereBetween('TimeStamp', [$start,$end])
            ->select([
                DB::raw('DATE_FORMAT(FROM_UNIXTIME(TimeStamp), \'%Y-%m\') as MonthDate'),
                'Serial',
                DB::raw('(MAX(TotalYield) - MIN(TotalYield)) / 1000 as Generation')
            ])
            ->groupBy('MonthDate', 'Serial')
            ->with('inverter')
            ->get();

        // Get inverter serials for day
        $inverters = $data->unique('Serial')->pluck('inverter');

        // Determine next/prev dates
        $prev = DayDataPoint::where('TimeStamp', '<', $start)->orderBy('TimeStamp', 'DESC')->first();
        if (!is_null($prev)) {
            $prev = $prev->TimeStamp->format('Y-m-d');
        }

        $next = DayDataPoint::where('TimeStamp', '>', $end)->orderBy('TimeStamp', 'ASC')->first();
        if (!is_null($next)) {
            $next = $next->TimeStamp->format('Y-m-d');
        }

        // Display
        return view('graphs.year', compact('date', 'next', 'prev', 'data', 'inverters'));
    }
}
