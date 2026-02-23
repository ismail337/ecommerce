<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\CategoryDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(CategoryDataTable $dataTable)
    {
        return $dataTable->render('admin.category.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'name'   => 'required|string|max:255|unique:categories,name',
            'icon'   => 'nullable|not_in:empty',
            'status' => 'required',
        ]);

        $category = new Category();

        $category->name   = $request->name;
        $category->icon   = $request->icon;
        $category->slug   = Str::slug($request->name);
        $category->status = $request->status;
        $category->save();

        toastr()->success('Category created successfully.', 'Success');
        return redirect()->route('admin.category.index');

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
        $category = Category::findOrFail($id);
        return view('admin.category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // dd($request->all());
        $request->validate([
            'name'   => 'required|string|max:255|unique:categories,name,' . $id,
            'icon'   => 'nullable|not_in:empty',
            'status' => 'required',
        ]);
        $category         = Category::findOrFail($id);
        $category->name   = $request->name;
        $category->icon   = $request->icon;
        $category->slug   = Str::slug($request->name);
        $category->status = $request->status;
        $category->save();
        toastr()->success('Category updated successfully.', 'Success');
        return redirect()->route('admin.category.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);

        $subcategories = $category->subCategories;

        if ($subcategories->count() > 0) {
            return response()->json([ 'status' => 'error', 'message' => 'Category has subcategories and cannot be deleted.' ]);
        }
        $category->delete();
        return response()->json([ 'status' => 'success', 'message' => 'Category deleted successfully.' ]);
    }


    public function changeStatus(Request $request)
    {
        $category         = Category::findOrFail($request->id);
        $category->status = $request->status == 'true' ? 1 : 0;
        $category->save();
        return response()->json([ 'status' => 'success', 'message' => 'Category status changed successfully.' ]);
    }
}