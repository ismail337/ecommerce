<?php

use function Symfony\Component\String\b;

/** Set Sidebar item active */

function setActive(array $routes)
{
    if (is_array($routes)) {
        foreach ($routes as $route) {
            if (request()->routeIs($route)) {
                return 'active';
            }
        }
    }
}


// check if product discount is active or not


function isDiscountActive($product)
{
    if ($product->offer_price) {
        if ($product->offer_start_date && $product->offer_end_date) {
            $currentDate = now();
            if ($currentDate->between($product->offer_start_date, $product->offer_end_date)) {
                return true;
            }
        }
    }
    return false;
}

function getDiscountedPrice($originalPrice, $discountPrice)
{
    $discountPrice = $originalPrice - $discountPrice;

    $discountPercentage = ($discountPrice / $originalPrice) * 100;

    return round($discountPercentage);

}

function productType($type)
{


    switch ($type) {
        case 'new_arrival':
            return 'New Arrival';
            break;
        case 'best_product':
            return 'Best Seller';
            break;
        case 'featured_product':
            return 'Featured';
            break;
        case 'top_product':
            return 'Top Product';
            break;
        default:
            return '';
            break;
    }


}

function getCartTotal()
{
    $total = 0;
    foreach (\Cart::content() as $product) {
        $total += ($product->price + $product->options->variant_total_price) * $product->qty;
    }
    return $total;
}
// Main cart total after applying coupon discount
function getMainCartTotal()
{
    if (Session::has('coupon')) {
        $coupon   = Session::get('coupon');
        $subTotal = getCartTotal();
        if ($coupon['discount_type'] === 'amount') {

            $total = max(0, $subTotal - $coupon['discount']);

            return $total;
        } elseif ($coupon['discount_type'] === 'percent') {

            $discountAmount = ($subTotal * $coupon['discount']) / 100;
            $total          = max(0, $subTotal - $discountAmount);

            return $total;
        }
    } else {
        return getCartTotal();
    }
}

// getCartDiscount
function getCartDiscount()
{
    if (Session::has('coupon')) {
        $coupon   = Session::get('coupon');
        $subTotal = getCartTotal();
        if ($coupon['discount_type'] === 'amount') {

            return $coupon['discount'];

        } elseif ($coupon['discount_type'] === 'percent') {

            $discountAmount = ($subTotal * $coupon['discount']) / 100;

            return $discountAmount;
        }
    } else {
        return 0;
    }
}


function getShippingFee()
{
    if (Session::has('shipping_method')) {
        return Session::get('shipping_method')['cost'];
    } else {
        return 0;
    }
}

/** get payable amount */
function getFinalPayableAmount()
{
    return getMainCartTotal() + getShippingFee();
}
