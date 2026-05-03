<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\ShippingRuleDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ShippingRule;

class ShippingRuleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ShippingRuleDataTable $dataTable)
    {
        return $dataTable->render('admin.shipping-rule.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.shipping-rule.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'type'     => 'required|string|max:255',
            'min_cost' => 'nullable|integer',
            'cost'     => 'nullable|integer',
            'status'   => 'required',
        ]);

        $shippingRule           = new ShippingRule();
        $shippingRule->name     = $request->name;
        $shippingRule->type     = $request->type;
        $shippingRule->min_cost = $request->min_cost;
        $shippingRule->cost     = $request->cost;
        $shippingRule->status   = $request->status;
        $shippingRule->save();

        toastr()->success('Shipping Rule created successfully');

        return redirect()->route('admin.shipping-rule.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(ShippingRule $shippingRule)
    {
        return view('admin.shipping-rule.show', compact('shippingRule'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ShippingRule $shippingRule)
    {
        return view('admin.shipping-rule.edit', compact('shippingRule'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'type'     => 'required|string|max:255',
            'min_cost' => 'nullable|integer',
            'cost'     => 'nullable|integer',
            'status'   => 'required',
        ]);

        $shippingRule           = ShippingRule::findOrFail($id);
        $shippingRule->name     = $request->name;
        $shippingRule->type     = $request->type;
        $shippingRule->min_cost = $request->min_cost;
        $shippingRule->cost     = $request->cost;
        $shippingRule->status   = $request->status;
        $shippingRule->save();

        toastr()->success('Shipping Rule updated successfully');

        return redirect()->route('admin.shipping-rule.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $shippingRule = ShippingRule::findOrFail($id);
        $shippingRule->delete();

        return response()->json([ 'status' => 'success', 'message' => 'Deleted Successfully' ]);
    }

    public function changeStatus(Request $request)
    {
        $shippingRule         = ShippingRule::findOrFail($request->id);
        $shippingRule->status = $request->status == 'true' ? 1 : 0;
        $shippingRule->save();
        return response()->json([ 'status' => 'success', 'message' => 'Shipping Rule status changed successfully.' ]);
    }

}