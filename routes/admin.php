<?php
use App\Http\Controllers\Backend\AdminController;
use Illuminate\support\Facades\Route;
use App\Http\Controllers\Backend\ProfileController;
use App\Http\Controllers\Backend\SliderController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\SubCategoryController;
use App\Http\Controllers\Backend\ChildCategoryController;
use App\Http\Controllers\Backend\BrandController;
use App\Http\Controllers\Backend\AdminVendorProfileController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\ProductImageGalleryController;
use App\Http\Controllers\Backend\ProductVariantController;
use App\Http\Controllers\Backend\ProductVariantItemController;
use App\Http\Controllers\Backend\SellerProductController;
use App\Http\Controllers\Backend\FlashSaleController;
use App\Http\Controllers\Backend\SettingController;
use App\Http\Controllers\Backend\CouponController;
use App\Http\Controllers\Backend\ShippingRuleController;
use App\Http\Controllers\Backend\PaymentSettingController;
use App\Http\Controllers\Backend\PaypalSettingController;
// AdminController routes

Route::get('dashboard', [ AdminController::class, 'dashboard' ])->name('dashboard');
Route::get('profile', [ ProfileController::class, 'index' ])->name('profile');
Route::post('profile/update', [ ProfileController::class, 'updateProfile' ])->name('profile.update');
Route::post('profile/update/password', [ ProfileController::class, 'updatePassword' ])->name('profile.update.password');


// slider Route

Route::resource('slider', SliderController::class);


/** Category routes */
Route::put('category/change-status', [ CategoryController::class, 'changeStatus' ])->name('category.change-status');
Route::resource('category', CategoryController::class);

/** Sub Category routes */

Route::put('sub-category/change-status', [ SubCategoryController::class, 'changeStatus' ])->name('sub-category.change-status');

Route::resource('sub-category', SubCategoryController::class);


/** Child Category routes */

Route::put('child-category/change-status', [ ChildCategoryController::class, 'changeStatus' ])->name('child-category.change-status');

Route::get('child-category/get-subcategories/{category_id}', [ ChildCategoryController::class, 'getSubCategories' ])->name('child-category.get-subcategories');

Route::resource('child-category', ChildCategoryController::class);


/** Brand routes */

Route::put('brand/change-status', [ BrandController::class, 'changeStatus' ])->name('brand.change-status');

Route::resource('brand', BrandController::class);


/** Admin Vendor Profile Controller */

Route::resource('vendor-profile', AdminVendorProfileController::class);


/** Product routes */
Route::get('product/get-subcategories/{category_id}', [ ProductController::class, 'getSubCategories' ])->name('product.get-subcategories');
Route::get('product/get-childcategories/{subcategory_id}', [ ProductController::class, 'getChildCategories' ])->name('product.get-childcategories');
Route::put('product/change-status', [ ProductController::class, 'changeStatus' ])->name('product.change-status');
Route::resource('product', ProductController::class);

/*producnt image gallery routes*/
Route::resource('product-image-gallery', ProductImageGalleryController::class);


/** Product Variant routes */
Route::put('product-variant/change-status', [ ProductVariantController::class, 'changeStatus' ])->name('product-variant.change-status');
Route::resource('product-variant', ProductVariantController::class);


/** Product Variant Item routes */
Route::get('product-variant-item/{productId}/{variantId}', [ ProductVariantItemController::class, 'index' ])->name('product-variant-item.index');

Route::get('product-variant-item/create/{productId}/{variantId}', [ ProductVariantItemController::class, 'create' ])->name('product-variant-item.create');

Route::post('product-variant-item/store', [ ProductVariantItemController::class, 'store' ])->name('product-variant-item.store');

Route::get('product-variant-item-edit/{variant_id}', [ ProductVariantItemController::class, 'edit' ])->name('product-variant-item.edit');

Route::put('product-variant-item/update/{variantItemId}', [ ProductVariantItemController::class, 'update' ])->name('product-variant-item.update');

Route::delete('product-variant-item/delete/{variantItemId}', [ ProductVariantItemController::class, 'destroy' ])->name('product-variant-item.destroy');

Route::put('product-variant-item/change-status', [ ProductVariantItemController::class, 'changeStatus' ])->name('product-variant-item.change-status');


// seller product routes

Route::get('seller-product', [ SellerProductController::class, 'index' ])->name('seller-product.index');
// Route::put('seller-product/change-approve', [ SellerProductController::class, 'changeApprove' ])->name('seller-product.change-approve');
Route::put('change-approve-status', [ SellerProductController::class, 'changeApproveStatus' ])->name('change-approve-status');

Route::get('seller-pending-product', [ SellerProductController::class, 'pending_products' ])->name('seller-pending-product.index');


// Flash Sale routes
Route::get('flash-sale', [ FlashSaleController::class, 'index' ])->name('flash-sale.index');
Route::put('flash-sale', [ FlashSaleController::class, 'update' ])->name('flash-sale.update');
Route::post('flash-sale/add-product', [ FlashSaleController::class, 'addProduct' ])->name('flash-sale.add-product');
Route::put('flash-sale/show-at-home/status-change', [ FlashSaleController::class, 'chageShowAtHomeStatus' ])->name('flash-sale.show-at-home.change-status');
Route::put('flash-sale-status', [ FlashSaleController::class, 'changeStatus' ])->name('flash-sale-status');
Route::delete('flash-sale/{id}', [ FlashSaleController::class, 'destroy' ])->name('flash-sale.destroy');

//coupon routes
Route::put('coupons/change-status', [ CouponController::class, 'changeStatus' ])->name('coupons.change-status');

Route::resource('coupons', CouponController::class);



// Shipping Role routes
Route::put('shipping-rule/change-status', [ ShippingRuleController::class, 'changeStatus' ])->name('shipping-rules.change-status');

Route::resource('shipping-rule', ShippingRuleController::class);



// setting routes

Route::get('settings', [ SettingController::class, 'index' ])->name('settings.index');
Route::put('settings/general', [ SettingController::class, 'updateGeneralSetting' ])->name('settings.update-general');

Route::get('payment-settings', [ PaymentSettingController::class, 'index' ])->name('payment-settings.index');
Route::put('paypal-setting/{id}', [ PaypalSettingController::class, 'update' ])->name('paypal-setting.update');
