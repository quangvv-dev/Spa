<?php
use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'API\AppCustomers'], function () { // Route non token

    Route::post('otp', 'AuthController@getOtp');
    Route::post('login-customer-otp', 'AuthController@loginOTP');
    Route::post('login-customer', 'AuthController@login');
    Route::post('forgot-password', 'AuthController@forgotPassword');
    Route::get('check-phone-exist', 'AuthController@checkPhoneExist');
    Route::get('services', 'HomePageController@getServices');
    Route::get('products', 'HomePageController@getProducts');
    Route::get('news', 'HomePageController@news');
    Route::get('get-category', 'HomePageController@category');
    Route::get('get-distance-branch', 'HomePageController@getBranchWithDistance');
    Route::post('register-customer', 'AuthController@register');

});

Route::group(['middleware' => ['jwt.auth.token'], 'namespace' => 'API\AppCustomers'], function () {

    Route::post('block-customer', 'AuthController@inactiveApp');
    Route::post('change-password', 'AuthController@changePassword');
    Route::get('schedules', 'SchedulesController@index');
    Route::post('schedules', 'SchedulesController@store');
    Route::get('schedules/{id}', 'SchedulesController@show');
    Route::delete('schedules/{id}', 'SchedulesController@destroy');
    Route::get('get-albums-with-me', 'HomePageController@album');
    Route::get('info', 'AuthController@info');
    Route::post('update-agency', 'AuthController@updateAgency');
    Route::post('update-device-token-customer', 'AuthController@updateDevicesTokenCustomer');
    Route::post('update-info', 'AuthController@updateProfile');
    Route::get('vourchers', 'AuthController@vouchers');
    Route::get('service-process', 'HomePageController@serviceProcess');//DV trừ liệu trình
    Route::get('process', 'HomePageController@process');//Lịch sử liệu trình
    Route::get('promotions', 'VouchersController@index');//Danh sách voucher
    Route::get('promotions-used', 'VouchersController@used');//Danh sách voucher

    Route::get('packages', 'OrdersController@getPackage');//Danh sách gói nạp
    Route::post('orders-wallet', 'OrdersController@storeWallet');// Tạo đơn nạp ví
    Route::delete('destroy-wallet/{id}', 'OrdersController@destroyWallet');// Xóa đơn nạp ví
    Route::get('ranking-wallet', 'OrdersController@rankingWallet');
    Route::get('history-change-wallet', 'OrdersController@historyChangeWallet');// lịch sử thanh đổi ví
    Route::get('history-change-wallet-ctv', 'WalletsController@index');// lịch sử thanh đổi ví CTV
    Route::get('history-change-wallet-ctv/{id}', 'WalletsController@show');// Chi tiết lịch sử ví CTV
    Route::post('receive-money', 'WalletsController@receiveMoney');// Chuyển từ ví ctv sang ví thường
    Route::post('withdraw', 'WalletsController@withdraw');// Y/C rút tiền
    Route::get('orders-with-me', 'OrdersController@index');
    Route::post('rate-orders/{id}', 'OrdersController@rate');
    Route::post('rate-history/{id}', 'OrdersController@rateHistory');

    Route::get('notification-customers', 'NotificationController@index');//thông báo khách hàng
    Route::get('count-notification-customers', 'NotificationController@countNotification');//Đếm số thông báo
    Route::post('read-notification-customers/{id}', 'NotificationController@readNotification');//Đọc thông báo
});

Route::get('orders-wallet-zalopay', 'API\AppCustomers\OrdersController@createOrderVNPay');// Tạo thanh toán vnpay
Route::get('push-zalo-pay', 'API\AppCustomers\OrdersController@pushZALOPay');
Route::post('callback-zalo-pay', 'API\AppCustomers\OrdersController@callbackZALOPay');

/*
|--------------------------------------------------------------------------
| END APP KHÁCH HÀNG
|--------------------------------------------------------------------------
*/
