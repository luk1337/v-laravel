<?php

use App\Http\Controllers\ApiKeyController;
use App\Http\Controllers\Auth\ChangePasswordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LatestBansController;
use App\Http\Controllers\UserListController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'getIndex'])->name('home');

Route::get('/api-key', [ApiKeyController::class, 'getIndex'])->name('api-key');
Route::post('/api-key/reset', [ApiKeyController::class, 'postReset'])->name('api-key/reset');
Route::post('/api-key/regen', [ApiKeyController::class, 'postRegen'])->name('api-key/regen');

Route::get('/change-password', [ChangePasswordController::class, 'getIndex'])->name('change-password');
Route::post('/change-password', [ChangePasswordController::class, 'postIndex'])->name('change-password');

Route::get('/list/add/{uuid}', [UserListController::class, 'getAdd'])->name('list/add');
Route::post('/list/add/{uuid}', [UserListController::class, 'postAdd'])->name('list/add');
Route::get('/list/create', [UserListController::class, 'getCreate'])->name('list/create');
Route::post('/list/create', [UserListController::class, 'postCreate'])->name('list/create');
Route::get('/list/delete/{uuid}', [UserListController::class, 'getDelete'])->name('list/delete');
Route::post('/list/delete/{uuid}', [UserListController::class, 'postDelete'])->name('list/delete');
Route::get('/list/delete/{uuid}/{steamid}', [UserListController::class, 'getDeleteAccount'])->name('list/delete/account');
Route::post('/list/delete/{uuid}/{steamid}', [UserListController::class, 'postDeleteAccount'])->name('list/delete/account');
Route::get('/list/edit/{uuid}', [UserListController::class, 'getEdit'])->name('list/edit');
Route::post('/list/edit/{uuid}', [UserListController::class, 'postEdit'])->name('list/edit');
Route::get('/list/my', [UserListController::class, 'getMy'])->name('list/my');
Route::get('/list/my/subscriptions', [UserListController::class, 'getMySubscriptions'])->name('list/my/subscriptions');
Route::get('/list/public', [UserListController::class, 'getPublic'])->name('list/public');
Route::get('/list/subscribe/{uuid}', [UserListController::class, 'getSubscribe'])->name('list/subscribe');
Route::post('/list/subscribe/{uuid}', [UserListController::class, 'postSubscribe'])->name('list/subscribe');
Route::get('/list/unsubscribe/{uuid}', [UserListController::class, 'getUnsubscribe'])->name('list/unsubscribe');
Route::post('/list/unsubscribe/{uuid}', [UserListController::class, 'postUnsubscribe'])->name('list/unsubscribe');
Route::get('/list/show/{uuid}', [UserListController::class, 'getShow'])->name('list/show');

Route::get('/latest-bans', [LatestBansController::class, 'getIndex'])->name('latest-bans');

Auth::routes();
