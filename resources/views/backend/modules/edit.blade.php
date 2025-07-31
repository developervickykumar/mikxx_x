@extends('layouts.master')

@section('title')
Edit Module
@endsection

@section('content')
@component('components.breadcrumb')
@slot('li_1')
Tables
@endslot
@slot('title')
Edit Module
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
                    <form action="{{ route('modules.update', $module->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-12 mb-4">
                                <div class="d-flex">
                                    <!-- User Category Radio Button -->
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="main_category"
                                            id="userRadio" value="User"
                                            {{ $module->category == 'User' ? 'checked' : '' }}>
                                        <label class="form-check-label me-4" for="userRadio">
                                            User
                                        </label>
                                    </div>

                                    <!-- Page Category Radio Button -->
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="main_category"
                                            id="pageRadio" value="Page"
                                            {{ $module->category == 'Page' ? 'checked' : '' }}>
                                        <label class="form-check-label me-4" for="pageRadio">
                                            Page
                                        </label>
                                    </div>

                                    <!-- Functionality Category Radio Button -->
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="main_category"
                                            id="functionalityRadio" value="Functionality"
                                            {{ $module->category == 'Functionality' ? 'checked' : '' }}>
                                        <label class="form-check-label me-4" for="functionalityRadio">
                                            Functionality
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="main_category"
                                            id="moduleRadio" value="Module"
                                            {{ $module->category == 'Module' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="moduleRadio">
                                            Module
                                        </label>
                                    </div>
                                </div>
                            </div>


                            <div class="col-md-4">
                                @php
                                    $selected = $module->category;
                                @endphp
                                <label for="category" class="form-label">Select Category</label>
                                <select class="form-select" id="category" name="category">
                                    
                                    @foreach($categories as $category)
                                    <option value="{{ $category->name }}" {{ $category->name == $selected ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                    @endforeach

                                </select>
                            </div>

                            <!-- <div class="col-md-4">
                                <label for="category" class="form-label">Select Category</label>
                                <select class="form-select" id="category" name="category">
                                </select>
                            </div> -->

                            <div class="col-md-4 mb-4">

                                <label for="moduleSubcategory" class="form-label">Select Module Subcategory</label>
                                <div class="d-flex">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="moduleSubcategory" id="goodsRadio" value="Goods" 
                                        {{ $module->subcategory == 'Goods' ? 'checked' : '' }}>
                                        <label class="form-check-label me-4" for="goodsRadio">
                                            Goods
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="moduleSubcategory" id="servicesRadio" value="Services"
                                        {{ $module->subcategory == 'Services' ? 'checked' : '' }}>
                                        <label class="form-check-label me-4" for="servicesRadio">
                                            Services
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="moduleSubcategory" id="othersRadio" value="Others"
                                        {{ $module->subcategory == 'Others' ? 'checked' : '' }}>
                                        <label class="form-check-label me-4" for="othersRadio">
                                            Others
                                        </label>
                                    </div>
                                
                                </div>
                            </div>


                            <!-- Page Name -->
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="page_name" class="form-label">Page Name</label>
                                    <input type="text" class="form-control" id="page_name" name="page_name"
                                        value="{{ old('page_name', $module->page_name) }}">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="module_name" class="form-label">Module Name</label>
                                    <input type="text" class="form-control" id="module_name" name="module_name"
                                        value="{{ old('module_name', $module->module_name) }}">
                                </div>
                            </div>

                            <!-- Tag Line -->
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="tag_line" class="form-label">Tag Line</label>
                                    <input type="text" class="form-control" id="tag_line" name="tag_line"
                                        value="{{ old('tag_line', $module->tag_line) }}">
                                </div>
                            </div>

                            <!-- Image Upload -->
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="image" class="form-label">Upload Image</label>
                                    <input type="file" class="form-control" id="image" name="image">
                                    @if($module->image)
                                    <p>Current image: <a href="{{ Storage::url($module->image) }}" target="_blank">View
                                            Image</a></p>
                                    @endif
                                </div>
                            </div>

                            <!-- Logo Upload -->
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="logo" class="form-label">Upload Icon</label>
                                    <input type="file" class="form-control" id="logo" name="logo">
                                    @if($module->logo)
                                    <p>Current logo: <a href="{{ Storage::url($module->logo) }}" target="_blank">View
                                            Logo</a></p>
                                    @endif
                                </div>
                            </div>

                            <!-- Short Description -->
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="short_desc" class="form-label">Short Description</label>
                                    <textarea class="form-control" id="short_desc" name="short_desc"
                                        rows="2">{{ old('short_desc', $module->short_desc) }}</textarea>
                                </div>
                            </div>

                            <!-- Long Description -->
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="long_desc" class="form-label">Description</label>
                                    <textarea class="form-control" id="long_desc" name="long_desc"
                                        rows="2">{{ old('long_desc', $module->long_desc) }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div id="features-container">
                            @foreach(json_decode($module->feature) as $index => $feature)


                            <div class="row">
                                <div class="col-md-4">
                                    <label for="feature[]" class="form-label">Feature</label>
                                    <input type="text" class="form-control" name="feature[]"
                                        value="{{ $feature->feature }}">
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="feature_desc[]" class="form-label">Feature Description</label>
                                        <textarea class="form-control" name="feature_desc[]"
                                            rows="2">{{ $feature->feature_desc }}</textarea>
                                    </div>
                                </div>

                                <div class="col-md-2 align-content-center">
                                    <div class="mb-3">
                                        <button type="button" class="btn btn-sm btn-danger"
                                            onclick="removeFeatureRow(this)">Remove</button>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>


                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-sm btn-primary">Update</button>
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
    const categorySelect = document.getElementById('category');
    categorySelect.innerHTML = ''; 

    fetch(`/admin/module/get-categories/${mainCategory}`)
        .then(response => response.json())
        .then(data => {
            data.categories.forEach(category => {
                const option = document.createElement('option');
                option.value = category.name;
                option.textContent = category.name;

                if (category.name === "{{ $module->category }}") {
                    option.selected = true;
                }
                categorySelect.appendChild(option);
            });
        })
        .catch(error => console.log(error));
}

document.getElementById('userRadio').addEventListener('change', () => filterCategories('User'));
document.getElementById('pageRadio').addEventListener('change', () => filterCategories('Page'));
document.getElementById('functionalityRadio').addEventListener('change', () => filterCategories('Functionality'));
document.getElementById('moduleRadio').addEventListener('change', () => filterSubcategories('Module'));

// document.addEventListener('DOMContentLoaded', () => {
//     const mainCategory = "{{ $module->category }}";  
//     // alert(mainCategory);
//     filterCategories(mainCategory);
// });

</script>

@endsection