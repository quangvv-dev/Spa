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
Auth::routes();

Route::group(['middleware' => 'auth', 'namespace' => 'BE'], function () {
    Route::get('/', function () {
        return view('dashboard.index');
    });

    Route::resource('status', 'StatusController');
    Route::resource('category', 'CategoryController');
    Route::resource('services', 'ServiceController');
    Route::resource('users', 'UserController')->middleware('admin');
    Route::resource('customers', 'CustomerController');
    Route::get('profiles/{id}/edit', 'UserController@getEditProfile');
    Route::put('profiles/{id}/edit', 'UserController@postEditProfile');

    Route::get('/statistics/', 'StatisticController@index')->name('statistics.index');
    Route::get('/statistics/{id}/detail', 'StatisticController@show')->name('statistics.show');
    //Order
    Route::get('order/{id}', 'OrderController@index');
    Route::group(['prefix' => 'ajax',], function () {
        Route::get('info-service', 'OrderController@getInfoService');
        Route::get('info-customer', 'OrderController@getInfoCustomer');

    });
    Route::post('order-detail', 'OrderController@store')->name('order-detail.store');
    Route::get('list-orders', 'OrderController@listOrder')->name('order.list');
//    Route::get('list-order-detail', 'OrderDetailController@index')->name('order-detail.index');
    Route::get('order/{id}/show', 'OrderController@show')->name('order.show');
    Route::get('order-pdf/{id}', 'OrderController@orderDetailPdf');
});
