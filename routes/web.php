<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes(['register' => false]);

Route::get('/', function () {
    return redirect(route('graphs.day'));
});

Route::get('day/{date?}', 'GraphController@day')->name('graphs.day');
Route::get('month/{date?}', 'GraphController@month')->name('graphs.month');
Route::get('year/{date?}', 'GraphController@year')->name('graphs.year');

Route::get('day_data_points/{serial}/{timestamp}', 'DayDataPointController@edit')->middleware('auth')->name('day_data_points.edit');
Route::patch('day_data_points/{serial}/{timestamp}', 'DayDataPointController@update')->middleware('auth')->name('day_data_points.update');
Route::delete('day_data_points/{serial}/{timestamp}', 'DayDataPointController@destroy')->middleware('auth')->name('day_data_points.destroy');
