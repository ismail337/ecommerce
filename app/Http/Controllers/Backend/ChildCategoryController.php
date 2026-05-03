<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\ChildCategoryDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ChildCategory;
use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\SubCategory;

use function Symfony\Component\Translation\t;

class ChildCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ChildCategoryDataTable $dataTable)
    {

        return $dataTable->render('admin.child-category.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories    = Category::where('status', 1)->get();
        $subcategories = SubCategory::where('status', 1)->get();
        return view('admin.child-category.create', compact('categories', 'subcategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_id'    => 'required|integer',
            'subcategory_id' => 'required|integer',
            'name'           => 'required|string|max:255',
            'status'         => 'required|boolean',
        ]);

        $childCategory                  = new ChildCategory();
        $childCategory->category_id     = $request->category_id;
        $childCategory->sub_category_id = $request->subcategory_id;
        $childCategory->name            = $request->name;
        $childCategory->slug            = Str::slug($request->name);
        $childCategory->status          = $request->status;
        $childCategory->save();

        toastr()->success('Category updated successfully.', 'Success');
        return redirect()->route('admin.child-category.index');

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
        $childCategory = ChildCategory::findOrFail($id);
        $categories    = Category::where('status', 1)->get();
        $subcategories = SubCategory::where('category_id', $childCategory->category_id)
            ->where('status', 1)
            ->get();
        return view('admin.child-category.edit', compact('childCategory', 'categories', 'subcategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'category_id'    => 'required|integer',
            'subcategory_id' => 'required|integer',
            'name'           => 'required|string|max:255',
            'status'         => 'required|boolean',
        ]);

        $childCategory                  = ChildCategory::findOrFail($id);
        $childCategory->category_id     = $request->category_id;
        $childCategory->sub_category_id = $request->subcategory_id;
        $childCategory->name            = $request->name;
        $childCategory->slug            = Str::slug($request->name);
        $childCategory->status          = $request->status;
        $childCategory->save();
        toastr()->success('Child Category updated successfully.', 'Success');
        return redirect()->route('admin.child-category.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $childCategory = ChildCategory::findOrFail($id);

        $childCategory->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Child Category deleted successfully.',
        ]);
    }


    public function changeStatus(Request $request)
    {
        $childCategory         = ChildCategory::findOrFail($request->id);
        $childCategory->status = $request->status == 'true' ? 1 : 0;
        $childCategory->save();

        return response()->json([
            'status'  => 'success',
            'message' => 'Child Category status changed successfully.',
        ]);
    }


    public function getSubCategories(Request $request)
    {
        $subcategories = SubCategory::where('category_id', $request->category_id)
            ->where('status', 1)
            ->get();

        return response()->json([
            'status'        => 'success',
            'subcategories' => $subcategories,
        ]);
    }
}
