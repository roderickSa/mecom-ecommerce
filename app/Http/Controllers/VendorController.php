<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class VendorController extends Controller
{
    public function VendorDashboard()
    {
        return view("vendor.index");
    }

    public function VendorLogin()
    {
        return view("vendor.vendor_login");
    }

    public function VendorProfile()
    {
        $vendorData = User::findOrFail(auth()->user()->id);
        return view("vendor.vendor_profile", compact("vendorData"));
    }

    public function VendorChangePassword()
    {
        $vendorData = User::findOrFail(auth()->user()->id);
        return view("vendor.vendor_change_password", compact("vendorData"));
    }

    public function VendorProfileStore(Request $request)
    {
        $vendorData = User::findOrFail(auth()->user()->id);
        $vendorData->name = $request->name;
        $vendorData->phone = $request->phone;
        $vendorData->address = $request->address;
        $vendorData->vendor_join = $request->vendor_join;
        $vendorData->vendor_short_info = $request->vendor_short_info;

        if ($request->file('photo')) {
            $file = $request->file('photo');
            @unlink(public_path("upload/vendor_images/" . $vendorData->photo));
            $filename = date("YmdHis") . $file->getClientOriginalName();
            $file->move(public_path("upload/vendor_images"), $filename);
            $vendorData["photo"] = $filename;
        }
        $vendorData->save();

        $notification = ['message' => 'Vendor Profile has been sucessfully updated', 'alert-type' => "success"];

        return redirect()->back()->with($notification);
    }

    public function VendorUpdatePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => ['required', "confirmed"],
        ]);

        if (!Hash::check($request->old_password, auth()->user()->password)) {
            return back()->with("error", "Old password doesn't match!!");
        }

        User::where('id', auth()->user()->id)->update(["password" => bcrypt($request->new_password)]);

        return back()->with("status", "Password Changed Successfully");
    }

    public function VendorDestroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/vendor/login');
    }
}
