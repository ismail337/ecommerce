<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductVariantItem;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\Auth;
use App\Models\Coupon;
use Cart;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        // dd('Add to cart request data: ', $request->all());

        $Product = Product::findOrFail($request->product_id);

        $variants          = [];
        $variantTotalPrice = 0;

        if ($request->has('variants_items')) {
            foreach ($request->variants_items as $variantItemId) {
                $variantItem = ProductVariantItem::find($variantItemId);
                if ($variantItem) {
                    $variants[$variantItem->productVariant->name]['name']   = $variantItem->name;
                    $variants[$variantItem->productVariant->name]['price']  = $variantItem->additional_price;
                    $variantTotalPrice                                     += $variantItem->additional_price;
                }
            }
        }

        if (isDiscountActive($Product)) {
            $ProductPrice = $Product->offer_price;
        } else {
            $ProductPrice = $Product->price;
        }

        $CartData = [];

        $CartData['id']                             = $Product->id;
        $CartData['name']                           = $Product->name;
        $CartData['price']                          = $ProductPrice * $request->qty;
        $CartData['qty']                            = $request->qty;
        $CartData['weight']                         = 10;
        $CartData['options']['variants']            = $variants;
        $CartData['options']['variant_total_price'] = $variantTotalPrice;
        $CartData['options']['image']               = $Product->thumb_image;
        $CartData['options']['stock_status']        = $Product->qty;
        $CartData['options']['slug']                = $Product->slug;

        Cart::add($CartData);

        return response()->json([ 'status' => 'success', 'message' => 'Product added to cart successfully' ]);


    }


    // cart details page

    public function cartDetails()
    {
        $cartItems = Cart::content();

        if (count($cartItems) == 0) {
            Session::forget('coupon');
            toastr()->warning('Your cart is empty!');
            return redirect()->route('home');
        }
        // dd($cartItems->toArray());
        return view('frontend.pages.cart-details', compact('cartItems'));
    }


    // update cart product quantity

    public function updateProductQty(Request $request)
    {


        Cart::update($request->rowId, $request->qty);

        $productTotal = $this->getProductTotal($request->rowId);

        $cart_total = 0;



        return response()->json([ 'status' => 'success', 'message' => 'Cart updated successfully', 'product_total' => $productTotal ]);
    }


    public function getProductTotal($rowId)
    {
        $product = Cart::get($rowId);
        if ($product) {
            $total = ($product->price + $product->options->variant_total_price) * $product->qty;
            return $total;
        }

    }

    public function getCartTotal()
    {
        $cartTotal = 0;

        foreach (Cart::content() as $item) {
            $itemTotal  = $this->getProductTotal($item->rowId);
            $cartTotal += $itemTotal;
        }

        return $cartTotal;
    }

    public function getCartProducts()
    {
        $cartItems = Cart::content();
        return response()->json([ 'status' => 'success', 'cart_items' => $cartItems ]);
    }



    public function clearCart()
    {
        Cart::destroy();
        return response()->json([ 'status' => 'success', 'message' => 'Cart cleared successfully' ]);
    }

    public function removeProduct($rowId)
    {
        Cart::remove($rowId);

        return redirect()->back();
    }

    public function getCartCount()
    {
        $cartCount = Cart::count();
        return response()->json([ 'status' => 'success', 'cart_count' => $cartCount ]);
    }


    public function removeSidebarProduct(Request $request)
    {
        Cart::remove($request->rowId);
        return response()->json([ 'status' => 'success', 'message' => 'Product removed from cart successfully' ]);
    }

    public function applyCoupon(Request $request)
    {

        // dd('Apply coupon request data: ', $request->coupon_code);
        $couponCode = $request->coupon_code;

        // Validate the coupon code
        if ($couponCode === null) {
            return response()->json([ 'status' => 'error', 'message' => 'Coupon code is required' ]);
        }

        $coupon = Coupon::where('status', 1)->where('code', $couponCode)->first();

        if (!$coupon) {
            return response()->json([ 'status' => 'error', 'message' => 'Invalid coupon code' ]);
        }

        // Check if the coupon is expired
        if ($coupon->start_date > now()) {
            return response()->json([ 'status' => 'error', 'message' => 'Coupon code has not started yet' ]);
        } elseif ($coupon->end_date < now()) {
            return response()->json([ 'status' => 'error', 'message' => 'Coupon code has expired' ]);
        } elseif ($coupon->quantity !== null && $coupon->total_used >= $coupon->quantity) {
            return response()->json([ 'status' => 'error', 'message' => 'Coupon code usage limit has been reached' ]);
        }


        if ($coupon->discount_type == 'amount') {
            Session::put('coupon', [
                'coupon_name'   => $coupon->name,
                'coupon_code'   => $coupon->code,
                'discount_type' => 'amount',
                'discount'      => $coupon->discount
            ]);
        } elseif ($coupon->discount_type == 'percent') {
            Session::put('coupon', [
                'coupon_name'   => $coupon->name,
                'coupon_code'   => $coupon->code,
                'discount_type' => 'percent',
                'discount'      => $coupon->discount
            ]);
        } else {
            return response()->json([ 'status' => 'error', 'message' => 'Invalid coupon type' ]);
        }

        return response()->json([ 'status' => 'success', 'message' => 'Coupon applied successfully' ]);

    }



    public function calculateCouponDiscount()
    {
        if (Session::has('coupon')) {


            $coupon = Session::get('coupon');

            $subTotal = getCartTotal();


            if ($coupon['discount_type'] === 'amount') {

                $total = max(0, $subTotal - $coupon['discount']);

                return response()->json([ 'status' => 'success', 'cart_total' => $total, 'discount' => $coupon['discount'] ]);
            } elseif ($coupon['discount_type'] === 'percent') {

                $discountAmount = ($subTotal * $coupon['discount']) / 100;
                $total          = max(0, $subTotal - $discountAmount);

                return response()->json([ 'status' => 'success', 'cart_total' => $total, 'discount' => $discountAmount ]);
            }
        } else {
            return response()->json([ 'status' => 'success', 'cart_total' => getCartTotal(), 'discount' => 0 ]);
        }
    }

}
