<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class AdminController extends Controller
{
    public function AdminDashboard()
    {
        return view("admin.index");
    }

    public function AdminLogin()
    {
        return view("admin.admin_login");
    }

    public function AdminProfile()
    {
        $adminData = User::findOrFail(auth()->user()->id);
        return view("admin.admin_profile", compact("adminData"));
    }

    public function AdminChangePassword()
    {
        $adminData = User::findOrFail(auth()->user()->id);
        return view("admin.admin_change_password", compact("adminData"));
    }

    public function AdminProfileStore(Request $request)
    {
        $adminData = User::findOrFail(auth()->user()->id);
        $adminData->name = $request->name;
        $adminData->phone = $request->phone;
        $adminData->address = $request->address;

        if ($request->file('photo')) {
            $file = $request->file('photo');
            @unlink(public_path("upload/admin_images/" . $adminData->photo));
            $filename = date("YmdHis") . $file->getClientOriginalName();
            $file->move(public_path("upload/admin_images"), $filename);
            $adminData["photo"] = $filename;
        }
        $adminData->save();

        $notification = ['message' => 'Admin Profile has been sucessfully updated', 'alert-type' => "success"];

        return redirect()->back()->with($notification);
    }

    public function AdminUpdatePassword(Request $request)
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

    public function AllVendor()
    {
        $vendors = User::where("role", "vendor")->latest()->get();
        return view("backend.vendor.vendor_all", compact("vendors"));
    }

    public function RegisterVendor()
    {
        return view("backend.vendor.register_vendor");
    }

    public function StoreVendor(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'phone' => $request->phone,
            'vendor_join' => $request->vendor_join,
            'password' => Hash::make($request->password),
            'role' => "vendor",
        ]);

        event(new Registered($user));

        /* Auth::login($user); */

        $notification = ['message' => 'Vendor User has been sucessfully created', 'alert-type' => "success"];

        return redirect()->route("all.vendor")->with($notification);
    }

    public function DetailsVendor(string $id)
    {
        $vendor = User::findOrFail($id);
        return view("backend.vendor.vendor_details", compact("vendor"));
    }

    public function ChangeStatusVendor(Request $request)
    {
        $vendor = User::findOrFail($request->id);
        $status = $vendor->status == "active" ? "inactive" : "active";
        User::where("id", $request->id)->update(["status" => $status]);

        return back()->with("status", "Status Changed Successfully");
    }

    public function AdminDestroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/admin/login');
    }
}
