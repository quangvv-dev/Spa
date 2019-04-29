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
    Route::get('/users', function () {
        return view('users.index');
    });
    Route::resource('status', 'StatusController');
    Route::resource('category', 'CategoryController');
    Route::resource('services', 'ServiceController');
    Route::resource('users', 'UserController');
    Route::get('profiles/{id}/edit', 'UserController@getEditProfile');
    Route::put('profiles/{id}/edit', 'UserController@postEditProfile');
});
