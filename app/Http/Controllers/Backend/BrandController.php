<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\BrandDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\imageUploadTrait;
use App\Models\Brand;
use Str;

use function Symfony\Component\Translation\t;

class BrandController extends Controller
{

    use imageUploadTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(BrandDataTable $dataTable)
    {
        return $dataTable->render('admin.brand.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.brand.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'name'        => 'required|string|max:255',
            'logo'        => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status'      => 'required',
            'is_featured' => 'required',
        ]);

        $brand              = new \App\Models\Brand();
        $brand->name        = $request->name;
        $image_path         = $this->uploadImage($request, 'logo', 'uploads/brands');
        $brand->logo        = $image_path;
        $brand->slug        = Str::slug($request->name);
        $brand->status      = $request->status;
        $brand->is_featured = $request->is_featured;
        $brand->save();

        toastr()->success('Brand created successfully!');

        return redirect()->route('admin.brand.index');

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
        $brand = Brand::findOrFail($id);
        return view('admin.brand.edit', compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'logo'        => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status'      => 'required',
            'is_featured' => 'required',
        ]);

        $brand       = Brand::findOrFail($id);
        $brand->name = $request->name;

        $imagePath = $this->updateImage($request, 'logo', 'uploads/brands', $brand->logo);

        $brand->logo = $request->logo ? $imagePath : $brand->logo;

        $brand->slug        = Str::slug($request->name);
        $brand->status      = $request->status;
        $brand->is_featured = $request->is_featured;
        $brand->save();

        toastr()->success('Brand updated successfully!');

        return redirect()->route('admin.brand.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $brand = Brand::findOrFail($id);

        $this->deleteImage($brand->logo);

        $brand->delete();

        return response()->json([ 'status' => 'success', 'message' => 'Deleted Successfully' ]);
    }


    public function changeStatus(Request $request)
    {
        $brand         = Brand::findOrFail($request->id);
        $brand->status = $request->status == 'true' ? 1 : 0;
        $brand->save();

        return response()->json([ 'status' => 'success', 'message' => 'Status changed successfully' ]);
    }
}
