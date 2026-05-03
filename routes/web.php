<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\AdminController;
use App\Http\Controllers\Backend\VendorController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\UserDashboardController;
use App\Http\Controllers\Frontend\UserProfileController;
use App\Http\Controllers\Frontend\FlashSaleController;
use App\Http\Controllers\Frontend\ProductDetailsController;
use App\Http\Controllers\Frontend\UserAddressController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Backend\CheckoutController;
use App\Http\Controllers\Frontend\PaymentController;

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

Route::get('/', [ HomeController::class, 'index' ])->name('home');


// flash sale page

Route::get('flash-sale', [ FlashSaleController::class, 'index' ])->name('flash-sale');
// product details page

Route::get('product-details/{slug}', [ ProductDetailsController::class, 'index' ])->name('product-details');





// Route::get('/dashboard', function () {
//     return view('frontend.dashboard.dashboard');
// })->middleware([ 'auth', 'verified' ])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ ProfileController::class, 'edit' ])->name('profile.edit');
    Route::patch('/profile', [ ProfileController::class, 'update' ])->name('profile.update');
    Route::delete('/profile', [ ProfileController::class, 'destroy' ])->name('profile.destroy');
});

Route::get('admin/login', [ AdminController::class, 'login' ])->name('admin.login');
Route::get('vendor/login', [ VendorController::class, 'login' ])->name('vendor.login');



// Cart Controller routes

Route::post('add-to-cart', [ CartController::class, 'addToCart' ])->name('add-to-cart');

Route::get('cart-details', [ CartController::class, 'cartDetails' ])->name('cart-details');

Route::post('cart/update-quantity', [ CartController::class, 'updateProductQty' ])->name('cart.update-quantity');
Route::get('clear-cart', [ CartController::class, 'clearCart' ])->name('cart.clear');
Route::get('cart/remove-product/{rowId}', [ CartController::class, 'removeProduct' ])->name('cart.remove-product');
Route::get('cart-count', [ CartController::class, 'getCartCount' ])->name('cart.count');
Route::get('cart-products', [ CartController::class, 'getCartProducts' ])->name('cart.products');
Route::get('cart/remove-sidebar-product', [ CartController::class, 'removeSidebarProduct' ])->name('cart.remove-sidebar-product');
Route::get('cart/total', [ CartController::class, 'getCartTotal' ])->name('cart.total');
Route::get('apply-coupon', [ CartController::class, 'applyCoupon' ])->name('cart.apply-coupon');
Route::get('remove-coupon', [ CartController::class, 'removeCoupon' ])->name('cart.remove-coupon');
Route::get('cart/coupon-discount', [ CartController::class, 'getCouponDiscount' ])->name('cart.coupon-discount');
Route::get('coupon-calculate', [ CartController::class, 'calculateCouponDiscount' ])->name('coupon-calculation');



Route::group([ 'middleware' => [ 'auth', 'verified' ], 'prefix' => 'user', 'as' => 'user.' ], function () {
    Route::get('dashboard', [ UserDashboardController::class, 'index' ])->name('dashboard');
    Route::get('profile', [ UserProfileController::class, 'index' ])->name('profile');
    Route::put('profile', [ UserProfileController::class, 'updateProfile' ])->name('profile.update');
    Route::post('profile/update/password', [ UserProfileController::class, 'updatePassword' ])->name('profile.update.password');

    // user address routes
    Route::resource('address', UserAddressController::class);



    // Checkout page
    Route::get('checkout', [ CheckoutController::class, 'index' ])->name('checkout');
    Route::post('checkout/add-address', [ CheckoutController::class, 'addAddress' ])->name('checkout.add-address');
    Route::post('checkout/form-submit', [ CheckoutController::class, 'submitCheckoutForm' ])->name('checkout.form-submit');

    // payment routes will be here
    Route::get('payment', [ PaymentController::class, 'index' ])->name('payment');

    Route::get('payment-success', [ PaymentController::class, 'paymentSuccess' ])->name('payment.success');

    Route::get('paypal/payment', [ PaymentController::class, 'payWithPaypal' ])->name('paypal.payment');
    Route::get('paypal/success', [ PaymentController::class, 'paypalSuccess' ])->name('paypal.success');
    Route::get('paypal/cancel  ', [ PaymentController::class, 'paypalCancel' ])->name('paypal.cancel');
});



require __DIR__ . '/auth.php';