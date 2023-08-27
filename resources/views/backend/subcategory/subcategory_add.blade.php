@extends('admin.admin_dashboard')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Add SubCategory</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item">
                            <a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Add SubCategory
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
                                <form id="myForm" action="{{ route('subcategory.store') }}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Category Name</h6>
                                        </div>
                                        <div class="form-group col-sm-9 text-secondary">
                                            <select name="category_id" id="category_id" class="form-control">
                                                @foreach ($categories as $key => $category)
                                                    <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                                @endforeach
                                            </select>
                                            <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">SubCategory Name</h6>
                                        </div>
                                        <div class="form-group col-sm-9 text-secondary">
                                            <input type="text" name="subcategory_name" class="form-control" />
                                            <x-input-error :messages="$errors->get('subcategory_name')" class="mt-2" />
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
            //validation form
            $("#myForm").validate({
                rules: {
                    subcategory_name: {
                        required: true
                    },
                    category_id: {
                        required: true
                    },
                },
                messages: {
                    subcategory_name: {
                        required: "Please enter subcategory name"
                    },
                    category_id: {
                        required: "Please select a category"
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
