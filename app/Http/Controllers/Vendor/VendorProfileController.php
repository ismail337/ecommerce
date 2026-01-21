<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VendorProfileController extends Controller
{
    public function index()
    {
        return view('vendor.profile');
    }

    public function updateProfile(Request $request)
    {

        $request->validate([
            'username' => 'required|string|max:255',
            'email'    => 'required|email|max:255| unique:users,email,' . auth()->id(),

            'image'    => 'image|max:2048'
        ]);

        $user = auth()->user();

        if ($request->hasFile('image')) {

            if ($user->profile_image && file_exists(public_path($user->profile_image))) {
                unlink(public_path($user->profile_image));
            }

            $image     = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/profile/'), $imageName);

            $user->profile_image = 'uploads/profile/' . $imageName;
        }


        $user->username = $request->username;
        $user->email    = $request->email;
        $user->save();


        toastr()->success('Profile updated successfully');

        return redirect()->back();

    }

    public function updatePassword(Request $request)
    {


        // Update password logic here

        $request->validate([
            'current_password' => 'required|current_password',
            'password'         => 'required|min:8|confirmed',
        ]);

        $user = auth()->user();

        if (!\Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->withErrors([ 'current_password' => 'Current password is incorrect' ]);
        }

        $user->password = bcrypt($request->new_password);
        $user->save();


        toastr()->success('Password updated successfully');

        // return redirect()->back()->with('success', 'Password updated successfully');
        return redirect()->back();
    }
}
