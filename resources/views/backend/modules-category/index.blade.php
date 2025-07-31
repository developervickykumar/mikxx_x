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
<meta name="csrf-token" content="{{ csrf_token() }}">

@section('content')
@component('components.breadcrumb')
@slot('li_1')
Tables
@endslot
@slot('title')
Module Categories
@endslot
@endcomponent

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="row">

                <div class="card-header d-flex justify-content-between">
                    <h4 class="card-title">Modules Categories</h4>

                    <div>
                        <a href="{{route('modules.index')}}" class="btn btn-soft-light"> Modules </a>
                        <button type="button" class="btn btn-soft-light" data-bs-toggle="modal" data-bs-target="#addCategoryModal"> Add Category </button>
                    </div>
                </div>
                
                    <!-- <div class="col-md-10">
                        <ol class="breadcrumb m-0 p-0 go-back d-none">
                            <li class="breadcrumb-item"><a onclick="goBack()" href="javascript: void(0);">Go Back </a></li>
                            <li class="breadcrumb-item active">Module Categories</li>
                        </ol>
                    </div> -->
<!-- 
                    <div class="col-md-12 mb-2">

                        <a href="{{route('modules.create')}}" class="btn btn-soft-light"> Add Modules </a>

                        <button type="button" class="btn btn-soft-light" data-bs-toggle="modal" data-bs-target="#addCategoryModal"> Add Category </button>
                    </div> -->

                    <!-- <div class="category-list">
                        <table id="datatable" class="table table-bordered dt-responsive nowrap w-100">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Icon</th>
                                    <th>Image</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="categoryTableBody1">  
                                <tr>
                                    <td class="text-primary text-decoration-underline" onclick="fetchCategory('User Account Type')">User Account Type</td>
                                                                    <td><img src="" alt="" class="rounded" style="width:50px; height:50px"></td>
                                <td><img src="" alt="" class="rounded" style="width:50px; height:50px"></td>

                                <td class="d-flex justify-content-around">
                                        <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editCategoryModal">Edit</button>

                                        <form class="mb-0" action="" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-primary text-decoration-underline"  onclick="fetchCategory('Services')"> Services</td>
                                                                    <td><img src="" alt="" class="rounded" style="width:50px; height:50px"></td>
                                <td><img src="" alt="" class="rounded" style="width:50px; height:50px"></td>

                                <td class="d-flex justify-content-around">
                                        <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editCategoryModal">Edit</button>

                                        <form class="mb-0" action="" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-primary text-decoration-underline" onclick="fetchCategory('Goods')">Goods </td>
                                                                    <td><img src="" alt="" class="rounded" style="width:50px; height:50px"></td>
                                <td><img src="" alt="" class="rounded" style="width:50px; height:50px"></td>

                                <td class="d-flex justify-content-around">
                                        <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editCategoryModal">Edit</button>

                                        <form class="mb-0" action="" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                               
                            </tbody>
                        </table>
                    </div>
              -->
                    <div class="card-body ">
                        <table id="datatable" class="table table-bordered dt-responsive nowrap w-100">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Main Category</th>
                                    <th>Name</th>
                                    <!-- <th>Module Category</th> -->
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="categoryTableBody">
                                @foreach ($categories as $category)
                                    <tr data-name="{{ $category->name }}">
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $category->main_category }}</td>
                                        <!-- <td><img src="{{ asset('storage/' . $category->image) }}" alt="" class="rounded" style="width:50px; height:50px"></td>
                                        <td><img src="{{ asset('storage/' . $category->icon) }}" alt="" class="rounded" style="width:50px; height:50px"></td> -->
                                        <td>{{ $category->name }}</td>
                                        <!-- <td>{{ $category->category }}</td> -->
                                        <td>{{ $category->status == 1 ? 'Active' : 'Inactive' }}</td>
                                        <td class="d-flex justify-content-around">
                                            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editCategoryModal" onclick="editCategory({{ $category->id }})">Edit</button>

                                            <form class="mb-0" action="{{ route('module.category.destroy', $category->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div> 
</div>



<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCategoryModalLabel">Add Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addCategoryForm" method="POST">
                    @csrf

                    <div class="col-md-12 mb-4">
                        <div class="d-flex">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="userPageFunctionality" id="userRadio"
                                    value="User" checked>
                                <label class="form-check-label me-4" for="userRadio">
                                    User
                                </label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="userPageFunctionality" id="pageRadio"
                                    value="Page">
                                <label class="form-check-label me-4" for="pageRadio">
                                    Page
                                </label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="userPageFunctionality"
                                    id="functionalityRadio" value="Functionality">
                                <label class="form-check-label me-4" for="functionalityRadio">
                                    Functionality
                                </label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="userPageFunctionality"
                                    id="moduleRadio" value="Functionality">
                                <label class="form-check-label" for="moduleRadio">
                                    Module
                                </label>
                            </div>

                        </div>
                    </div>


                    <div class="mb-3">
                        <label for="category-name" class="form-label">Category Name</label>
                        <input type="text" class="form-control" id="category-name" name="name" required
                            placeholder="Enter category name">
                    </div>

                    <!-- <div class="mb-3">
                        <label for="add_category" class="form-label">Add Categories</label>
                        <input type="text" class="form-control" id="add_category" name="add_category" required
                            placeholder="Add Categories">
                    </div> -->

                    <div class="mb-3">
                        <label for="image" class="form-label">Add Image</label>
                        <input type="file" class="form-control" id="image" name="image">
                    </div>

                    <div class="mb-3">
                        <label for="icon" class="form-label">Add Icon</label>
                        <input type="file" class="form-control" id="icon" name="icon">
                    </div>


                    <div class="mt-3">
                        <button class="btn btn-primary" type="submit">Add Category</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Category Modal -->
<div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="editCategoryModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCategoryModalLabel">Edit Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editCategoryForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <input type="hidden" id="edit-category-id" name="category_id">

                    <div class="col-md-12 mb-4">
                        <div class="d-flex">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="userPageFunctionality"
                                    id="editUserRadio" value="User">
                                <label class="form-check-label me-4" for="editUserRadio">
                                    User
                                </label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="userPageFunctionality"
                                    id="editPageRadio" value="Page">
                                <label class="form-check-label me-4" for="editPageRadio">
                                    Page
                                </label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="userPageFunctionality"
                                    id="editFunctionalityRadio" value="Functionality">
                                <label class="form-check-label" for="editFunctionalityRadio">
                                    Functionality
                                </label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="userPageFunctionality"
                                    id="editModuleRadio" value="Module">
                                <label class="form-check-label" for="editModuleRadio">
                                    Module
                                </label>
                            </div>

                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="edit-category-name" class="form-label">Category Name</label>
                        <input type="text" class="form-control" id="edit-category-name" name="name" required>
                    </div>

                    <!-- <div class="mb-3">
                        <label for="edit-add_category" class="form-label">Add Categories</label>
                        <input type="text" class="form-control" id="edit-add_category" name="add_category" required>
                    </div> -->

                    <div class="mb-3">
                        <label for="edit-image" class="form-label">Add Image</label>
                        <input type="file" class="form-control" id="edit-image" name="image">
                    </div>

                    <div class="mb-3">
                        <label for="edit-icon" class="form-label">Add Icon</label>
                        <input type="file" class="form-control" id="edit-icon" name="icon">
                    </div>

                    <div class="mt-3">
                        <button class="btn btn-primary" type="submit">Update Category</button>
                    </div>
                </form>
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

<script>
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).ready(function() {
    $('#addCategoryForm').on('submit', function(e) {
        e.preventDefault();

        let formData = new FormData(this);

        $.ajax({
            url: '{{ route('module.category.store') }}',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                // console.log(response);
                // alert(response.message); 
                $('#addCategoryModal').modal('hide');
                location.reload();
            },
            error: function(xhr) {
                let errors = xhr.responseJSON.errors;
                let errorMessage = '';

                for (let error in errors) {
                    errorMessage += errors[error] + '\n';
                }
                alert(errorMessage);
            }
        });
    });
});

function editCategory(categoryId) {
    $.ajax({
        url: '{{ route('module.category.edit', '') }}/' + categoryId,
        type: 'GET',
        success: function(response) {
            console.log(response.category.main_category);

            if (response.success) {
                $('#edit-category-id').val(response.category.id);
                $('#edit-category-name').val(response.category.name);
                $('#edit-add_category').val(response.category.category);
                $('#edit-image').val(response.category.image);
                $('#edit-icon').val(response.category.icon);

                // Clear previously checked radio buttons by id
                $("#editUserRadio, #editPageRadio, #editFunctionalityRadio").prop('checked', false);

                // Check the relevant radio button using id
                if (response.category.main_category === "User") {
                    $('#editUserRadio').prop('checked', true);
                } else if (response.category.main_category === "Page") {
                    $('#editPageRadio').prop('checked', true);
                } else if (response.category.main_category === "Functionality") {
                    $('#editFunctionalityRadio').prop('checked', true);
                }

                $('#editCategoryModal').modal('show');
            } else {
                alert('Error: Unable to fetch category details');
            }
        },
        error: function(xhr) {
            alert('Error fetching category details.');
        }
    });
}

$('#editCategoryForm').on('submit', function(e) {
    e.preventDefault();

    var categoryId = $('#edit-category-id').val();
    let formData = new FormData(this);

    for (var pair of formData.entries()) {
        console.log(pair[0] + ', ' + pair[1]);
    }

    $.ajax({
        url: '{{ route('module.category.update', '') }}/' + categoryId,
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            $('#editCategoryModal').modal('hide');
            location.reload(); // Reload the page after updating
        },
        error: function(xhr) {
            if (xhr.responseJSON && xhr.responseJSON.errors) {
                let errors = xhr.responseJSON.errors;
                let errorMessage = '';
                for (let error in errors) {
                    errorMessage += errors[error] + '\n';
                }
                alert(errorMessage);
            }
        }
    });
});

function fetchCategory(categoryId){
    
}
</script>

<script>
// function fetchCategory(categoryName) {

//     document.querySelector('.card-body').classList.remove('d-none');
//     document.querySelector('.category-list').classList.add('d-none');
    
//     document.querySelector('.go-back').classList.remove('d-none');
    
//     const rows = document.querySelectorAll('#categoryTableBody tr');
    
//     rows.forEach(row => {
//         const rowName = row.getAttribute('data-name');
        
//         if (categoryName === 'all' || rowName === categoryName) {
//             row.style.display = ''; 
//         } else {
//             row.style.display = 'none';
//         }
//     });
// }

// function goBack() {
//     console.log('go back');
//     document.querySelector('.card-body').classList.add('d-none');
//     document.querySelector('.category-list').classList.add('d-block');
//     document.querySelector('.category-list').classList.remove('d-none');
//     document.querySelector('.go-back').classList.add('d-none');
// }
</script>


@endsection