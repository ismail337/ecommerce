<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\SubCategoryDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubCategory;
use App\Models\Category;
use Str;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(SubCategoryDataTable $dataTable)
    {
        return $dataTable->render('admin.sub-category.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $categories = Category::all();

        return view('admin.sub-category.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name'        => 'required|string|max:255',
            'status'      => 'required',
        ]);

        $subCategory              = new SubCategory();
        $subCategory->category_id = $request->category_id;
        $subCategory->name        = $request->name;
        $subCategory->slug        = Str::slug($request->name);
        $subCategory->status      = $request->status;
        $subCategory->save();

        toastr()->success('SubCategory created successfully.', 'Success');
        return redirect()->route('admin.sub-category.index');
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
        $subCategory = SubCategory::findOrFail($id);
        $categories  = Category::all();

        return view('admin.sub-category.edit', compact('subCategory', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $subCategory = SubCategory::findOrFail($id);
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name'        => 'required|string|max:255',
            'status'      => 'required',
        ]);
        $subCategory->category_id = $request->category_id;
        $subCategory->name        = $request->name;
        $subCategory->slug        = Str::slug($request->name);
        $subCategory->status      = $request->status;
        $subCategory->save();

        toastr()->success('SubCategory updated successfully.', 'Success');
        return redirect()->route('admin.sub-category.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $subCategory = SubCategory::findOrFail($id);

        $childCategories = $subCategory->childCategories;

        if ($childCategories->count() > 0) {
            return response()->json([ 'status' => 'error', 'message' => 'SubCategory has child categories and cannot be deleted.' ]);
        }

        $subCategory->delete();
        return response()->json([ 'status' => 'success', 'message' => 'SubCategory deleted successfully.' ]);
    }

    public function changeStatus(Request $request)
    {
        $subCategory         = SubCategory::findOrFail($request->id);
        $subCategory->status = $request->status == 'true' ? 1 : 0;
        $subCategory->save();

        return response()->json([ 'status' => 'success', 'message' => 'SubCategory status changed successfully.' ]);
    }
}