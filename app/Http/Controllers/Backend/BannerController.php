<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Image;

class BannerController extends Controller
{
    public function AllBanner()
    {
        $banners = Banner::latest()->get();
        return view("backend.banner.banner_all", compact("banners"));
    }

    public function AddBanner()
    {
        return view("backend.banner.banner_add");
    }

    public function StoreBanner(Request $request)
    {
        $request->validate([
            "banner_title" => ["required", "min:5"],
            "banner_url" => ["required", "min:2"],
            "banner_image" => ["required", "mimes:gif,png,jpg"]
        ]);

        $image = $request->file("banner_image");
        $name_generated = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
        $url_image = 'upload/banner/' . $name_generated;
        Image::make($image)->resize(768, 450)->save($url_image);

        Banner::create([
            "banner_title" => $request->banner_title,
            "banner_url" => $request->banner_url,
            "banner_image" => $url_image
        ]);

        $notification = ['message' => 'banner has been sucessfully created', 'alert-type' => "success"];

        return redirect()->route("all.banner")->with($notification);
    }

    public function EditBanner(Banner $banner)
    {
        return view("backend.banner.banner_edit", compact("banner"));
    }

    public function UpdateBanner(Banner $banner, Request $request)
    {
        $request->validate([
            "banner_title" => ["required", "min:5"],
            "banner_url" => ["required", "min:2"],
            "banner_image" => ["mimes:gif,png,jpg"]
        ]);

        $banner->banner_title = $request->banner_title;
        $banner->banner_url = $request->banner_url;

        if ($request->file("banner_image")) {
            $image = $request->file("banner_image");
            $old_image = $request->old_image;
            $name_generated = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $url_image = 'upload/banner/' . $name_generated;
            Image::make($image)->resize(768, 450)->save($url_image);

            if (file_exists($old_image)) {
                unlink($old_image);
            }

            $banner->banner_image = $url_image;
        }
        
        $banner->save();

        $notification = ['message' => 'Banner has been sucessfully updated', 'alert-type' => "success"];

        return redirect()->route("all.banner")->with($notification);
    }

    public function DeleteBanner(Banner $banner)
    {
        if (file_exists($banner->banner_image)) {
            unlink($banner->banner_image);
        }

        $banner->delete();

        $notification = ['message' => 'Banner has been sucessfully deleted', 'alert-type' => "success"];

        return redirect()->back()->with($notification);
    }
}
