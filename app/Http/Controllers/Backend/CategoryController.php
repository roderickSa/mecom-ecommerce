<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Image;

class CategoryController extends Controller
{
    public function AllCategory()
    {
        $categories = Category::latest()->get();
        return view("backend.category.category_all", compact("categories"));
    }

    public function AddCategory()
    {
        return view("backend.category.category_add");
    }

    public function StoreCategory(Request $request)
    {
        $request->validate([
            'category_name' => 'required',
            'category_image' => ['required', "mimes:jpeg,png,jpg"],
        ]);

        $image = $request->file('category_image');
        $name_generated = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
        $url_image = 'upload/category/' . $name_generated;
        Image::make($image)->resize(300, 300)->save($url_image);

        Category::create([
            'category_name' => $request->category_name,
            'category_slug' => strtolower(str_replace(' ', '-', $request->category_name)),
            'category_image' => $url_image,
        ]);

        $notification = ['message' => 'Category has been sucessfully created', 'alert-type' => "success"];

        return redirect()->route("all.category")->with($notification);
    }

    public function EditCategory(string $id)
    {
        $category = Category::findOrFail($id);
        return view("backend.category.category_edit", compact("category"));
    }

    public function UpdateCategory(Request $request)
    {
        $request->validate([
            'category_name' => 'required',
        ]);

        $category_id = $request->id;
        $old_image = $request->old_image;

        if ($request->file('category_image')) {
            $image = $request->file('category_image');
            $name_generated = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $url_image = 'upload/category/' . $name_generated;
            Image::make($image)->resize(300, 300)->save($url_image);

            if (file_exists($old_image)) {
                unlink($old_image);
            }

            Category::where('id', '=', $category_id)->update([
                'category_name' => $request->category_name,
                'category_slug' => strtolower(str_replace(' ', '-', $request->category_name)),
                'category_image' => 'upload/category/' . $name_generated,
            ]);
        } else {
            Category::where('id', '=', $category_id)->update([
                'category_name' => $request->category_name,
                'category_slug' => strtolower(str_replace(' ', '-', $request->category_name)),
            ]);
        }

        $notification = ['message' => 'Category has been sucessfully created', 'alert-type' => "success"];

        return redirect()->route("all.category")->with($notification);
    }

    public function DeleteCategory(string $id)
    {
        $category = Category::findOrFail($id);

        Category::findOrFail($id)->delete();

        if (file_exists($category->category_image)) {
            unlink($category->category_image);
        }

        $notification = ['message' => 'Category has been sucessfully deleted', 'alert-type' => "success"];

        return redirect()->back()->with($notification);
    }
}
