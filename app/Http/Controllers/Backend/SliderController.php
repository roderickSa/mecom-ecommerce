<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Image;

class SliderController extends Controller
{
    public function AllSlider()
    {
        $sliders = Slider::latest()->get();
        return view("backend.slider.slider_all", compact("sliders"));
    }

    public function AddSlider()
    {
        return view("backend.slider.slider_add");
    }

    public function StoreSlider(Request $request)
    {
        $request->validate([
            "slider_title" => ["required", "min:5"],
            "short_title" => ["required", "min:2"],
            "slider_image" => ["required", "mimes:gif,png,jpg"]
        ]);

        $image = $request->file("slider_image");
        $name_generated = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
        $url_image = 'upload/slider/' . $name_generated;
        Image::make($image)->resize(300, 300)->save($url_image);

        Slider::create([
            "slider_title" => $request->slider_title,
            "short_title" => $request->short_title,
            "slider_image" => $url_image
        ]);

        $notification = ['message' => 'Slider has been sucessfully created', 'alert-type' => "success"];

        return redirect()->route("all.slider")->with($notification);
    }

    public function EditSlider(Slider $slider)
    {
        return view("backend.slider.slider_edit", compact("slider"));
    }

    public function UpdateSlider(Request $request)
    {
        $request->validate([
            "slider_title" => ["required", "min:5"],
            "short_title" => ["required", "min:2"],
            "slider_image" => ["mimes:gif,png,jpg"]
        ]);

        $slider_id = $request->id;

        $arr_update = [
            "slider_title" => $request->slider_title,
            "short_title" => $request->short_title,
        ];

        if ($request->file("slider_image")) {
            $image = $request->file("slider_image");
            $old_image = $request->old_image;
            $name_generated = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $url_image = 'upload/slider/' . $name_generated;
            Image::make($image)->resize(300, 300)->save($url_image);

            if (file_exists($old_image)) {
                unlink($old_image);
            }

            $arr_update["slider_image"] = $url_image;
        }

        Slider::where("id", $slider_id)->update($arr_update);

        $notification = ['message' => 'Slider has been sucessfully updated', 'alert-type' => "success"];

        return redirect()->route("all.slider")->with($notification);
    }

    public function DeleteSlider(Slider $slider)
    {
        if (file_exists($slider->slider_image)) {
            unlink($slider->slider_image);
        }

        $slider->delete();

        $notification = ['message' => 'Slider has been sucessfully deleted', 'alert-type' => "success"];

        return redirect()->back()->with($notification);
    }
}
