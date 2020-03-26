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
    Route::get('/', 'BookingController@index');
    Route::get('{id}/edit', 'BookingController@edit');
    Route::post('import', 'BookingController@import');
    Route::patch('{id}/update', 'BookingController@update');

});

Route::group(['prefix' => 'reports'], function (){
    // Schedule Reports
   Route::get('/schedule/preview', 'ReportController@schedulePreview');
   Route::get('/schedule/export', 'ReportController@scheduleExport');
   Route::get('/schedule/waivers', 'ReportController@waivers');
   Route::get('/schedule/filterData', 'ReportController@filterData');
   // Bookings Reports
   Route::get('/bookings/export', 'ReportController@bookingsExport');
   Route::get('/bookings/preview', 'ReportController@bookingsPreview');
});

Route::group(['prefix' => 'webhooks'], function (){
   Route::post('email/import', 'WebhookController@emailImport');
});

Route::group(['prefix' => 'agents'], function (){
    Route::get('/', 'AgentsController@index');
    Route::get('{id}/edit', 'AgentsController@edit');
    Route::patch('{id}/update', 'AgentsController@update');
    Route::get('{id}/products', 'AgentsProductsController@index');
    Route::get('{id}/products/create', 'AgentsProductsController@create');
    Route::post('products/store', 'AgentsProductsController@store');
    Route::patch('products/{product}/update', 'AgentsController@updateProduct');
    Route::get('products/{product}/edit', 'AgentsProductsController@show');

});

Route::group(['prefix' => 'products'], function() {
   Route::get('/', 'ProductController@index');
   Route::get('{id}/edit', 'ProductController@edit');
   Route::patch('{id}/update', 'ProductController@update');
   Route::post('/', 'ProductController@store');
});

Route::group(['prefix' => 'dashboard'], function (){
   Route::get('revenue', 'DashboardController@revenue');
   Route::get('commission', 'DashboardController@commission');
   Route::get('booking/overview', 'DashboardController@overview');
});
