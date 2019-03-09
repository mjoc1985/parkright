<?php

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/auth/login', 'Auth\LoginController@login');

Route::group(['middleware' => 'jwt.auth'], function(){
    Route::get('/auth/user', 'Auth\LoginController@user');
    Route::post('/auth/logout', 'Auth\LoginController@logout');

});
Route::group(['middleware' => 'jwt.refresh'], function(){
    Route::post('auth/refresh', 'Auth\LoginController@refresh');
});

Route::group(['prefix' => 'bookings'], function (){
    Route::get('/', 'BookingController@get');
    Route::get('{id}/edit', 'BookingController@edit');
    Route::post('import', 'BookingController@import');
    Route::post('{id}/update', 'BookingController@update');

});

Route::group(['prefix' => 'reports'], function (){
    // Schedule Reports
   Route::get('/schedule/preview', 'ReportController@schedulePreview'); 
   Route::get('/schedule/export', 'ReportController@scheduleExport');
   Route::get('/schedule/waivers', 'ReportController@waivers');
   // Bookings Reports
   Route::get('/bookings/export', 'ReportController@bookingsExport');
   Route::get('/bookings/preview', 'ReportController@bookingsPreview');
});

Route::group(['prefix' => 'webhooks'], function (){
   Route::post('email/import', 'WebhookController@emailImport'); 
});

Route::group(['prefix' => 'agents'], function (){
    Route::get('/', 'AgentsController@all');
    Route::get('{id}/edit', 'AgentsController@edit');
    Route::post('{id}/update', 'AgentsController@update');
    Route::get('{id}/products', 'AgentsController@getProducts');
    Route::get('{id}/products/create', 'AgentsController@createProduct');
    Route::post('products/store', 'AgentsController@saveProduct');
    Route::post('products/{product}/update', 'AgentsController@updateProduct');
    Route::get('products/{product}/edit', 'AgentsController@getProduct');
    
});

Route::group(['prefix' => 'products'], function() {
   Route::get('/', 'ProductController@all');
   Route::get('{id}/edit', 'ProductController@edit');
   Route::post('{id}/update', 'ProductController@update');
});

Route::group(['prefix' => 'dashboard'], function (){
   Route::get('revenue', 'DashboardController@revenue');
   Route::get('commission', 'DashboardController@commission');
   Route::get('booking/overview', 'DashboardController@overview');
});

Route::get('/fix-dates', function (){
   $bookings = \App\Booking::all();
   foreach ($bookings as $booking){
       $data = $booking->booking_data;
       $arr = (new \Carbon\Carbon($data['arrival_date']))->format('Y-m-d H:i:s');
       $ret = (new \Carbon\Carbon($data['return_date']))->format('Y-m-d H:i:s');
       unset($data['arrival_date']);
       unset($data['return_date']);
        Arr::set($data, 'arrival_date', $arr);
        Arr::set($data, 'return_date', $ret);

       //dd($arr);
       //dd($data);
       //dd($booking->booking_data['arrival_date']);
      
       $booking->update(['booking_data' => $data]);
   }
});
