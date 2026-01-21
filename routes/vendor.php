<?php
use App\Http\Controllers\Backend\VendorController;
use Illuminate\support\Facades\Route;
use App\Http\Controllers\vendor\VendorProfileController;
// VendorController routes
Route::get('dashboard', [ VendorController::class, 'dashboard' ])->name('dashboard');

Route::get('profile', [ VendorProfileController::class, 'index' ])->name('profile');

Route::put('profile', [ VendorProfileController::class, 'updateProfile' ])->name('profile.update');

Route::post('profile/update/password', [ VendorProfileController::class, 'updatePassword' ])->name('profile.update.password');
