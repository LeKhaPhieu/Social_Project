<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\HomeController;

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
    return view('welcome');
});

Route::get('/', [HomeController::class, 'viewDashboard'])->name('dashboard');
Route::get('/category', [CategoryController::class, 'viewCategory'])->name('category');
Route::post('/category/create', [CategoryController::class, 'createCategory'])->name('post.category');
Route::get('/category', [CategoryController::class, 'getCategory'])->name('getCategory');
Route::post('/category/update', [CategoryController::class, 'updateCategory'])->name('update.category');
