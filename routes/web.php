<?php

Auth::routes();
Route::get('vong-quay-may-man', function () {
    return view('post.vongquay');
});
Route::get('post/{slug}', 'BE\AjaxController@indexPost');
Route::post('customer-post', 'BE\AjaxController@storeCustomerPost');
Route::get('optin-form/{id}', 'BE\PostsController@showOptinForm');
Route::get('call-content/{id}', 'BE\CallController@getStreamLink');
Route::get('zalopay', 'BE\WalletController@indexVNPAY')->name('vnpay.index');// hiển thị VNPAY

Route::get('403', function () {
    return view('errors.403');
});
Route::get('privacy-policy', function () {
    return view('policy');
});

Route::get('demo/data-system', 'BE\DBController@index');

Route::group(['middleware' => 'auth', 'namespace' => 'BE'], function () {
    Route::get('/', function () {
        return redirect(url('/customers'));
    });
    Route::get('kanban-board', function () {
        return view('kanban_board.index');
    });

    Route::resource('call-center', 'CallController');
    Route::resource('gifts', 'Gift\GiftController');

    Route::resource('status', 'StatusController');
    Route::resource('category', 'CategoryServiceController');
    Route::resource('category-product', 'CategoryProductController');
    Route::resource('services', 'ServiceController');
    Route::resource('products', 'ProductController');
    Route::resource('combos', 'CombosController');
    Route::resource('users', 'UserController');
    Route::resource('roles', 'RoleController');
    Route::resource('tips', 'PaymentWallet\TipController');
    Route::get('tips-export', 'PaymentWallet\TipController@exportData');
//    Route::resource('users', 'UserController')->middleware('admin');
    Route::resource('customers', 'CustomerController');
    Route::get('customers-group', 'CustomerController@createGroup')->name('customers.indexGroup');
    Route::post('customers-group', 'CustomerController@storeGroup')->name('customers.storeGroup');
    Route::post('customers/delete-multiple', 'CustomerController@deleteMultiple');
    Route::post('customers/restore', 'CustomerController@restore');
    Route::post('customers/force-delete', 'CustomerController@forceDelete');
    Route::post('customers/update-multiple-status', 'CustomerController@updateMultipleStatus')->name('customers.update-multiple-status');
    Route::post('customers/update-multiple-branch', 'CustomerController@updateBranch')->name('customers.update-multiple-branch');
    //sms
    Route::resource('sms', 'SmsController');
    Route::post('send-sms-customer', 'SmsController@sendSmsCustomer')->name('sms.sentCustomer');
    Route::post('sent-sms', 'SmsController@sentSms')->name('sms.sent');
    Route::post('save-sms', 'SmsController@saveSmsSchedules')->name('sms.saveSchedules');
    Route::get('history-sms', 'SmsController@history')->name('sms.history');
    Route::post('sent-sms-multiple', 'SmsController@sendSmsMultiple')->name('sms.sentMultiple');

    Route::resource('department', 'DepartmentController');
    Route::get('position/{id}', 'PositionController@index')->name('position.index');
    Route::post('position/{id}', 'PositionController@store')->name('position.store');
    Route::put('position/{id}', 'PositionController@update')->name('position.update');
    Route::get('position/edit/{id}', 'PositionController@edit')->name('position.edit');

    Route::get('schedules', 'ScheduleController@homePage')->name('schedules.index');
    Route::post('schedules/{id}', 'ScheduleController@store')->name('schedules.store');
    Route::put('schedules/{id}', 'ScheduleController@update')->name('schedules.update');
    Route::get('schedules/edit/{id}', 'ScheduleController@edit')->name('schedules.edit');
    Route::delete('schedules/{id}', 'ScheduleController@destroy')->name('schedules.destroy');

    Route::get('chart-pay', 'StatisticController@chartPay')->name('statistics.chartPay');
    Route::get('/statistics', 'StatisticController@index')->name('statistics.index');
    Route::get('/statistics/{id}/detail', 'StatisticController@show')->name('statistics.show');
    Route::get('/statistics-task', 'StatisticController@taskSchedules')->name('statistics.taskSchedules');
    Route::get('settings', 'SettingController@index')->name('settings.index');
    Route::post('settings', 'SettingController@storeRank')->name('settings.storeRank');
    Route::get('super-admin', 'SettingController@indexAdmin')->name('settings.indexAdmin');
    Route::post('super-admin', 'SettingController@storeAdmin')->name('settings.storeAdmin');
    Route::post('store-branch', 'SettingController@storeBranch')->name('settings.storeBranch');
    Route::post('store-location', 'SettingController@storeLocation')->name('settings.storeLocation');
    Route::put('branch/{id}', 'SettingController@updateBranch')->name('settings.updateBranch');
    Route::put('location/{id}', 'SettingController@updateLocation')->name('settings.updateLocation');
    Route::delete('branch/{id}', 'SettingController@destroy')->name('settings.destroy');
    Route::delete('location/{id}', 'SettingController@deleteLocation')->name('settings.deleteLocation');
    Route::get('settings/phan-bo-data', 'SettingController@phanbo')->name('settings.phanbo');//Phân bổ data Sale
    Route::post('settings/post', 'SettingController@postPhanBo')->name('settings.postPhanBo');

    //Order
    Route::get('orders/{customer_id?}', 'OrderController@index')->name('orders.create');
    Route::get('orders-service/{customer_id?}', 'OrderController@indexService')->name('ordersService.create');

    Route::group(['prefix' => 'ajax'], function () {
        Route::get('services-with-order/{id}', 'AjaxController@getServiceWithOrder');
        Route::get('info-service', 'OrderController@getInfoService');
        Route::get('info-customer', 'OrderController@getInfoCustomer');
        Route::get('info-order-payment/{id}', 'OrderController@infoPayment');
        Route::get('customers/{id}', 'CustomerController@getCustomerById');
        Route::put('customers/{id}', 'CustomerController@ajaxUpdate');
        Route::put('schedules/{id}', 'ScheduleController@ajaxUpdate');
        Route::get('statuses', 'StatusController@getList');
        Route::get('genitives', 'GenitiveController@getList');
        Route::get('/status-schedules', 'ScheduleController@getList');
        Route::get('categories', 'CategoryServiceController@getListApi');
        Route::get('categories-tips', 'CategoryServiceController@getListTip');
        Route::put('orders/{id}', 'OrderController@updateCountDay')->name('order.update_count_day');
        Route::put('orders_sum/{id}', 'OrderController@sumCountDay')->name('order.sum_count_day');
        Route::get('orders/{id}', 'OrderController@getOrderById');
        Route::get('order-details/{id}', 'OrderController@find');
        Route::get('view-chat/{id}', 'CustomerController@getChat');
        Route::post('view-chat/{id}', 'CustomerController@postChat');
        Route::post('group-comments', 'GroupCommentController@chatAjax');
        Route::get('customers', 'CustomerController@getListAjax');
        Route::get('group-comments/{id}', 'GroupCommentController@edit');
        Route::put('update-type-orders/{id}', 'OrderController@updateType');
        Route::any('updatePostion', 'StatusController@updatePostion');
        Route::any('updateColor', 'StatusController@updateColor');
        Route::get('count-customer', 'SmsController@getCountCustomer');//sms count customer
        Route::get('settings', 'SettingController@store');
        Route::get('commission', 'CommissionController@getCommissionWithUser');
        Route::put('tasks/{id}', 'TaskController@ajaxUpdate');
        Route::get('count-notifications', 'AjaxController@countNotification');
        Route::get('notifications', 'AjaxController@getNotification');
        Route::get('change-notification/{id}', 'AjaxController@updateNotification');
        Route::post('tasks/update', 'TaskController@updateStatus');
        Route::get('tasks/{id}', 'TaskController@findTask');

        Route::post('image/store', 'AjaxController@store');
        Route::post('image/destroy', 'AjaxController@destroy');
        Route::put('update-customer-post', 'AjaxController@updateCustomerPost')->name('customer_post.update');
        Route::post('convert-customer-post', 'AjaxController@convertCustomerPost')->name('customer_post.convert');
        Route::get('export-customer-post', 'AjaxController@exportCustomer')->name('customer_post.export');
        Route::get('find-customer-post', 'AjaxController@findCustomerPost')->name('customer_post.find');
        Route::get('find-role/{department_id}', 'AjaxController@getRoleWithDepartment');

        Route::get('product-depot/{id}', 'Depot\ProductDepotController@getDetail');
        Route::post('change-status-thu-chi', 'ThuChi\ThuChiController@changeStatus');

        Route::post('marketing/add-line-price-marketing', 'Marketing\MarketingController@addLinePriceMarketing');
        Route::get('marketing/search-price-marketing', 'Marketing\MarketingController@searchPriceMarketing');

//        Route::delete('marketing/price-marketing', 'Marketing\MarketingController@destroy');
        Route::post('user-filter-grid', 'SettingController@userFilterGrid');

        Route::get('report/detail-hoa-hong/{user_id}', 'CommissionController@detailHoaHong');
    });

    Route::resource('rules', 'RuleController');//Automation
    Route::get('rules/{id}/delete', 'RuleController@delete');
    Route::get('orders-payment', 'OrderController@listOrderPayment')->name('order.index_payment');//đã thu trong kỳ
    Route::post('order-detail', 'OrderController@store')->name('order-detail.store');
    Route::get('list-orders', 'OrderController@listOrder')->name('order.list');
    Route::get('order/{id}/show', 'OrderController@show')->name('order.show');
    Route::get('orders-destroy', 'OrderController@getOrderDestroy')->name('order.orders-destroy');//đã thu trong kỳ

    Route::delete('order/{id}/destroy', 'OrderController@destroy')->name('order.destroy');
    Route::get('orders-service/{id}/edit', 'OrderController@editService')->name('orderService.edit');
    Route::get('orders/{id}/edit', 'OrderController@edit')->name('order.edit');
    Route::put('orders/{id}/edit', 'OrderController@update')->name('order.update');
    Route::get('order-pdf/{id}', 'OrderController@orderDetailPdf');
    Route::get('wallet-pdf/{id}', 'PaymentWallet\PaymentWalletController@pdf');

    Route::get('commission/{id}', 'CommissionController@index')->name('commission.index');
    Route::post('commission/{id}', 'CommissionController@store')->name('commission.store');
    Route::put('commission/{id}', 'CommissionController@update')->name('commission.update');
    Route::delete('commission/{id}/delete', 'CommissionController@destroy')->name('commission.destroy');
    Route::put('order/{id}/show', 'OrderController@payment')->name('order.payment');
    Route::delete('order/{id}/delete-payment', 'OrderController@deletePayment')->name('order.delete-payment');
    //Customer import & export
    Route::post('customer-export', 'CustomerController@exportCustomer')->name('customer.export');
    Route::post('customer-import', 'CustomerController@importCustomer')->name('customer.import');
    Route::post('import-orders', 'OrderController@importDataByExcel');
    Route::get('product-export', 'ProductController@exportData')->name('product.export');
    Route::post('product-import', 'ProductController@importData')->name('product.import');
    //Chart doanh số
    Route::get('chart-revenue', 'ChartController@index');
    //Trao đổi với khách hàng
    Route::get('group_comments/{id}', 'GroupCommentController@index2');
    Route::post('group_comments/{id}', 'GroupCommentController@store');
    Route::get('group-comments/{id}/edit', 'GroupCommentController@edit');
    Route::post('group-comments/{id}/edit', 'GroupCommentController@update');
    Route::delete('group-comments/{id}/delete', 'GroupCommentController@destroy');
    Route::group(['prefix' => 'report'], function () {//Chart doanh số
        Route::get('customers', 'CustomerController@reportCustomer')->name('report.customers');
        Route::get('products', 'OrderController@reportProduct');
        Route::get('sales', 'SalesController@index')->name('report.sale');
        Route::get('sale-ranking', 'SalesController@ranking')->name('report.saleRanking');
        Route::get('group-sale', 'SalesController@indexGroupCategory')->name('report.groupSale');
        Route::get('commission', 'CommissionController@statistical')->name('report.commission');
        Route::get('hoa-hong-ctv', 'CommissionController@statisticalCTV');
        Route::get('hoa-hong', 'CommissionController@statisticalRose')->name('report.hoa-hong');
        Route::get('waiters', 'CommissionController@statisticalWaiters')->name('report.waiters');
        Route::get('tasks', 'TaskController@statistical')->name('report.tasks');
        Route::get('branchs', 'Branch\BranchController@index')->name('report.branchs');
    });
    Route::resource('promotions', 'PromotionController');
    Route::resource('trademark', 'TrademarkController');
    Route::resource('genitives', 'GenitiveController');
    Route::resource('tasks', 'TaskController');
    Route::get('tasks-employee', 'TaskController@statisticIndex')->name('tasks.employee');
    Route::get('notifications', 'AjaxController@getNotificationOutView')->name('notifications.index');
    Route::resource('payment-wallet', 'PaymentWallet\PaymentWalletController');
    Route::resource('wallet', 'WalletController');
    Route::resource('package', 'PackageController');
    Route::post('tasks-customer', 'TaskController@storeCustomer')->name('task.customer');
    Route::resource('posts', 'PostsController');
    Route::resource('landipages', 'LandipageController');
    Route::get('form/{id}', 'PostsController@showForm');
    Route::get('customer-post', 'AjaxController@ListCustomerPost')->name('post.customer');

//KHO VAN
    Route::group(['prefix' => 'depots', 'as' => 'depots.', 'namespace' => 'Depot'], function () {
        Route::resource('product', 'ProductDepotController');
        Route::resource('history', 'HistoryDepotController');
        Route::resource('list', 'DepotController');
        Route::get('statistical', 'HistoryDepotController@statistical');
        Route::post('import-product', 'ProductDepotController@import')->name('import');
    });

    Route::resource('danh-muc-thu-chi', 'ThuChi\DanhMucController');
    Route::resource('ly-do-thu-chi', 'ThuChi\LyDoController');
    Route::resource('thu-chi', 'ThuChi\ThuChiController');
    Route::post('export-thu-chi', 'ThuChi\ThuChiController@exportExcel')->name('thu-chi.export');
    Route::get('get-ly-do-thu-chi/{category_id}', 'ThuChi\ThuChiController@category');


    Route::group(['namespace' => 'Marketing', 'prefix' => 'marketing', 'as' => 'marketing.'], function () {
        Route::resource('fanpage', 'FanpageController');
        Route::resource('fanpage-post', 'FanpagePostController');
        Route::post('storePost', 'FanpagePostController@storeCustom')->name('fanpage_post.storeCustom');

        Route::resource('seeding-number', 'SeedingNumberController');
        Route::delete('delete-seeding', 'SeedingNumberController@deleteSeeding');
        Route::resource('source-fb', 'SourceController');
        Route::resource('source-landipage', 'LandipageController');
        Route::post('update-accept-source', 'SourceController@updateAcceptSource');
        Route::post('update-accept-source-landi', 'LandipageController@updateAcceptSource');

        Route::get('leader', 'MarketingController@index');
        Route::get('dashboard', 'MarketingController@show')->name('dashboard');
        Route::delete('dashboard/{id}', 'MarketingController@destroy');
        Route::get('ranking', 'MarketingController@ranking');

        Route::get('carepage', 'CarepageController@index');
        Route::get('carepage-ranking', 'CarepageController@ranking');

        //Chat
        Route::get('chat-messages', 'ChatController@chatFanpage')->name('chat-messages');
        Route::get('chat-messages/{page_id}', 'ChatController@index');
        Route::get('chat-multi-page', 'ChatController@chatMultiPage')->name('chat-multi-page');
        Route::get('get-token-fanpage/{id}', 'ChatController@getFanpageToken');
        Route::get('get-phone-page', 'ChatController@getPhonePage');
        Route::get('get-comment-page', 'ChatController@getCommentPage');
        Route::get('get-detail-comment', 'ChatController@getDetailComment');

        Route::post('update-comment/{id}', 'ChatController@updateContentComment');// cập nhật nội dung comment

        Route::post('update-is-read-comment', 'ChatController@updateReadComment');
        Route::get('get-data-form-customer', 'ChatController@getDataFormCustomer');
        Route::post('create-customer', 'ChatController@createCustomer');

        Route::resource('setting-quick-reply','SettingChatController');
        Route::get('setting-quick-reply/{page_id}/create', 'SettingChatController@create');
        Route::post('setting-quick-reply/{page_id}/create', 'SettingChatController@insertSettingChat');
        Route::post('setting-quick-reply/sync/{page_id}', 'SettingChatController@syncQuick');
        Route::put('setting-quick-reply/{page_id}/setting/{id}', 'SettingChatController@updateSettingChat');
        Route::post('setting-quick-reply/test','SettingChatController@test');
        Route::post('setting-quick-reply/delete-image','SettingChatController@deleteImage');
        Route::post('setting-quick-reply/import/{page_id}','SettingChatController@importExcel');
        Route::get('get-quick-reply/{page_id}', 'SettingChatController@getQuickReply');

        //Chat multi_page
        Route::get('get-data-group/{group_id}','ChatController@getDataGroup');
        Route::post('add-group','ChatController@addGroup');
        Route::put('update-group','ChatController@updateGroup');
        Route::delete('delete-group/{id}','ChatController@deleteGroup');
        Route::post('create-comment-customer','ChatController@createCommentCustomer');

    });
    Route::group(['namespace' => 'Setting', 'prefix' => 'settings', 'as' => 'settings.'], function () {
        Route::resource('time-status','TimeStatusController');
    });

    Route::group(['namespace' => 'ChamCong', 'prefix' => 'approval', 'as' => 'approval.'], function () {
        Route::resource('order', 'OrderController');
        Route::get('order/create/{type}', 'OrderController@createOrder');
        Route::get('order/edit/{order_id}', 'OrderController@editOrder');
        Route::get('order/show/{id}/{type}', 'OrderController@showDetail');
        Route::put('update-order','OrderController@accept');
        Route::put('update-array-order','OrderController@acceptArrayOrder');
        Route::get('statistic', 'StatisticController@index');
        Route::get('history', 'StatisticController@history');
        Route::get('show-history', 'StatisticController@showHistory');
        Route::get('get-detail-cham-cong','StatisticController@getDetail');

        Route::post('import-salary', 'StatisticController@importSalary');
        Route::get('salary', 'StatisticController@salary');
        Route::get('history-import-salary', 'StatisticController@historyImportSalary');
        Route::delete('delete-history-salary/{id}', 'StatisticController@deleteImportSalary');
        Route::get('detail-history-salary/{id}', 'StatisticController@detailHistory');

        Route::resource('reason', 'ReasonController');

        Route::get('export-data-approval','StatisticController@exportDataApproval');
    });

    Route::get('login/facebook', 'Marketing\FanpageController@postLoginFB')->name('facebook.login');
    Route::get('login/facebook/callback', 'Marketing\FanpageController@callbackFB');
    Route::get('remove-account-facebook', 'Marketing\FanpageController@removeAccount')->name('facebook.removeAccount');

//    Route::get('test-cham-cong',)
});
