<section class="banners mb-25">
    <div class="container">
        <div class="row">
            @php
                $banners = App\Models\Banner::orderBy('banner_title', 'ASC')->get();
            @endphp
            @foreach ($banners as $banner)
                <div class="col-lg-4 d-md-none d-lg-flex">
                    <div class="banner-img mb-sm-0 wow animate__animated animate__fadeInUp" data-wow-delay=".4s">
                        <img src="{{ asset($banner->banner_image) }}" alt="" />
                        <div class="banner-text">
                            <h4>
                                {{ $banner->banner_title }}
                            </h4>
                            <a href="shop-grid-right.html" class="btn btn-xs">Shop Now <i
                                    class="fi-rs-arrow-small-right"></i></a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
