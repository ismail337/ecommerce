<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\SliderDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slider;
use App\Traits\imageUploadTrait;
class SliderController extends Controller
{
    use imageUploadTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(SliderDataTable $dataTable)
    {

        return $dataTable->render('admin.Slider.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.slider.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $data = $request->validate([
            'banner'         => 'required|image|max:2048',
            'title'          => 'required|string|max:255',
            'type'           => 'required|string|max:255',
            'starting_price' => 'required|string|max:255',
            'btn_url'        => 'required|string|max:255',
            'serial'         => 'required|string|max:255',
            'status'         => 'required|string|max:255',
        ]);


        $slider = new Slider();

        // if ($request->hasFile('image')) {
        // $filename = time() . '_' . $request->banner->getClientOriginalName();
        // $filepath = $request->banner->storeAs('uploads/slider', $filename, 'public');
        // }

        $image_path             = $this->uploadImage($request, 'banner', 'uploads/slider');
        $slider->banner         = $image_path;
        $slider->type           = $data['type'];
        $slider->title          = $data['title'];
        $slider->starting_price = $data['starting_price'];
        $slider->btn_url        = $data['btn_url'];
        $slider->serial         = $data['serial'];
        $slider->status         = $data['status'];

        $slider->save();

        toastr()->success('Sldier updated successfully');

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
    public function edit(Slider $slider)
    {
        return view('admin.slider.edit', compact('slider'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Slider $slider)
    {
        $data = $request->validate([
            'banner'         => 'image|max:2048',
            'title'          => 'required|string|max:255',
            'type'           => 'required|string|max:255',
            'starting_price' => 'required|string|max:255',
            'btn_url'        => 'required|string|max:255',
            'serial'         => 'required|string|max:255',
            'status'         => 'required|string|max:255',
        ]);


        $imagePath = $this->uploadImage($request, 'banner', 'uploads/slider', $request->banner);

        $slider->banner         = $request->banner ? $imagePath : $slider->banner;
        $slider->type           = $data['type'];
        $slider->title          = $data['title'];
        $slider->starting_price = $data['starting_price'];
        $slider->btn_url        = $data['btn_url'];
        $slider->serial         = $data['serial'];
        $slider->status         = $data['status'];

        $slider->save();

        toastr()->success('Sldier updated successfully');

        return redirect()->back();

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $slider = Slider::findOrFail($id);

        // Delete the slider image
        $this->deleteImage($slider->banner);

        // Delete the slider record
        $slider->delete();

        // Return a success response
        return response()->json([ 'status' => 'success', 'message' => 'Deleted Successfully' ]);
    }
}
