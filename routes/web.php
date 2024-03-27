<?php

use App\Http\Controllers\Auth\AuthController;
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

Route::get('/', function () {
    return view('guest.home');
});

Route::get('/register', [AuthController::class, 'viewRegister'])->name('view.register');
Route::post('/register', [AuthController::class, 'register'])->name('post.register');
Route::get('/token', [AuthController::class, 'viewTokenForm'])->name('view.token.form');
Route::post('/token', [AuthController::class, 'token'])->name('post.token');
Route::get('/login', [AuthController::class, 'viewLogin'])->name('view.login');
Route::post('/login', [AuthController::class, 'login'])->name('post.login');
