<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserAddress;
use Illuminate\Support\Facades\Auth;

use function Symfony\Component\Translation\t;

class UserAddressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userAddresses = UserAddress::where('user_id', auth()->id())->get();
        return view('frontend.dashboard.address.index', compact('userAddresses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('frontend.dashboard.address.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'phone'   => 'required|string|max:20',
            'email'   => 'nullable|email|max:255',
            'address' => 'required|string|max:255',
            'city'    => 'required|string|max:100',
            'state'   => 'required|string|max:100',
            'zip'     => 'required|string|max:20',
            'country' => 'required|string|max:100',
        ]);

        $userAddress          = new UserAddress();
        $userAddress->user_id = Auth::user()->id;
        $userAddress->name    = $request->name;
        $userAddress->phone   = $request->phone;
        $userAddress->email   = $request->email;
        $userAddress->address = $request->address;
        $userAddress->city    = $request->city;
        $userAddress->state   = $request->state;
        $userAddress->zip     = $request->zip;
        $userAddress->country = $request->country;
        $userAddress->save();

        toastr()->success('Address added successfully');
        return redirect()->route('user.address.index');
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
        $userAddress = UserAddress::where('user_id', Auth::user()->id)->findOrFail($id);
        return view('frontend.dashboard.address.edit', compact('userAddress'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'phone'   => 'required|string|max:20',
            'email'   => 'nullable|email|max:255',
            'address' => 'required|string|max:255',
            'city'    => 'required|string|max:100',
            'state'   => 'required|string|max:100',
            'zip'     => 'required|string|max:20',
            'country' => 'required|string|max:100',
        ]);

        $userAddress          = UserAddress::where('user_id', Auth::user()->id)->findOrFail($id);
        $userAddress->name    = $request->name;
        $userAddress->phone   = $request->phone;
        $userAddress->email   = $request->email;
        $userAddress->address = $request->address;
        $userAddress->city    = $request->city;
        $userAddress->state   = $request->state;
        $userAddress->zip     = $request->zip;
        $userAddress->country = $request->country;
        $userAddress->save();

        toastr()->success('Address updated successfully');
        return redirect()->route('user.address.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $userAddress = UserAddress::findOrFail($id);
        $userAddress->delete();
        return response()->json([ 'status' => 'success', 'message' => 'Address deleted successfully' ]);
    }
}
