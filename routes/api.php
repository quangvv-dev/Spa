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
Route::post('test-firebase_token', 'API\ThuChiController@testSendFirebase');
Route::post('callcenter/hangup', 'API\CallController@hangUp');//Api dành cho 3CX
Route::get('callcenter/account_code', 'API\CallController@getAccountCode');//Api dành cho 3CX

Route::post('callcenter/crmSendCallLog', 'API\CallController@hangUp');//api dành cho GTC Telecom
Route::post('callcenter/crmSendIncomingCall', 'API\CallController@inComing');//api dành cho GTC Telecom
Route::post('callcenter/callOut', 'API\CallController@callOut');//api dành cho GTC Telecom

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login-app', 'API\AuthController@login');
Route::post('register', 'API\AuthController@register');

Route::group(['namespace' => 'API'], function () {
    Route::post('Contact/ReceiveData/sc/{id}', 'SourceController@storeCustomerLandipage');
    Route::post('cham-cong', 'ChamCong\ChamCongController@store');
});

Route::group(['middleware' => ['jwt.auth.token'], 'namespace' => 'API'], function () {
    Route::post('block-user', 'AuthController@blockUser');

    Route::get('admin/menu-permissions', 'AuthController@menuPermission');// menu app thong ke
    Route::post('upload/images', 'BaseApiController@apiUpload');
    //ALBUM
    Route::post('albums', 'AlbumController@store');
    Route::delete('albums/{id}', 'AlbumController@delete');
    Route::get('albums', 'AlbumController@index');
    Route::get('albums/{id}', 'AlbumController@show');
    // HỒ sơ khách hàng full
    Route::group(['prefix' => 'preview'], function () {
        Route::get('customers', 'AlbumController@index');
        Route::get('orders/{customer}', 'CustomerController@orders');
        Route::get('therapy/{order}', 'OrderController@therapy');
        Route::get('group-comment/{customer}', 'GroupCommentController@index');
        Route::post('group-comment/{customer}', 'GroupCommentController@store');
        Route::delete('group-comment/{comment}', 'GroupCommentController@destroy');
        Route::get('source', 'AuthController@source');
        Route::apiResource('contact', 'Contact\ContactController');
    });

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

    Route::post('change-password-user', 'AuthController@changePassword');
    Route::get('get-profile', 'AuthController@getProfile');
    Route::post('change-profile', 'AuthController@changeProfile');

    Route::get('branch', 'AuthController@branch');
    Route::get('marketing', 'Marketing\MarketingController@index');
    Route::get('statistic-marketing', 'Marketing\MarketingController@statistic');
    Route::get('statistic-sales', 'SaleController@statistic');//sale
    Route::get('users-marketing', 'Marketing\MarketingController@getMarketingUser');

    Route::get('sales', 'SaleController@salePerfomance');
    Route::get('cskh', 'CSKH\CskhController@index');

    Route::get('carepage', 'Marketing\MarketingController@carepage');//carepage
    Route::get('waiters', 'Marketing\MarketingController@waiters');//Lễ tân
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
    // Route khách hàng
    Route::apiResource('customers', 'CustomerController');
    Route::get('status-customers', 'CustomerController@statusCustomer');
    Route::get('group-customers', 'CustomerController@groupCustomer');
    Route::get('source-customers', 'CustomerController@sourceCustomer');
//    begin chấm công & đơn từ & lịch hẹn (newest)
    Route::get('salary', 'ChamCong\ChamCongController@salary');
    Route::get('approval-history', 'ChamCong\ChamCongController@history');
    Route::get('approval-history-detail', 'ChamCong\ChamCongController@showHistory');
    Route::get('admin/customers-schedules/{customer}', 'SchedulesController@show');
    Route::get('admin/schedules', 'SchedulesController@index');
    Route::put('admin/schedules/{id}', 'SchedulesController@update');
    Route::get('admin/status-schedules', 'SchedulesController@statusSchedules');
    Route::get('approval-orders', 'ChamCong\OrderController@index');
    Route::post('approval-orders', 'ChamCong\OrderController@store');
    Route::post('checkin-orders', 'ChamCong\OrderController@checkInOrder');
    Route::put('approval-orders/{id}', 'ChamCong\OrderController@update');
    Route::get('approval-reason', 'ChamCong\OrderController@getListReason');
    Route::get('approval-accept', 'ChamCong\OrderController@getListAccept');
    Route::get('approval-hours', 'ChamCong\OrderController@getListHours');
    Route::get('teams', 'AuthController@teams');
//end chấm công

    // Doanh thu app thống kê
    Route::group(['prefix' => 'revenue'], function () {
        Route::get('customers', 'RevenueController@index');
        Route::get('orders', 'RevenueController@orders');
        Route::get('charts', 'RevenueController@statusRevenue');
        Route::get('revenue-month', 'RevenueController@revenueMonth');
        Route::get('revenue-days', 'RevenueController@revevueDays');
        Route::get('revenue-branch', 'RevenueController@revevueBranch');
        Route::get('tab-schedules', 'RevenueController@tabSchedules');
        Route::get('tab-thuchi', 'RevenueController@tabThuChi');
        Route::get('source-customers', 'CustomerController@revenueSourceCustomer');
    });
});


Route::post('/check-unique-users', 'BE\UserController@checkUnique');
Route::post('/check-unique-customers', 'BE\CustomerController@checkUniquePhone');
Route::post('/check-unique-code-orders', 'BE\OrderController@checkUniqueCode');

Route::get('/task-schedules', 'API\StatisticController@TaskScheduleSale');
//Post customers
Route::put('posts/{id}', 'API\PostController@update');
Route::get('posts/{id}', 'API\PostController@show');
Route::get('voucher-services', 'API\PromotionController@listVoucherServices');
Route::get('voucher', 'API\PromotionController@listVoucher');
Route::get('voucher/{id}', 'API\PromotionController@checkVoucher');

Route::get('product-depot', 'API\DepotController@productDepot');
Route::get('depots/statistical', 'API\DepotController@index');

Route::get('uri-wallet', 'API\AppCustomers\WalletsController@hiddenWallet');// Ẩn hiện ví


/*
|--------------------------------------------------------------------------
| APIs APP KHÁCH HÀNG
|--------------------------------------------------------------------------
*/


@include('app_customer.php');

/*
|--------------------------------------------------------------------------
| END APP KHÁCH HÀNG
|--------------------------------------------------------------------------
*/
