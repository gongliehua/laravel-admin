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

Route::view('/', 'welcome');

// 后台路由
Route::group(['prefix'=>config('admin.routePrefix'), 'namespace'=>'Admin', 'middleware'=>['web', 'admin']], function () {
    Route::any('/', 'IndexController@index')->name('admin');
    Route::any('profile', 'IndexController@profile')->name('admin.profile');
    Route::any('login', 'IndexController@login')->name('admin.login');
    Route::any('logout', 'IndexController@logout')->name('admin.logout');
});
