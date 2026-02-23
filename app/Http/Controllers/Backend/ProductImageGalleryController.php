<?php

namespace App\Http\Controllers\Backend;
use App\DataTables\ProductImageGalleryDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductImageGallery;
use App\Traits\imageUploadTrait;
use File;

class ProductImageGalleryController extends Controller
{
    use imageUploadTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, ProductImageGalleryDataTable $dataTable)
    {

        $product = Product::findOrFail($request->product);

        return $dataTable->render('admin.product.ImageGallery.index', compact('product'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.product.ImageGallery.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'image.*'    => 'required|image|max:2048',
            'product_id' => 'required|exists:products,id',
        ]);


        $images = $this->uploadMultiImage($request, 'image', 'uploads/product-gallery');

        foreach ($images as $imagePath) {
            $product_gallery             = new ProductImageGallery();
            $product_gallery->product_id = $request->product_id;
            $product_gallery->image      = $imagePath;
            $product_gallery->save();
        }

        toastr()->success('Product images uploaded successfully.');
        return redirect()->back();

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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product_image = ProductImageGallery::findOrFail($id);

        $this->deleteImage($product_image->image);

        $product_image->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Product image deleted successfully.',
        ]);
    }
}