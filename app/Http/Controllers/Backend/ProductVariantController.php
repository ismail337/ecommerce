<?php

namespace App\Http\Controllers\backend;

use App\DataTables\ProductVariantDataTable;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\ProductVariant;

class ProductVariantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ProductVariantDataTable $dataTable)
    {
        return $dataTable->render('admin.product.product-variant.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.product.product-variant.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'   => 'required|string|max:255',
            'status' => 'required|string',
        ]);

        $productVariant             = new ProductVariant();
        $productVariant->name       = $request->name;
        $productVariant->product_id = $request->product;
        $productVariant->status     = $request->status;
        $productVariant->save();

        toastr()->success('Product Variant created successfully.');

        return redirect()->route('admin.product-variant.index', [ 'product' => $request->product ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $productVariant = ProductVariant::findOrFail($id);
        return view('admin.product.product-variant.edit', compact('productVariant'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name'   => 'required|string|max:255',
            'status' => 'required|string',
        ]);
        $productVariant             = ProductVariant::findOrFail($id);
        $productVariant->name       = $request->name;
        $productVariant->product_id = $request->product;
        $productVariant->status     = $request->status;
        $productVariant->save();
        toastr()->success('Product Variant updated successfully.');
        return redirect()->route('admin.product-variant.index', [ 'product' => $request->product ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $productVariant = ProductVariant::findOrFail($id);

        $productVariantItemsCount = $productVariant->productVariantItems()->count();
        if ($productVariantItemsCount > 0) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Cannot delete Product Variant with associated items.',
            ]);
        }


        $productVariant->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Product Variant deleted successfully.',
        ]);
    }

    public function changeStatus(Request $request)
    {
        $productVariant         = ProductVariant::findOrFail($request->id);
        $productVariant->status = $request->status == 'true' ? 1 : 0;
        $productVariant->save();

        return response()->json([
            'status'  => 'success',
            'message' => 'Product Variant status changed successfully.',
        ]);
    }
}
