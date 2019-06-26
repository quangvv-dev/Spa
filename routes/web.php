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
    Route::resource('department', 'DepartmentController');
    Route::get('schedules/{id}', 'ScheduleController@index')->name('schedules.index');
    Route::post('schedules/{id}', 'ScheduleController@store')->name('schedules.store');
    Route::put('schedules/{id}', 'ScheduleController@update')->name('schedules.update');
    Route::get('schedules/edit/{id}', 'ScheduleController@edit')->name('schedules.edit');

    Route::get('/statistics/', 'StatisticController@index')->name('statistics.index');
    Route::get('/statistics/{id}/detail', 'StatisticController@show')->name('statistics.show');
    //Order
    Route::get('orders', 'OrderController@index')->name('orders.create');
    Route::group(['prefix' => 'ajax',], function () {
        Route::get('info-service', 'OrderController@getInfoService');
        Route::get('info-customer', 'OrderController@getInfoCustomer');
        Route::get('info-order-payment/{id}', 'OrderController@infoPayment');
    });
    Route::post('order-detail', 'OrderController@store')->name('order-detail.store');
    Route::get('list-orders', 'OrderController@listOrder')->name('order.list');
//    Route::get('list-order-detail', 'OrderDetailController@index')->name('order-detail.index');
    Route::get('order/{id}/show', 'OrderController@show')->name('order.show');
    Route::get('order-pdf/{id}', 'OrderController@orderDetailPdf');
    Route::get('commission/{id}', 'CommissionController@index')->name('commission.index');
    Route::post('commission/{id}', 'CommissionController@store')->name('commission.store');
    Route::put('commission/{id}', 'CommissionController@update')->name('commission.update');
    Route::put('order/{id}/show', 'OrderController@payment')->name('order.payment');
    //Customer import & export
    Route::get('customer-export', 'CustomerController@exportCustomer');
    Route::get('customer-import', 'CustomerController@importCustomer');

});
