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
Route::get('/shop', [App\Http\Controllers\ShopController::class, 'shop'])->name('shop');
Route::get('/product/{id}', [App\Http\Controllers\ShopController::class, 'view'])->name('single_product');
Route::get('/login', [App\Http\Controllers\Controller::class, 'login'])->name('login');
Route::get('/register', [App\Http\Controllers\Controller::class, 'register'])->name('register');
Route::post('/submit_register', [App\Http\Controllers\UserController::class, 'submit_register'])->name('submit_register');
Route::post('/submit_login', [App\Http\Controllers\UserController::class, 'submit_login'])->name('submit_login');


Route::middleware(['auth'])->group(function() {
    Route::get('/account', [App\Http\Controllers\Controller::class, 'account'])->name('account');
    Route::get('/account/edit', [App\Http\Controllers\Controller::class, 'update_account'])->name('update_account');
    Route::post('submit_update_account', [App\Http\Controllers\UserController::class, 'submit_update_account'])->name('submit_update_account');
    Route::get('/account/bank-account', [App\Http\Controllers\UserController::class, 'bank_account'])->name('bank_account');
    Route::get('/account/bank-account/add', [App\Http\Controllers\UserController::class, 'add_bank_account'])->name('add_bank_account');
    Route::post('submit_add_bank', [App\Http\Controllers\UserController::class, 'submit_add_bank'])->name('submit_add_bank');
    Route::post('submit_delete_bank', [App\Http\Controllers\UserController::class, 'submit_delete_bank'])->name('submit_delete_bank');
    Route::get('withdraw', [App\Http\Controllers\Controller::class, 'withdraw'])->name('withdraw');
    Route::get('/address', [App\Http\Controllers\UserController::class, 'address'])->name('address');
    Route::get('/add_address', [App\Http\Controllers\UserController::class, 'add_address'])->name('add_address');
    Route::post('/submit_add_address', [App\Http\Controllers\UserController::class, 'submit_add_address'])->name('submit_add_address');
    Route::post('/submit_delete_address', [App\Http\Controllers\UserController::class, 'submit_delete_address'])->name('submit_delete_address');
    Route::get('/payment/{id}', [App\Http\Controllers\ShopController::class, 'payment'])->name('payment');
    Route::post('/submit_payment', [App\Http\Controllers\ShopController::class, 'submit_payment'])->name('submit_payment');
    Route::get('/joined-records', [App\Http\Controllers\Controller::class, 'join_record'])->name('join_record');
    Route::get('/booking-records', [App\Http\Controllers\Controller::class, 'booking_record'])->name('booking_record');
    Route::get('/withdraw-records', [App\Http\Controllers\Controller::class, 'withdraw_record'])->name('withdraw_record');
    Route::get('/money-records', [App\Http\Controllers\Controller::class, 'money_record'])->name('money_record');
    Route::get('/order', [App\Http\Controllers\UserController::class, 'order'])->name('order');
    Route::post('/load_order', [App\Http\Controllers\UserController::class, 'load_order'])->name('load_order');
});

Route::get('/faq', [App\Http\Controllers\Controller::class, 'faq'])->name('faq');
Route::get('/about_us', [App\Http\Controllers\Controller::class, 'about_us'])->name('about_us');
Route::get('/logout', [App\Http\Controllers\UserController::class, 'logout'])->name('logout');

