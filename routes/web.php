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


use App\Booking;
use App\Schedule;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;

Route::get('test', function (){
    dd(strtotime('43527'));
    $date = Carbon::createFromFormat('d/m/Y H:i:s', strtotime('43527'));
    dd($date);
   return view('reports.pdf-waiver', compact('bookings'));

print_r($bookings);
    //return $collection;
});
Route::get('/{any}', 'SpaController@index')->where('any', '.*');
