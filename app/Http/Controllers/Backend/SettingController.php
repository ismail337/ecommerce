<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GanaralSetting;
class SettingController extends Controller
{
    public function index()
    {

        $generalSetting = GanaralSetting::first();

        return view('admin.settings.index', compact('generalSetting'));
    }

    public function updateGeneralSetting(Request $request)
    {
        $request->validate([
            'site_name'       => 'required|string|max:255',
            'layout'          => 'required|string|max:255',
            'contact_email'   => 'required|email|max:255',
            'contact_phone'   => 'required|string|max:20',
            'contact_address' => 'required|string|max:500',
            'currency_name'   => 'required|string|max:10',
            'currency_icon'   => 'required|string|max:10',
            'time_zone'       => 'required|string|max:255',
        ]);


        GanaralSetting::updateOrCreate(
            [ 'id' => 1 ], // Assuming you want to update the record with ID 1, or create it if it doesn't exist
            [
                'site_name'       => $request->site_name,
                'layout'          => $request->layout,
                'contact_email'   => $request->contact_email,
                'contact_phone'   => $request->contact_phone,
                'contact_address' => $request->contact_address,
                'currency_name'   => $request->currency_name,
                'map'             => $request->map,
                'currency_icon'   => $request->currency_icon,
                'time_zone'       => $request->time_zone,
            ]
        );

        // $setting                  = new GanaralSetting();
        // $setting->site_name       = $request->site_name;
        // $setting->layout          = $request->layout;
        // $setting->contact_email   = $request->contact_email;
        // $setting->contact_phone   = $request->contact_phone;
        // $setting->contact_address = $request->contact_address;
        // $setting->currency_name   = $request->currency_name;
        // $setting->currency_name   = $request->map;
        // $setting->currency_icon   = $request->currency_icon;
        // $setting->time_zone       = $request->time_zone;

        // $setting->save();


        toastr()->success('General settings updated successfully.', 'Success');
        return redirect()->back();

    }
}
