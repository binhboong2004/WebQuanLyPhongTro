<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserController as UserController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UserController as AdminUserController;

Route::get('/', function () {
    return view('welcome');
});

// Routes cho User
Route::prefix('user')->group(function () {
    Route::get('/index', [UserController::class, 'index'])->name('user.index');
});

// Routes cho Admin
Route::prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/danh-sach-tai-khoan', [AdminUserController::class, 'index'])->name('users.index');
    Route::get('/cap-moi-tai-khoan', [AdminUserController::class, 'create'])->name('users.create');
    Route::post('/cap-moi-tai-khoan', [AdminUserController::class, 'store'])->name('users.store');
});
