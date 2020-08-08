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
        with(DayDataPoint::where('Serial', $serial)->firstWhere('TimeStamp', $timestamp), function ($dayDataPoint) {
            $dayDataPoint->update([
                'TimeStamp' => Carbon::parse(request('TimeStamp', $dayDataPoint->TimeStamp))->format('U'),
                'TotalYield' => request('TotalYield', $dayDataPoint->TotalYield),
                'Power' => request('Power', $dayDataPoint->Power),
            ]);

            return redirect(route('graphs.day', $dayDataPoint->TimeStamp->toDateString()));
        });
    }

    public function destroy($serial, $timestamp)
    {
        DayDataPoint::where('Serial', $serial)->where('TimeStamp', $timestamp)->delete();

        return redirect(route('graphs.day', date('Y-m-d', $timestamp)));
    }
}
