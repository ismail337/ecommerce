<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\VendorProductVariantItemDataTable;
use App\Http\Controllers\Controller;
use App\Models\Vendor;
use Illuminate\Http\Request;
use App\Models\ProductVariant;
use App\Models\Product;
use App\Models\ProductVariantItem;


class VendorProductVariantItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(VendorProductVariantItemDataTable $dataTable, Request $request)
    {

        $product         = Product::find($request->productId);
        $product_variant = ProductVariant::find($request->variantId);

        return $dataTable->render('vendor.product.product-variant-item.index', compact('product', 'product_variant'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(string $productId, string $variantId)
    {
        $product         = Product::findOrFail($productId);
        $product_variant = ProductVariant::findOrFail($variantId);
        return view('vendor.product.product-variant-item.create', compact('product', 'product_variant'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'variant_id' => 'required|exists:product_variants,id',
            'name'       => 'required|string|max:255',
            'price'      => 'nullable|numeric|min:0',
            'is_default' => 'required',
            'status'     => 'required',
        ]);

        $productVariantItem                     = new ProductVariantItem();
        $productVariantItem->product_variant_id = $request->variant_id;
        $productVariantItem->name               = $request->name;
        $productVariantItem->additional_price   = $request->price ?? 0;
        $productVariantItem->is_default         = $request->is_default;
        $productVariantItem->status             = $request->status;
        $productVariantItem->save();

        toastr()->success('Product Variant created successfully.');

        return redirect()->route('vendor.products-variant-item.index', [ $request->product_id, $request->variant_id ]);
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
        $variantItem = ProductVariantItem::findOrFail($id);

        return view('vendor.product.product-variant-item.edit', compact('variantItem'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'price'      => 'nullable|numeric|min:0',
            'is_default' => 'required',
            'status'     => 'required',
        ]);

        $productVariantItem                   = ProductVariantItem::findOrFail($id);
        $productVariantItem->name             = $request->name;
        $productVariantItem->additional_price = $request->price;
        $productVariantItem->is_default       = $request->is_default;
        $productVariantItem->status           = $request->status;
        $productVariantItem->save();

        toastr()->success('Product Variant Item updated successfully.');
        return redirect()->route('vendor.products-variant-item.index', [ $productVariantItem->productVariant->product_id, $productVariantItem->product_variant_id ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $variantItem = ProductVariantItem::findOrFail($id);
        $variantItem->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Product Variant Item deleted successfully.',
        ]);
    }

    public function changeStatus(Request $request)
    {
        $variantItem         = ProductVariantItem::findOrFail($request->id);
        $variantItem->status = $request->status == 'true' ? 1 : 0;
        $variantItem->save();

        return response()->json([
            'status'  => 'success',
            'message' => 'Product Variant status changed successfully.',
        ]);
    }
}