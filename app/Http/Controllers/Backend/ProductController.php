<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\MultiImg;
use App\Models\Product;
use App\Models\SubCategory;
use App\Models\User;
use Illuminate\Http\Request;
use Image;

class ProductController extends Controller
{
    public function AllProduct()
    {
        $products = Product::latest()->get();
        return view("backend.product.product_all", compact("products"));
    }

    public function AddProduct()
    {
        $brands = Brand::latest()->get();
        $categories = Category::latest()->get();
        $vendors = User::where([["status", "active"], ["role", "vendor"]])->latest()->get();
        return view("backend.product.product_add", compact("brands", "categories", "vendors"));
    }

    public function StoreProduct(Request $request)
    {
        $request->validate([
            'product_name' => 'required',
            'brand_id' => ['required', 'exists:brands,id'],
            'category_id' => ['required', 'exists:categories,id'],
            'sub_category_id' => ['required', 'exists:sub_categories,id'],
            'short_descp' => 'required',
            'selling_price' => ['required', 'numeric', 'min:0.01'],
            'product_code' => 'required',
            'product_size' => 'required',
            'product_qty' => ['required', 'numeric', 'min:0'],
            'product_thumbnail' => ['required', "mimes:gif,png,jpg"],
        ]);

        /* THUMBNAIL IMAGE */
        $image = $request->file('product_thumbnail');
        $name_generated = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
        $url_image = 'upload/product/thumbnail/' . $name_generated;
        Image::make($image)->resize(300, 300)->save($url_image);

        /* $data = $request->all(); */
        $data = $request->except(['multi_img']);
        $data["product_slug"] = strtolower(str_replace(" ", "-", $data["product_name"]));
        $data["status"] = 1;
        $data["product_thumbnail"] = $url_image;

        //CHECKBOXS VALIDATIONS
        $data["hot_deals"] = $request->input("hot_deals") ? 1 : 0;
        $data["featured"] = $request->input("featured") ? 1 : 0;
        $data["special_offer"] = $request->input("special_offer") ? 1 : 0;
        $data["special_deals"] = $request->input("special_deals") ? 1 : 0;

        $product_id = Product::create($data)->id;

        /* MULTI IMAGE REGISTER */
        if ($request->file("multi_img")) {
            foreach ($request->file("multi_img") as $key => $image) {
                $name_generated = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
                $url_image = 'upload/product/multi-image/' . $name_generated;
                Image::make($image)->resize(300, 300)->save($url_image);

                MultiImg::create(['product_id' => $product_id, 'photo_name' => $url_image]);
            }
        }

        $notification = ['message' => 'Product has been sucessfully created', 'alert-type' => "success"];

        return redirect()->route("all.product")->with($notification);
    }

    public function EditProduct(string $id)
    {
        $product = Product::findOrFail($id);
        $multiimages = MultiImg::where("product_id", $id)->get();
        $brands = Brand::latest()->get();
        $categories = Category::latest()->get();
        $subcategories = SubCategory::where("category_id", $product->category_id)->latest()->get();
        $vendors = User::where([["status", "active"], ["role", "vendor"]])->latest()->get();
        return view("backend.product.product_edit", compact("product", "multiimages", "brands", "categories", "subcategories", "vendors"));
    }

    public function UpdateProduct(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'product_name' => 'required',
            'brand_id' => ['required', 'exists:brands,id'],
            'category_id' => ['required', 'exists:categories,id'],
            'sub_category_id' => ['required', 'exists:sub_categories,id'],
            'vendor_id' => ['required', 'exists:users,id'],
            'short_descp' => 'required',
            'selling_price' => ['required', 'numeric', 'min:0.01'],
            'product_code' => 'required',
            'product_size' => 'required',
            'product_qty' => ['required', 'numeric', 'min:0'],
        ]);

        $product_id = $request->id;
        $data = $request->except("_token");

        //CHECKBOXS VALIDATIONS
        $data["hot_deals"] = $request->input("hot_deals") ? 1 : 0;
        $data["featured"] = $request->input("featured") ? 1 : 0;
        $data["special_offer"] = $request->input("special_offer") ? 1 : 0;
        $data["special_deals"] = $request->input("special_deals") ? 1 : 0;

        Product::where("id", $product_id)->update($data);

        $notification = ['message' => 'Product has been sucessfully updated', 'alert-type' => "success"];

        return redirect()->route("all.product")->with($notification);
    }

    public function UpdateProductThumbnail(Request $request)
    {
        $request->validate([
            'product_thumbnail' => ['required', "mimes:gif,png,jpg"],
        ]);

        $product_id = $request->id;
        $old_image = $request->old_image;

        $image = $request->file('product_thumbnail');
        $name_generated = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
        $url_image = 'upload/product/thumbnail/' . $name_generated;
        Image::make($image)->resize(300, 300)->save($url_image);

        if (file_exists($old_image)) {
            unlink($old_image);
        }

        Product::where("id", $product_id)->update(["product_thumbnail" => $url_image]);

        $notification = ['message' => 'Image has been sucessfully updated', 'alert-type' => "success"];

        return redirect()->route("all.product")->with($notification);
    }

    public function UpdateProductMultiimage(Request $request)
    {
        /* FIELD multi_img IS AN ARRAY */
        $request->validate([
            'multi_img' => 'required',
            'multi_img.*' => "mimes:gif,png,jpg",
        ]);

        $multi_img = $request->multi_img;

        foreach ($multi_img as $image_id => $image) {
            $image_to_delete = MultiImg::findOrFail($image_id);
            unlink($image_to_delete->photo_name);

            $name_generated = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $url_image = 'upload/product/multi-image/' . $name_generated;
            Image::make($image)->resize(300, 300)->save($url_image);

            MultiImg::where("id", $image_id)->update(["photo_name" => $url_image]);
        }

        $notification = ['message' => 'Multi Image has been sucessfully updated', 'alert-type' => "success"];

        return redirect()->back()->with($notification);
    }

    public function DeleteProductMultiimage(string $id)
    {
        $multi_image = MultiImg::findOrFail($id);
        unlink($multi_image->photo_name);

        MultiImg::findOrFail($id)->delete();

        $notification = ['message' => 'Multi Image has been sucessfully deleted', 'alert-type' => "success"];

        return redirect()->back()->with($notification);
    }
}
