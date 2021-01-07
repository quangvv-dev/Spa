<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/check-unique-users', 'BE\UserController@checkUnique');
Route::post('/check-unique-customers', 'BE\CustomerController@checkUniquePhone');
Route::post('/check-unique-code-orders', 'BE\OrderController@checkUniqueCode');
Route::get('/statistics', 'API\StatisticController@index');
Route::get('/statistics-all', 'API\StatisticController@getAllBranch');
Route::get('/sales', 'API\StatisticController@sales');
Route::get('/sales-with-branch', 'API\StatisticController@saleWithBranch');
Route::get('/campaigns', 'API\StatisticController@campaign');
Route::get('/campaign-with-branch', 'API\StatisticController@campaignWithBranch');
Route::get('/task-schedules', 'API\StatisticController@TaskScheduleSale');
//Post customers
Route::put('posts/{id}', 'API\PostController@update');
Route::get('posts/{id}', 'API\PostController@show');
Route::get('voucher-services', 'API\PromotionController@listVoucherServices');
Route::get('voucher', 'API\PromotionController@listVoucher');
Route::get('voucher/{id}', 'API\PromotionController@checkVoucher');
