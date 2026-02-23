<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\VendorProductVariantDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\Auth;

class VendorProductVariantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(VendorProductVariantDataTable $dataTable)
    {
        return $dataTable->render('vendor.product.product-variant.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('vendor.product.product-variant.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product' => [ 'integer', 'required' ],
            'name'    => [ 'required', 'max:200' ],
            'status'  => [ 'required' ]
        ]);

        $varinat             = new ProductVariant();
        $varinat->product_id = $request->product;
        $varinat->name       = $request->name;
        $varinat->status     = $request->status;
        $varinat->save();

        toastr('Created Successfully!', 'success', 'success');

        return redirect()->route('vendor.product-variant.index', [ 'product' => $request->product ]);
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
        /** Check product vendor */
        if ($productVariant->product->vendor_id !== Auth::user()->vendor->id) {
            abort(404);
        }
        return view('vendor.product.product-variant.edit', compact('productVariant'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name'   => [ 'required', 'max:200' ],
            'status' => [ 'required' ]
        ]);

        $varinat = ProductVariant::findOrFail($id);
        /** Check product vendor */
        if ($varinat->product->vendor_id !== Auth::user()->vendor->id) {
            abort(404);
        }
        $varinat->name   = $request->name;
        $varinat->status = $request->status;
        $varinat->save();

        toastr('Updated Successfully!', 'success', 'success');

        return redirect()->route('vendor.product-variant.index', [ 'product' => $varinat->product_id ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $productVariant = ProductVariant::findOrFail($id);

        if ($productVariant->product->vendor_id !== Auth::user()->vendor->id) {
            abort(404);
        }

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