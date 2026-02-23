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