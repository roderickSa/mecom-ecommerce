@extends('admin.admin_dashboard')
@section('admin')
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">All Product</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item">
                            <a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            All Product
                        </li>
                    </ol>
                </nav>
            </div>
            <div class="ms-auto">
                <div class="btn-group">
                    <a href="{{ route('add.product') }}" class="btn btn-primary">Add Product</a>
                </div>
            </div>
        </div>
        <!--end breadcrumb-->
        <hr />
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example" class="table table-striped table-bordered" style="width: 100%">
                        <thead>
                            <tr>
                                <th>Sl</th>
                                <th>Image</th>
                                <th>Product Name</th>
                                <th>Price</th>
                                <th>QTY</th>
                                <th>Discount</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $key => $product)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td><img src="{{ asset($product->product_thumbnail) }}" alt="image"
                                            style="width:80px;height:80px"></td>
                                    <td>{{ $product->product_name }}</td>
                                    <td>{{ $product->selling_price }}</td>
                                    <td>{{ $product->product_qty }}</td>
                                    <td>{{ $product->discount_price }}</td>
                                    <td>
                                        @if ($product->status == 1)
                                            <span class="btn btn-success">Active</span>
                                        @else
                                            <span class="btn btn-secondary">Inactive</span>
                                        @endif
                                    </td>
                                    <td><a href="{{ route('edit.product', $product->id) }}" class="btn btn-info">Edit</a><a
                                            href="{{ route('delete.category', $product->id) }}" id="delete"
                                            class="btn btn-danger">Delete</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Sl</th>
                                <th>Image</th>
                                <th>Product Name</th>
                                <th>Price</th>
                                <th>QTY</th>
                                <th>Discount</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
