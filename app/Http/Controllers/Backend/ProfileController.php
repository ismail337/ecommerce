<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.profile.index');
    }

    public function updateProfile(Request $request)
    {
        // Update profile logic here

        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|max:255| unique:users,email,' . auth()->id(),
            'image' => 'image|max:2024',
        ]);


        $user = User::find(auth()->id());

        if ($request->hasFile('image')) {

            if ($user->profile_image && file_exists(public_path($user->profile_image))) {
                unlink(public_path($user->profile_image));
            }

            $image     = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/profile/'), $imageName);

            $user->profile_image = 'uploads/profile/' . $imageName;
        }

        $user->name  = $request->name;
        $user->email = $request->email;
        $user->save();


        toastr()->success('Profile updated successfully');

        return redirect()->back();

        // return redirect()->back()->with('success', 'Profile updated successfully');
    }

    public function updatePassword(Request $request)
    {
        // Update password logic here

        $request->validate([
            'current_password' => 'required|current_password',
            'new_password'     => 'required|min:8|confirmed',
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
