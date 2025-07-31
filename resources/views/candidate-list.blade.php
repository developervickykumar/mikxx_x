@extends('layouts.master')

@section('title') Candidate's Profile Type List @endsection

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
@slot('li_1') Candidates @endslot
@slot('title') Candidate's List @endslot
@endcomponent

<!-- <button type="button" class="btn btn-soft-light mb-2" data-bs-toggle="modal" data-bs-target="#updateProfileModal">
    Add candidates
</button> -->
<!-- Start row -->
<div class="modal fade" id="updateProfileModal" tabindex="-1" aria-labelledby="updateProfileModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">Add candidates</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" action=" " method="POST" enctype="multipart/form-data"
                    id="candidate-register">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                            name="name" value="{{ old('name') }}" autofocus placeholder="Enter role name">
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

<div class="modal fade" id="viewCandidateModal" tabindex="-1" aria-labelledby="viewCandidateModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewCandidateModalLabel">Candidate Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>Name:</strong> <span id="candidate-full-name"></span></p>
                <p><strong>DOB:</strong> <span id="candidate-dob"></span></p>
                <p><strong>Father's Name:</strong> <span id="candidate-fathers-name"></span></p>
                <p><strong>Role:</strong> <span id="candidate-role"></span></p>
                <p><strong>Created At:</strong> <span id="candidate-created-at"></span></p>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="deleteCandidateModal" tabindex="-1" aria-labelledby="deleteCandidateModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteCandidateModalLabel">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this role?
            </div>
            <div class="modal-footer">
                <form id="delete-role-form" method="POST" action="">
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
                        <th>Profile</th>
                        <th>Name</th>
                        <th>DOB</th>
                        <th>Father's Name</th>
                        <th>Role</th>
                        <th>City</th>
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>
                </thead>


                <tbody>
                    @foreach($candidates as $candidate)

                    <tr>
                        <td>{{ ($candidates->currentPage() - 1) * $candidates->perPage() + $loop->index + 1 }}
                        <td><img class="w-100 h-100 rounded-circle" src="{{ Storage::url('build/images/candidates/' . $candidate->profile_pic) }}" lazyloadloading="lazy" alt=""></td>
                        <td class="text-capitalize">
                            {{ $candidate->user ? "{$candidate->user->first_name} {$candidate->user->last_name}" : 'N/A' }}
                        </td>
                        <td>{{ $candidate->dob }}</td>
                        <td class="text-capitalize">{{ $candidate->fathers_name }}</td>
                        <td>{{ $candidate->role ? $candidate->role->name : 'N/A' }}</td>
                        <td>{{ $candidate->city }}</td>
                        <td>{{  date('d-m-Y', strtotime($candidate->created_at)) }}</td>


                        <td>
                            <button class="btn btn-outline-secondary btn-sm view-candidate"
                                data-id="{{ $candidate->id }}"
                                data-full-name="{{ $candidate->user ? "{$candidate->user->first_name} {$candidate->user->last_name}" : 'N/A' }}"
                                data-dob="{{ $candidate->dob }}" data-fathers-name="{{ $candidate->fathers_name }}"
                                data-role="{{ $candidate->role ? $candidate->role->name : 'N/A' }}"
                                data-created-at="{{ date('d-m-Y', strtotime($candidate->created_at)) }}"
                                data-bs-toggle="modal" data-bs-target="#viewCandidateModal" title="View">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-outline-secondary btn-sm edit-role" data-id="{{ $candidate->id }}"
                                data-name="{{ $candidate->name }}" data-bs-toggle="modal"
                                data-bs-target="#editCandidateModal" title="Edit">
                                <i class="fas fa-pencil-alt"></i>
                            </button>
                            <button class="btn btn-outline-danger btn-sm delete-role" data-id="{{ $candidate->id }}"
                                data-bs-toggle="modal" data-bs-target="#deleteCandidateModal" title="Delete">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </td>

                        <!-- <button class="btn btn-outline-secondary btn-sm edit-role" 
                                data-id="{{ $candidate->id }}" 
                                data-name="{{ $candidate->name }}" 
                                data-bs-toggle="modal" 
                                data-bs-target="#editCandidateModal" title="Edit">
                            <i class="fas fa-pencil-alt"></i>
                        </button> -->


                    </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>
</div>
</div>
<!-- End row -->

@endsection

@section('script')

<script src="{{ URL::asset('build/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ URL::asset('build/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<!-- <script src="{{ URL::asset('build/libs/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script> -->
<!-- <script src="{{ URL::asset('build/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') }}"></script> -->
<!-- <script src="{{ URL::asset('build/libs/jszip/jszip.min.js') }}"></script>
<script src="{{ URL::asset('build/libs/pdfmake/build/pdfmake.min.js') }}"></script>
<script src="{{ URL::asset('build/libs/pdfmake/build/vfs_fonts.js') }}"></script>
<script src="{{ URL::asset('build/libs/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ URL::asset('build/libs/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ URL::asset('build/libs/datatables.net-buttons/js/buttons.colVis.min.js') }}"></script> -->
<script src="{{ URL::asset('build/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
<!-- <script src="{{ URL::asset('build/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script> -->
<script src="{{ URL::asset('build/js/pages/datatables.init.js') }}"></script>


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
    $('#edit-role-form').attr('action', "{{ url('candidate/candidates') }}/" + roleId);
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
    $('#delete-role-form').attr('action', "{{ url('candidate/candidates') }}/" + roleId);
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

$(document).on('click', '.view-candidate', function() {
    // Get data attributes
    var fullName = $(this).data('full-name');
    var dob = $(this).data('dob');
    var fathersName = $(this).data('fathers-name');
    var role = $(this).data('role');
    var createdAt = $(this).data('created-at');

    // Set the modal content
    $('#candidate-full-name').text(fullName);
    $('#candidate-dob').text(dob);
    $('#candidate-fathers-name').text(fathersName);
    $('#candidate-role').text(role);
    $('#candidate-created-at').text(createdAt);
});
</script>
@endsection