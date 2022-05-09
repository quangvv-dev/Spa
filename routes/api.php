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
Route::post('callcenter/hangup', 'API\CallController@hangUp');


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login-app', 'API\AuthController@login');
Route::post('register', 'API\AuthController@register');

Route::group(['namespace' => 'API'], function () {
    Route::post('Contact/ReceiveData/sc/{id}', 'SourceController@storeCustomerLandipage');
});

Route::group(['middleware' => ['jwt.auth.token'], 'namespace' => 'API'], function () {
    Route::post('upload/images', 'BaseApiController@apiUpload');
    //ALBUM
    Route::post('albums', 'AlbumController@store');
    Route::delete('albums/{id}', 'AlbumController@delete');
    Route::get('albums', 'AlbumController@index');
    Route::get('albums/{id}', 'AlbumController@show');
    //THU CHI
    Route::get('pay', 'ThuChiController@index');
    Route::post('pay/{id}', 'ThuChiController@update');
    Route::get('notification-pay', 'ThuChiController@getNotification');
    Route::post('notification-pay/{id}', 'ThuChiController@readNotification');
    Route::get('count-notification-pay', 'ThuChiController@countNotification');

    Route::get('list-creator-centor', 'ThuChiController@listUserThuChi');
    Route::get('list-category-chi', 'ThuChiController@getCategory');
    //Test sms
    Route::get('sent-test-sms', 'AuthController@testSendSMS');

    Route::post('update-firebase_token', 'ThuChiController@updateDevicesToken');
    Route::post('test-firebase_token', 'ThuChiController@testSendFirebase');

    Route::post('change-password', 'AuthController@changePassword');
    Route::get('get-profile', 'AuthController@getProfile');
    Route::post('change-profile', 'AuthController@changeProfile');

    Route::get('branch', 'AuthController@branch');
    Route::get('marketing', 'Marketing\MarketingController@index');
    Route::get('sales', 'SaleController@sale');
    Route::get('call', 'CallController@index');
    Route::get('orders', 'OrderController@index');
    Route::get('orders/{id}', 'OrderController@show');
    Route::get('commission', 'OrderController@commission');
    Route::get('orders', 'OrderController@index');
    Route::get('tuvanvien', 'OrderController@tuvanvien');
    Route::get('schedules', 'StatisticController@schedules');
    Route::get('tasks', 'StatisticController@tasks');
    Route::get('group', 'StatisticController@group');
    Route::get('group/{id}', 'StatisticController@groupDetail');
    Route::get('get-employee-category', 'StatisticController@getUserCategory');
    Route::get('get-employee-call', 'CallController@getEmployeeCall');
    Route::group(['prefix' => 'revenue'], function () {
        Route::get('customers', 'RevenueController@index');
        Route::get('orders', 'RevenueController@orders');
        Route::get('charts', 'RevenueController@statusRevenue');
        Route::get('revenue-month', 'RevenueController@revenueMonth');
        Route::get('revenue-days', 'RevenueController@revevueDays');
        Route::get('revenue-branch', 'RevenueController@revevueBranch');
        Route::get('tab-schedules', 'RevenueController@tabSchedules');
        Route::get('tab-thuchi', 'RevenueController@tabThuChi');
    });

});


Route::post('/check-unique-users', 'BE\UserController@checkUnique');
Route::post('/check-unique-customers', 'BE\CustomerController@checkUniquePhone');
Route::post('/check-unique-code-orders', 'BE\OrderController@checkUniqueCode');
//Route::get('/statistics', 'API\StatisticController@index');
//Route::get('/statistics-all', 'API\StatisticController@getAllBranch');
//Route::get('/sales', 'API\StatisticController@sales');
//Route::get('/sales-with-branch', 'API\StatisticController@saleWithBranch');
//Route::get('/campaigns', 'API\StatisticController@campaign');
//Route::get('/campaign-with-branch', 'API\StatisticController@campaignWithBranch');
//Route::get('tab-schedules', 'API\RevenueController@tabSchedules');

Route::get('/task-schedules', 'API\StatisticController@TaskScheduleSale');
//Post customers
Route::put('posts/{id}', 'API\PostController@update');
Route::get('posts/{id}', 'API\PostController@show');
Route::get('voucher-services', 'API\PromotionController@listVoucherServices');
Route::get('voucher', 'API\PromotionController@listVoucher');
Route::get('voucher/{id}', 'API\PromotionController@checkVoucher');

Route::get('product-depot', 'API\DepotController@productDepot');
Route::get('depots/statistical', 'API\DepotController@index');

/*
|--------------------------------------------------------------------------
| APIs APP KHÁCH HÀNG
|--------------------------------------------------------------------------
*/


Route::group(['namespace' => 'API\AppCustomers'], function () { // Route non token

    Route::post('login-customer', 'AuthController@login');
    Route::post('forgot-password', 'AuthController@forgotPassword');
    Route::get('check-phone-exist', 'AuthController@checkPhoneExist');
    Route::get('services', 'HomePageController@getServices');
    Route::get('products', 'HomePageController@getProducts');
    Route::get('news', 'HomePageController@news');
    Route::get('get-distance-branch', 'HomePageController@getBranchWithDistance');

});

Route::group(['middleware' => ['jwt.auth.token'], 'namespace' => 'API\AppCustomers'], function () {

    Route::post('change-password', 'AuthController@changePassword');

});

