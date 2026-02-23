<?php
use App\Http\Controllers\Backend\VendorController;
use Illuminate\support\Facades\Route;
use App\Http\Controllers\vendor\VendorProfileController;
use App\Http\Controllers\Backend\VendorShopProfileController;
use App\Http\Controllers\Backend\VendorProductController;
use App\Http\Controllers\Backend\VendorProductImageGalleryController;
use App\Http\Controllers\Backend\VendorProductVariantController;
use App\Http\Controllers\Backend\VendorProductVariantItemController;
// VendorController routes
Route::get('dashboard', [ VendorController::class, 'dashboard' ])->name('dashboard');

Route::get('profile', [ VendorProfileController::class, 'index' ])->name('profile');

Route::put('profile', [ VendorProfileController::class, 'updateProfile' ])->name('profile.update');

Route::post('profile/update/password', [ VendorProfileController::class, 'updatePassword' ])->name('profile.update.password');

/* shop profile routes */

Route::resource('shop-profile', VendorShopProfileController::class);

/* product routes */

Route::get('get-subcategories', [ VendorProductController::class, 'getSubCategories' ])->name('product.get-subcategories');
Route::get('get-child-categories', [ VendorProductController::class, 'getChildCategories' ])->name('product.get-child-categories');
Route::put('change-status', [ VendorProductController::class, 'changeStatus' ])->name('product.change-status');
Route::resource('products', VendorProductController::class);

/** Products image gallery route */
Route::resource('product-image-gallery', VendorProductImageGalleryController::class);

/** Products variant route */
Route::put('product-variant/change-status', [ VendorProductVariantController::class, 'changeStatus' ])->name('products-variant.change-status');
Route::resource('product-variant', VendorProductVariantController::class);

/** Products variant item route */
Route::get('product-variant-item/{productId}/{variantId}', [ VendorProductVariantItemController::class, 'index' ])->name('products-variant-item.index');

Route::get('product-variant-item/create/{productId}/{variantId}', [ VendorProductVariantItemController::class, 'create' ])->name('products-variant-item.create');

Route::post('product-variant-item', [ VendorProductVariantItemController::class, 'store' ])->name('products-variant-item.store');

Route::get('product-variant-item-edit/{variantItemId}', [ VendorProductVariantItemController::class, 'edit' ])->name('products-variant-item.edit');

Route::put('product-variant-item-update/{variantItemId}', [ VendorProductVariantItemController::class, 'update' ])->name('products-variant-item.update');

Route::delete('product-variant-item/{variantItemId}', [ VendorProductVariantItemController::class, 'destroy' ])->name('products-variant-item.destroy');

Route::put('product-variant-item-status', [ VendorProductVariantItemController::class, 'changeStatus' ])->name('products-variant-item.chages-status');