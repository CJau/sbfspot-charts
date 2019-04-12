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

Route::get('/', function () {
    return redirect(route('graphs.day'));
});

Route::get('day/{date?}','GraphController@day')->name('graphs.day');
Route::get('month/{date?}','GraphController@month')->name('graphs.month');
Route::get('year/{date?}','GraphController@year')->name('graphs.year');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
