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
            <h4>Add Modules</h4>

            <div class="card">
                <div class="card-body">
                    <form action="">
                        <div class="row">
                            <div class="col-md-12 mb-4">
                                <div class="d-flex">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="userFeaturesFunctionality"
                                            id="userRadio" checked>
                                        <label class="form-check-label me-4" for="userRadio">
                                            User
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="userFeaturesFunctionality"
                                            id="featuresRadio">
                                        <label class="form-check-label me-4" for="featuresRadio">
                                            Features
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="userFeaturesFunctionality"
                                            id="functionalityRadio">
                                        <label class="form-check-label" for="functionalityRadio">
                                            Functionality
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <label for="pageType" class="form-label">Select Category</label>
                                <select class="form-select" id="pageType" aria-label="Page Type">
                                    <option selected>Select Category</option>
                                    <option value="Finance">Finance</option>
                                    <option value="Entertainment">Entertainment</option>
                                    <option value="Health & Wellness">Health & Wellness</option>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="pageName" class="form-label">Page Name</label>
                                    <input type="text" class="form-control" id="pageName">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="pageName" class="form-label">Tag Line</label>
                                    <input type="text" class="form-control" id="pageName">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="image" class="form-label">Upload Image</label>
                                    <input type="file" class="form-control" id="image">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="logo" class="form-label">Upload Logo</label>
                                    <input type="file" class="form-control" id="logo">
                                </div>
                            </div>

                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="short_description" class="form-label">Short Description</label>
                                    <textarea class="form-control" id="short_description" rows="2"></textarea>
                                </div>
                            </div>

                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control" id="description" rows="2"></textarea>
                                </div>
                            </div>

                        </div>

                        <div id="features-container">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="feature" class="form-label">Feature</label>
                                    <input type="text" class="form-control" id="feature">
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="description" class="form-label">Feature Description</label>
                                        <textarea class="form-control" id="description" rows="2"></textarea>
                                    </div>
                                </div>

                                <div class="col-md-2 align-content-center">
                                    <div class="mb-3">
                                        <button type="button" class="btn btn-sm btn-danger"
                                            onclick="removeFeatureRow(this)">Remove</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">

                                <button class="btn btn-sm btn-primary">Submit</button>
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
    const featureRow = document.createElement('div');
    featureRow.classList.add('row');
    featureRow.innerHTML = `
                <div class="col-md-4">
                    <label for="pageType" class="form-label">Select Feature</label>
                    <select class="form-select" aria-label="Page Type">
                        <option selected>Select Feature</option>
                        <option value="Finance">Finance</option>
                        <option value="Entertainment">Entertainment</option>
                        <option value="Health & Wellness">Health & Wellness</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="featureDescription" class="form-label">Feature Description</label>
                        <textarea class="form-control" rows="2"></textarea>
                    </div>
                </div>

                <div class="col-md-2 align-content-center">
                    <div class="mb-3">
                        <button class="btn btn-sm btn-danger" onclick="removeFeatureRow(this)">Remove</button>
                    </div>
                </div>
            `;
    document.getElementById('features-container').appendChild(featureRow);
}

function removeFeatureRow(button) {
    button.closest('.row').remove();
}
</script>
@endsection