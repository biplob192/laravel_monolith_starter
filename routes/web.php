<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\AttendanceController;

Route::get('register', [AuthController::class, 'registerView'])->name('auth.register_view');
Route::post('register', [AuthController::class, 'register'])->name('auth.register');
Route::get('login', [AuthController::class, 'loginView'])->name('auth.login_view');
Route::get('login_new', [AuthController::class, 'loginViewNew'])->name('auth.login_view_new');
Route::post('login', [AuthController::class, 'login'])->name('auth.login');
Route::get('logout', [AuthController::class, 'logout'])->name('auth.logout');
Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback'])->name('auth.google_callback');


Route::get('/', [AuthController::class, 'home'])->name('auth.home');
Route::get('dashboard', [AuthController::class, 'dashboard'])->name('auth.dashboard');


Route::group(['middleware' => 'login'], function () {
    Route::group(['middleware' => ['role:admin']], function () {
        Route::get('users/index', [UserController::class, 'index'])->name('users.index');
        Route::get('users/get/data', [UserController::class, 'getData'])->name('users.getData');
        Route::get('users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('users/store', [UserController::class, 'store'])->name('users.store');
        Route::get('users/show/{id}', [UserController::class, 'show'])->name('users.show');
        Route::get('users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('users/update/{id}', [UserController::class, 'update'])->name('users.update');
        Route::delete('users/destroy/{id}', [UserController::class, 'destroy'])->name('users.destroy');

        Route::get('users/export/data', [UserController::class, 'export'])->name('users.export');

        Route::get('attendance', [AttendanceController::class, 'index'])->name('attendance.index');
        Route::get('attendance/{id}/edit', [AttendanceController::class, 'edit'])->name('attendance.edit');
        Route::put('attendance/{id}', [AttendanceController::class, 'update'])->name('attendance.update');
        Route::delete('attendance/{id}', [AttendanceController::class, 'destroy'])->name('attendance.destroy');
    });


    Route::group(['middleware' => ['role:employee|admin']], function () {
        Route::get('auth/user', [UserController::class, 'loggedInUser'])->name('users.details');

        Route::post('attendance', [AttendanceController::class, 'store'])->name('attendance.store');
        Route::get('attendance/{id}', [AttendanceController::class, 'show'])->name('attendance.show');
    });
});
