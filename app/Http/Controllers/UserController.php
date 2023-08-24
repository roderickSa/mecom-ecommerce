<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function UserDashboard()
    {
        $userData = User::findOrFail(auth()->user()->id);
        return view("index", compact("userData"));
    }

    public function UserProfileStore(Request $request)
    {
        $userData = User::findOrFail(auth()->user()->id);
        $userData->name = $request->name;
        $userData->phone = $request->phone;
        $userData->address = $request->address;

        if ($request->file('photo')) {
            $file = $request->file('photo');
            @unlink(public_path("upload/user_images/" . $userData->photo));
            $filename = date("YmdHis") . $file->getClientOriginalName();
            $file->move(public_path("upload/user_images"), $filename);
            $userData["photo"] = $filename;
        }
        $userData->save();

        $notification = ['message' => 'User Profile has been sucessfully updated', 'alert-type' => "success"];

        return redirect()->back()->with($notification);
    }

    public function UserUpdatePassword(Request $request)
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

    public function UserDestroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        $notification = ['message' => 'User logout sucessfully', 'alert-type' => "success"];

        return redirect('/login')->with($notification);
    }
}
