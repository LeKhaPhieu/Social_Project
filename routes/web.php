<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Guest\PostController;
use App\Http\Controllers\Admin\PostController as PostControllerAdmin;
use App\Http\Controllers\Admin\UserController as UserControllerAdmin;
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

Route::get('/', [PostController::class, 'homePage'])->name('blogs.home');
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


Route::group(['as' => 'admin.', 'prefix' => 'isAdmin'], function () {
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
});


Route::group(['as' => 'categories.', 'prefix' => 'categories', 'middleware' => ['isAdmin']], function () {
    Route::get('/index', [CategoryController::class, 'index'])->name('index');
    Route::get('/create', [CategoryController::class, 'create'])->name('create');
    Route::post('/store', [CategoryController::class, 'store'])->name('store');
    Route::get('/edit/{category}', [CategoryController::class, 'edit'])->name('edit');
    Route::put('/update/{id}', [CategoryController::class, 'update'])->name('update');
    Route::delete('/destroy/{id}', [CategoryController::class, 'destroy'])->name('destroy');
});

Route::group(['as' => 'posts.', 'prefix' => 'posts', 'middleware' => ['isAdmin']], function () {
    Route::get('/index', [PostControllerAdmin::class, 'index'])->name('index');
    Route::get('/edit/{post}', [PostControllerAdmin::class, 'edit'])->name('edit');
    Route::put('/update/{id}', [PostControllerAdmin::class, 'update'])->name('update');
    Route::get('/status/{id}', [PostControllerAdmin::class, 'updateStatus'])->name('update.status');
    Route::delete('/destroy/{id}', [PostControllerAdmin::class, 'destroy'])->name('destroy');
});

Route::group(['as' => 'users.', 'prefix' => 'users', 'middleware' => ['isAdmin']], function () {
    Route::get('/index', [UserControllerAdmin::class, 'index'])->name('index');
    Route::get('/status/{id}', [UserControllerAdmin::class, 'updateStatus'])->name('update.status');
    Route::delete('/destroy/{id}', [UserControllerAdmin::class, 'destroy'])->name('destroy');
});

Route::group(['as' => 'passwords.', 'prefix' => 'users'], function () {
    Route::get('/edit', [UserController::class, 'edit'])->name('edit');
    Route::put('/update', [UserController::class, 'update'])->name('update');
});
