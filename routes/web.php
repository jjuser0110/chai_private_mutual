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

Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);

Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('index');
// Route::get('/history', [App\Http\Controllers\HomeController::class, 'history'])->name('history')->middleware('auth');
// Route::get('/bonus', [App\Http\Controllers\HomeController::class, 'bonus'])->name('bonus');
// Route::get('/profile', [App\Http\Controllers\HomeController::class, 'profile'])->name('profile')->middleware('auth');
// Route::get('/chat', [App\Http\Controllers\HomeController::class, 'chat'])->name('chat');
// Route::get('/resetpassword', [App\Http\Controllers\HomeController::class, 'resetpassword'])->name('resetpassword');
// Route::get('/forgotpassword', [App\Http\Controllers\HomeController::class, 'forgotpassword'])->name('forgotpassword');
// Route::get('/deposit', [App\Http\Controllers\HomeController::class, 'deposit'])->name('deposit')->middleware('auth');
// Route::get('/withdraw', [App\Http\Controllers\HomeController::class, 'withdraw'])->name('withdraw')->middleware('auth');
// Route::get('/add_bank', [App\Http\Controllers\HomeController::class, 'add_bank'])->name('add_bank')->middleware('auth');
// Route::get('/downline', [App\Http\Controllers\HomeController::class, 'downline'])->name('downline')->middleware('auth');


// Route::post('/forgot_password_request', [App\Http\Controllers\UserController::class, 'forgot_password_request'])->name('forgot_password_request');
// Route::post('/forgot_password_update', [App\Http\Controllers\UserController::class, 'forgot_password_update'])->name('forgot_password_update');

// //start function
// Route::post('/user_register', [App\Http\Controllers\UserController::class, 'user_register'])->name('user_register');
// Route::post('/sendsms', [App\Http\Controllers\SMSController::class, 'sendsms'])->name('sendsms');
// Route::post('/resetpasswordotp', [App\Http\Controllers\SMSController::class, 'resetpasswordotp'])->name('resetpasswordotp');
// Route::post('/submit_deposit', [App\Http\Controllers\CdmController::class, 'submit_deposit'])->name('submit_deposit')->middleware('auth');
// Route::post('/form_change_password', [App\Http\Controllers\UserController::class, 'form_change_password'])->name('form_change_password')->middleware('auth');
// Route::post('/submit_withdraw', [App\Http\Controllers\CdmController::class, 'submit_withdraw'])->name('submit_withdraw')->middleware('auth');
// Route::post('/create_user_bank', [App\Http\Controllers\UserController::class, 'create_user_bank'])->name('create_user_bank')->middleware('auth');
// Route::get('/game_click/{game_short_name}', [App\Http\Controllers\GameController::class, 'game_click'])->name('game_click')->middleware('auth');
// Route::get('/start_game/{game_short_name}', [App\Http\Controllers\GameController::class, 'start_game'])->name('start_game')->middleware('auth');
// Route::get('/getWalletBalance', [App\Http\Controllers\GameController::class, 'getWalletBalance'])->name('getWalletBalance')->middleware('auth');
// Route::get('/clearCredit', [App\Http\Controllers\UserController::class, 'clearCredit'])->name('clearCredit')->middleware('auth');
// Route::get('/bonus_claim/{modal_type}/{modal_id}', [App\Http\Controllers\BonusController::class, 'bonus_claim'])->name('bonus_claim');
// Route::get('/check_cooldown/{modal_type}/{modal_id}', [App\Http\Controllers\BonusController::class, 'check_cooldown'])->name('check_cooldown');
// Route::get('/check_bonus/{modal_type}/{modal_id}', [App\Http\Controllers\BonusController::class, 'check_bonus'])->name('check_bonus');
// Route::get('/referral_claim', [App\Http\Controllers\BonusController::class, 'referral_claim'])->name('referral_claim')->middleware('auth');
// Route::get('/game_rate', [App\Http\Controllers\HomeController::class, 'game_rate'])->name('game_rate')->middleware('auth');