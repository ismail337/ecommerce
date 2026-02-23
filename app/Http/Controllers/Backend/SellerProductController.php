<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\SellerProductsDataTable;
use App\DataTables\SellerPendingProductDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class SellerProductController extends Controller
{

    public function index(SellerProductsDataTable $dataTable)
    {
        return $dataTable->render('admin.product.seller-product.index');
    }

    public function pending_products(SellerPendingProductDataTable $dataTable)
    {
        return $dataTable->render('admin.product.seller-pending-product.index');
    }


    public function changeApproveStatus(Request $request)
    {
        $product              = Product::findOrFail($request->id);
        $product->is_approved = $request->is_approved;
        $product->save();

        return response()->json([
            'status'  => 'success',
            'message' => 'Product approve status changed successfully.',
        ]);
    }



}
