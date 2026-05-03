<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserAddress;
use Illuminate\Support\Facades\Auth;
use App\Models\ShippingRule;
use Illuminate\Support\Facades\Session;
class CheckoutController extends Controller
{
    public function index()
    {
        $userAddresses = UserAddress::where('user_id', Auth::user()->id)->get();

        $shippingAddress = ShippingRule::where('status', 1)->get();


        return view('frontend.pages.checkout-page', compact('userAddresses', 'shippingAddress'));
    }


    public function addAddress(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'phone'   => 'required|string|max:20',
            'address' => 'required|string',
            'state'   => 'required|string|max:255',
            'zip'     => 'required|string|max:20',
            'country' => 'required|string|max:255',
        ]);

        $address          = new UserAddress();
        $address->user_id = Auth::user()->id;
        $address->name    = $request->name;
        $address->email   = $request->email;
        $address->phone   = $request->phone;
        $address->address = $request->address;
        $address->city    = $request->city;
        $address->state   = $request->state;
        $address->zip     = $request->zip;
        $address->country = $request->country;
        $address->save();

        toastr()->success('Address added successfully!');
        return redirect()->back();
    }


    public function submitCheckoutForm(Request $request)
    {
        // Handle the checkout form submission logic here
        // You can process the order, save it to the database, etc.

        // For demonstration, we'll just return a success message


        $request->validate([
            'shipping_address_id' => 'required|integer',
            'shipping_method_id'  => 'required|integer',
        ]);

        $shippingMethod = ShippingRule::findOrFail($request->shipping_method_id);

        if ($shippingMethod) {
            Session::put('shipping_method', [
                'id'   => $shippingMethod->id,
                'name' => $shippingMethod->name,
                'type' => $shippingMethod->type,
                'cost' => $shippingMethod->cost
            ]);
        }


        $shippingAddress = UserAddress::findOrFail($request->shipping_address_id)->toArray();



        if ($shippingAddress) {
            Session::put('address', $shippingAddress);
        }

        toastr()->success('Checkout form submitted successfully!');

        return response([ 'status' => 'success', 'redirect_url' => route('user.payment') ]);
    }
}
