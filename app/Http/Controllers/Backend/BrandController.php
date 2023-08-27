<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Image;

class BrandController extends Controller
{
    public function AllBrand()
    {
        $brands = Brand::latest()->get();
        return view("backend.brand.brand_all", compact("brands"));
    }

    public function AddBrand()
    {
        return view("backend.brand.brand_add");
    }

    public function StoreBrand(Request $request)
    {
        $request->validate([
            'brand_name' => 'required',
            'brand_image' => ['required', "mimes:jpeg,png,jpg"],
        ]);

        $image = $request->file('brand_image');
        $name_generated = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
        $url_image = 'upload/brand/' . $name_generated;
        Image::make($image)->resize(300, 300)->save($url_image);

        Brand::create([
            'brand_name' => $request->brand_name,
            'brand_slug' => strtolower(str_replace(' ', '-', $request->brand_name)),
            'brand_image' => 'upload/brand/' . $name_generated,
        ]);

        $notification = ['message' => 'Brand has been sucessfully created', 'alert-type' => "success"];

        return redirect()->route("all.brand")->with($notification);
    }

    public function EditBrand(string $id)
    {
        $brand = Brand::findOrFail($id);
        return view("backend.brand.brand_edit", compact("brand"));
    }

    public function UpdateBrand(Request $request)
    {
        $request->validate([
            'brand_name' => 'required',
        ]);

        $brand_id = $request->id;
        $old_image = $request->old_image;

        if ($request->file('brand_image')) {
            $image = $request->file('brand_image');
            $name_generated = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $url_image = 'upload/brand/' . $name_generated;
            Image::make($image)->resize(300, 300)->save($url_image);

            if (file_exists($old_image)) {
                unlink($old_image);
            }

            Brand::where('id', '=', $brand_id)->update([
                'brand_name' => $request->brand_name,
                'brand_slug' => strtolower(str_replace(' ', '-', $request->brand_name)),
                'brand_image' => 'upload/brand/' . $name_generated,
            ]);
        } else {
            Brand::where('id', '=', $brand_id)->update([
                'brand_name' => $request->brand_name,
                'brand_slug' => strtolower(str_replace(' ', '-', $request->brand_name)),
            ]);
        }

        $notification = ['message' => 'Brand has been sucessfully created', 'alert-type' => "success"];

        return redirect()->route("all.brand")->with($notification);
    }

    public function DeleteBrand(string $id)
    {
        $brand = Brand::findOrFail($id);
        unlink($brand->brand_image);

        Brand::findOrFail($id)->delete();

        $notification = ['message' => 'Brand has been sucessfully deleted', 'alert-type' => "success"];

        return redirect()->back()->with($notification);
    }
}
