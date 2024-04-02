<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Guest\PostController;
use App\Http\Controllers\User\UserController;
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

Route::get('/', [PostController::class, 'homePage'])->name('blogs.home')->middleware('status');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::prefix('auth')->middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'viewRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('post.register');
    Route::get('/token', [AuthController::class, 'viewTokenForm'])->name('token');
    Route::post('/token', [AuthController::class, 'token'])->name('post.token');
    Route::get('/login', [AuthController::class, 'viewLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('post.login');
    Route::get('/formForgotPassword', [AuthController::class, 'formForgotPassword'])->name('forgot.password');
    Route::post('/forgotPassword', [AuthController::class, 'forgotPassword'])->name('post.forgot.password');
    Route::get('/tokenForgotPassword', [AuthController::class, 'formTokenForgot'])->name('token.password');
    Route::post('/tokenForgotPassword', [AuthController::class, 'postTokenForgot'])->name('post.token.password');
});


Route::group(['as' => 'admin.', 'prefix' => 'admin'], function () {
    Route::get('/', [HomeController::class, 'viewDashboard'])->name('dashboard');
    Route::get('/category', [CategoryController::class, 'viewCategory'])->name('category');
    Route::post('/category/create', [CategoryController::class, 'createCategory'])->name('post.category');
    Route::get('/category', [CategoryController::class, 'getCategory'])->name('getCategory');
    Route::post('/category/update', [CategoryController::class, 'updateCategory'])->name('update.category');
    Route::delete('/category/delete/{category}', [CategoryController::class, 'deleteCategory'])->name('delete.category');
});

Route::group(['as' => 'user.', 'prefix' => 'users'], function () {
    Route::get('/password/edit', [UserController::class, 'editChangePassword'])->name('password.edit');
    Route::put('/password/update', [UserController::class, 'updatePassword'])->name('password.update');
});
