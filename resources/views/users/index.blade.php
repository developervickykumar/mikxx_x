@extends('layouts.master')

@section('content')
<div class="container">
    <h2 class="mb-4">User Management</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="GET" class="mb-3">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name, email, username..." class="form-control">
    </form>

    <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addUserModal">Add User</button>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Profile</th>
                <th>Full Name</th>
                <th> Gender</th>
                <th>Username</th>
                <th>Email</th>
                
                <th>Admin</th>
                 
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @foreach($users as $index => $user)
            <tr>
                <td>{{ ($users->currentPage() - 1) * $users->perPage() + $index + 1 }}</td>

                <td>
                    @php $profilePic = optional($user->profile)->profile_picture; @endphp
                   <form method="POST" action="{{ route('users.updatePicture', $user) }}" enctype="multipart/form-data">
                        @csrf @method('PUT')
                        <label for="profile-upload-{{ $user->id }}">
                            <img src="{{ $user->profile_picture ? asset('uploads/profile_pics/' . $user->profile_picture) : asset('images/default-avatar.png') }}"
                                 width="50" height="50"
                                 class="rounded-circle border"
                                 style="cursor:pointer; object-fit:cover;">
                        </label>
                        <input id="profile-upload-{{ $user->id }}" type="file" name="profile_picture" class="d-none" onchange="this.form.submit();">
                    </form>

                </td>
                <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                <td>{{ $user->gender }}</td>
                <td>{{ $user->username }}</td>
                <td>{{ $user->email }}</td>
                 
                <td>{{ $user->is_admin ? 'Yes' : 'No' }}</td>
                 
                <td>
                    <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#editUserModal{{ $user->id }}">Edit</button>
                    <a href="{{ route('user.detail', ['id' => $user->id]) }}" class="btn btn-sm btn-success">View</a>

                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#assignRoleModal{{ $user->id }}">Assign Role</button>
                </td>
            </tr>

        
        @endforeach
        </tbody>
    </table>
    
    
<div class="d-flex justify-content-center">
    {{ $users->appends(['search' => request('search')])->links('pagination::bootstrap-4') }}


</div>

</div>


   <div class="modal fade" id="editUserModal{{ $user->id }}" tabindex="-1">
                <div class="modal-dialog">
                    <form method="POST" action="{{ route('users.update', $user) }}">
                        @csrf @method('PUT')
                        <div class="modal-content">
                            <div class="modal-header"><h5 class="modal-title">Edit User</h5></div>
                            <div class="modal-body">
                                <input type="text" name="first_name" class="form-control mb-2" value="{{ $user->first_name }}" placeholder="First Name" required>
                                <input type="text" name="last_name" class="form-control mb-2" value="{{ $user->last_name }}" placeholder="Last Name" required>
                                <input type="text" name="username" class="form-control mb-2" value="{{ $user->username }}" placeholder="Username" required>
                                <input type="email" name="email" class="form-control mb-2" value="{{ $user->email }}" required>
                                <select name="gender" class="form-control mb-2">
                                    <option value="">Select Gender</option>
                                    <option value="Male" {{ $user->gender === 'Male' ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ $user->gender === 'Female' ? 'selected' : '' }}>Female</option>
                                    <option value="Other" {{ $user->gender === 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                                <input type="text" name="user_type" class="form-control mb-2" value="{{ $user->user_type }}" placeholder="User Type">
                                <select name="is_admin" class="form-control mb-2">
                                    <option value="0" {{ !$user->is_admin ? 'selected' : '' }}>Not Admin</option>
                                    <option value="1" {{ $user->is_admin ? 'selected' : '' }}>Admin</option>
                                </select>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-primary" type="submit">Save</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>


<div class="modal fade" id="addUserModal" tabindex="-1">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('users.store') }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header"><h5 class="modal-title">Add User</h5></div>
                <div class="modal-body">
                    <input type="text" name="name" class="form-control mb-2" placeholder="Name" required>
                    <input type="email" name="email" class="form-control mb-2" placeholder="Email" required>
                    <input type="password" name="password" class="form-control mb-2" placeholder="Password" required>
                    <input type="date" name="dob" class="form-control mb-2" placeholder="DOB">
                    <select name="gender" class="form-control mb-2">
                        <option value="">Select Gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Other">Other</option>
                    </select>
                    <input type="text" name="contact" class="form-control mb-2" placeholder="Contact">
                    <input type="text" name="state" class="form-control mb-2" placeholder="State">
                    <input type="text" name="country" class="form-control mb-2" placeholder="Country">
                    <input type="text" name="user_type" class="form-control mb-2" placeholder="User Type (optional)">
                    <select name="is_admin" class="form-control mb-2">
                        <option value="0">Not Admin</option>
                        <option value="1">Admin</option>
                    </select>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" type="submit">Create</button>
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
