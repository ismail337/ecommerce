<?php
use App\Http\Controllers\Backend\AdminController;
use Illuminate\support\Facades\Route;
use App\Http\Controllers\Backend\ProfileController;
use App\Http\Controllers\Backend\SliderController;
// AdminController routes

Route::get('dashboard', [ AdminController::class, 'dashboard' ])->name('dashboard');
Route::get('profile', [ ProfileController::class, 'index' ])->name('profile');
Route::post('profile/update', [ ProfileController::class, 'updateProfile' ])->name('profile.update');
Route::post('profile/update/password', [ ProfileController::class, 'updatePassword' ])->name('profile.update.password');


// slider Route

Route::resource('slider', SliderController::class);