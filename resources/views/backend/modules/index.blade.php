@extends('layouts.master')

@section('title')
Moduels
@endsection

@section('css')
<!-- DataTables -->
<link href="{{ URL::asset('build/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet"
    type="text/css" />
<link href="{{ URL::asset('build/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet"
    type="text/css" />
<link href="{{ URL::asset('build/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}"
    rel="stylesheet" type="text/css" />
@endsection

@section('content')
@component('components.breadcrumb')
@slot('li_1')
Tables
@endslot
@slot('title')
Modules
@endslot
@endcomponent

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
               
                <div class="row">
                    <div class="col-md-3">
                        <select name="" id="" class="form-select">
                            <option value="">Select Main Category</option>
                            <option value="User">User</option>
                            <option value="Page">Page</option>
                            <option value="Functionality">Functionality</option>
                            <option value="Module">Module</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <select name="" id="" class="form-select">
                            <option value="">Select Category</option>
                            @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>    
                    </div>

                    <div class="col-md-2">
                        <select name="" id="" class="form-select">
                            <option value="Goods">Goods</option>
                            <option value="Services">Services</option>
                            <option value="Others">Others</option>
                        </select>
                    </div>
                    
                    <div class="col-md-4 d-flex justify-content-between">
                        <a href="{{route('module.category.index')}}" class="btn btn-secondary"> Module Categories </a>
                        <a href="{{route('modules.create')}}" class="btn btn-secondary"> Add Modules </a>
                    </div>
                </div>

            </div>
            <div class="card-body">
                <div class="row">
                    @foreach ($modules as $module)
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body">

                            <div class="d-flex justify-content-between">
                                <img src="{{ asset('storage/' . $module->logo) }}" alt="" class="rounded mb-3 me-2"
                                    style="width:50px; height:50px">
                                <a href="{{ route('modules.edit', $module->id) }}"><i class="fas fa-pencil-alt"></i>
                                </a>
                            </div>
                                <h5 class="card-title fs-4 "> <a href="{{ route('module-detail', $module->id) }}">{{ $module->module_name }}</a></h5>
                                <p class="card-title mb-0 text-truncate" style="font-size:13px">{{ $module->page_name }}</p>
                                <p class="card-title bg-primary ps-1 text-light text-truncate" style="font-size:13px">{{ $module->subcategory }}</p>
                            </div>
                        </div>
                    </div> 

                    @endforeach
                </div>

                <table id="datatable" class="table table-bordered dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th>Module Category</th>
                            <th>Module Subcategory</th>
                            <th>Page Name</th>
                            <th>Module Name</th>
                            <th>Icon</th>
                            <th>Image</th>
                            <!-- <th>Status</th> -->
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($modules as $module)
                        <div class="col-md-4">
                            <tr>
                                <td>{{ $module->category }}</td>
                                <td>{{ $module->subcategory }}</td>
                                <td>{{ $module->page_name }}</td>
                                <td> <a href="{{ route('module-detail', $module->id) }}"> {{ $module->module_name }}</a>
                                </td>
                                <td><img src="{{ asset('storage/' . $module->logo) }}" alt="" class="rounded"
                                        style="width:50px; height:50px"></td>
                                <td><img src="{{ asset('storage/' . $module->image) }}" alt="" class="rounded"
                                        style="width:50px; height:50px"></td>
                                <!-- <td>{{ $module->status == 1 ? 'Active' : 'Inactive' }}</td> -->
                                <td class="d-flex justify-content-around">
                                    <a href="{{ route('modules.edit', $module->id) }}" class="btn btn-warning">Edit</a>
                                    <form action="{{ route('modules.destroy', $module->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </td>

                            </tr>
                        </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection


@section('script')
<script src="{{ URL::asset('build/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ URL::asset('build/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ URL::asset('build/libs/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ URL::asset('build/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ URL::asset('build/libs/jszip/jszip.min.js') }}"></script>
<script src="{{ URL::asset('build/libs/pdfmake/build/pdfmake.min.js') }}"></script>
<script src="{{ URL::asset('build/libs/pdfmake/build/vfs_fonts.js') }}"></script>
<script src="{{ URL::asset('build/libs/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ URL::asset('build/libs/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ URL::asset('build/libs/datatables.net-buttons/js/buttons.colVis.min.js') }}"></script>
<script src="{{ URL::asset('build/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ URL::asset('build/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ URL::asset('build/js/pages/datatables.init.js') }}"></script>

@endsection