<?php

namespace App\Http\Controllers;

use App\DayDataPoint;
use Illuminate\Support\Carbon;

class DayDataPointController extends Controller
{
    public function edit($serial, $timestamp)
    {
        return view('day_data_points.edit', [
            'dayDataPoint' => DayDataPoint::where('Serial', $serial)->firstWhere('TimeStamp', $timestamp),
        ]);
    }

    public function update($serial, $timestamp)
    {
        $dayDataPoint = DayDataPoint::firstWhere([
            'Serial' => $serial,
            'TimeStamp' => $timestamp
        ]);

        $dayDataPoint->update([
            'TimeStamp' => Carbon::parse(request('TimeStamp', $dayDataPoint->TimeStamp))->format('U'),
            'Power' => request('Power', $dayDataPoint->Power),
            'TotalYield' => request('TotalYield', $dayDataPoint->TotalYield),
        ]);

        return redirect(route('graphs.day', $dayDataPoint->TimeStamp->toDateString()));
    }

    public function destroy($serial, $timestamp)
    {
        DayDataPoint::where([
            'Serial' => $serial,
            'TimeStamp' => $timestamp,
        ])->delete();

        return redirect(route('graphs.day'));
    }
}
