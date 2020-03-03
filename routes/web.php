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

Route::get('/', 'HomeController@getIndex')->name('home');

Route::get('/api-key', 'ApiKeyController@getIndex')->name('api-key');
Route::post('/api-key/reset', 'ApiKeyController@postReset')->name('api-key/reset');
Route::post('/api-key/regen', 'ApiKeyController@postRegen')->name('api-key/regen');

Route::get('/change-password', 'Auth\ChangePasswordController@getIndex')->name('change-password');
Route::post('/change-password', 'Auth\ChangePasswordController@postIndex')->name('change-password');

Route::get('/list/add/{uuid}', 'UserListController@getAdd')->name('list/add');
Route::post('/list/add/{uuid}', 'UserListController@postAdd')->name('list/add');
Route::get('/list/create', 'UserListController@getCreate')->name('list/create');
Route::post('/list/create', 'UserListController@postCreate')->name('list/create');
Route::get('/list/delete/{uuid}', 'UserListController@getDelete')->name('list/delete');
Route::post('/list/delete/{uuid}', 'UserListController@postDelete')->name('list/delete');
Route::get('/list/delete/{uuid}/{steamid}', 'UserListController@getDeleteAccount')->name('list/delete/account');
Route::post('/list/delete/{uuid}/{steamid}', 'UserListController@postDeleteAccount')->name('list/delete/account');
Route::get('/list/edit/{uuid}', 'UserListController@getEdit')->name('list/edit');
Route::post('/list/edit/{uuid}', 'UserListController@postEdit')->name('list/edit');
Route::get('/list/my', 'UserListController@getMy')->name('list/my');
Route::get('/list/my/subscriptions', 'UserListController@getMySubscriptions')->name('list/my/subscriptions');
Route::get('/list/public', 'UserListController@getPublic')->name('list/public');
Route::get('/list/subscribe/{uuid}', 'UserListController@getSubscribe')->name('list/subscribe');
Route::post('/list/subscribe/{uuid}', 'UserListController@postSubscribe')->name('list/subscribe');
Route::get('/list/unsubscribe/{uuid}', 'UserListController@getUnsubscribe')->name('list/unsubscribe');
Route::post('/list/unsubscribe/{uuid}', 'UserListController@postUnsubscribe')->name('list/unsubscribe');
Route::get('/list/show/{uuid}', 'UserListController@getShow')->name('list/show');

Route::get('/latest-bans', 'LatestBansController@getIndex')->name('latest-bans');

Auth::routes();
