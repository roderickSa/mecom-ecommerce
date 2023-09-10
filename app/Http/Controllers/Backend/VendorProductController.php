<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\MultiImg;
use App\Models\Product;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class VendorProductController extends Controller
{
    public function VendorAllProduct()
    {
        $products = Product::where("vendor_id", auth()->user()->id)->latest()->get();
        return view("vendor.backend.product.vendor_product_all", compact("products"));
    }

    public function VendorShowProduct(string $id)
    {
        $product = Product::findOrFail($id);
        $multiimages = MultiImg::where("product_id", $product->id)->latest()->get();
        $brands = Brand::latest()->get();
        $categories = Category::latest()->get();
        $subcategories = SubCategory::where("category_id", $product->category_id)->latest()->get();
        return view("vendor.backend.product.vendor_product_show", compact("product", "multiimages", "brands", "categories", "subcategories"));
    }
}
