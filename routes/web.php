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

Route::get('booking-test', function (){
   $booking = Booking::find(30);
   $price = $booking->booking_data->price_paid;
   $price = preg_replace('/£/','', $price);
   dd($price);
});
Route::get('fix-booking-relations', function (){
   $bookings = Booking::all();
   $bookings->each(function ($booking) {
       $agentProduct = \App\AgentProduct::where('agent_code', $booking->booking_data->product_id)->first();
       //dd($agentProduct);
       $product = \App\Product::find($agentProduct['product_id']);
       $booking->product_id = $product->id;
       $booking->agents_products_id = $agentProduct->id;
       $booking->save();

   });
});
Route::get('/{any}', 'SpaController@index')->where('any', '.*');
