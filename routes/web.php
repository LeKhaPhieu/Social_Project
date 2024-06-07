<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Guest\PostController;
use App\Http\Controllers\Admin\PostController as PostControllerAdmin;
use App\Http\Controllers\Admin\UserController as UserControllerAdmin;
use App\Http\Controllers\User\CommentController;
use App\Http\Controllers\User\LikeController;
use App\Http\Controllers\User\PostController as PostControllerUser;
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

Route::get('/', [PostController::class, 'index'])->name('home');
Route::get('/my-blogs', [PostControllerUser::class, 'myBlog'])->name('my.blog');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/detail/{post}', [PostController::class, 'detail'])->name('detail')->middleware('checkPostStatus');

Route::prefix('auth')->middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'viewRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('post.register');
    Route::get('/token', [AuthController::class, 'viewTokenForm'])->name('token');
    Route::post('/token', [AuthController::class, 'token'])->name('post.token');
    Route::get('/resend', [AuthController::class, 'resend'])->name('resend');
    Route::post('/resend/token', [AuthController::class, 'resendToken'])->name('resend.token');
    Route::get('/login', [AuthController::class, 'viewLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('post.login');
    Route::get('/formForgotPassword', [AuthController::class, 'formForgotPassword'])->name('forgot.password');
    Route::post('/forgotPassword', [AuthController::class, 'forgotPassword'])->name('post.forgot.password');
});


Route::group(['as' => 'admin.', 'prefix' => 'admin', 'middleware' => ['isAdmin']], function () {
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
});

Route::group(['as' => 'statistics.', 'prefix' => 'admin', 'middleware' => ['isAdmin']], function () {
    Route::get('/posts', [HomeController::class, 'statisticsPosts'])->name('posts');
    Route::get('/users', [HomeController::class, 'statisticsUsers'])->name('users');
    Route::post('/filter/posts', [HomeController::class, 'filterPosts'])->name('filter.posts');
    Route::post('/filter/users', [HomeController::class, 'filterUsers'])->name('filter.users');
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
    Route::put('/status/{id}', [PostControllerAdmin::class, 'updateStatus'])->name('update.status');
    Route::delete('/destroy/{id}', [PostControllerAdmin::class, 'destroy'])->name('destroy');
});

Route::group(['as' => 'users.', 'prefix' => 'admin', 'middleware' => ['isAdmin']], function () {
    Route::get('/index', [UserControllerAdmin::class, 'index'])->name('index');
    Route::put('/status/{id}', [UserControllerAdmin::class, 'updateStatus'])->name('update.status');
    Route::delete('/destroy/{id}', [UserControllerAdmin::class, 'destroy'])->name('destroy');
});

Route::group(['as' => 'passwords.', 'prefix' => 'users'], function () {
    Route::get('/edit', [UserController::class, 'edit'])->name('edit');
    Route::put('/update', [UserController::class, 'update'])->name('update');
});

Route::group(['as' => 'users.', 'prefix' => 'users', 'middleware' => 'auth'], function () {
    Route::get('/create', [PostControllerUser::class, 'create'])->name('post.create');
    Route::post('/store', [PostControllerUser::class, 'store'])->name('post.store');
    Route::get('/edit/{post}', [PostControllerUser::class, 'edit'])->name('post.edit');
    Route::put('/update/{id}', [PostControllerUser::class, 'update'])->name('post.update');
    Route::delete('/destroy/{id}', [PostControllerUser::class, 'destroy'])->name('post.destroy');
    Route::post('/like/{post}', [LikeController::class, 'likePost'])->name('post.like');
    Route::post('/like/comment/{id}', [LikeController::class, 'likeComment'])->name('comment.like');
});

Route::group(['as' => 'comments.', 'prefix' => 'comments', 'middleware' => 'auth'], function () {
    Route::get('/', [CommentController::class, 'index'])->name('index');
    Route::post('/store/{postId}', [CommentController::class, 'store'])->name('store')->middleware('checkPostStatus');
    Route::put('update/{id}', [CommentController::class, 'update'])->name('update');
    Route::delete('destroy/{id}', [CommentController::class, 'destroy'])->name('destroy');
});

Route::group(['as' => 'user.', 'prefix' => 'user'], function () {
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::put('/update', [UserController::class, 'updateProfile'])->name('update.profile');
});
