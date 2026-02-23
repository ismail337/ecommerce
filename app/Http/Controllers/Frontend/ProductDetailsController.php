<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductDetailsController extends Controller
{
    public function index($slug)
    {
        $product = Product::with('productImageGalleries', 'productVariants.productVariantItems', 'vendor')->where('slug', $slug)->firstOrFail();
        return view('frontend.pages.product-details', compact('product'));
    }
}