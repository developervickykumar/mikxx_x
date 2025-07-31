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
    <div class="col-xl-6 col-lg-6">
        <div class="card">
            <div class="card-body">
                <div class="row">

                    <form class="form-horizontal" method="POST" enctype="multipart/form-data" id="update-password" action="{{ route('admin.updatePassword') }}">
                        @csrf
                        @method('PATCH')
                        <div class="mb-3">
                            <label for="currentPassword" class="form-label">Current Password</label>
                            <input type="password" class="form-control @error('currentPassword') is-invalid @enderror"
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
                            <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror"
                                   id="password_confirmation" name="password_confirmation" placeholder="Confirm new password" />
                            @error('password_confirmation')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mt-3 d-grid">
                            <button class="btn btn-primary waves-effect waves-light" type="submit">Update Password</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection
