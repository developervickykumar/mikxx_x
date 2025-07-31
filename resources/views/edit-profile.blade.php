@extends('layouts.master')

@section('title')
@lang('translation.Profile')
@endsection

@section('content')
@component('components.breadcrumb')
@slot('li_1')
Contacts
@endslot
@slot('title')
Profile
@endslot
@endcomponent

<div class="row">
    <div class="col-xl-8 col-lg-8">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm order-2 order-sm-1">
                        <form method="POST" action="" id="update-profile" enctype="multipart/form-data"
                            class="needs-validation mt-4 pt-2" novalidate>
                            @csrf
                            @method('PUT')

                            <div class="mb-3 row">
                                <div class="mb-3 col-sm">
                                    <label for="first_name" class="form-label">First Name</label>
                                    <input id="first_name" type="text" placeholder="Enter First Name"
                                        class="form-control @error('first_name') is-invalid @enderror" name="first_name"
                                        value="{{ old('first_name', $user->first_name) }}" required>
                                    @error('first_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="mb-3 col-sm">
                                    <label for="last_name" class="form-label">Last Name</label>
                                    <input id="last_name" type="text" placeholder="Enter Last Name"
                                        class="form-control @error('last_name') is-invalid @enderror" name="last_name"
                                        value="{{ old('last_name', $user->last_name) }}" required>
                                    @error('last_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="mb-3 col-sm">
                                    <label for="username" class="form-label">Username</label>
                                    <input id="username" type="text" placeholder="Enter Username"
                                        class="form-control @error('username') is-invalid @enderror" name="username"
                                        value="{{ old('username', $user->username) }}" required>
                                    @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <div class="mb-3 col-sm">
                                    <label for="email" class="form-label">Email</label>
                                    <input id="email" type="email" placeholder="Enter Email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email', $user->email) }}" required>
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="mb-3 col-sm">
                                    <label for="phone" class="form-label">Phone</label>
                                    <input id="phone" type="text" placeholder="Enter Phone Number"
                                        class="form-control @error('phone') is-invalid @enderror" name="phone"
                                        value="{{ old('phone', $user->phone) }}" required>
                                    @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="mb-3 col-sm">
                                    <label for="gender" class="form-label">Gender</label>
                                    <select id="gender" name="gender"
                                        class="form-select @error('gender') is-invalid @enderror" required>
                                        <option value="">Select Gender</option>
                                        <option value="male"
                                            {{ old('gender', $user->gender) == 'male' ? 'selected' : '' }}>Male</option>
                                        <option value="female"
                                            {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>Female
                                        </option>
                                        <option value="other"
                                            {{ old('gender', $user->gender) == 'other' ? 'selected' : '' }}>Other
                                        </option>
                                    </select>
                                    @error('gender')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <div class="mb-3 col-sm">
                                    <label for="fathers_name" class="form-label">Father's Name</label>
                                    <input id="fathers_name" type="text" placeholder="Enter Father's Name"
                                        class="form-control @error('fathers_name') is-invalid @enderror"
                                        name="fathers_name"
                                        value="{{ old('fathers_name', $candidate->fathers_name ?? '') }}" required>
                                    @error('fathers_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="mb-3 col-sm">
                                    <label for="age" class="form-label">Age</label>
                                    <input id="age" type="number" placeholder="Enter Age"
                                        class="form-control @error('age') is-invalid @enderror" name="age"
                                        value="{{ old('age', $candidate->age ?? '') }}" required>
                                    @error('age')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="mb-3 col-sm">
                                    <label for="dob" class="form-label">Date of Birth</label>
                                    <input id="dob" type="date" placeholder="Select Date of Birth"
                                        class="form-control @error('dob') is-invalid @enderror" name="dob"
                                        value="{{ old('dob', $candidate->dob ?? '') }}" required>
                                    @error('dob')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3 row">

                                <div class="mb-3 col-4">
                                    <label for="profile_pic" class="form-label">Profile Picture</label>
                                    <input id="profile_pic" type="file"
                                        class="form-control @error('profile_pic') is-invalid @enderror"
                                        name="profile_pic">
                                    @error('profile_pic')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                @php
                                if ($candidate && $candidate->profile_pic) {
                                @endphp
                                <div class="mb-3 col-2">
                                    <img class="w-100 h-100"
                                        src="{{ Storage::url('build/images/candidates/' . $candidate->profile_pic) }}"
                                        alt="Profile Picture">
                                </div>
                                @php
                                }
                                @endphp

                                <div class="mb-3 col-4">
                                    <label for="cover_photo" class="form-label">Cover Photo</label>
                                    <input id="cover_photo" type="file"
                                        class="form-control @error('cover_photo') is-invalid @enderror"
                                        name="cover_photo">
                                    @error('cover_photo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                @php
                                if($candidate && $candidate->cover_photo){
                                @endphp
                                <div class="mb-3 col-2">
                                    <img class="w-100 h-100"
                                        src="{{ Storage::url('build/images/candidates/' . $candidate->cover_photo) }}"
                                        alt="Cover Photo">
                                </div>
                                @php
                                }
                                @endphp

                            </div>

                            <div class="mb-3 row">
                                <div class="mb-3 col-sm">
                                    <label for="social_links" class="form-label">Social Links</label>
                                    <div id="social-links-container" class="row">
                                        @foreach($socialLinks as $platform => $data)
                                        <div class="social-link-row col-4">
                                            <input type="text" name="social_links[{{ $platform }}][platform]"
                                                value="{{ $data['platform'] }}" class="form-control platform"
                                                placeholder="Platform">

                                            <input type="url" name="social_links[{{ $platform }}][url]"
                                                value="{{ $data['url'] }}" class="form-control url" placeholder="Link">

                                            <button type="button"
                                                class="btn btn-danger remove-social-link my-2">Remove</button>
                                        </div>
                                        @endforeach
                                    </div>

                                    <button type="button" id="add-social-link" class="btn btn-primary">Add Social
                                        Link</button>
                                </div>
                            </div>

                            <div class="mb-3 col-sm">
                                <label for="portfolio_url" class="form-label">Portfolio URL</label>
                                <input id="portfolio_url" type="url" placeholder="Enter Portfolio URL"
                                    class="form-control @error('portfolio_url') is-invalid @enderror"
                                    name="portfolio_url"
                                    value="{{ old('portfolio_url', $candidate->portfolio_url ?? '') }}" required>
                                @error('portfolio_url')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="mb-3 row">
                                <!-- <div class="mb-3 col-sm">
                                <label for="city" class="form-label">City</label>
                                <input id="city" type="text" placeholder="Enter City"
                                    class="form-control @error('city') is-invalid @enderror" name="city"
                                    value="{{ old('city', $candidate->city ?? '') }}" required>
                                @error('city')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div> -->

                                <div class="mb-3 col-sm">
                                    <label for="state" class="form-label">State</label>
                                    <select id="state" class="form-control @error('state') is-invalid @enderror"
                                        name="state" required>
                                        <option value="" disabled selected>Select State</option>
                                        
                                    </select>
                                   
                                </div>

                                <div class="mb-3 col-sm">
                                    <label for="district" class="form-label">District</label>
                                    <select id="district" class="form-control @error('district') is-invalid @enderror"
                                        name="city" required>
                                        <option value="" disabled selected>Select District</option>
                                         

                                    </select>
                                   
                                </div>
                                <!-- 
                        <div class="mb-3 col-sm">
                            <label for="city" class="form-label">City</label>
                            <input id="city" type="text" placeholder="Enter City"
                                class="form-control @error('city') is-invalid @enderror" name="city"
                                value="{{ old('city', $candidate->city ?? '') }}" required>
                            @error('city')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div> -->

                                <div class="mb-3 col-sm">
                                    <label for="country" class="form-label">Country</label>
                                    <input id="country" type="text" placeholder="Enter Country"
                                        class="form-control @error('country') is-invalid @enderror" name="country"
                                        value="{{ old('country', $candidate->country ?? '') }}" required>
                                    @error('country')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <button class="btn btn-primary w-100 waves-effect waves-light" type="submit">Update
                                    Profile</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
            <!-- end card body -->
        </div>
        <!-- end card -->
    </div>

    <div class="col-xl-4 col-lg-4">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm order-2 order-sm-1">
                        <form class="form-horizontal" method="POST" enctype="multipart/form-data" id="update-password"
                            action="{{ route ('updatePassword', ['id' => $user->id])}}">
                            @csrf
                            @method('POST')
                            <div class="mb-3">
                                <label for="currentPassword" class="form-label">Current Password</label>
                                <input type="password"
                                    class="form-control @error('currentPassword') is-invalid @enderror"
                                    id="currentPassword" name="currentPassword" placeholder="Enter current password" />
                                @error('currentPassword')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">New Password</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    id="password" name="password" placeholder="Enter new password" />
                                @error('password')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Confirm Password</label>
                                <input type="password"
                                    class="form-control @error('password_confirmation') is-invalid @enderror"
                                    id="password_confirmation" name="password_confirmation"
                                    placeholder="Confirm new password" />
                                @error('password_confirmation')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mt-3 d-grid">
                                <button class="btn btn-primary waves-effect waves-light" type="submit">Update
                                    Password</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script>
document.getElementById("add-social-link").addEventListener("click", function() {
    const container = document.getElementById("social-links-container");

    const row = document.createElement("div");
    row.classList.add("social-link-row" , "col-4");

    const platformInput = document.createElement("input");
    platformInput.type = "text";
    platformInput.name = "social_links[][platform]";
    platformInput.classList.add("form-control", "platform");
    platformInput.placeholder = "Platform";

    const urlInput = document.createElement("input");
    urlInput.type = "url";
    urlInput.name = "social_links[][url]"; 
    urlInput.classList.add("form-control", "url");
    urlInput.placeholder = "Link";

    const removeButton = document.createElement("button");
    removeButton.type = "button";
    removeButton.classList.add("btn", "btn-danger", "remove-social-link", "my-2");
    removeButton.textContent = "Remove";
    removeButton.addEventListener("click", function() {
        row.remove();
    });

    row.appendChild(platformInput);
    row.appendChild(urlInput);
    row.appendChild(removeButton);

    container.appendChild(row);
});
document.getElementById("social-links-container").addEventListener("click", function(event) {
    if (event.target.classList.contains("remove-social-link")) {
        event.target.closest(".social-link-row").remove();
    }
});

$('#update-profile').on('submit', function(event) {
    event.preventDefault();
    let formData = new FormData(this);
    $('#emailError').text('');
    $('#nameError').text('');
    $('#avatarError').text('');

    $.ajax({
        url: "{{ url('update-profile', ['id' => $user->id]) }}",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            if (response.isSuccess) {
                alert(response.Message);
                setTimeout(function() {
                    window.location.reload();
                }, 1000);
            } else {
                alert(response.Message);
            }
        },
        error: function(response) {
            if (response.responseJSON.errors) {
                $('#emailError').text(response.responseJSON.errors.email);
                $('#nameError').text(response.responseJSON.errors.name);
                $('#avatarError').text(response.responseJSON.errors.avatar);
            }
        }
    });
});

$('#update-candidate-profile').on('submit', function(event) {
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
</script>

<script>
const statesData = [
    {
        state: "State1",
        districts: ["District1", "District2", "District3"]
    },
    {
        state: "State2",
        districts: ["District4", "District5", "District6"]
    },
    {
        state: "State3",
        districts: ["District7", "District8", "District9"]
    }
];

document.getElementById('state').addEventListener('change', function() {
    const selectedState = this.value;
    const districtSelect = document.getElementById('district');

    districtSelect.innerHTML = '<option value="" disabled selected>Select District</option>';

    const state = statesData.find(state => state.state === selectedState);
    if (state) {
        state.districts.forEach(district => {
            const option = document.createElement('option');
            option.value = district;
            option.textContent = district;
            districtSelect.appendChild(option);
        });
    }
});
</script>

@endsection