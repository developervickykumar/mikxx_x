@extends('layouts.master')

@section('title') Candidate's Profile Type @endsection

@section('content')
@component('components.breadcrumb')
@slot('li_1') Candidates @endslot
@slot('title') Candidate's Profile Type @endslot
@endcomponent


<button type="button" class="btn btn-soft-light mb-2" data-bs-toggle="modal" data-bs-target="#updateProfileModal">
    Add Profile Type
</button>
<!-- Start row -->
<div class="modal fade" id="updateProfileModal" tabindex="-1" aria-labelledby="updateProfileModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">Add Profile Type</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" action="{{ route('candidate.roles.store') }}" method="POST"
                    enctype="multipart/form-data" id="candidate-register">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                            name="name" value="{{ old('name') }}" autofocus placeholder="Enter profile type name">
                        @error('name')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mt-3 d-grid">
                        <button class="btn btn-primary waves-effect waves-light" type="submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editRoleModal" tabindex="-1" aria-labelledby="editRoleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editRoleModalLabel">Edit Profile Type</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="edit-role-form" method="POST" action="{{ route('candidate.roles.update', 'role') }}">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="edit-role-id" name="id">
                    <div class="mb-3">
                        <label for="edit-role-name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="edit-role-name" name="name" required>
                    </div>
                    <div class="mt-3 d-grid">
                        <button class="btn btn-primary waves-effect waves-light" type="submit">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteRoleModal" tabindex="-1" aria-labelledby="deleteRoleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteRoleModalLabel">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this profile type?
            </div>
            <div class="modal-footer">
                <form id="delete-role-form" method="POST" action="{{ route('candidate.roles.destroy', 'role') }}">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" id="delete-role-id" name="id">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="col-12">
    <div class="card">

        <div class="card-body">

            <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Name</th>
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>
                </thead>


                 
            </table>

        </div>
    </div>
</div>
</div>
<!-- End row -->

@endsection

@section('script')
<script>
$('#update-profile').on('submit', function(event) {
    event.preventDefault();
    var Id = $('#data_id').val();
    let formData = new FormData(this);
    $('#emailError').text('');
    $('#nameError').text('');
    $('#avatarError').text('');
    $.ajax({
        url: "{{ url('update-profile') }}" + "/" + Id,
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            $('#emailError').text('');
            $('#nameError').text('');
            $('#avatarError').text('');
            if (response.isSuccess == false) {
                alert(response.Message);
            } else if (response.isSuccess == true) {
                setTimeout(function() {
                    window.location.reload();
                }, 1000);
            }
        },
        error: function(response) {
            $('#emailError').text(response.responseJSON.errors.email);
            $('#nameError').text(response.responseJSON.errors.name);
            $('#avatarError').text(response.responseJSON.errors.avatar);
        }
    });
});

$(document).on('click', '.edit-role', function() {
    var roleId = $(this).data('id');
    var roleName = $(this).data('name');

    $('#edit-role-id').val(roleId);
    $('#edit-role-name').val(roleName);

    // Set the form action URL
    $('#edit-role-form').attr('action', "{{ url('candidate/roles') }}/" + roleId);
});

$('#edit-role-form').on('submit', function(event) {
    event.preventDefault();
    let formData = new FormData(this);

    $.ajax({
        url: $(this).attr('action'),
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            if (response.isSuccess) {
                window.location.reload();
            } else {
                alert(response.Message);
            }
        },
        error: function(response) {
            // Handle validation errors
            // Similar to previous error handling
        }
    });
});

$(document).on('click', '.delete-role', function() {
    var roleId = $(this).data('id');
    $('#delete-role-id').val(roleId);

    // Set the form action URL
    $('#delete-role-form').attr('action', "{{ url('candidate/roles') }}/" + roleId);
});

$('#delete-role-form').on('submit', function(event) {
    event.preventDefault();
    let formData = new FormData(this);

    $.ajax({
        url: $(this).attr('action'),
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            if (response.isSuccess) {
                window.location.reload();
            } else {
                alert(response.Message);
            }
        },
        error: function(response) {
            alert('Error deleting role. Please try again.');
        }
    });
});
</script>
@endsection