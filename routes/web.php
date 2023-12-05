<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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
 
Route::get('/', function () {
    return view('auth.login');
})->name('user.login');

Route::get('/register', function () {
    return view('auth.register');
})->name('registration');

Route::get('/profile', function () {
    return view('auth.profile');
})->name('profile.view');

Route::get('/verify-email/{token}',[AuthController::class,'verifyEmail']) -> name('profile.email.verified');
Route::get('/reset-password',[AuthController::class,'resetPasswordLoad']) -> name('reset.password.load');
// Route::post('/reset-password',[AuthController::class,'resetPassword']) -> name('password.reset');

