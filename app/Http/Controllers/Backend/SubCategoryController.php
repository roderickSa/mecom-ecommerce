<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    public function AllSubCategory()
    {
        $subcategories = SubCategory::with("category")->latest()->get();
        return view("backend.subcategory.subcategory_all", compact("subcategories"));
    }

    public function AddSubCategory()
    {
        $categories = Category::orderBy('category_name')->get();
        return view("backend.subcategory.subcategory_add", compact("categories"));
    }

    public function StoreSubCategory(Request $request)
    {
        $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'subcategory_name' => 'required',
        ]);

        SubCategory::create([
            'category_id' => $request->category_id,
            'subcategory_name' => $request->subcategory_name,
            'subcategory_slug' => strtolower(str_replace(' ', '-', $request->subcategory_name)),
        ]);

        $notification = ['message' => 'SubCategory has been sucessfully created', 'alert-type' => "success"];

        return redirect()->route("all.subcategory")->with($notification);
    }

    public function EditSubCategory(string $id)
    {
        $subcategory = SubCategory::findOrFail($id);
        $categories = Category::orderBy('category_name')->get();
        return view("backend.subcategory.subcategory_edit", compact("subcategory", "categories"));
    }

    public function UpdateSubCategory(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'category_id' => ['required', 'exists:categories,id'],
            'subcategory_name' => 'required',
        ]);

        $subcategory_id = $request->id;

        SubCategory::where("id", "=", $subcategory_id)->update([
            'category_id' => $request->category_id,
            'subcategory_name' => $request->subcategory_name,
            'subcategory_slug' => strtolower(str_replace(' ', '-', $request->subcategory_name)),
        ]);

        $notification = ['message' => 'SubCategory has been sucessfully updated', 'alert-type' => "success"];

        return redirect()->route("all.subcategory")->with($notification);
    }

    public function DeleteSubCategory(string $id)
    {
        SubCategory::findOrFail($id)->delete();

        $notification = ['message' => 'SubCategory has been sucessfully deleted', 'alert-type' => "success"];

        return redirect()->back()->with($notification);
    }

    public function GetSubCategory(string $category_id)
    {
        $subcategories = SubCategory::where("category_id", $category_id)->get();
        return response()->json($subcategories);
    }
}
