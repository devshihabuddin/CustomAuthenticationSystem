<?php

use App\Http\Controllers\CustomAuthController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [CustomAuthController::class,'login'])->middleware('AlreadyLogin');
Route::get('/register', [CustomAuthController::class,'register'])->middleware('AlreadyLogin');
Route::post('/register-user', [CustomAuthController::class,'registerUser'])->name('register-user');
Route::post('/login-user', [CustomAuthController::class,'loginUser'])->name('login-user');
Route::get('/dashboard', [CustomAuthController::class, 'dashboard'])->name('dashboard')->middleware('isLoggedIn');
Route::get('/logout', [CustomAuthController::class, 'logout'])->name('logout');



