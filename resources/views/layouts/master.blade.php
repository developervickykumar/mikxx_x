<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <title> @yield('title') | Dellywood</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ URL::asset('build/images/dellywood-logo.webp') }}">
    @include('layouts.head-css')
</head>
@php
if(Auth::check()){
    $isAdmin = Auth::user()->isAdmin();
}
@endphp
{{-- @section('body') --}}

<body class="pace-done" data-sidebar-size="sm">
    {{-- @show --}}
    <!-- Begin page -->
    <div id="layout-wrapper">
        @include('layouts.topbar')
        @include('layouts.sidebar')
        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    @yield('content')
                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->
            @include('layouts.footer')
        </div>
        <!-- end main content-->
    </div>
    <!-- END layout-wrapper -->

    <!-- Right Sidebar -->
    @include('layouts.right-sidebar')
    <!-- /Right-bar -->

    <!-- JAVASCRIPT -->
    @include('layouts.vendor-scripts')

    <script>
    window.fontawesomeList = @json($fontawesomeList ?? []);
    window.materialIconsList = @json($materialicons ?? []);
    </script>
    <script src="{{ URL::asset('build/js/icon-selector.js') }}"></script>
    <script src="{{ URL::asset('build/js/image-selector.js') }}"></script>

    <script>
    $('#createSubcategoryModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var parentId = button.data('parent-id');
        var parentName = button.data('parent-name');

        $('#category_parent_id').val(parentId);
        $('#category_parent_name').val(parentName);
    });


    $('#createSubCategoryForm').submit(function(e) {
        e.preventDefault();
        var formData = $(this).serialize();
        var parentId = $('#parent_id').val();
        var currentLevelId = $('#breadcrumb li:last').data('category-id');

        $.ajax({
            url: '/admin/categories',
            type: 'POST',
            data: formData,
            success: function() {
                $('#createSubcategoryModal').modal('hide');
                $('#createSubCategoryForm')[0].reset();

                if (parentId == '') {
                    parentId = '0'
                }
                loadCategories(currentLevelId);
            }
        });
    });
    </script>

</body>

</html>