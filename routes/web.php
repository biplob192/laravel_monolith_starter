<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CropController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\SeasonController;
use App\Http\Controllers\VarietyController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\GrowthStageController;
use App\Http\Controllers\CropRequirementController;

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
        Route::get('users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('users/store', [UserController::class, 'store'])->name('users.store');
        Route::get('users/show/{id}', [UserController::class, 'show'])->name('users.show');
        Route::get('users/edit/{id}', [UserController::class, 'edit'])->name('users.edit');
        Route::put('users/update/{id}', [UserController::class, 'update'])->name('users.update');
        Route::delete('users/destroy/{id}', [UserController::class, 'destroy'])->name('users.destroy');

        Route::get('users/get/data', [UserController::class, 'getData'])->name('users.getData');
        Route::get('users/export/data', [UserController::class, 'export'])->name('users.export');

        // Route::get('attendance', [AttendanceController::class, 'index'])->name('attendance.index');
        // Route::get('attendance/{id}/edit', [AttendanceController::class, 'edit'])->name('attendance.edit');
        // Route::put('attendance/{id}', [AttendanceController::class, 'update'])->name('attendance.update');
        // Route::delete('attendance/{id}', [AttendanceController::class, 'destroy'])->name('attendance.destroy');

        Route::get('attendance/index', [AttendanceController::class, 'index'])->name('attendance.index');
        Route::get('attendance/edit/{id}', [AttendanceController::class, 'edit'])->name('attendance.edit');
        Route::put('attendance/update/{id}', [AttendanceController::class, 'update'])->name('attendance.update');
        Route::delete('attendance/destroy/{id}', [AttendanceController::class, 'destroy'])->name('attendance.destroy');
    });


    Route::group(['middleware' => ['role:employee|admin']], function () {
        Route::get('categories/index', [CategoryController::class, 'index'])->name('categories.index');
        Route::get('categories/create', [CategoryController::class, 'create'])->name('categories.create');
        Route::post('categories/store', [CategoryController::class, 'store'])->name('categories.store');
        Route::get('categories/show/{id}', [CategoryController::class, 'show'])->name('categories.show');
        Route::get('categories/edit/{id}', [CategoryController::class, 'edit'])->name('categories.edit');
        Route::put('categories/update/{id}', [CategoryController::class, 'update'])->name('categories.update');
        Route::delete('categories/destroy/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');
        Route::get('categories/get/data', [CategoryController::class, 'getData'])->name('categories.getData');
        Route::get('categories/export/data', [CategoryController::class, 'export'])->name('categories.export');


        Route::get('crop_requirements/index', [CropRequirementController::class, 'index'])->name('crop_requirements.index');
        Route::get('crop_requirements/create', [CropRequirementController::class, 'create'])->name('crop_requirements.create');
        Route::post('crop_requirements/store', [CropRequirementController::class, 'store'])->name('crop_requirements.store');
        Route::get('crop_requirements/show/{id}', [CropRequirementController::class, 'show'])->name('crop_requirements.show');
        Route::get('crop_requirements/edit/{id}', [CropRequirementController::class, 'edit'])->name('crop_requirements.edit');
        Route::put('crop_requirements/update/{id}', [CropRequirementController::class, 'update'])->name('crop_requirements.update');
        Route::delete('crop_requirements/destroy/{id}', [CropRequirementController::class, 'destroy'])->name('crop_requirements.destroy');


        Route::get('crops/index', [CropController::class, 'index'])->name('crops.index');
        Route::get('crops/create', [CropController::class, 'create'])->name('crops.create');
        Route::post('crops/store', [CropController::class, 'store'])->name('crops.store');
        Route::get('crops/show/{id}', [CropController::class, 'show'])->name('crops.show');
        Route::get('crops/edit/{id}', [CropController::class, 'edit'])->name('crops.edit');
        Route::put('crops/update/{id}', [CropController::class, 'update'])->name('crops.update');
        Route::delete('crops/destroy/{id}', [CropController::class, 'destroy'])->name('crops.destroy');
        Route::get('crops/get/data', [CropController::class, 'getData'])->name('crops.getData');
        Route::get('crops/show/get/data/{id}', [CropController::class, 'detailsData'])->name('crops.detailsData');
        Route::get('crops/export/data', [CropController::class, 'export'])->name('crops.export');


        Route::get('seasons/index', [SeasonController::class, 'index'])->name('seasons.index');
        Route::get('seasons/create', [SeasonController::class, 'create'])->name('seasons.create');
        Route::post('seasons/store', [SeasonController::class, 'store'])->name('seasons.store');
        Route::get('seasons/show/{id}', [SeasonController::class, 'show'])->name('seasons.show');
        Route::get('seasons/edit/{id}', [SeasonController::class, 'edit'])->name('seasons.edit');
        Route::put('seasons/update/{id}', [SeasonController::class, 'update'])->name('seasons.update');
        Route::delete('seasons/destroy/{id}', [SeasonController::class, 'destroy'])->name('seasons.destroy');
        Route::get('seasons/get/data', [SeasonController::class, 'getData'])->name('seasons.getData');
        Route::get('seasons/export/data', [SeasonController::class, 'export'])->name('seasons.export');


        Route::get('growth_stages/index', [GrowthStageController::class, 'index'])->name('growth_stages.index');
        Route::get('growth_stages/create', [GrowthStageController::class, 'create'])->name('growth_stages.create');
        Route::post('growth_stages/store', [GrowthStageController::class, 'store'])->name('growth_stages.store');
        Route::get('growth_stages/show/{id}', [GrowthStageController::class, 'show'])->name('growth_stages.show');
        Route::get('growth_stages/edit/{id}', [GrowthStageController::class, 'edit'])->name('growth_stages.edit');
        Route::put('growth_stages/update/{id}', [GrowthStageController::class, 'update'])->name('growth_stages.update');
        Route::delete('growth_stages/destroy/{id}', [GrowthStageController::class, 'destroy'])->name('growth_stages.destroy');
        Route::get('growth_stages/get/data', [GrowthStageController::class, 'getData'])->name('growth_stages.getData');
        Route::get('growth_stages/export/data', [GrowthStageController::class, 'export'])->name('growth_stages.export');


        Route::get('auth/user', [UserController::class, 'loggedInUser'])->name('users.details');

        // Route::post('attendance', [AttendanceController::class, 'store'])->name('attendance.store');
        // Route::get('attendance/{id}', [AttendanceController::class, 'show'])->name('attendance.show');

        Route::post('attendance/store', [AttendanceController::class, 'store'])->name('attendance.store');
        Route::get('attendance/show/{id}', [AttendanceController::class, 'show'])->name('attendance.show');

        Route::get('users/list', [CropRequirementController::class, 'userList'])->name('users.list');

        // This Route For Create New Requirement
        Route::get('varieties/crop_id/{id}', [VarietyController::class, 'certainCropVariety'])->name('varieties.certainCrop');
        Route::get('growth_stages/crop_id/{id}', [GrowthStageController::class, 'certainCropGrowthStage'])->name('growth_stages.certainCrop');
    });
});




// Default nameing
// Route::get('users', [UserController::class, 'index'])->name('users.index');
// Route::get('users/create', [UserController::class, 'create'])->name('users.create');
// Route::post('users', [UserController::class, 'store'])->name('users.store');
// Route::get('users/{id}', [UserController::class, 'show'])->name('users.show');
// Route::get('users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
// Route::put('users/{id}', [UserController::class, 'update'])->name('users.update');
// Route::delete('users/{id}', [UserController::class, 'destroy'])->name('users.destroy');


// AdminLTE theme nameing
// Route::get('users/index', [UserController::class, 'index'])->name('users.index');
// Route::get('users/create', [UserController::class, 'create'])->name('users.create');
// Route::post('users/store', [UserController::class, 'store'])->name('users.store');
// Route::get('users/show/{id}', [UserController::class, 'show'])->name('users.show');
// Route::get('users/edit/{id}', [UserController::class, 'edit'])->name('users.edit');
// Route::put('users/update/{id}', [UserController::class, 'update'])->name('users.update');
// Route::delete('users/destroy/{id}', [UserController::class, 'destroy'])->name('users.destroy');
