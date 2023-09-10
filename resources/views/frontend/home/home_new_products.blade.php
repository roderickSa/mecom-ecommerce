@php
    $products = App\Models\Product::where('status', 1)
        ->orderBy('id', 'ASC')
        ->limit(10)
        ->get();
    /* $categories = App\Models\Category::has("products")->orderBy('category_name', 'ASC')->get(); */
    $categories = App\Models\Category::orderBy('category_name', 'ASC')->get();
@endphp
<section class="product-tabs section-padding position-relative">
    <div class="container">
        <div class="section-title style-2 wow animate__animated animate__fadeIn">
            <h3> New Products </h3>
            <ul class="nav nav-tabs links" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="nav-tab-one" data-bs-toggle="tab" data-bs-target="#tab-one"
                        type="button" role="tab" aria-controls="tab-one" aria-selected="true">All</button>
                </li>
                @foreach ($categories as $key => $category)
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="nav-tab-four" data-bs-toggle="tab"
                            data-bs-target="#tab-{{ $category->category_name }}" type="button" role="tab"
                            aria-controls="tab-four" aria-selected="false">{{ $category->category_name }}</button>
                    </li>
                @endforeach
            </ul>
        </div>
        <!--End nav-tabs-->
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="tab-one" role="tabpanel" aria-labelledby="tab-one">
                <div class="row product-grid-4">
                    @foreach ($products as $key => $product)
                        <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                            <div class="product-cart-wrap mb-30 wow animate__animated animate__fadeIn"
                                data-wow-delay=".1s">
                                <div class="product-img-action-wrap">
                                    <div class="product-img product-img-zoom">
                                        <a href="shop-product-right.html">
                                            <img class="default-img" src="{{ asset($product->product_thumbnail) }}"
                                                alt="" />
                                        </a>
                                    </div>
                                    <div class="product-action-1">
                                        <a aria-label="Add To Wishlist" class="action-btn" href="shop-wishlist.html"><i
                                                class="fi-rs-heart"></i></a>
                                        <a aria-label="Compare" class="action-btn" href="shop-compare.html"><i
                                                class="fi-rs-shuffle"></i></a>
                                        <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal"
                                            data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                                    </div>
                                    @php
                                        $amount = (float) $product->selling_price - (float) $product->discount_price;
                                        $discount = ($amount / $product->selling_price) * 100;
                                    @endphp
                                    <div class="product-badges product-badges-position product-badges-mrg">
                                        @if (!$product->discount_price)
                                            <span class="new">New</span>
                                        @else
                                            <span class="hot">{{ round($discount) }}%</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="product-content-wrap">
                                    <div class="product-category">
                                        <a href="shop-grid-right.html">{{ $product->category->category_name }}</a>
                                    </div>
                                    <h2><a href="shop-product-right.html">{{ $product->product_name }}</a></h2>
                                    <div class="product-rate-cover">
                                        <div class="product-rate d-inline-block">
                                            <div class="product-rating" style="width: 90%"></div>
                                        </div>
                                        <span class="font-small ml-5 text-muted"> (4.0)</span>
                                    </div>
                                    <div>
                                        @php
                                            $vendor_name = $product->vendor ? $product->vendor->name : 'owner';
                                        @endphp
                                        <span class="font-small text-muted">By <a
                                                href="vendor-details-1.html">{{ $vendor_name }}</a></span>
                                    </div>
                                    <div class="product-card-bottom">
                                        <div class="product-price">
                                            @if (!$product->discount_price)
                                                <span>${{ $product->selling_price }}</span>
                                            @else
                                                <span>${{ $product->discount_price }}</span>
                                                <span class="old-price">${{ $product->selling_price }}</span>
                                            @endif
                                        </div>
                                        <div class="add-cart">
                                            <a class="add" href="shop-cart.html"><i
                                                    class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <!--end product card-->
                </div>
                <!--End product-grid-4-->
            </div>
            @foreach ($categories as $key => $category)
                <div class="tab-pane fade" id="tab-{{ $category->category_name }}" role="tabpanel"
                    aria-labelledby="tab-two">
                    @if (count($category->products) == 0)
                        <h6>This category doesn't contain products yet</h6>
                    @else
                        <div class="row product-grid-4">
                            @foreach ($category->products as $key => $product)
                                <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                                    <div class="product-cart-wrap mb-30 wow animate__animated animate__fadeIn"
                                        data-wow-delay=".1s">
                                        <div class="product-img-action-wrap">
                                            <div class="product-img product-img-zoom">
                                                <a href="shop-product-right.html">
                                                    <img class="default-img"
                                                        src="{{ asset($product->product_thumbnail) }}"
                                                        alt="" />
                                                </a>
                                            </div>
                                            <div class="product-action-1">
                                                <a aria-label="Add To Wishlist" class="action-btn"
                                                    href="shop-wishlist.html"><i class="fi-rs-heart"></i></a>
                                                <a aria-label="Compare" class="action-btn" href="shop-compare.html"><i
                                                        class="fi-rs-shuffle"></i></a>
                                                <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal"
                                                    data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                                            </div>
                                            @php
                                                $amount = (float) $product->selling_price - (float) $product->discount_price;
                                                $discount = ($amount / $product->selling_price) * 100;
                                            @endphp
                                            <div class="product-badges product-badges-position product-badges-mrg">
                                                @if (!$product->discount_price)
                                                    <span class="new">New</span>
                                                @else
                                                    <span class="hot">{{ round($discount) }}%</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="product-content-wrap">
                                            <div class="product-category">
                                                <a
                                                    href="shop-grid-right.html">{{ $product->category->category_name }}</a>
                                            </div>
                                            <h2><a href="shop-product-right.html">{{ $product->product_name }}</a>
                                            </h2>
                                            <div class="product-rate-cover">
                                                <div class="product-rate d-inline-block">
                                                    <div class="product-rating" style="width: 90%"></div>
                                                </div>
                                                <span class="font-small ml-5 text-muted"> (4.0)</span>
                                            </div>
                                            <div>
                                                @php
                                                    $vendor_name = $product->vendor ? $product->vendor->name : 'owner';
                                                @endphp
                                                <span class="font-small text-muted">By <a
                                                        href="vendor-details-1.html">{{ $vendor_name }}</a></span>
                                            </div>
                                            <div class="product-card-bottom">
                                                <div class="product-price">
                                                    @if (!$product->discount_price)
                                                        <span>${{ $product->selling_price }}</span>
                                                    @else
                                                        <span>${{ $product->discount_price }}</span>
                                                        <span class="old-price">${{ $product->selling_price }}</span>
                                                    @endif
                                                </div>
                                                <div class="add-cart">
                                                    <a class="add" href="shop-cart.html"><i
                                                            class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <!--end product card-->
                        </div>
                    @endif
                    <!--End product-grid-4-->
                </div>
            @endforeach
        </div>
        <!--End tab-content-->
    </div>
</section>
