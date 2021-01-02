<?php

use Illuminate\Support\Facades\Route;

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

Route::get('admin/login', 'App\Http\Controllers\AdminController@login')->name('adminLogin');
Route::post('admin/login', 'App\Http\Controllers\AdminController@doLogin');

//for bot
Route::any('bot/reply', 'App\Http\Controllers\BotController@reply');
Route::get('updateGroupUserInfo', 'App\Http\Controllers\BotController@updateGroupUserInfo');

//login
Route::group(['middleware' => ['auth']], function () {
    Route::get('admin', 'App\Http\Controllers\AdminController@index');
    Route::get('admin/logout', 'App\Http\Controllers\AdminController@logout');
    Route::get('admin/user/edit', 'App\Http\Controllers\AdminController@adminUserEdit')->name('adminUserEdit');
    Route::get('admin/user/create', 'App\Http\Controllers\AdminController@adminUserEdit')->name('adminUserCreate');
    
    Route::post('admin/user/doEdit', 'App\Http\Controllers\AdminController@adminUserDoEdit');
    Route::delete('admin/user/delete', 'App\Http\Controllers\AdminController@adminUserDoDelete');

    Route::get('admin/bot/group/list', 'App\Http\Controllers\AdminController@groupList');
    Route::get('admin/bot/group/user/list', 'App\Http\Controllers\AdminController@groupUserList');
    Route::get('admin/bot/group/user/message', 'App\Http\Controllers\AdminController@groupUserMessage');

    Route::post('admin/togglePrintSetting', 'App\Http\Controllers\AdminController@togglePrintSetting');
    Route::get('admin/bot/group/print/get', 'App\Http\Controllers\AdminController@getGroupPrint');
    Route::get('admin/bot/group/print', 'App\Http\Controllers\AdminController@groupPrint');
    Route::post('admin/bot/group/rePrint', 'App\Http\Controllers\AdminController@rePrint');
    Route::post('admin/bot/group/print/success', 'App\Http\Controllers\AdminController@groupPrintSuccess');
});

