<?php

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

Route::get('/', [App\Http\Controllers\Controller::class, 'index']);

Auth::routes();
Route::get('/home', [App\Http\Controllers\Controller::class, 'index'])->name('index');
Route::get('/join', [App\Http\Controllers\Controller::class, 'join'])->name('join');
Route::get('/shop', [App\Http\Controllers\Controller::class, 'shop'])->name('shop');
Route::get('/login', [App\Http\Controllers\Controller::class, 'login'])->name('login');
Route::get('/register', [App\Http\Controllers\Controller::class, 'register'])->name('register');
Route::get('/product/{id}', [App\Http\Controllers\ProductController::class, 'view'])->name('single_product');
Route::get('/account', [App\Http\Controllers\Controller::class, 'account'])->name('account');
Route::get('/account/edit', [App\Http\Controllers\Controller::class, 'update_account'])->name('update_account');
Route::get('/account/bank-account', [App\Http\Controllers\Controller::class, 'bank_account'])->name('bank_account');
Route::get('/account/bank-account/add', [App\Http\Controllers\Controller::class, 'add_bank_account'])->name('add_bank_account');
Route::get('withdraw', [App\Http\Controllers\Controller::class, 'withdraw'])->name('withdraw');

Route::get('/joined-records', [App\Http\Controllers\Controller::class, 'join_record'])->name('join_record');
Route::get('/booking-records', [App\Http\Controllers\Controller::class, 'booking_record'])->name('booking_record');
Route::get('/withdraw-records', [App\Http\Controllers\Controller::class, 'withdraw_record'])->name('withdraw_record');
Route::get('/money-records', [App\Http\Controllers\Controller::class, 'money_record'])->name('money_record');

Route::get('/faq', [App\Http\Controllers\Controller::class, 'faq'])->name('faq');
Route::get('/about_us', [App\Http\Controllers\Controller::class, 'about_us'])->name('about_us');
