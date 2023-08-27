@extends('admin.admin_dashboard')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Edit Brand</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item">
                            <a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Edit Brand
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->
        <div class="container">
            <div class="main-body">
                <div class="row">
                    <div class="col-lg-10">
                        <div class="card">
                            <div class="card-body">
                                <form id="myForm" action="{{ route('update.brand') }}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $brand->id }}" />
                                    <input type="hidden" name="old_image" value="{{ $brand->brand_image }}" />
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Brand Name</h6>
                                        </div>
                                        <div class="form-group col-sm-9 text-secondary">
                                            <input type="text" name="brand_name" class="form-control"
                                                value="{{ $brand->brand_name }}" />
                                            <x-input-error :messages="$errors->get('brand_name')" class="mt-2" />
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Brand Image</h6>
                                        </div>
                                        <div class="form-group col-sm-9 text-secondary">
                                            <input type="file" name="brand_image" class="form-control" id="image" />
                                            <x-input-error :messages="$errors->get('brand_image')" class="mt-2" />
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0"></h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <img id="showImage"
                                                src="{{ !empty($brand->brand_image) ? url($brand->brand_image) : url('upload/no_image.jpg/') }}"
                                                alt="Brand" style="width:100px;height:100px;" />
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-3"></div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="submit" class="btn btn-primary px-4" value="Save Changes" />
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $("#image").change(function(e) {
                const reader = new FileReader()
                reader.onload = function(e) {
                    $("#showImage").attr('src', e.target.result)
                }
                reader.readAsDataURL(e.target.files[0])
            })

            //validation form
            $("#myForm").validate({
                rules: {
                    brand_name: {
                        required: true
                    },
                },
                messages: {
                    brand_name: {
                        required: "Please enter brand name"
                    },
                },
                errorElement: 'span',
                errorPlacement: function(err, ele) {
                    err.addClass('invalid-feedback')
                    ele.closest('.form-group').append(err)
                },
                highlight: function(ele, err, val) {
                    $(ele).addClass('is-invalid')
                },
                unhighlight: function(ele, err, val) {
                    $(ele).removeClass('is-invalid')
                },
            });
        })
    </script>
@endsection
