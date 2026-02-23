<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\VendorProductDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\ChildCategory;
use App\Models\Brand;
use App\Traits\imageUploadTrait;
use Illuminate\Support\Facades\Auth;
use Str;

class VendorProductController extends Controller
{
    use imageUploadTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(VendorProductDataTable $dataTable)
    {
        return $dataTable->render('vendor.product.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::where('status', 1)->get();

        $brands = Brand::where('status', 1)->get();

        return view('vendor.product.create', compact('categories', 'brands'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'              => 'required|string|max:255',
            'category'          => 'required|integer',
            'brand'             => 'required|integer',
            'price'             => 'required|numeric',
            'qty'               => 'required|integer',
            'image'             => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'short_description' => 'nullable|string',
            'long_description'  => 'nullable|string',
            'seo_title'         => 'nullable|string|max:255',
            'seo_description'   => 'nullable|string',
            'status'            => 'required|boolean',
        ]);

        $product                    = new Product();
        $image_path                 = $this->uploadImage($request, 'image', 'uploads/products');
        $product->thumb_image       = $image_path;
        $product->name              = $request->name;
        $product->slug              = Str::slug($request->name);
        $product->category_id       = $request->category;
        $product->sub_category_id   = $request->sub_category;
        $product->child_category_id = $request->child_category;
        $product->brand_id          = $request->brand;
        $product->price             = $request->price;
        $product->vendor_id         = Auth::user()->vendor->id;
        $product->qty               = $request->qty;
        $product->short_description = $request->short_description;
        $product->long_description  = $request->long_description;
        $product->seo_title         = $request->seo_title;
        $product->seo_description   = $request->seo_description;
        $product->status            = $request->status;
        $product->is_approved       = 0;
        $product->offer_start_date  = $request->offer_start_date;
        $product->offer_end_date    = $request->offer_end_date;
        $product->offer_price       = $request->offer_price;
        $product->video_link        = $request->video_link;
        $product->product_type      = $request->product_type;
        $product->sku               = $request->sku;

        $product->save();

        toastr()->success('Product created successfully.', 'Success');
        return redirect()->route('vendor.products.index');
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


        $product = Product::with('category', 'brand')->findOrFail($id);


        if ($product->vendor_id !== Auth::user()->vendor->id) {
            abort(403, 'Unauthorized action.');
        }

        $categories = Category::where('status', 1)->get();

        $brands = Brand::where('status', 1)->get();

        $subCategories = SubCategory::where('category_id', $product->category_id)->get();


        $childCategories = ChildCategory::where('sub_category_id', $product->sub_category_id)->get();


        return view('vendor.product.edit', compact('categories', 'childCategories', 'subCategories', 'brands', 'product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name'              => 'required|string|max:255',
            'category'          => 'required|integer',
            'brand'             => 'required|integer',
            'price'             => 'required|numeric',
            'qty'               => 'required|integer',
            'image'             => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'short_description' => 'nullable|string',
            'long_description'  => 'nullable|string',
            'seo_title'         => 'nullable|string|max:255',
            'seo_description'   => 'nullable|string',
            'status'            => 'required|boolean',
        ]);

        $product = Product::findOrFail($id);

        $image_path           = $this->updateImage($request, 'image', 'uploads/banner', $product->thumb_image);
        $product->thumb_image = empty(!$image_path) ? $image_path : $product->thumb_image;

        $product->name              = $request->name;
        $product->slug              = Str::slug($request->name);
        $product->category_id       = $request->category;
        $product->sub_category_id   = $request->sub_category;
        $product->child_category_id = $request->child_category;
        $product->brand_id          = $request->brand;
        $product->price             = $request->price;
        $product->qty               = $request->qty;
        $product->short_description = $request->short_description;
        $product->long_description  = $request->long_description;
        $product->seo_title         = $request->seo_title;
        $product->seo_description   = $request->seo_description;
        $product->status            = $request->status;
        $product->offer_start_date  = $request->offer_start_date;
        $product->offer_end_date    = $request->offer_end_date;
        $product->offer_price       = $request->offer_price;
        $product->video_link        = $request->video_link;
        $product->product_type      = $request->product_type;
        $product->sku               = $request->sku;

        $product->save();

        toastr()->success('Product update successfully.', 'Success');
        return redirect()->route('vendor.products.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);

        if ($product->vendor_id !== Auth::user()->vendor->id) {
            abort(403, 'Unauthorized action.');
        }

        $this->deleteImage($product->thumb_image);

        $galleryImages = $product->productImageGalleries()->get();

        if ($galleryImages->count() > 0) {
            foreach ($galleryImages as $galleryImage) {
                $this->deleteImage($galleryImage->image);
                $galleryImage->delete();
            }
        }


        $productVariantsCount = $product->productVariants()->get();

        if ($productVariantsCount->count() > 0) {
            foreach ($productVariantsCount as $productVariant) {
                $productVariant->productVariantItems()->delete();
                $productVariant->delete();
            }
        }


        $product->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Product deleted successfully.',
        ]);
    }

    public function getSubCategories(Request $request)
    {
        $subCategories = SubCategory::where('category_id', $request->id)->get();

        return $subCategories;
    }

    public function getChildCategories(Request $request)
    {
        $childCategories = ChildCategory::where('sub_category_id', $request->id)->get();

        return $childCategories;
    }

    public function changeStatus(Request $request)
    {

        $product = Product::findOrFail($request->id);

        if ($product->vendor_id !== Auth::user()->vendor->id) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Unauthorized action.',
            ], 403);
        }

        $product->status = $request->status == 'true' ? 1 : 0;

        $product->save();

        return response()->json([
            'status'  => 'success',
            'message' => 'Product status changed successfully.',
        ]);



    }
}