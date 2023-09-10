@extends('vendor.vendor_dashboard')
@section('vendor')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <div class="page-wrapper">
        <div class="page-content">

            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">eCommerce</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Product</li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-auto">
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary">Settings</button>
                        <button type="button"
                            class="btn btn-primary split-bg-primary dropdown-toggle dropdown-toggle-split"
                            data-bs-toggle="dropdown"> <span class="visually-hidden">Toggle Dropdown</span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end"> <a class="dropdown-item"
                                href="javascript:;">Action</a>
                            <a class="dropdown-item" href="javascript:;">Another action</a>
                            <a class="dropdown-item" href="javascript:;">Something else here</a>
                            <div class="dropdown-divider"></div> <a class="dropdown-item" href="javascript:;">Separated
                                link</a>
                        </div>
                    </div>
                </div>
            </div>
            <!--end breadcrumb-->

            <div class="card">
                <div class="card-body p-4">
                    <h5 class="card-title">Show Product</h5>
                    <hr />
                    <div class="form-body mt-4">
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="border border-3 p-4 rounded">
                                    <div class="form-group mb-3">
                                        <label for="product_name" class="form-label">Product Name</label>
                                        <input type="text" class="form-control" id="product_name" name="product_name"
                                            placeholder="Enter product name" value="{{ $product->product_name }}"
                                            disabled />
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="product_tags" class="form-label">Product Tags</label>
                                        <input type="text" class="form-control visually-hidden" data-role="tagsinput"
                                            id="product_tags" name="product_tags" value="{{ $product->product_tags }}"
                                            disabled />
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="product_size" class="form-label">Product Size</label>
                                        <input type="text" class="form-control visually-hidden" data-role="tagsinput"
                                            id="product_size" name="product_size" value="{{ $product->product_size }}"
                                            disabled />
                                        <x-input-error :messages="$errors->get('product_size')" class="mt-2" />
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="product_color" class="form-label">Product Color</label>
                                        <input type="text" class="form-control visually-hidden" data-role="tagsinput"
                                            id="product_color" name="product_color" value="{{ $product->product_color }}"
                                            disabled />
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="short_descp" class="form-label">Short Description</label>
                                        <textarea class="form-control" id="short_descp" name="short_descp" rows="3" disabled>
                                                {{ $product->short_descp }}
                                            </textarea>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="long_descp" class="form-label">Long Description</label>
                                        <textarea id="mytextarea" name="long_descp">{{ $product->long_descp }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="border border-3 p-4 rounded">
                                    <div class="row g-3">
                                        <div class="form-group col-md-6">
                                            <label for="selling_price" class="form-label">Product Price</label>
                                            <input type="text" class="form-control" id="selling_price"
                                                name="selling_price" placeholder="0.00"
                                                value="{{ $product->selling_price }}" disabled />
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="discount_price" class="form-label">Discount
                                                Price</label>
                                            <input type="text" class="form-control" id="discount_price"
                                                name="discount_price" placeholder="0.00"
                                                value="{{ $product->discount_price }}" disabled />
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="product_code" class="form-label">Product Code</label>
                                            <input type="text" class="form-control" id="product_code"
                                                name="product_code" placeholder="ABc"
                                                value="{{ $product->product_code }}" disabled />
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="product_qty" class="form-label">Product Quantity</label>
                                            <input type="text" class="form-control" id="product_qty"
                                                name="product_qty" placeholder="0.00" value="{{ $product->product_qty }}"
                                                disabled />
                                        </div>
                                        <div class="form-group col-12">
                                            <label for="brand_id" class="form-label">Product Brand</label>
                                            <select class="form-select" id="brand_id" name="brand_id" disabled>
                                                <option>Choose</option>
                                                @foreach ($brands as $key => $brand)
                                                    <option value="{{ $brand->id }}"
                                                        @if ($product->brand_id == $brand->id) selected="selected" @endif>
                                                        {{ $brand->brand_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-12">
                                            <label for="category_id" class="form-label">Product Category</label>
                                            <select class="form-select" id="category_id" name="category_id" disabled>
                                                <option>Choose</option>
                                                @foreach ($categories as $key => $category)
                                                    <option value="{{ $category->id }}"
                                                        @if ($product->category_id == $category->id) selected="selected" @endif>
                                                        {{ $category->category_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-12">
                                            <label for="sub_category_id" class="form-label">Product
                                                SubCategory</label>
                                            <select class="form-select" id="sub_category_id" name="sub_category_id"
                                                disabled>
                                                <option>Choose</option>
                                                @foreach ($subcategories as $key => $subcategory)
                                                    <option value="{{ $subcategory->id }}"
                                                        @if ($product->sub_category_id == $subcategory->id) selected="selected" @endif>
                                                        {{ $subcategory->subcategory_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-12">
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="hot_deals"
                                                            name="hot_deals"
                                                            @if ($product->hot_deals == 1) checked @endif disabled />
                                                        <label for="hot_deals" class="form-check-label">Hot
                                                            deals</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="featured"
                                                            name="featured"
                                                            @if ($product->featured == 1) checked @endif disabled />
                                                        <label for="featured" class="form-check-label">Featured</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox"
                                                            id="special_offer" name="special_offer"
                                                            @if ($product->special_offer == 1) checked @endif disabled />
                                                        <label for="special_offer" class="form-check-label">Special
                                                            Offer</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox"
                                                            id="special_deals" name="special_deals"
                                                            @if ($product->special_deals == 1) checked @endif disabled />
                                                        <label for="special_deals" class="form-check-label">Special
                                                            Deal</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!--end row-->
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body p-4">
                    <h5 class="card-title">Edit Main Image</h5>
                    <hr />
                    <div class="form-group mb-3">
                        <label for="product_thumbnail" class="form-label">Main Thumbnail</label>
                        <img src="{{ asset($product->product_thumbnail) }}" id="img_main_thumbnail" alt="">
                        <x-input-error :messages="$errors->get('product_thumbnail')" class="mt-2" />
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <form id="" action="{{ route('update.product.multiimage') }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <table id="example" class="table table-striped table-bordered" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>Sl</th>
                                        <th>Image</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($multiimages as $key => $image)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td><img src="{{ asset($image->photo_name) }}" alt="image"
                                                    style="width:180px;height:180px"></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Sl</th>
                                        <th>Image</th>
                                </tfoot>
                            </table>
                            <x-input-error :messages="$errors->get('multi_img')" class="mt-2" />
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
