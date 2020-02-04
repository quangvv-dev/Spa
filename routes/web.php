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
//    Route::get('demo/data-system', 'DBController@index');
    Route::get('fanpage', 'FanpageController@index')->name('fanpage.index');
    Route::post('fanpage', 'FanpageController@store')->name('fanpage.store');
    Route::resource('category', 'CategoryController');
    Route::resource('services', 'ServiceController');
    Route::resource('users', 'UserController')->middleware('admin');
    Route::resource('customers', 'CustomerController');
    Route::post('customers/delete-multiple', 'CustomerController@deleteMultiple');
    Route::post('customers/restore', 'CustomerController@restore');
    Route::post('customers/force-delete', 'CustomerController@forceDelete');
    Route::post('customers/update-multiple-status', 'CustomerController@updateMultipleStatus')->name('customers.update-multiple-status');
    //sms
    Route::resource('sms', 'SmsController');
    Route::post('sent-sms', 'SmsController@sentSms')->name('sms.sent');

    Route::resource('department', 'DepartmentController');
    Route::get('position/{id}', 'PositionController@index')->name('position.index');
    Route::post('position/{id}', 'PositionController@store')->name('position.store');
    Route::put('position/{id}', 'PositionController@update')->name('position.update');
    Route::get('position/edit/{id}', 'PositionController@edit')->name('position.edit');

    Route::get('schedules', 'ScheduleController@homePage')->name('schedules.index');
//    Route::get('schedules/{id}', 'ScheduleController@index')->name('schedules.index');
    Route::post('schedules/{id}', 'ScheduleController@store')->name('schedules.store');
    Route::put('schedules/{id}', 'ScheduleController@update')->name('schedules.update');
    Route::get('schedules/edit/{id}', 'ScheduleController@edit')->name('schedules.edit');

    Route::get('/statistics/', 'StatisticController@index')->name('statistics.index');
    Route::get('/statistics/{id}/detail', 'StatisticController@show')->name('statistics.show');
    //Order
    Route::get('orders/{customer_id?}', 'OrderController@index')->name('orders.create');
    Route::group(['prefix' => 'ajax',], function () {
        Route::get('info-service', 'OrderController@getInfoService');
        Route::get('info-customer', 'OrderController@getInfoCustomer');
        Route::get('info-order-payment/{id}', 'OrderController@infoPayment');
        Route::get('customers/{id}', 'CustomerController@getCustomerById');
        Route::put('customers/{id}', 'CustomerController@ajaxUpdate');
        Route::put('schedules/{id}', 'ScheduleController@ajaxUpdate');
        Route::get('statuses', 'StatusController@getList');
        Route::get('/status-schedules', 'ScheduleController@getList');
        Route::get('categories', 'CategoryController@getListApi');
        Route::put('orders/{id}', 'OrderController@updateCountDay')->name('order.update_count_day');
        Route::get('orders/{id}', 'OrderController@getOrderById');
        Route::get('order-details/{id}', 'OrderController@find');
        Route::get('view-chat/{id}', 'CustomerController@getChat');
        Route::post('view-chat/{id}', 'CustomerController@postChat');
        Route::post('group-comments', 'GroupCommentController@chatAjax');
        Route::post('tasks/update', 'TaskController@updateStatus');
        Route::get('customers', 'CustomerController@getListAjax');
        Route::get('group-comments/{id}', 'GroupCommentController@edit');
    });
    Route::post('order-detail', 'OrderController@store')->name('order-detail.store');
    Route::get('list-orders', 'OrderController@listOrder')->name('order.list');
    Route::get('order/{id}/show', 'OrderController@show')->name('order.show');
    Route::delete('order/{id}/destroy', 'OrderController@destroy')->name('order.destroy');
    Route::get('orders/{id}/edit', 'OrderController@edit')->name('order.edit');
    Route::put('orders/{id}/edit', 'OrderController@update')->name('order.update');
    Route::get('order-pdf/{id}', 'OrderController@orderDetailPdf');
    Route::get('commission/{id}', 'CommissionController@index')->name('commission.index');
    Route::post('commission/{id}', 'CommissionController@store')->name('commission.store');
    Route::put('commission/{id}', 'CommissionController@update')->name('commission.update');
    Route::delete('commission/{id}/delete', 'CommissionController@destroy')->name('commission.destroy');
    Route::put('order/{id}/show', 'OrderController@payment')->name('order.payment');
    Route::delete('order/{id}/delete-payment', 'OrderController@deletePayment')->name('order.delete-payment');
    //Customer import & export
    Route::post('customer-export', 'CustomerController@exportCustomer')->name('customer.export');
    Route::post('customer-import', 'CustomerController@importCustomer');
    Route::post('import-orders', 'OrderController@importDataByExcel');
    //Chart doanh số
    Route::get('chart-revenue', 'ChartController@index');
    //Trao đổi với khách hàng
    Route::get('group_comments/{id}', 'GroupCommentController@index2');
    Route::post('group_comments/{id}', 'GroupCommentController@store');
    Route::get('group-comments/{id}/edit', 'GroupCommentController@edit');
    Route::post('group-comments/{id}/edit', 'GroupCommentController@update');
    Route::delete('group-comments/{id}/delete', 'GroupCommentController@destroy');
    Route::group(['prefix' => 'report'], function () {
        Route::get('customers', 'CustomerController@reportCustomer');
        Route::get('products', 'OrderController@reportProduct');
    });
    Route::resource('tasks', 'TaskController');
    Route::post('tasks-customer', 'TaskController@storeCustomer')->name('task.customer');
});
