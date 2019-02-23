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
    $collection = collect([
        'incoming' => Booking::where('booking_data->arrival_date', '=', '09-06-2018')->get(),
        'outgoing' => Booking::where('booking_data->return_date', '09-06-2018')->get()
    ]);
   $bookings = (new Schedule(Carbon::createFromFormat('d-m-Y', '09-06-2018')))->processBookings($collection);
   return view('reports.schedule', compact('bookings'));

print_r($bookings);
    //return $collection;
});
Route::get('/{any}', 'SpaController@index')->where('any', '.*');
