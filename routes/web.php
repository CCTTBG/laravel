<?php
use App\Http\Controllers\AuthSimpleController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('posts',\App\Http\Controllers\PostController::class);
Route::get('/register', [AuthSimpleController::class, 'showRegister'])->name('simple.register.form');
Route::post('/register', [AuthSimpleController::class, 'register'])->name('simple.register');

Route::get('/login', [AuthSimpleController::class, 'showLogin'])->name('simple.login.form');
Route::post('/login', [AuthSimpleController::class, 'login'])->name('simple.login');

Route::post('/logout', [AuthSimpleController::class, 'logout'])->middleware('auth')->name('simple.logout');
