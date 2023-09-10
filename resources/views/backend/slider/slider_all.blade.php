@extends('admin.admin_dashboard')
@section('admin')
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">All Slider</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item">
                            <a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            All Slider
                        </li>
                    </ol>
                </nav>
            </div>
            <div class="ms-auto">
                <div class="btn-group">
                    <a href="{{ route('add.slider') }}" class="btn btn-primary">Add Slider</a>
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
                                <th>Slider Title</th>
                                <th>Short Title</th>
                                <th>Slider Image</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sliders as $key => $slider)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $slider->slider_title }}</td>
                                    <td>{{ $slider->short_title }}</td>
                                    <td><img src="{{ asset($slider->slider_image) }}" alt="image"
                                            style="width:70px;height:40px"></td>
                                    <td>
                                        <form action="{{ route('delete.slider', $slider->id) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <a href="{{ route('edit.slider', $slider->id) }}" class="btn btn-info">Edit</a>
                                            <button id="delete-submit" class="btn btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Sl</th>
                                <th>Slider Title</th>
                                <th>Short Title</th>
                                <th>Slider Image</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
