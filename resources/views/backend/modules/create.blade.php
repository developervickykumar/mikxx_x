@extends('layouts.master')

@section('title')
Events
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

<div class="container">
    <div class="row">
        <div class="col-md-12">

        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


            <div class="card">
                <div class="card-body">
                    <form action="{{ route('modules.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-12 mb-4">
                                <div class="d-flex">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="userFeaturesFunctionality" id="userRadio" value="User" checked>
                                        <label class="form-check-label me-4" for="userRadio">
                                            User
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="userFeaturesFunctionality" id="pageRadio" value="Page">
                                        <label class="form-check-label me-4" for="pageRadio">
                                            Page
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="userFeaturesFunctionality" id="functionalityRadio" value="Functionality">
                                        <label class="form-check-label me-4" for="functionalityRadio">
                                            Functionality
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="userFeaturesFunctionality" id="moduleRadio" value="Module">
                                        <label class="form-check-label" for="moduleRadio">
                                            Module
                                        </label>
                                    </div>
                                    
                                </div>
                            </div>

                            <div class="col-md-4">
                                <label for="category" class="form-label">Select Module Category</label>
                                <select class="form-select" id="category_type" name="category_type">
                                </select>
                            </div>


                            <div class="col-md-4 mb-4">

                                <label for="moduleSubcategory" class="form-label">Select Module Subcategory</label>
                                <div class="d-flex">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="moduleSubcategory" id="goodsRadio" value="Goods" checked>
                                        <label class="form-check-label me-4" for="goodsRadio">
                                            Goods
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="moduleSubcategory" id="servicesRadio" value="Services">
                                        <label class="form-check-label me-4" for="servicesRadio">
                                            Services
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="moduleSubcategory" id="othersRadio" value="Others">
                                        <label class="form-check-label me-4" for="othersRadio">
                                            Others
                                        </label>
                                    </div>
                                   
                                </div>
                            </div> 


                            <!-- <div class="col-md-4">
                                <label for="category" class="form-label">Select Category</label>
                                <select class="form-select" id="category_type" name="category_type">
                                    @foreach($categories as $category)
                                        <option value="{{ $category->name }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div> -->

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="page_name" class="form-label">Page Name</label>
                                    <input type="text" class="form-control" id="page_name" name="page_name">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="module_name" class="form-label">Module Name</label>
                                    <input type="text" class="form-control" id="module_name" name="module_name">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="tag_line" class="form-label">Tag Line</label>
                                    <input type="text" class="form-control" id="tag_line" name="tag_line">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="image" class="form-label">Upload Image</label>
                                    <input type="file" class="form-control" id="image" name="image">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="logo" class="form-label">Upload Icon</label>
                                    <input type="file" class="form-control" id="logo" name="logo">
                                </div>
                            </div>

                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="short_desc" class="form-label">Short Description</label>
                                    <textarea class="form-control" id="short_desc" name="short_desc"
                                        rows="2"></textarea>
                                </div>
                            </div>

                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="long_desc" class="form-label">Description</label>
                                    <textarea class="form-control" id="long_desc" name="long_desc" rows="2"></textarea>
                                </div>
                            </div>

                        </div>

                        <div id="features-container">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="feature[]" class="form-label">Feature</label>
                                    <input type="text" class="form-control" name="feature[]" value="">
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="feature_desc[]" class="form-label">Feature Description</label>
                                        <textarea class="form-control" name="feature_desc[]" rows="2"></textarea>
                                    </div>
                                </div>

                                <div class="col-md-2 align-content-center">
                                    <div class="mb-3">
                                        <button type="button" class="btn btn-sm btn-danger" onclick="removeFeatureRow(this)">Remove</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-sm btn-primary">Submit</button>
                                <button type="button" class="btn btn-sm btn-secondary" onclick="addFeatureRow()">Add
                                    More Features</button>
                            </div>
                        </div>
                    </form>
                </div>
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
    // Add more features dynamically
    function addFeatureRow() {
        const featureContainer = document.getElementById('features-container');
        const featureRow = document.createElement('div');
        featureRow.classList.add('row');
        featureRow.innerHTML = `
            <div class="col-md-4">
                <label for="feature[]" class="form-label">Feature</label>
                <input type="text" class="form-control" name="feature[]">
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <label for="feature_desc[]" class="form-label">Feature Description</label>
                    <textarea class="form-control" name="feature_desc[]" rows="2"></textarea>
                </div>
            </div>

            <div class="col-md-2 align-content-center">
                <div class="mb-3">
                    <button type="button" class="btn btn-sm btn-danger" onclick="removeFeatureRow(this)">Remove</button>
                </div>
            </div>
        `;
        featureContainer.appendChild(featureRow);
    }

    function removeFeatureRow(button) {
        button.closest('.row').remove();
    }
</script>

<script>
    function filterCategories(mainCategory) {
        const categorySelect = document.getElementById('category_type');
        categorySelect.innerHTML = '';

        fetch(`/admin/module/get-categories/${mainCategory}`)

            .then(response => response.json())
            .then(data => {
                data.categories.forEach(category => {
                    const option = document.createElement('option');
                    option.value = category.name;
                    option.textContent = category.name;
                    categorySelect.appendChild(option);
                });
            })
            .catch(error => console.log(error));
    }

    document.getElementById('userRadio').addEventListener('change', () => filterCategories('User'));
    document.getElementById('pageRadio').addEventListener('change', () => filterCategories('Page'));
    document.getElementById('functionalityRadio').addEventListener('change', () => filterCategories('Functionality'));
    document.getElementById('moduleRadio').addEventListener('change', () => filterCategories('Module'));

    filterCategories('User');
</script>

@endsection