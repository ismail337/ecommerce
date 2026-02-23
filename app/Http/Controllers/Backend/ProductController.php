<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\ProductDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\ChildCategory;
use App\Models\Brand;
use App\Traits\imageUploadTrait;
use Illuminate\Support\Facades\Auth;
use App\Models\Vendor;
use Str;

class ProductController extends Controller
{

    use imageUploadTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(ProductDataTable $dataTable)
    {
        return $dataTable->render('admin.product.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {



        $categories = Category::where('status', 1)->get();

        $brands = Brand::where('status', 1)->get();

        return view('admin.product.create', compact('categories', 'brands'));
    }


    public function getSubCategories(Request $request)
    {
        $category_id   = $request->category_id;
        $subcategories = SubCategory::where('category_id', $category_id)->get();
        return response()->json($subcategories);
    }

    public function getChildCategories(Request $request)
    {
        $subcategory_id  = $request->subcategory_id;
        $childcategories = ChildCategory::where('sub_category_id', $subcategory_id)->get();
        return response()->json($childcategories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'              => 'required|string|max:255',
            'category_id'       => 'required|integer',
            'brand_id'          => 'required|integer',
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
        $product->category_id       = $request->category_id;
        $product->sub_category_id   = $request->sub_category_id;
        $product->child_category_id = $request->child_category_id;
        $product->brand_id          = $request->brand_id;
        $product->price             = $request->price;
        $product->vendor_id         = Auth::user()->vendor->id;
        $product->qty               = $request->qty;
        $product->short_description = $request->short_description;
        $product->long_description  = $request->long_description;
        $product->seo_title         = $request->seo_title;
        $product->seo_description   = $request->seo_description;
        $product->status            = $request->status;
        $product->is_approved       = 1;
        $product->offer_start_date  = $request->offer_start_date;
        $product->offer_end_date    = $request->offer_end_date;
        $product->offer_price       = $request->offer_price;
        $product->video_link        = $request->video_link;
        $product->product_type      = $request->product_type;
        $product->sku               = $request->sku;

        $product->save();

        toastr()->success('Product created successfully.', 'Success');
        return redirect()->route('admin.product.index');
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

        $categories = Category::where('status', 1)->get();

        $brands = Brand::where('status', 1)->get();

        $subcategories = SubCategory::where('category_id', $product->category_id)->get();


        $child_categories = ChildCategory::where('sub_category_id', $product->sub_category_id)->get();


        return view('admin.product.edit', compact('categories', 'child_categories', 'subcategories', 'brands', 'product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name'              => 'required|string|max:255',
            'category_id'       => 'required|integer',
            'brand_id'          => 'required|integer',
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
        $product->category_id       = $request->category_id;
        $product->sub_category_id   = $request->sub_category_id;
        $product->child_category_id = $request->child_category_id;
        $product->brand_id          = $request->brand_id;
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
        return redirect()->route('admin.product.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);

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

    public function changeStatus(Request $request)
    {

        $product = Product::findOrFail($request->id);

        $product->status = $request->status == 'true' ? 1 : 0;

        $product->save();

        return response()->json([
            'status'  => 'success',
            'message' => 'Product status changed successfully.',
        ]);

    }
}