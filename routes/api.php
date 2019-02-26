<?php

use Illuminate\Http\Request;
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
   Route::get('/schedule/preview', 'ReportController@schedulePreview'); 
   Route::get('/schedule/export', 'ReportController@scheduleExport');
   Route::get('/schedule/waivers', 'ReportController@waivers');
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
    Route::post('products/{productId}/update', 'AgentsController@updateProduct');
    Route::get('{id}/products/{productId}/edit', 'AgentsController@editProduct');
    
});

Route::group(['prefix' => 'products'], function() {
   Route::get('/', 'ProductController@all');
   Route::get('{id}/edit', 'ProductController@edit');
   Route::post('{id}/update', 'ProductController@update');
});
