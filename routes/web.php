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

Route::get('/', 'HomeController@getIndex')->name('home');

Route::get('/list/create', 'UserListController@getCreate')->name('list/create');
Route::post('/list/create', 'UserListController@postCreate')->name('list/create');
Route::get('/list/delete/{uuid}', 'UserListController@getDelete')->name('list/delete');
Route::post('/list/delete/{uuid}', 'UserListController@postDelete')->name('list/delete');
Route::get('/list/edit/{uuid}', 'UserListController@getEdit')->name('list/edit');
Route::post('/list/edit/{uuid}', 'UserListController@postEdit')->name('list/edit');
Route::get('/list/my', 'UserListController@getMy')->name('list/my');
Route::get('/list/public', 'UserListController@getPublic')->name('list/public');
Route::get('/list/show/{uuid}', 'UserListController@getShow')->name('list/show');

Auth::routes();