<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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

    public function AdminDestroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/admin/login');
    }
}
