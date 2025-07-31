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

{{ ucfirst(Auth::user()->user_type) }}

Profile
@endslot
@endcomponent

<style>
.field-block .open-settings {
    visibility: hidden;
    opacity: 0;
    transition: visibility 0s, opacity 0.2s linear;
}

.field-block:hover .open-settings {
    visibility: visible;
    opacity: 1;
}
</style>

<div class="row">
    <div class="col-xl-9 col-lg-8">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm order-2 order-sm-1">
                        <div class="d-flex align-items-start mt-3 mt-sm-0">
                            <div class="flex-shrink-0">
                                <div class="avatar-xl me-3">
                                    <img class="w-100 h-100  rounded-circle"
                                        src="{{ $user->profile_pic ?  Storage::url('build/images/candidates/' . $user->profile_pic) : asset('build/images/users/avatar-1.jpg') }}"
                                        alt="Profile Picture">
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <div>
                                    <h5 class="font-size-16 mb-1 text-capitalize">{{ Auth::user()->username }}</h5>
                                    <p class="text-muted font-size-13"></p>

                                    <div
                                        class="d-flex flex-wrap align-items-start gap-2 gap-lg-3 text-muted font-size-13">
                                        @if (Auth::check() && Auth::user()->candidate)
                                        @php
                                        $roleName = Auth::user()->candidate->role ? Auth::user()->candidate->role->name
                                        : 'No Role Assigned';
                                        @endphp
                                        <div>
                                            <i class="mdi mdi-circle-medium me-1 text-success align-middle"></i>
                                            {{ $roleName }}
                                        </div>
                                        @endif

                                        <div><i
                                                class="mdi mdi-circle-medium me-1 text-success align-middle"></i>{{ Auth::user()->email  }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-auto order-1 order-sm-2">
                        <div class="d-flex align-items-start justify-content-end gap-2">
                            <div>


                                <a href="{{ route('editProfile', Auth::user()->id) }}" class="btn btn-soft-light">Edit
                                    Profile</a>
                            </div>

                        </div>
                    </div>
                </div>

                <ul class="nav nav-tabs-custom card-header-tabs border-top mt-4" id="pills-tab" role="tablist">
                    @foreach($profileTabs as $index => $tab)
                    <li class="nav-item">
                        <a class="nav-link px-3 {{ $index === 0 ? 'active' : '' }}" data-bs-toggle="tab"
                            href="#tab-{{ Str::slug($tab->name) }}" role="tab">
                            @if ($tab->icon)
                            <i class="{{ $tab->icon }} me-1"></i>
                            @endif
                            {{ ucfirst($tab->name) }}
                        </a>
                    </li>
                    @endforeach
                </ul>


            </div>
        </div>
        <!-- end card -->

        @php

        function flattenCategoryNames($categories)
        {
        $result = [];

        foreach ($categories as $category) {
        $result[] = $category->name;

        if (isset($category->children) && $category->children->count()) {
        $result = array_merge($result, flattenCategoryNames($category->children));
        }
        }

        return $result;
        }


        @endphp

        @php
        function countNestedCategories($category) {
        if (!$category || !$category->children || $category->children->isEmpty()) {
        return 0;
        }

        $maxDepth = 0;
        foreach ($category->children as $child) {
        $depth = countNestedCategories($child);
        $maxDepth = max($maxDepth, $depth);
        }


        return 1 + $maxDepth;
        }
        @endphp


        <div class="tab-content ">
            @foreach($profileTabs as $index => $tab)
            <div class="tab-pane fade {{ $index === 0 ? 'show active' : '' }}" id="tab-{{ Str::slug($tab->name) }}"
                role="tabpanel">
                <div class="row">
                    <div class="col-md-3">
                        <div class="nav flex-column nav-pills" role="tablist" aria-orientation="vertical">
                            @foreach($tab->subTabs as $subIndex => $subTab)
                            <a class="border nav-link {{ $subIndex === 0 ? 'active' : '' }}"
                                id="vtab-{{ Str::slug($tab->name) }}-{{ Str::slug($subTab->name) }}-tab"
                                data-bs-toggle="pill"
                                href="#vtab-{{ Str::slug($tab->name) }}-{{ Str::slug($subTab->name) }}" role="tab">
                                {{ $subTab->name }}
                            </a>
                            @endforeach
                        </div>
                    </div>

                    <div class="col-md-9">
                        <div class="tab-content">

                            @foreach($tab->subTabs as $subIndex => $subTab)



                            <div class="tab-pane fade {{ $subIndex === 0 ? 'show active' : '' }}"
                                id="vtab-{{ Str::slug($tab->name) }}-{{ Str::slug($subTab->name) }}" role="tabpanel">

                                <div class="d-flex justify-content-between ">
                                    <h4>{{ $subTab->name }} </h4>
                                    <span class="form-setting ms-3" role="button" data-bs-toggle="modal"
                                        data-bs-target="#formSettingsModal">⋮</span>

                                </div>


                                <form method="POST" action="" enctype="multipart/form-data">
                                    @csrf

                                    <!-- CTA Dropdown Button Selector -->
                                    @php
                                    $ctaButtons = [
                                    'Book Me', 'Order Me', 'DM Me', 'Apply Now', 'Donate Now', 'Reserve Now',
                                    'Contact Seller', 'Get Quote', 'Reply Me', 'Do Comment', 'Donate', 'Auction',
                                    'Bid', 'Join Now', 'Subscribe', 'Claim Offer', 'Apply For Loan', 'Check
                                    Availability',
                                    'Get Started', 'Rate & Reviews', 'Vote', 'Appointment', 'Buy Ticket', 'Book Seat',
                                    'Book Table', 'Book Stall', 'Invitation'
                                    ];
                                    @endphp



                                    <div id="sortable-fields" class="row">
                                        @foreach($subTab->fields as $index => $field)

                                        @php

                                        $fieldName = Str::slug($field->name, '_');
                                        $fieldValue = old($fieldName, $user->$fieldName ?? '');
                                        $fieldValueArray = is_array($fieldValue) ? $fieldValue :
                                        (array)json_decode($fieldValue, true) ?? [];
                                        $allowUserOptions = $field->advanced['allow_user_options'] ?? false;
                                        $selectedValues = is_array($fieldValue) ? $fieldValue :
                                        (array)json_decode($fieldValue, true) ?? [];
                                        $suggestions = flattenCategoryNames($field->children ?? collect());
                                        $columnWidth = $field->column_width ?? 6;
                                        $settings = $field->settings ?? [];

                                        @endphp

                                        <div class="mb-3 col-md-{{ $columnWidth }} field-block"
                                            data-id="{{ $field->id }}" data-settings="{{ json_encode($field->settings ?? []) }}">
                                            <div class="border p-2 position-relative bg-light">
                                                <!-- Settings Gear Icon -->
                                                <button type="button"
                                                        class="btn btn-sm fs-5 position-absolute top-0 end-0 m-1 open-settings"
                                                        data-field-id="{{ $field->id }}"
                                                        data-settings="{{ htmlspecialchars(json_encode($field->settings ?? [])) }}"
                                                        data-settings-type="{{ strtolower(Str::slug($field->name)) }}">
                                                        <i class="mdi mdi-cog"></i>
                                                    </button>

                                                @include('components.inputs.base', [
                                                'field' => $field,
                                                'fieldValue' => $fieldValue,
                                                'fieldValueArray' => $fieldValueArray,
                                                'selectedValues' => $selectedValues,
                                                'allowUserOptions' => $allowUserOptions,
                                                'suggestions' => $suggestions,
                                                'user' => $user,
                                                'settings' => $settings
                                                ])
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>


                                </form>




                                <div class="btn-group mb-3">
                                    <button type="button"
                                        class="btn btn-primary dropdown-toggle d-flex align-items-center"
                                        data-bs-toggle="dropdown" id="ctaDropdownBtn" aria-expanded="false">
                                        <span id="selectedCtaText">Choose Call-to-Action</span>
                                        <i class="mdi mdi-chevron-down ms-1"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        @foreach($ctaButtons as $btn)
                                        <li>
                                            <button type="button" class="dropdown-item cta-action-btn"
                                                data-value="{{ $btn }}">
                                                {{ $btn }}
                                            </button>
                                        </li>
                                        @endforeach
                                    </ul>
                                    <input type="hidden" name="cta_action" id="cta_action">
                                </div>

                                <!-- CTA action customization options -->


                            </div>
                            @endforeach

                            <div class="p-md-3">


                                <div class="col-md-2">
                                    <button id="setting-submit" class="btn btn-sm btn-primary">Save
                                        Settings</button>
                                </div>


                            </div>


                        </div>
                    </div>


                </div>
            </div>
            @endforeach
        </div>


    </div>
    <!-- end col -->

    <div class="col-xl-3 col-lg-4">


        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-3">Portfolio</h5>

                <div>
                    <ul class="list-unstyled mb-0">
                        <li>
                            <a href="{{ $user->portfolio_url}}" target="_blank" class="py-2 d-block text-muted"><i
                                    class="mdi mdi-web text-primary me-1"></i>
                                Portfolio url</a>
                        </li>
                        <!-- <li>
                            <a href="#" class="py-2 d-block text-muted"><i
                                    class="mdi mdi-note-text-outline text-primary me-1"></i> Blog</a>
                        </li> -->
                    </ul>
                </div>
            </div>
            <!-- end card body -->
        </div>
        <!-- end card -->
        @if (Auth::check() && Auth::user()->candidate)

        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-3">Similar Profiles</h5>

                <div class="list-group list-group-flush">


                    @foreach($similarProfiles as $profile)
                    <a href="#" class="list-group-item list-group-item-action">
                        <div class="d-flex align-items-center">
                            <div class="avatar-sm flex-shrink-0 me-3">
                                <img src="{{ $profile->profile_pic ? Storage::url($profile->profile_pic) : 'default-avatar.jpg' }}"
                                    alt="" class="img-thumbnail rounded-circle">
                            </div>
                            <div class="flex-grow-1">
                                <div>
                                    <h5 class="font-size-14 mb-1">{{ $profile->user->first_name }}
                                        {{ $profile->user->last_name }}</h5>
                                    <p class="font-size-13 text-muted mb-0">
                                        {{ $profile->role->name ?? 'Role not specified' }}</p>
                                </div>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
            <!-- end card body -->
        </div>
        @endif


        <!-- end card -->
    </div>
    <!-- end col -->
</div>
<!-- end row -->


<div class="modal fade" id="settingsModal" tabindex="-1" aria-labelledby="settingsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="settingsModalLabel">Field Settings</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="row">
                    <!-- Vertical Nav -->
                    <div class="col-md-3 border-end">
                        <div class="nav flex-column nav-pills" id="settings-tab" role="tablist"
                            aria-orientation="vertical">
                            <button class="text-start nav-link active" id="edit-tab" data-bs-toggle="pill"
                                data-bs-target="#edit" type="button" role="tab">Edit</button>
                            <button class="text-start nav-link " id="edit-tab" data-bs-toggle="pill"
                                data-bs-target="#user" type="button" role="tab">User</button>
                            <button class="text-start nav-link " id="edit-tab" data-bs-toggle="pill"
                                data-bs-target="#communication" type="button" role="tab">Communication</button>
                            <button class="text-start nav-link" id="communication-tab" data-bs-toggle="pill"
                                data-bs-target="#dateandtime" type="button" role="tab">Date & Time</button>
                            <button class="text-start nav-link" id="dateandtime-tab" data-bs-toggle="pill"
                                data-bs-target="#address" type="button" role="tab">Address</button>
                            <button class="text-start nav-link" id="address-tab" data-bs-toggle="pill"
                                data-bs-target="#subcategory" type="button" role="tab">Subcategory</button>
                            <button class="text-start nav-link" id="unit-tab" data-bs-toggle="pill"
                                data-bs-target="#unit" type="button" role="tab">Unit</button>
                            <button class="text-start nav-link" id="table-tab" data-bs-toggle="pill"
                                data-bs-target="#table" type="button" role="tab">Table</button>
                            <button class="text-start nav-link" id="media-tab" data-bs-toggle="pill"
                                data-bs-target="#media" type="button" role="tab">Media</button>
                            <button class="text-start nav-link" id="popup-tab" data-bs-toggle="pill"
                                data-bs-target="#popup" type="button" role="tab">Popup</button>
                        </div>
                    </div>

                    <!-- Tab Content -->
                    <div class="col-md-9">
                        <div class="tab-content" id="settings-tabContent">

                            <!-- Edit Tab -->
                            <div class="tab-pane fade show active" id="edit" role="tabpanel">
                                <div class="mb-3">
                                    <label for="column-width" class="form-label">Select Column Layout</label>
                                    <select id="column-width" class="form-select">
                                        <option value="12">1 Column (Full Width)</option>
                                        <option value="6">2 Columns</option>
                                        <option value="4">3 Columns</option>
                                        <option value="3">4 Columns</option>
                                    </select>
                                    <input type="hidden" id="activeFieldId">
                                </div>



                                @php

                                use App\Models\Category;

                                $builder = Category::where('name', 'Builders')->first();
                                $unitOptions = [];

                                if ($builder) {
                                $form = $builder->children()->where('name', 'Form')->first();
                                if ($form) {
                                $common = $form->children()->where('name', 'Common')->first();

                                $functionalityOptions = $common->children()->get();
                                }


                                }
                                @endphp

                                <div class="mb-3">
                                    <label for="customFunctionalitySelect" class="form-label">Functionality</label>
                                    <div class="accordion" id="functionalityAccordion"
                                        style="max-height: 300px; overflow-y: auto; overflow-x: hidden;">
                                        @foreach ($functionalityOptions as $index => $option)
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="heading-{{ $index }}">
                                                <button class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapse-{{ $index }}"
                                                    aria-expanded="false" aria-controls="collapse-{{ $index }}">
                                                    {{ $option->name }}
                                                </button>
                                            </h2>
                                            <div id="collapse-{{ $index }}" class="accordion-collapse collapse"
                                                aria-labelledby="heading-{{ $index }}"
                                                data-bs-parent="#functionalityAccordion">
                                                <div class="accordion-body">
                                                    @foreach ($option->children as $subOption)
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio"
                                                            name="functionality" value="{{ $subOption->name }}"
                                                            id="func-{{ $subOption->id }}">
                                                        <label class="form-check-label" for="func-{{ $subOption->id }}">
                                                            {{ $subOption->name }}
                                                        </label>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>



                                <div class="mb-3">
                                    <label for="edit_validation" class="form-label">Validation</label>
                                    <input type="text" class="form-control" id="edit_validation" name="validation">
                                </div>

                                <div class="mb-3">
                                    <label for="edit_tooltip" class="form-label">Tooltip</label>
                                    <input type="text" class="form-control" id="edit_tooltip" name="tooltip">
                                </div>

                                <div class="form-check">
                                    <input type="checkbox" name="allow_user_options" id="allow_user_options"
                                        class="form-check-input">
                                    <label for="allow_user_options" class="form-check-label">Allow User to Add
                                        Options</label>
                                </div>
                            </div>

                            <!-- User Tab -->
                            <div class="tab-pane fade" id="user" role="tabpanel">

                                <div class="mb-4 border rounded p-3">
                                    <h5 class="mb-3">User Conditions</h5>

                                    <!-- Static Conditions -->
                                    <div class="mb-3">
                                        <label class="form-check-label fw-semibold d-block">Select User Options:</label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input user-field-toggle" type="checkbox"
                                                value="profile_pic" id="profilePic">
                                            <label class="form-check-label" for="profilePic">Profile Picture</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input user-field-toggle" type="checkbox"
                                                value="title" id="userTitle">
                                            <label class="form-check-label" for="userTitle">Title</label>
                                        </div>
                                    </div>

                                    <!-- Name Type -->
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Name Format:</label><br>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input name-format" type="radio" name="nameFormat"
                                                id="firstLast" value="first_last" checked>
                                            <label class="form-check-label" for="firstLast">First & Last Name</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input name-format" type="radio" name="nameFormat"
                                                id="fullName" value="full">
                                            <label class="form-check-label" for="fullName">Full Name</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input name-format" type="radio" name="nameFormat"
                                                id="middleName" value="with_middle">
                                            <label class="form-check-label" for="middleName">Add Middle Name</label>
                                        </div>
                                    </div>

                                    <!-- Dynamic Fields Container -->
                                    <div class="row g-3 align-items-end" id="userFieldsRow"></div>
                                </div>

                                <style>
                                .image-uploader-wrapper {
                                    cursor: pointer;
                                    display: inline-block;
                                }

                                .image-uploader-wrapper img {
                                    width: 30px;
                                    height: 30px;
                                    object-fit: cover;
                                    border-radius: 6px;
                                }

                                .image-hidden-input {
                                    display: none;
                                }
                                </style>



                                <script>
                                document.addEventListener('DOMContentLoaded', () => {
                                    const userFieldsRow = document.getElementById('userFieldsRow');

                                    const renderUserFields = () => {
                                        userFieldsRow.innerHTML = '';

                                        // Checkboxes
                                        if (document.getElementById('profilePic').checked) {
                                            userFieldsRow.innerHTML += `
                                                    <div class="col-md-1">
                                                    
                                                    <div class="image-uploader-wrapper mb-2">
                                                        <label for="profilePicInput">
                                                            <img id="" src="{{asset('images/no-img.jpg') }}" alt="profile Image" height="30px" width="30px">
                                                        </label>
                                                        <input type="file" id="" class="image-hidden-input" ">
                                                    </div>
                                                    </div>`;
                                        }

                                        if (document.getElementById('userTitle').checked) {
                                            userFieldsRow.innerHTML += `
                                                    <div class="col-md-2">
                                                    <label class="form-label">Title</label>
                                                    <select class="form-select mb-2">
                                                        <option>Mr.</option><option>Mrs.</option><option>Miss</option>
                                                    </select>
                                                    </div>`;
                                        }

                                        // Radio - Name Formats
                                        const selectedName = document.querySelector('.name-format:checked')
                                            ?.value;

                                        if (selectedName === 'first_last') {
                                            userFieldsRow.innerHTML += `
                                                    <div class="col-md-3">
                                                    <label class="form-label">First Name</label>
                                                    <input type="text" class="form-control">
                                                    </div>
                                                    <div class="col-md-3">
                                                    <label class="form-label">Last Name</label>
                                                    <input type="text" class="form-control">
                                                    </div>`;
                                        } else if (selectedName === 'full') {
                                            userFieldsRow.innerHTML += `
                                                    <div class="col-md-6">
                                                    <label class="form-label">Full Name</label>
                                                    <input type="text" class="form-control">
                                                    </div>`;
                                        } else if (selectedName === 'with_middle') {
                                            userFieldsRow.innerHTML += `
                                                    <div class="col-md-3">
                                                    <label class="form-label">First Name</label>
                                                    <input type="text" class="form-control">
                                                    </div>
                                                    <div class="col-md-3">
                                                    <label class="form-label">Middle Name</label>
                                                    <input type="text" class="form-control">
                                                    </div>
                                                    <div class="col-md-3">
                                                    <label class="form-label">Last Name</label>
                                                    <input type="text" class="form-control">
                                                    </div>`;
                                        }
                                    };

                                    document.querySelectorAll('.user-field-toggle, .name-format').forEach(
                                        el => {
                                            el.addEventListener('change', renderUserFields);
                                        });

                                    renderUserFields(); // Initial call
                                });
                                </script>


                            </div>

                            <!-- Communication Tab -->
                            <div class="tab-pane fade" id="communication" role="tabpanel">


                                <h5 class="mb-3">Communication Conditions</h5>

                                <div class="form-check">
                                    <input class="form-check-input comm-check" type="checkbox" value="email"
                                        id="emailCheck">
                                    <label class="form-check-label" for="emailCheck">Email ID</label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input comm-check" type="checkbox" value="contact"
                                        id="contactCheck">
                                    <label class="form-check-label" for="contactCheck">Contact Number (with Country
                                        Code)</label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input comm-check" type="checkbox" value="whatsapp"
                                        id="whatsappCheck">
                                    <label class="form-check-label" for="whatsappCheck">WhatsApp Number (Same as Contact
                                        or Alternative)</label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input comm-check" type="checkbox" value="social"
                                        id="socialCheck">
                                    <label class="form-check-label" for="socialCheck">Social Media Links</label>
                                </div>

                                <div id="commFields" class="row mt-3"></div>

                                <script>
                                const fieldContainer = document.getElementById('commFields');

                                const commMap = {
                                    email: `
                                            <div id="commField_email" class="col-md-6 mb-3">
                                                <label>Email</label>
                                                <input type="email" id="commEmail" name="communication[email]" class="form-control" placeholder="Enter valid email">
                                                <small id="emailStatus" class="text-muted"></small>
                                            </div>
                                        `,
                                    contact: `
                                            <div id="commField_contact" class="col-md-6 mb-3">
                                                <label>Contact Number</label>
                                                <input type="tel" id="commContact" name="communication[contact]" class="form-control" placeholder="+91XXXXXXXXXX">
                                                <small id="contactStatus" class="text-muted"></small>
                                            </div>
                                        `,
                                    whatsapp: `
                                            <div id="commField_whatsapp" class="col-md-6 mb-3">
                                                <label>WhatsApp Number</label>
                                                <input type="tel" id="commWhatsapp" name="communication[whatsapp]" class="form-control" placeholder="+91XXXXXXXXXX">
                                                <small id="whatsappStatus" class="text-muted"></small>
                                                <div class="form-check mt-2">
                                                    <input class="form-check-input" type="checkbox" id="sameAsContact">
                                                    <label class="form-check-label" for="sameAsContact">Same as Contact</label>
                                                </div>
                                            </div>
                                        `,
                                    social: `
                                            <div id="commField_social" class="col-md-12 mb-3">
                                                <label>Social Media Links</label>
                                                <div class="row">
                                                    <div class="col-md-6 mb-2 d-flex align-items-center">
                                                        <i class="fab fa-facebook fa-lg me-2 text-primary"></i>
                                                        <input class="form-control social-input" data-platform="facebook" name="communication[social][]" type="url" placeholder="Facebook URL">
                                                    </div>
                                                    <div class="col-md-6 mb-2 d-flex align-items-center">
                                                        <i class="fab fa-instagram fa-lg me-2 text-danger"></i>
                                                        <input class="form-control social-input" data-platform="instagram" name="communication[social][]" type="url" placeholder="Instagram URL">
                                                    </div>
                                                    <div class="col-md-6 mb-2 d-flex align-items-center">
                                                        <i class="fab fa-linkedin fa-lg me-2 text-primary"></i>
                                                        <input class="form-control social-input" data-platform="linkedin" name="communication[social][]" type="url" placeholder="LinkedIn URL">
                                                    </div>
                                                    <div class="col-md-6 mb-2 d-flex align-items-center">
                                                        <i class="fab fa-twitter fa-lg me-2 text-primary"></i>
                                                        <input class="form-control social-input" data-platform="x" name="communication[social][]" type="url" placeholder="X (Twitter) URL">
                                                    </div>
                                                    <div class="col-md-6 mb-2 d-flex align-items-center">
                                                        <i class="fab fa-youtube fa-lg me-2 text-danger"></i>
                                                        <input class="form-control social-input" data-platform="youtube" name="communication[social][]" type="url" placeholder="YouTube URL">
                                                    </div>
                                                    <div class="col-md-6 mb-2 d-flex align-items-center">
                                                        <i class="fab fa-google fa-lg me-2 text-danger"></i>
                                                        <input class="form-control social-input" data-platform="google" name="communication[social][]" type="url" placeholder="Google Profile URL">
                                                    </div>
                                                </div>

                                                <hr class="my-3">
                                                <label>Add Custom Social Link</label>
                                                <div class="d-flex gap-2 align-items-center mb-2">
                                                    <select class="form-control w-25 social-select">
                                                        <option value="other">Other</option>
                                                        <option value="facebook">Facebook</option>
                                                        <option value="instagram">Instagram</option>
                                                        <option value="linkedin">LinkedIn</option>
                                                        <option value="x">X (Twitter)</option>
                                                        <option value="youtube">YouTube</option>
                                                        <option value="google">Google</option>
                                                    </select>
                                                    <input class="form-control w-75 social-input" data-custom="true" type="url" name="communication[social][]" placeholder="Enter Social Link">
                                                    <small class="form-text status-text w-100"></small>
                                                </div>
                                            </div>
                                        `


                                };

                                document.querySelectorAll('.comm-check').forEach(chk => {
                                    chk.addEventListener('change', () => {
                                        const fieldId = `commField_${chk.value}`;
                                        const exists = document.getElementById(fieldId);

                                        if (chk.checked && !exists) {
                                            const wrapper = document.createElement('div');
                                            wrapper.innerHTML = commMap[chk.value];
                                            fieldContainer.appendChild(wrapper);

                                            setTimeout(() => {
                                                const emailInput = document.getElementById(
                                                    'commEmail');
                                                const contactInput = document.getElementById(
                                                    'commContact');
                                                const whatsappInput = document.getElementById(
                                                    'commWhatsapp');
                                                const sameAsContact = document.getElementById(
                                                    'sameAsContact');

                                                if (emailInput) {
                                                    emailInput.addEventListener('input',
                                                        function() {
                                                            const email = this.value.trim();
                                                            const status = document
                                                                .getElementById(
                                                                    'emailStatus');
                                                            const valid =
                                                                /^[^@\s]+@[^@\s]+\.[^@\s]+$/
                                                                .test(email);

                                                            status.textContent = email ? (
                                                                valid ? "Valid Email" :
                                                                "Invalid Email") : "";
                                                            status.className = valid ?
                                                                "text-success" :
                                                                "text-danger";
                                                        });
                                                }

                                                if (contactInput) {
                                                    contactInput.addEventListener('input',
                                                        function() {
                                                            const contact = this.value
                                                            .trim();
                                                            const status = document
                                                                .getElementById(
                                                                    'contactStatus');
                                                            const valid =
                                                                /^(\+?\d{1,4})?\d{7,14}$/
                                                                .test(contact);

                                                            status.textContent = contact ? (
                                                                valid ? "Valid Number" :
                                                                "Invalid Number") : "";
                                                            status.className = valid ?
                                                                "text-success" :
                                                                "text-danger";
                                                        });
                                                }

                                                if (whatsappInput) {
                                                    whatsappInput.addEventListener('input',
                                                        function() {
                                                            const whatsapp = this.value
                                                                .trim();
                                                            const status = document
                                                                .getElementById(
                                                                    'whatsappStatus');
                                                            const valid =
                                                                /^(\+?\d{1,4})?\d{7,14}$/
                                                                .test(whatsapp);

                                                            status.textContent = whatsapp ?
                                                                (valid ? "Valid Number" :
                                                                    "Invalid Number") : "";
                                                            status.className = valid ?
                                                                "text-success" :
                                                                "text-danger";
                                                        });
                                                }

                                                if (sameAsContact && whatsappInput &&
                                                    contactInput) {
                                                    sameAsContact.addEventListener('change',
                                                        function() {
                                                            if (this.checked) {
                                                                whatsappInput.value =
                                                                    contactInput.value;
                                                                whatsappInput.dispatchEvent(
                                                                    new Event('input'));
                                                            }
                                                        });
                                                }



                                                // Social media platform validation map
                                                const socialPatterns = {
                                                    facebook: /^(https?:\/\/)?(www\.)?facebook\.com\/[A-Za-z0-9_.-]+$/i,
                                                    instagram: /^(https?:\/\/)?(www\.)?instagram\.com\/[A-Za-z0-9_.-]+$/i,
                                                    linkedin: /^(https?:\/\/)?(www\.)?linkedin\.com\/in\/[A-Za-z0-9_.-]+$/i,
                                                    x: /^(https?:\/\/)?(www\.)?(x\.com|twitter\.com)\/[A-Za-z0-9_.-]+$/i,
                                                    youtube: /^(https?:\/\/)?(www\.)?youtube\.com\/(c|channel|user)\/[A-Za-z0-9_.-]+$/i,
                                                    google: /^(https?:\/\/)?(www\.)?plus\.google\.com\/[A-Za-z0-9_.-]+$/i, // or use custom G Profiles
                                                    other: /^(https?:\/\/)?([\w\d\-]+\.)+\w{2,}(\/[^\s]*)?$/i
                                                };


                                                // Validate fixed platform inputs
                                                document.querySelectorAll(
                                                    '.social-input[data-platform]').forEach(
                                                    input => {
                                                        const platform = input.dataset
                                                            .platform;
                                                        input.addEventListener('input',
                                                        () => {
                                                                const pattern =
                                                                    socialPatterns[
                                                                        platform];
                                                                const valid = pattern
                                                                    .test(input.value
                                                                        .trim());
                                                                input.classList.remove(
                                                                    'is-invalid',
                                                                    'is-valid');
                                                                input.classList.add(
                                                                    valid ?
                                                                    'is-valid' :
                                                                    'is-invalid');
                                                            });
                                                    });

                                                // Validate custom platform + input pair
                                                document.querySelectorAll('.social-select')
                                                    .forEach(select => {
                                                        const input = select
                                                            .nextElementSibling;
                                                        const status = input
                                                            .nextElementSibling;

                                                        function validate() {
                                                            const platform = select.value;
                                                            const value = input.value
                                                        .trim();
                                                            const pattern = socialPatterns[
                                                                    platform] ||
                                                                socialPatterns.other;
                                                            const valid = pattern.test(
                                                                value);
                                                            input.classList.remove(
                                                                'is-invalid', 'is-valid'
                                                                );
                                                            input.classList.add(valid ?
                                                                'is-valid' :
                                                                'is-invalid');
                                                            status.textContent = value ? (
                                                                valid ? 'Valid URL' :
                                                                'Invalid URL') : '';
                                                            status.className =
                                                                `form-text status-text ${valid ? 'text-success' : 'text-danger'}`;
                                                        }

                                                        select.addEventListener('change',
                                                            validate);
                                                        input.addEventListener('input',
                                                            validate);
                                                    });


                                            }, 50);
                                        } else if (!chk.checked && exists) {
                                            exists.remove();


                                        } else if (!chk.checked && exists) {
                                            exists.remove();
                                        }
                                    });
                                });
                                </script>
                            </div>



                            <!-- Date & Time Tab -->
                            <div class="tab-pane fade" id="dateandtime" role="tabpanel">

                                <div class="mb-4 border rounded p-3">
                                    <h5 class="mb-3">Date & Time Conditions</h5>

                                    <div class="mb-3">
                                        <label class="form-label">Choose Date Format</label>
                                        <select id="globalDateFormat" class="form-select">
                                            <option value="yyyy-mm-dd">YYYY-MM-DD</option>
                                            <option value="dd-mm-yyyy">DD-MM-YYYY</option>
                                            <option value="mm-dd-yyyy">MM-DD-YYYY</option>
                                            <option value="yyyy/dd/mm">YYYY/DD/MM</option>
                                            <option value="dd M yyyy">DD MMM YYYY</option>
                                        </select>
                                    </div>



                                    <!-- Additional Conditions for Remaining Date & Time Types -->
                                    <div class="container">
                                        <div class="row mb-3">
                                            <div class="col-md-12">
                                                <label class="form-label">Select Date Type</label>
                                                <div class="d-flex flex-wrap gap-2">
                                                    <label><input type="radio" name="dateType" class="date-type-option"
                                                            value="date"> Date</label>
                                                    <label><input type="radio" name="dateType" class="date-type-option"
                                                            value="datetime"> Date & Time</label>
                                                    <label><input type="radio" name="dateType" class="date-type-option"
                                                            value="lastdate"> Last Date</label>
                                                    <label><input type="radio" name="dateType" class="date-type-option"
                                                            value="previousdate"> Previous Date</label>
                                                    <label><input type="radio" name="dateType" class="date-type-option"
                                                            value="daterange"> Date Range</label>
                                                    <label><input type="radio" name="dateType" class="date-type-option"
                                                            value="time"> Time</label>
                                                    <label><input type="radio" name="dateType" class="date-type-option"
                                                            value="timer"> Timer</label>
                                                    <label><input type="radio" name="dateType" class="date-type-option"
                                                            value="countdown"> Countdown</label>
                                                    <label><input type="radio" name="dateType" class="date-type-option"
                                                            value="daycountdown"> Day Countdown</label>
                                                    <label><input type="radio" name="dateType" class="date-type-option"
                                                            value="birthdate"> Birth Date Picker</label>
                                                    <label><input type="radio" name="dateType" class="date-type-option"
                                                            value="localcalendar"> Localized Calendar</label>
                                                    <label><input type="radio" name="dateType" class="date-type-option"
                                                            value="slider"> Slider Time Picker</label>
                                                    <label><input type="radio" name="dateType" class="date-type-option"
                                                            value="timetracker"> Time Tracker</label>
                                                    <label><input type="radio" name="dateType" class="date-type-option"
                                                            value="datereservation"> Date Reservation</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row" id="dateFieldsContainer">
                                            <div class="col-md-12"><em>Please select a Date Type.</em></div>
                                        </div>
                                    </div>

                                    <script>
                                    document.addEventListener('DOMContentLoaded', () => {
                                        const container = document.getElementById('dateFieldsContainer');

                                        const createInput = (label, type = 'text', id = '') => `
                                        <div class="col-md-6">
                                        <label class="form-label">${label}</label>
                                        <input type="${type}" id="${id}" class="form-control" placeholder="${label}">
                                        </div>`;

                                        const renderDateFields = (type) => {
                                            container.innerHTML = '';
                                            switch (type) {
                                                case 'birthdate':
                                                    container.innerHTML = `
                                            <div class="col-md-6">
                                                <label class="form-label">Select Birth Date</label>
                                                <input type="date" id="birthDateInput" class="form-control" max="${new Date().toISOString().split('T')[0]}">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Age (Years)</label>
                                                <small class="form-control bg-light" id="ageYears"></small>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Age (Days)</label>
                                                <small class="form-control bg-light" id="ageDays"></small>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Age Group</label>
                                                <small class="form-control bg-light" id="ageGroup"></small>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Time Until Next Birthday</label>
                                                <small class="form-control bg-light" id="daysToBirthday"></small>
                                            </div>`;

                                                    setTimeout(() => {
                                                        const input = document.getElementById(
                                                            'birthDateInput');
                                                        if (input) {
                                                            input.max = new Date().toISOString()
                                                                .split(
                                                                    'T')[0];
                                                            input.addEventListener('change',
                                                                function() {
                                                                    const birthDate = new Date(
                                                                        this
                                                                        .value);
                                                                    const today = new Date();
                                                                    let ageYrs = today
                                                                        .getFullYear() -
                                                                        birthDate
                                                                        .getFullYear();
                                                                    const birthMonthDay =
                                                                        new Date(
                                                                            today.getFullYear(),
                                                                            birthDate
                                                                            .getMonth(),
                                                                            birthDate.getDate()
                                                                        );
                                                                    if (birthMonthDay > today)
                                                                        ageYrs--;
                                                                    const ageDays = Math.floor((
                                                                            today -
                                                                            birthDate) /
                                                                        (1000 * 60 * 60 *
                                                                            24));

                                                                    const nextBirthday =
                                                                        new Date(
                                                                            today.getFullYear(),
                                                                            birthDate
                                                                            .getMonth(),
                                                                            birthDate.getDate()
                                                                        );
                                                                    if (nextBirthday < today)
                                                                        nextBirthday
                                                                        .setFullYear(
                                                                            today
                                                                            .getFullYear() + 1
                                                                        );
                                                                    const totalDays = Math.ceil(
                                                                        (
                                                                            nextBirthday -
                                                                            today
                                                                        ) / (1000 * 60 *
                                                                            60 * 24));

                                                                    const monthsLeft =
                                                                        nextBirthday
                                                                        .getMonth() - today
                                                                        .getMonth() + (
                                                                            nextBirthday
                                                                            .getFullYear() >
                                                                            today
                                                                            .getFullYear() ?
                                                                            12 : 0
                                                                        );
                                                                    const daysLeft =
                                                                        nextBirthday
                                                                        .getDate() - today
                                                                        .getDate();
                                                                    const formattedCountdown =
                                                                        `${monthsLeft} month${monthsLeft !== 1 ? 's' : ''} ${daysLeft < 0 ? (30 + daysLeft) : daysLeft} day${daysLeft !== 1 ? 's' : ''}`;

                                                                    let group = 'Unknown';
                                                                    if (ageYrs < 1) group =
                                                                        'Infant';
                                                                    else if (ageYrs < 3) group =
                                                                        'Toddler';
                                                                    else if (ageYrs < 13)
                                                                        group =
                                                                        'Child';
                                                                    else if (ageYrs < 18)
                                                                        group =
                                                                        'Teenager';
                                                                    else if (ageYrs < 25)
                                                                        group =
                                                                        'Young Adult';
                                                                    else if (ageYrs < 41)
                                                                        group =
                                                                        'Adult';
                                                                    else if (ageYrs < 60)
                                                                        group =
                                                                        'Mid Age';
                                                                    else if (ageYrs < 76)
                                                                        group =
                                                                        'Senior';
                                                                    else group = 'Elderly';

                                                                    document.getElementById(
                                                                            'ageYears')
                                                                        .textContent = ageYrs;
                                                                    document.getElementById(
                                                                            'ageDays')
                                                                        .textContent =
                                                                        ageDays;
                                                                    document.getElementById(
                                                                            'ageGroup')
                                                                        .textContent = group;
                                                                    document.getElementById(
                                                                            'daysToBirthday')
                                                                        .textContent =
                                                                        formattedCountdown;
                                                                });
                                                        }
                                                    }, 100);
                                                    break;

                                                case 'date':
                                                    container.innerHTML = createInput("Select Date",
                                                        "date");
                                                    break;
                                                case 'datetime':
                                                    container.innerHTML = createInput("Select Date & Time",
                                                        "datetime-local");
                                                    break;
                                                case 'daterange':
                                                    container.innerHTML = createInput("Start Date",
                                                            "date") +
                                                        createInput("End Date", "date");
                                                    break;
                                                case 'countdown':
                                                    container.innerHTML = `
                                                <div class="mb-3">
                                                <label class="form-label">Select Countdown Target (Date & Time)</label>
                                                <input type="datetime-local" id="countdownInput" class="form-control"
                                                    min="${new Date().toISOString().slice(0, 16)}">
                                                </div>

                                                <div id="countdownDetails" class="row g-3" style="display:none;">
                                                <div class="col-md-4">
                                                    <label class="form-label">Target Date & Time</label>
                                                    <div id="targetDateTime" class="fw-semibold text-primary"></div>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label">Days Left</label>
                                                    <div id="daysLeft" class="text-success fw-bold"></div>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label">Time Left</label>
                                                    <div id="timeLeft" class="text-danger fw-bold"></div>
                                                </div>
                                                </div>
                                            `;

                                                    setTimeout(() => {
                                                        const input = document.getElementById(
                                                            'countdownInput');
                                                        input?.addEventListener('change',
                                                            function() {
                                                                const target = new Date(this
                                                                    .value);
                                                                const now = new Date();
                                                                const countdownDetails =
                                                                    document
                                                                    .getElementById(
                                                                        'countdownDetails');

                                                                if (target <= now) {
                                                                    alert(
                                                                        "Please select a future date & time."
                                                                    );
                                                                    return;
                                                                }

                                                                countdownDetails.style.display =
                                                                    'flex';
                                                                document.getElementById(
                                                                        'targetDateTime')
                                                                    .textContent = target
                                                                    .toLocaleString();

                                                                const updateCountdown = () => {
                                                                    const now = new Date();
                                                                    const diff = target -
                                                                        now;

                                                                    if (diff <= 0) {
                                                                        document
                                                                            .getElementById(
                                                                                'daysLeft')
                                                                            .textContent =
                                                                            "0";
                                                                        document
                                                                            .getElementById(
                                                                                'timeLeft')
                                                                            .textContent =
                                                                            "⏱ Time's Up!";
                                                                        clearInterval(
                                                                            interval);
                                                                        return;
                                                                    }

                                                                    const days = Math.floor(
                                                                        diff / (1000 *
                                                                            60 *
                                                                            60 * 24));
                                                                    const hours = Math
                                                                        .floor((
                                                                                diff / (
                                                                                    1000 *
                                                                                    60 * 60)
                                                                            ) %
                                                                            24);
                                                                    const minutes = Math
                                                                        .floor((
                                                                                diff / (
                                                                                    1000 *
                                                                                    60)) %
                                                                            60);
                                                                    const seconds = Math
                                                                        .floor((
                                                                                diff / 1000
                                                                            ) %
                                                                            60);

                                                                    document.getElementById(
                                                                            'daysLeft')
                                                                        .textContent =
                                                                        `${days} days`;
                                                                    document.getElementById(
                                                                            'timeLeft')
                                                                        .textContent =
                                                                        `${hours}h ${minutes}m ${seconds}s`;
                                                                };

                                                                updateCountdown(); // initial
                                                                const interval = setInterval(
                                                                    updateCountdown, 1000);
                                                            });
                                                    }, 100);
                                                    break;


                                                case 'lastdate':
                                                    container.innerHTML = createInput("Last Valid Date",
                                                        "date");
                                                    break;
                                                case 'previousdate':
                                                    container.innerHTML = createInput("Any Previous Date",
                                                        "date");
                                                    break;
                                                    // Timer Countdown
                                                case 'timer':
                                                    container.innerHTML = `
                                                    ${createInput("Enter Total Time (in minutes)", "number", "totalTimeInput")}
                                                    <div class="mt-3">
                                                    <button class="btn btn-primary" id="startTimerBtn">Start Timer</button>
                                                    <button class="btn btn-danger ms-2" id="stopTimerBtn">Stop Timer</button>
                                                    </div>
                                                    <div class="mt-3">
                                                    <label>Total Time:</label> <small class="text-muted" id="totalTimerView"></small><br>
                                                    <label>Time Left:</label> <small class="text-muted" id="timeLeftView"></small>
                                                    </div>`;

                                                    let timerInterval;

                                                    setTimeout(() => {
                                                        const startBtn = document.getElementById(
                                                            'startTimerBtn');
                                                        const stopBtn = document.getElementById(
                                                            'stopTimerBtn');
                                                        const totalInput = document.getElementById(
                                                            'totalTimeInput');

                                                        startBtn?.addEventListener('click', () => {
                                                            const totalMinutes = parseInt(
                                                                totalInput.value);
                                                            if (isNaN(totalMinutes) ||
                                                                totalMinutes <= 0) return;

                                                            const totalSeconds =
                                                                totalMinutes *
                                                                60;
                                                            let remainingSeconds =
                                                                totalSeconds;

                                                            document.getElementById(
                                                                    'totalTimerView')
                                                                .textContent =
                                                                `${totalMinutes} minutes`;
                                                            timerInterval = setInterval(
                                                                () => {
                                                                    const mins = Math
                                                                        .floor(
                                                                            remainingSeconds /
                                                                            60);
                                                                    const secs =
                                                                        remainingSeconds %
                                                                        60;
                                                                    document
                                                                        .getElementById(
                                                                            'timeLeftView'
                                                                        )
                                                                        .textContent =
                                                                        `${mins}m ${secs}s`;

                                                                    if (remainingSeconds <=
                                                                        0) {
                                                                        clearInterval(
                                                                            timerInterval
                                                                        );
                                                                        document
                                                                            .getElementById(
                                                                                'timeLeftView'
                                                                            )
                                                                            .textContent =
                                                                            'Time Up!';
                                                                    } else {
                                                                        remainingSeconds--;
                                                                    }
                                                                }, 1000);
                                                        });

                                                        stopBtn?.addEventListener('click', () => {
                                                            clearInterval(timerInterval);
                                                        });
                                                    }, 100);
                                                    break;

                                                case 'daycountdown':
                                                    container.innerHTML = createInput(
                                                        "Days Countdown Target",
                                                        "date") + createInput("Number of Days",
                                                        "number");
                                                    break;
                                                case 'slider':
                                                    container.innerHTML = `
                                                <div class="col-md-12">
                                                    <label class="form-label">Slider Time Picker</label>
                                                    <input type="range" class="form-range" min="0" max="1440" step="15">
                                                    <small class="text-muted">Each step is 15 minutes (0 to 1440 min)</small>
                                                </div>`;
                                                    break;
                                                case 'timetracker':
                                                    container.innerHTML = createInput("Start Time",
                                                            "time") +
                                                        createInput("End Time", "time");
                                                    break;
                                                case 'localcalendar':
                                                    container.innerHTML = `
                                            <div class="mb-3">
                                            <label class="form-label">Select Country for Local Calendar</label>
                                            <select id="localeSelector" class="form-select">
                                                <option value="en-IN">India</option>
                                                <option value="zh-CN">China</option>
                                                <option value="ar-SA">Saudi Arabia</option>
                                                <option value="ja-JP">Japan</option>
                                                <option value="fr-FR">France</option>
                                            </select>
                                            </div>

                                            <div class="mb-3">
                                            <label class="form-label">Select Date</label>
                                            <input type="date" id="localizedDateInput" class="form-control">
                                            </div>

                                            <button class="btn btn-primary" id="testLocale">Test Format</button>

                                            <div class="mt-3">
                                            <label class="form-label">Localized Date Format</label>
                                            <div id="localizedResult" class="text-success fw-bold"></div>
                                            </div>
                                        `;

                                                    setTimeout(() => {
                                                        const dateInput = document.getElementById(
                                                            'localizedDateInput');
                                                        const localeSelector = document
                                                            .getElementById(
                                                                'localeSelector');
                                                        const testBtn = document.getElementById(
                                                            'testLocale');

                                                        testBtn?.addEventListener('click', () => {
                                                            const selectedDate = new Date(
                                                                dateInput.value);
                                                            const locale = localeSelector
                                                                .value;

                                                            if (isNaN(selectedDate)) {
                                                                document.getElementById(
                                                                        'localizedResult')
                                                                    .textContent =
                                                                    'Please select a valid date';
                                                                return;
                                                            }

                                                            const formatted = selectedDate
                                                                .toLocaleDateString(
                                                                    locale, {
                                                                        weekday: 'long',
                                                                        year: 'numeric',
                                                                        month: 'long',
                                                                        day: 'numeric'
                                                                    });

                                                            document.getElementById(
                                                                    'localizedResult')
                                                                .textContent = formatted;
                                                        });
                                                    }, 100);
                                                    break;

                                                case 'datereservation':
                                                    container.innerHTML = createInput("Reserve Date",
                                                            "date") +
                                                        createInput("Time Slot", "time");
                                                    break;
                                                default:
                                                    container.innerHTML =
                                                        '<div class="col-md-12"><em>Please select a Date Type.</em></div>';
                                            }
                                        };

                                        document.querySelectorAll('.date-type-option').forEach(radio => {
                                            radio.addEventListener('change', () => renderDateFields(
                                                radio
                                                .value));
                                        });
                                    });
                                    </script>




                                </div>


                            </div>

                            <!-- address -->
                            <div class="tab-pane fade" id="address" role="tabpanel">

                                <h5>Select Place</h5>

                                <div class="mb-3">
                                    @php
                                    function getNestedCategoryPaths($category, $path = [])
                                    {
                                    $results = [];
                                    $path[] = $category->name;

                                    if ($category->children->isEmpty()) {
                                    $reversedPath = array_reverse($path);
                                    $label = implode(', ', $reversedPath); // Shown in UI
                                    $value = end($path); // Only last item used as chip value
                                    $results[] = ['label' => $label, 'value' => $value];
                                    } else {
                                    foreach ($category->children as $child) {
                                    $results = array_merge($results, getNestedCategoryPaths($child, $path));
                                    }
                                    }

                                    return $results;
                                    }


                                    // Start from "Venue"
                                    $builder = Category::where('name', 'Builders')->first();
                                    $placeOptions = [];

                                    if ($builder) {
                                    $form = $builder->children()->where('name', 'Form')->first();
                                    if ($form) {
                                    $page = $form->children()->where('name', 'Page')->first();
                                    if ($page) {
                                    $venue = $page->children()->where('name', 'Venue')->first();
                                    if ($venue) {
                                    $suggestions = getNestedCategoryPaths($venue);

                                    }
                                    }
                                    }
                                    }

                                    // Prepare required variables for chip-view
                                    $fieldName = 'venue_place_options';
                                    $selectedValues = [];
                                    $suggestions = $suggestions;
                                    $allowUserOptions = true;
                                    @endphp

                                    @if($suggestions && count($suggestions))
                                    @include('components.chip-view', [
                                    'fieldName' => $fieldName,
                                    'selectedValues' => $selectedValues,
                                    'suggestions' => $suggestions,
                                    'allowUserOptions' => $allowUserOptions
                                    ])
                                    @else
                                    <p class="text-danger">Venue category or child options not found.</p>
                                    @endif


                                </div>

                                <div class="mb-3">

                                    <select name="country_id" id="countrySelect" class="form-control"></select>
                                    <select name="state_id" id="stateSelect" class="form-control"></select>
                                    <select name="district_id" id="districtSelect" class="form-control"></select>

                                </div>
                                <div class="mb-3">
                                    <input type="text" id="addressSearch" class="form-control"
                                        placeholder="Search Address or Add New">

                                    <input type="text" name="pin_code" class="form-control" placeholder="Pin Code">
                                    <textarea name="street_address" class="form-control"
                                        placeholder="Street / Locality"></textarea>

                                    <div id="map" style="height: 300px;"></div>
                                    <input type="hidden" name="latitude" id="latitude">
                                    <input type="hidden" name="longitude" id="longitude">

                                </div>





                            </div>

                            <!-- Subcategory Tab -->
                            <div class="tab-pane fade" id="subcategory" role="tabpanel">
                                <!-- 📌 Functionality Selection Radio Buttons -->
                                <div class="mb-4">
                                    <label class="form-label">Select Functionality</label>
                                    <div id="functionalityRadios" class="d-flex flex-wrap gap-3">
                                        <label><input type="radio" name="functionality" value="dropdowns">
                                            Dropdowns</label>
                                        <label><input type="radio" name="functionality" value="communication">
                                            Communication</label>
                                        <!-- Add more cases here -->
                                    </div>
                                </div>

                                <!-- 📌 Content Target Area -->
                                <div id="functionalityContainer"></div>

                                <!-- ✅ Script -->
                                <script>
                                document.querySelectorAll('input[name="functionality"]').forEach(radio => {
                                    radio.addEventListener('change', function() {
                                        const selected = this.value;
                                        const container = document.getElementById(
                                            'functionalityContainer');

                                        switch (selected) {

                                            case 'dropdowns':
                                                container.innerHTML = `
    <div class="mb-3">
      <label class="form-label">Select Dropdown Type</label>
      <div class="d-flex flex-wrap gap-2">
        ${[
          'Dropdown',
          'Checkbox Group',
          'Radio Button',
          'Toggle Switch',
          'Button Group',
          'Multiselect Dropdown',
          'Checkbox Dropdown',
          'Chip View Dropdown',
          'Expandable Dropdown',
          'Grouped Dropdown',
          'Dropdown with Search'
        ].map((type, i) => `
          <label class="me-3">
            <input type="radio" name="dropdownType" value="${type}" ${i === 0 ? 'checked' : ''}>
            ${type}
          </label>
        `).join('')}
      </div>
    </div>

    <div class="row g-3">
      <div class="col-md-6">
        <label class="form-label">Option Text</label>
        <input type="text" id="optionText" class="form-control" placeholder="e.g., Option A">
      </div>
      <div class="col-md-3">
        <label class="form-label">Icon Class (optional)</label>
        <input type="text" id="optionIcon" class="form-control" placeholder="e.g., fa fa-user">
      </div>
      <div class="col-md-3">
        <label class="form-label">Image URL (optional)</label>
        <input type="url" id="optionImage" class="form-control" placeholder="Image URL">
      </div>
    </div>

    <div class="mt-3">
      <label class="form-label">Selection Mode</label>
      <div>
        <label><input type="radio" name="selectMode" value="single" checked> Single Select</label>
        <label class="ms-3"><input type="radio" name="selectMode" value="multiple"> Multiple Select</label>
      </div>
    </div>

    <button class="btn btn-sm btn-primary mt-3" id="addDropdownOption">Add Option</button>

    <div class="mt-4">
      <label class="form-label">Preview</label>
      <div id="dropdownPreview" class="border rounded p-3 bg-light"></div>
    </div>
  `;

                                                setTimeout(() => {
                                                    const preview = document.getElementById(
                                                        'dropdownPreview');
                                                    const options = [];

                                                    const renderPreview = () => {
                                                        const type = document.querySelector(
                                                            'input[name="dropdownType"]:checked'
                                                            )?.value;
                                                        const mode = document.querySelector(
                                                            'input[name="selectMode"]:checked'
                                                            )?.value;

                                                        preview.innerHTML = ''; // reset

                                                        if (options.length === 0) {
                                                            preview.innerHTML =
                                                                `<em>No options added yet</em>`;
                                                            return;
                                                        }

                                                        const iconAndImage = (opt) => {
                                                            const icon = opt.icon ?
                                                                `<i class="${opt.icon} me-1"></i>` :
                                                                '';
                                                            const img = opt.image ?
                                                                `<img src="${opt.image}" style="width:20px;height:20px;object-fit:cover;margin-right:5px;border-radius:4px;">` :
                                                                '';
                                                            return `${img}${icon}<span>${opt.label}</span>`;
                                                        };

                                                        switch (type) {
                                                            case 'Dropdown':
                                                            case 'Dropdown with Search':
                                                                const isMulti = mode ===
                                                                    'multiple';
                                                                preview.innerHTML = `
            <select class="form-select" ${isMulti ? 'multiple' : ''}>
              ${options.map(opt => `<option>${opt.label}</option>`).join('')}
            </select>
          `;
                                                                break;

                                                            case 'Radio Button':
                                                                preview.innerHTML = options
                                                                    .map(opt => `
            <label class="d-block">
              <input type="radio" name="previewRadio"> ${iconAndImage(opt)}
            </label>
          `).join('');
                                                                break;

                                                            case 'Checkbox Group':
                                                                preview.innerHTML = options
                                                                    .map(opt => `
            <label class="d-block">
              <input type="checkbox"> ${iconAndImage(opt)}
            </label>
          `).join('');
                                                                break;

                                                            case 'Toggle Switch':
                                                                preview.innerHTML = options
                                                                    .map((opt, i) => `
            <div class="form-check form-switch">
              <input class="form-check-input" type="checkbox" id="toggle_${i}">
              <label class="form-check-label" for="toggle_${i}">${iconAndImage(opt)}</label>
            </div>
          `).join('');
                                                                break;

                                                            case 'Button Group':
                                                                preview.innerHTML = `
            <div class="btn-group" role="group">
              ${options.map(opt => `<button type="button" class="btn btn-outline-primary">${opt.label}</button>`).join('')}
            </div>
          `;
                                                                break;

                                                            default:
                                                                // Default visual for custom types like Chip View, Expandable, etc.
                                                                preview.innerHTML = options
                                                                    .map(opt => `
            <div class="badge bg-secondary me-2 mb-2 p-2">
              ${iconAndImage(opt)}
            </div>
          `).join('');
                                                        }
                                                    };

                                                    document.getElementById('addDropdownOption')
                                                        .addEventListener('click', () => {
                                                            const text = document
                                                                .getElementById(
                                                                    'optionText').value
                                                                .trim();
                                                            const icon = document
                                                                .getElementById(
                                                                    'optionIcon').value
                                                                .trim();
                                                            const image = document
                                                                .getElementById(
                                                                    'optionImage').value
                                                                .trim();

                                                            if (!text) return alert(
                                                                'Enter option text');
                                                            options.push({
                                                                label: text,
                                                                icon,
                                                                image
                                                            });

                                                            // Reset inputs
                                                            document.getElementById(
                                                                'optionText').value = '';
                                                            document.getElementById(
                                                                'optionIcon').value = '';
                                                            document.getElementById(
                                                                    'optionImage').value =
                                                                '';

                                                            renderPreview();
                                                        });

                                                    document.querySelectorAll(
                                                        'input[name="dropdownType"], input[name="selectMode"]'
                                                        ).forEach(input => {
                                                        input.addEventListener('change',
                                                            renderPreview);
                                                    });

                                                }, 100);
                                                break;


                                            case 'communication':
                                                container.innerHTML =
                                                    `<div class="alert alert-info">Communication functionality selected (load from communication case)</div>`;
                                                break;

                                            default:
                                                container.innerHTML =
                                                    `<div class="alert alert-warning">No case implemented</div>`;
                                        }
                                    });
                                });
                                </script>

                            </div>

                            @php

                            $builder = Category::where('name', 'Builders')->first();
                            $unitOptions = [];

                            if ($builder) {
                            $form = $builder->children()->where('name', 'Form')->first();
                            if ($form) {
                            $common = $form->children()->where('name', 'Common')->first();
                            if ($common) {
                            $basic = $common->children()->where('name', 'Basic')->first();
                            if ($basic) {
                            $unit = $basic->children()->where('name', 'Unit')->first();
                            if ($unit) {
                            $unitOptions = $unit->children()->get(); // e.g., Volume, Length, Area
                            }
                            }
                            }
                            }
                            }

                            // Predefine number of inputs for each unit (by name)
                            $inputMap = [
                            'Length' => ['Length'],
                            'Volume' => ['Length', 'Breadth', 'Height'],
                            'Area' => ['Length', 'Breadth'],
                            'Weight' => ['Weight'],
                            'Temperature' => ['Temperature'],
                            'Time' => ['Time'],
                            'Speed' => ['Speed'],
                            'Energy' => ['Energy'],
                            'Power' => ['Power'],
                            'Pressure' => ['Pressure'],
                            'Density' => ['Density'],
                            'Electrical' => ['Value'],
                            'Frequency' => ['Frequency'],
                            'Data Storage' => ['Size']
                            ];
                            @endphp

                            <div class="tab-pane fade" id="size" role="tabpanel" aria-labelledby="size-tab">

                                <!-- Radio Switches -->
                                <div class="mb-3">
                                    <input type="radio" name="selection" id="unitRadio" onclick="toggleSection('unit')">
                                    <label for="unitRadio" class="form-label">Unit</label>

                                    <input type="radio" name="selection" id="priceRadio"
                                        onclick="toggleSection('price')">
                                    <label for="priceRadio">Price</label>

                                    <input type="radio" name="selection" id="productRadio"
                                        onclick="toggleSection('product')">
                                    <label for="productRadio">Product</label>
                                </div>

                                <!-- Unit Selection Dropdown -->
                                <select name="unit_id" id="unit_id" class="form-select" onchange="renderInputs()">
                                    <option value="">Select Unit</option>
                                    @foreach ($unitOptions as $unit)
                                    <option value="{{ $unit->id }}" data-name="{{ $unit->name }}">{{ $unit->name }}
                                    </option>
                                    @endforeach
                                </select>

                                <!-- Dynamic Fields Output -->
                                <div id="dynamic_fields" class="row mt-3 w-100"></div>

                                <!-- Product Section -->
                                <div class="product section" style="display: none;">
                                    <h4 class="mb-3">Select Functionalities</h4>

                                    <!-- Functional Checkboxes -->
                                    <div class="p-3" id="fieldDropdown">
                                        @foreach (['Discount %', 'Variant', 'Color', 'Size', 'Dimensions', 'Features',
                                        'Specification',
                                        'Packaging Size', 'Packaging Weight', 'Wholesale Price', 'Retail Price', 'Agent
                                        Commission'] as $field)
                                        <label>
                                            <input type="checkbox" class="form-check-input field-option"
                                                value="{{ $field }}"> {{ $field }}
                                        </label>
                                        @endforeach
                                    </div>

                                    <!-- Taxes Section -->
                                    <div id="tax-section">
                                        <h4>Taxes</h4>
                                        <div class="mb-3">
                                            <label for="customTaxInput" class="form-label">Add Custom Tax</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="customTaxInput"
                                                    placeholder="Enter custom tax name">
                                                <button type="button" class="btn btn-outline-primary"
                                                    id="addCustomTaxBtn">Add</button>
                                            </div>
                                        </div>

                                        <!-- Predefined Taxes -->
                                        <div id="predefined-taxes" class="mb-3">
                                            @foreach (['CGST', 'SGST', 'IGST', 'VAT'] as $tax)
                                            <div class="input-group mb-2">
                                                <input type="checkbox" class="form-check-input field-option me-2"
                                                    name="taxes[]" value="{{ $tax }}">
                                                <input type="text" class="form-control" value="{{ $tax }} %"
                                                    name="tax_labels[]">
                                            </div>
                                            @endforeach
                                        </div>

                                        <!-- Custom Tax Container -->
                                        <div id="custom-tax-container"></div>
                                    </div>

                                    <!-- Tax JavaScript -->
                                    <script>
                                    document.getElementById('addCustomTaxBtn').addEventListener('click', function() {
                                        const value = document.getElementById('customTaxInput').value.trim();
                                        if (!value) return;

                                        const container = document.getElementById('custom-tax-container');

                                        const taxGroup = document.createElement('div');
                                        taxGroup.classList.add('input-group', 'mb-2');

                                        const checkbox = document.createElement('input');
                                        checkbox.type = 'checkbox';
                                        checkbox.className = 'form-check-input field-option me-2';
                                        checkbox.name = 'taxes[]';
                                        checkbox.value = value;

                                        const input = document.createElement('input');
                                        input.type = 'text';
                                        input.className = 'form-control';
                                        input.value = value;
                                        input.name = 'tax_labels[]';

                                        const removeBtn = document.createElement('button');
                                        removeBtn.type = 'button';
                                        removeBtn.className = 'btn btn-outline-danger';
                                        removeBtn.innerHTML = '×';
                                        removeBtn.onclick = () => taxGroup.remove();

                                        taxGroup.appendChild(checkbox);
                                        taxGroup.appendChild(input);
                                        taxGroup.appendChild(removeBtn);

                                        container.appendChild(taxGroup);
                                        document.getElementById('customTaxInput').value = '';
                                    });
                                    </script>

                                    <!-- Product Table -->
                                    <h4>Preview</h4>
                                    <table class="table table-bordered table-sm mt-4" id="productTable">
                                        <thead class="table-dark text-white">
                                            <tr id="tableHeaderRow"></tr>
                                        </thead>
                                        <tbody id="productBody"></tbody>
                                    </table>

                                    <button class="btn btn-primary" onclick="addProductRow()">➕ Add Product</button>
                                </div>

                                <!-- Section Toggle Script -->
                                <script>
                                function toggleSection(section) {
                                    document.querySelectorAll('.section').forEach(div => div.style.display = 'none');
                                    const selected = document.querySelector('.' + section);
                                    if (selected) selected.style.display = 'block';
                                }
                                </script>

                                <!-- Dynamic Unit Input Renderer -->
                                <script>
                                const inputMap = @json($inputMap);

                                async function renderInputs() {
                                    const unitSelect = document.getElementById('unit_id');
                                    const selectedOption = unitSelect.options[unitSelect.selectedIndex];
                                    const unitName = selectedOption.dataset.name;
                                    const unitId = selectedOption.value;
                                    const fieldsContainer = document.getElementById('dynamic_fields');

                                    fieldsContainer.innerHTML = '';

                                    // Add predefined labeled inputs
                                    if (unitName && inputMap[unitName]) {
                                        inputMap[unitName].forEach((label, index) => {
                                            fieldsContainer.innerHTML += `
                        <div class="col-md-3 mb-2">
                            <input type="text" name="unit_inputs[${index}][value]" placeholder="Enter ${label}" class="form-control">
                        </div>
                    `;
                                        });
                                    }

                                    // Fetch child units via AJAX
                                    if (unitId) {
                                        const response = await fetch(`/unit/${unitId}/children`);
                                        const children = await response.json();

                                        let unitDropdown = `<div class="col-md-3 mb-3">
                    <select name="common_unit_id" class="form-select"> `;
                                        children.forEach(child => {
                                            unitDropdown +=
                                                `<option value="${child.id}">${child.name}</option>`;
                                        });
                                        unitDropdown += `</select></div>`;

                                        fieldsContainer.innerHTML += unitDropdown;
                                    }
                                }
                                </script>

                                <!-- Product Table JS -->
                                <script>
                                const defaultFields = ["S.No", "Product Name", "MRP"];
                                let selectedFields = [];

                                document.querySelectorAll('.field-option').forEach(el => {
                                    el.addEventListener('change', () => {
                                        selectedFields = Array.from(document.querySelectorAll(
                                            '.field-option:checked')).map(i => i.value);
                                        renderTable();
                                    });
                                });

                                function renderTable() {
                                    const headerRow = document.getElementById("tableHeaderRow");
                                    const tbody = document.getElementById("productBody");
                                    headerRow.innerHTML = '';
                                    tbody.innerHTML = '';

                                    const allFields = [...defaultFields, ...selectedFields, "Total Value", "Action"];
                                    allFields.forEach(field => {
                                        const th = document.createElement("th");
                                        th.textContent = field;
                                        headerRow.appendChild(th);
                                    });

                                    addProductRow();
                                }

                                function addProductRow() {
                                    const tbody = document.getElementById("productBody");
                                    const row = document.createElement("tr");
                                    const allFields = [...defaultFields, ...selectedFields];

                                    allFields.forEach(field => {
                                        const td = document.createElement("td");
                                        let type = "text";

                                        if (["Quantity", "MRP", "Discount", "CGST", "SGST", "IGST", "VAT",
                                                "Wholesale Price", "Retail Price", "Agent Commission"
                                            ].includes(field)) {
                                            type = "number";
                                        }

                                        const input = document.createElement("input");
                                        input.type = type;
                                        input.className = "form-control form-control-sm";
                                        input.placeholder = field;

                                        if (field === "S.No") {
                                            input.value = tbody.rows.length + 1;
                                            input.readOnly = true;
                                        }

                                        if (field !== "S.No" && field !== "Product Name") {
                                            input.addEventListener("input", () => recalculate(row));
                                        }

                                        td.appendChild(input);
                                        row.appendChild(td);
                                    });

                                    const totalCell = document.createElement("td");
                                    totalCell.innerHTML = `<input class="form-control form-control-sm" readonly>`;
                                    row.appendChild(totalCell);

                                    const actionCell = document.createElement("td");
                                    actionCell.innerHTML = `
                <button class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#fieldSettingModal">⚙</button>
                <button class="btn btn-danger btn-sm ms-1" onclick="removeRow(this)">🗑</button>
            `;
                                    row.appendChild(actionCell);

                                    tbody.appendChild(row);
                                }

                                function removeRow(btn) {
                                    btn.closest('tr').remove();
                                    updateSno();
                                }

                                function updateSno() {
                                    const rows = document.querySelectorAll("#productBody tr");
                                    rows.forEach((tr, index) => {
                                        const snoCell = tr.cells[0].querySelector("input");
                                        if (snoCell) snoCell.value = index + 1;
                                    });
                                }

                                function recalculate(row) {
                                    const cells = row.querySelectorAll("td input");
                                    let mrp = parseFloat(getValue(cells, "MRP")) || 0;
                                    let discount = parseFloat(getValue(cells, "Discount")) || 0;
                                    let priceAfterDiscount = mrp - (mrp * discount / 100);

                                    let taxTotal = 0;
                                    ["CGST", "SGST", "IGST", "VAT"].forEach(tax => {
                                        taxTotal += priceAfterDiscount * (parseFloat(getValue(cells, tax)) ||
                                            0) / 100;
                                    });

                                    const finalTotal = priceAfterDiscount + taxTotal;
                                    cells[cells.length - 2].value = finalTotal.toFixed(2);
                                }

                                function getValue(inputs, label) {
                                    const header = document.getElementById("tableHeaderRow");
                                    const index = [...header.cells].findIndex(th => th.textContent === label);
                                    return inputs[index] ? inputs[index].value : 0;
                                }

                                // Init
                                renderTable();
                                </script>
                            </div>


                            <!-- Table Tab -->
                            <div class="tab-pane fade" id="table" role="tabpanel">

                                <div class="d-flex">

                                    <style>
                                    table {
                                        border-collapse: separate;
                                        width: 90%;
                                        /* margin: 20px auto; */
                                        border-spacing: 5px;
                                    }

                                    th {
                                        background-color: #d2d2d2 !important;
                                        color: white
                                    }



                                    th,
                                    td {
                                        border: 1px solid #ffffff;
                                        padding: 8px;
                                        text-align: left;
                                        height: 20px;
                                        /* ✅ Fixed height */
                                        width: 250px;
                                    }

                                    th[contenteditable],
                                    td[contenteditable] {
                                        background-color: #f1f1f1;
                                        color: #8b8b8b;
                                    }

                                    button {
                                        padding: 6px 12px;
                                        margin: 5px;
                                        cursor: pointer;
                                    }

                                    .controls {
                                        margin: 10px;
                                    }

                                    input.form-control {
                                        padding: 6px;
                                        margin-bottom: 10px;
                                    }

                                    .form-table input {
                                        min-width: 120px;
                                    }

                                    .barcode-input {
                                        width: 150px;
                                    }

                                    th,
                                    td {
                                        vertical-align: middle !important;
                                    }

                                    .dropdown-checkboxes {
                                        max-height: 200px;
                                        overflow-y: auto;
                                    }

                                    .form-table input {
                                        min-width: 120px;
                                    }
                                    </style>

                                    <div class="m-2">

                                        <input class="form-control" type="text" placeholder="Add Heading">

                                        <table id="customTable">
                                            <thead>
                                                <tr id="tableHeaders">
                                                    <th contenteditable="true">Field 1</th>
                                                    <th contenteditable="true">Field 2</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td contenteditable="true"></td>
                                                    <td contenteditable="true"></td>
                                                </tr>
                                            </tbody>
                                        </table>

                                    </div>

                                    <div class="controls">
                                        <button class="btn" onclick="addColumn()">
                                            <i class="mdi mdi-plus-box-outline fs-6 icon-choice"></i> Add
                                        </button>
                                        <button class="btn" onclick="deleteLastColumn()">
                                            <i class="bx bx-trash"></i> Delete
                                        </button>
                                    </div>

                                    <script>
                                    function addColumn() {
                                        const headerRow = document.getElementById("tableHeaders");
                                        const newTh = document.createElement("th");
                                        newTh.contentEditable = "true";
                                        newTh.innerText = ""; // Empty heading to be filled manually
                                        headerRow.appendChild(newTh); // ✅ Append at the end

                                        // Add a new editable cell at the end of each row
                                        const rows = document.querySelectorAll("#customTable tbody tr");
                                        rows.forEach(row => {
                                            const newCell = document.createElement("td");
                                            newCell.contentEditable = "true";
                                            newCell.innerText = ""; // Empty cell for manual entry
                                            row.appendChild(newCell);
                                        });

                                        // Optional: Clear the input field, if it's still visible
                                        document.getElementById("newColName").value = "";
                                    }


                                    function deleteLastColumn() {
                                        const headers = document.querySelectorAll("#tableHeaders th");
                                        if (headers.length <= 1) {
                                            alert("You must have at least one column.");
                                            return;
                                        }

                                        if (!confirm("Are you sure you want to delete the last column?")) return;

                                        // Remove last header
                                        headers[headers.length - 1].remove();

                                        // Remove last cell from each row
                                        const rows = document.querySelectorAll("#customTable tbody tr");
                                        rows.forEach(row => {
                                            row.deleteCell(row.cells.length - 1);
                                        });
                                    }
                                    </script>

                                </div>

                            </div>

                            <!-- Media Tab -->
                            <div class="tab-pane fade" id="media" role="tabpanel">

                                <div class="mb-3">


                                    <input type="checkbox" name="icon" id="icon" class="">
                                    <label for="icon">Show Icon</label>
                                </div>

                                <div class="mb-3">
                                    <label for="selectmediatype" class="form-label">Select Media Type</label>
                                    <div>


                                        <input type="radio" name="media_type" id="image" value="image">
                                        <label for="image">Image</label>
                                        <input type="radio" name="media_type" id="album" value="album">
                                        <label for="album">Album</label>
                                        <input type="radio" name="media_type" id="video" value="video">
                                        <label for="video">Video</label>
                                    </div>

                                </div>


                            </div>
                            <!-- popup Tab -->

                            <div class="tab-pane fade" id="popup" role="tabpanel">
                                <div class="mb-3">
                                    <label for="popupImage" class="form-label">Upload Image</label>
                                    <input type="file" class="form-control" id="popupImage">
                                </div>

                                <div class="mb-3">
                                    <label for="popupInput" class="form-label">Popup Title</label>
                                    <input type="text" class="form-control" id="popupInput"
                                        placeholder="Enter popup title">
                                </div>


                                <div class="mb-3">
                                    <label for="popupContent" class="form-label">Popup Content</label>
                                    <textarea class="form-control" id="popupContent" rows="3"
                                        placeholder="Enter popup content"></textarea>
                                </div>
                            </div>



                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveColumnWidth">Save changes</button>
            </div>
        </div>
    </div>
</div>

<!-- Advanced Functionalities Modal -->
<div class="modal fade" id="fieldSettingModal" tabindex="-1" aria-labelledby="fieldSettingModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Advanced Field Settings</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <!-- Vertical Nav -->
                    <div class="col-md-3 border-end">
                        <div class="nav flex-column nav-pills" role="tablist">
                            <button class="nav-link active" data-bs-toggle="pill"
                                data-bs-target="#colorTab">Color</button>
                            <button class="nav-link" data-bs-toggle="pill" data-bs-target="#sizeTab">Size</button>
                            <button class="nav-link" data-bs-toggle="pill"
                                data-bs-target="#dimensionTab">Dimension</button>
                            <button class="nav-link" data-bs-toggle="pill"
                                data-bs-target="#featureTab">Features</button>
                            <button class="nav-link" data-bs-toggle="pill"
                                data-bs-target="#specTab">Specifications</button>
                            <button class="nav-link" data-bs-toggle="pill"
                                data-bs-target="#variantTab">Variants</button>
                        </div>
                    </div>

                    <!-- Tab Content -->
                    <div class="col-md-9">
                        <div class="tab-content">
                            <!-- Color Tab -->
                            <div class="tab-pane fade show active" id="colorTab">
                                <label class="form-label">Select Predefined Color</label>
                                <div class="row mb-3">
                                    <div class="col">
                                        <select class="form-select">
                                            <option value="#000000">Black</option>
                                            <option value="#FFFFFF">White</option>
                                            <option value="#FF0000">Red</option>
                                            <option value="#0000FF">Blue</option>
                                            <option value="#008000">Green</option>
                                            <option value="#FFFF00">Yellow</option>
                                            <option value="#FFA500">Orange</option>
                                            <option value="#FFC0CB">Pink</option>
                                        </select>
                                    </div>
                                    <div class="col">
                                        <label class="form-label">Pick Custom Color</label>
                                        <input type="color" class="form-control form-control-color">
                                    </div>
                                </div>
                            </div>

                            <!-- Size Tab -->
                            <div class="tab-pane fade" id="sizeTab">
                                <label class="form-label">Apparel Size Table</label>
                                <select class="form-select mb-2">
                                    <option>Universal - Male</option>
                                    <option>Universal - Female</option>
                                    <option>Universal - Kids</option>
                                    <option>Custom Size</option>
                                </select>
                                <textarea class="form-control"
                                    placeholder="Size chart info or custom size format"></textarea>

                                <label class="form-label mt-3">Shoe Size Table</label>
                                <select class="form-select mb-2">
                                    <option>Shoe Size - Male</option>
                                    <option>Shoe Size - Female</option>
                                    <option>Shoe Size - Kids</option>
                                    <option>Custom Shoe Size</option>
                                </select>
                                <textarea class="form-control" placeholder="Shoe size info"></textarea>
                            </div>

                            <!-- Dimension Tab -->
                            <div class="tab-pane fade" id="dimensionTab">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label class="form-label">Length</label>
                                        <input type="number" class="form-control" placeholder="e.g., 100">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Breadth</label>
                                        <input type="number" class="form-control" placeholder="e.g., 50">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Height</label>
                                        <input type="number" class="form-control" placeholder="e.g., 20">
                                    </div>
                                    <div class="col-md-6 mt-3">
                                        <label class="form-label">Select Unit</label>
                                        <select class="form-select">
                                            <option value="cm">Centimeters</option>
                                            <option value="inch">Inches</option>
                                            <option value="mm">Millimeters</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Features Tab -->
                            <div class="tab-pane fade" id="featureTab">
                                <div id="features-container">
                                    <div class="feature-group mb-3">
                                        <label class="form-label">Feature Category</label>
                                        <input type="text" class="form-control mb-1" placeholder="e.g., Safety">
                                        <label class="form-label">Feature Name</label>
                                        <input type="text" class="form-control" placeholder="e.g., Airbags">
                                    </div>
                                </div>
                                <button class="btn btn-outline-primary btn-sm mt-2" onclick="addFeatureGroup()">+ Add
                                    More</button>
                            </div>

                            <!-- Specifications Tab -->
                            <div class="tab-pane fade" id="specTab">
                                <div class="specifications-container">
                                    <div class="row mb-2">
                                        <div class="col">
                                            <input type="text" class="form-control" placeholder="Type e.g., Engine">
                                        </div>
                                        <div class="col">
                                            <input type="text" class="form-control" placeholder="Value e.g., 2000cc">
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-outline-primary btn-sm" onclick="addSpecificationRow()">+ Add
                                    More</button>
                            </div>

                            <!-- Variant Tab -->
                            <div class="tab-pane fade" id="variantTab">
                                <p>Create variants with complete field combinations.</p>
                                <table class="table table-bordered table-sm">
                                    <thead>
                                        <tr>
                                            <th>Variant</th>
                                            <th>Price</th>
                                            <th>Color</th>
                                            <th>Size</th>
                                            <th>Specification</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="variantTableBody">
                                        <tr>
                                            <td><input class="form-control form-control-sm" placeholder="Model A"></td>
                                            <td><input class="form-control form-control-sm" placeholder="10000"></td>
                                            <td><input class="form-control form-control-sm" placeholder="Red"></td>
                                            <td><input class="form-control form-control-sm" placeholder="XL"></td>
                                            <td><input class="form-control form-control-sm" placeholder="2000cc"></td>
                                            <td><button class="btn btn-danger btn-sm"
                                                    onclick="this.closest('tr').remove()">🗑</button></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <button class="btn btn-outline-success btn-sm" onclick="addVariantRow()">+ Add
                                    Variant</button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button class="btn btn-primary">Save Settings</button>
            </div>
        </div>
    </div>
</div>

<script>
function addFeatureGroup() {
    const container = document.getElementById('features-container');
    const div = document.createElement('div');
    div.classList.add('feature-group', 'mb-3');
    div.innerHTML = `
        <label class="form-label">Feature Category</label>
        <input type="text" class="form-control mb-1" placeholder="e.g., Safety">
        <label class="form-label">Feature Name</label>
        <input type="text" class="form-control" placeholder="e.g., ABS">
    `;
    container.appendChild(div);
}

function addSpecificationRow() {
    const container = document.querySelector('.specifications-container');
    const row = document.createElement('div');
    row.classList.add('row', 'mb-2');
    row.innerHTML = `
        <div class="col">
            <input type="text" class="form-control" placeholder="Type">
        </div>
        <div class="col">
            <input type="text" class="form-control" placeholder="Value">
        </div>
    `;
    container.appendChild(row);
}

function addVariantRow() {
    const tbody = document.getElementById('variantTableBody');
    const tr = document.createElement('tr');
    tr.innerHTML = `
        <td><input class="form-control form-control-sm" placeholder="Model"></td>
        <td><input class="form-control form-control-sm" placeholder="Price"></td>
        <td><input class="form-control form-control-sm" placeholder="Color"></td>
        <td><input class="form-control form-control-sm" placeholder="Size"></td>
        <td><input class="form-control form-control-sm" placeholder="Specs"></td>
        <td><button class="btn btn-danger btn-sm" onclick="this.closest('tr').remove()">🗑</button></td>
    `;
    tbody.appendChild(tr);
}
</script>


<!-- Form Settings Modal -->
<div class="modal fade" id="formSettingsModal" tabindex="-1" aria-labelledby="formSettingsModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="formSettingsModalLabel">Form Settings</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class=" p-3">

                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label for="for_type" class="form-label">Form For</label>
                            <select name="for_type" class="form-select">
                                <option value="user">User Page</option>
                                <option value="business">Business Page</option>
                                <option value="admin">Admin Page</option>
                            </select>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="data_mode" class="form-label">Form Data For</label>
                            <select name="data_mode" class="form-select">
                                <option value="single">Single Use</option>
                                <option value="multi">Data Building</option>
                            </select>
                        </div>
                    </div>




                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label">Success Message</label>
                            <input type="text" name="cta_success_message" class="form-control"
                                placeholder="e.g. Thanks for your submission!">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Redirect URL After Submit</label>
                            <input type="url" name="cta_redirect_url" class="form-control"
                                placeholder="https://yourdomain.com/success">
                        </div>


                        <div class="col-md-2">
                            <label class="form-label d-block">Show Label</label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="showLabelToggle" name="show_label"
                                    value="yes">
                                <label class="form-check-label" for="showLabelToggle">Yes</label>
                            </div>
                            <input type="hidden" name="show_label" value="no"> {{-- fallback default --}}
                        </div>


                        <div class="col-md-12">
                            <label class="form-label d-block">Form Status</label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="formStatusToggle" name="publish"
                                    value="yes">
                                <label class="form-check-label" for="formStatusToggle">Publish</label>
                            </div>
                            <input type="hidden" name="publish" value="no"> {{-- fallback default --}}
                        </div>
                    </div>


                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="addGalleryModal" tabindex="-1" aria-labelledby="addGalleryModalLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">Add Gallery</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="{{ route('media.upload') }}"
                    enctype="multipart/form-data" id="add-gallery">
                    @csrf
                    <input type="hidden" value="{{ Auth::user()->id }}" id="data_id">

                    <div class="mb-3">
                        <label for="avatar">Upload Image</label>
                        <div class="input-group">
                            <input type="file" class="form-control @error('avatar') is-invalid @enderror" id="avatar"
                                name="avatar" autofocus>
                            <label class="input-group-text" for="avatar">Upload</label>
                        </div>
                        @error('avatar')
                        <div class="text-danger" role="alert">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mt-3 d-grid">
                        <button class="btn btn-primary waves-effect waves-light" type="submit">Upload</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="updateProfileModal" tabindex="-1" aria-labelledby="updateProfileModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">Edit Bio and Achievements</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="POST" enctype="multipart/form-data" id="update-candidate-profile">
                    @csrf

                    <div class="mb-3">
                        <label for="bio" class="form-label">Bio</label>
                        <textarea class="form-control @error('bio') is-invalid @enderror" id="bio" name="bio"
                            placeholder="Enter bio">{{ old('bio', $userProfile->bio ?? '') }}</textarea>
                        @error('bio')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="achievements" class="form-label">Achievements</label>
                        <textarea class="form-control @error('achievements') is-invalid @enderror" id="achievements"
                            name="achievements"
                            placeholder="Enter achievements">{{ old('achievements', $userProfile->achievements ?? '') }}</textarea>
                        @error('achievements')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mt-3 d-grid">
                        <button class="btn btn-primary waves-effect waves-light" type="submit">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


@endsection

@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.6/Sortable.min.js"
    integrity="sha512-csIng5zcB+XpulRUa+ev1zKo7zRNGpEaVfNB9On1no9KYTEY/rLGAEEpvgdw6nim1WdTuihZY1eqZ31K7/fZjw=="
    crossorigin="anonymous" referrerpolicy="no-referrer">
</script>


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

$(document).ready(function() {
    $('#update-candidate-profile').on('submit', function(e) {
        e.preventDefault();
        let formData = $(this).serialize();

        $.ajax({
            type: 'POST',
            url: '{{ route("update.profile.bio.achievements") }}',
            data: formData,
            success: function(response) {
                if (response.isSuccess) {
                    alert(response.message);
                    $('#updateProfileModal').modal('hide');
                    setTimeout(function() {
                        window.location.reload();
                    });
                }
            },
            error: function(xhr) {
                // Handle errors
                let errors = xhr.responseJSON.errors;
                for (let field in errors) {
                    $('#' + field).addClass('is-invalid');
                    $('#' + field).next('.text-danger').text(errors[field][0]);
                }
            }
        });
    });
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const sortableEl = document.getElementById('sortable-fields-111615');
    if (sortableEl) {
        new Sortable(sortableEl, {
            animation: 150,
            handle: '.field-block',
            ghostClass: 'bg-warning'
        });
    } else {
        console.warn('Sortable element not found: #sortable-fields-111615');
    }
});

let currentFieldId = null;

document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.open-settings').forEach(button => {
        button.addEventListener('click', () => {
            currentFieldId = button.getAttribute('data-field-id');
            const settings = JSON.parse(button.getAttribute('data-settings') || '{}');
            const type = button.getAttribute('data-settings-type') || '';

            // Populate modal UI based on type (use type to show different tabs like 'user', 'address')
            populateModal(settings, type);
        });
    });

    document.getElementById('saveColumnWidth').addEventListener('click', () => {
        const newSettings = {
            profile_pic: document.getElementById('profilePic')?.checked || false,
            title: document.getElementById('userTitle')?.checked || false,
            name_format: document.querySelector('.name-format:checked')?.value || 'first_last',
            // Add more dynamic settings as needed
        };

        fetch('/save-field-settings', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                field_id: currentFieldId,
                settings: newSettings
            })
        })
        .then(res => res.json())
        .then(data => {
            alert('Settings saved!');
            location.reload(); // Or re-render just that field if you want to avoid full reload
        });
    });
});

function populateModal(settings, type) {
    // Optionally switch tab based on type
    new bootstrap.Modal(document.getElementById('settingsModal')).show();

    document.getElementById('profilePic').checked = settings.profile_pic ?? false;
    document.getElementById('userTitle').checked = settings.title ?? false;

    const nameFormat = settings.name_format || 'first_last';
    document.querySelectorAll('.name-format').forEach(input => {
        input.checked = input.value === nameFormat;
    });

    // Trigger render if needed
    const renderUserFields = window.renderUserFields;
    if (typeof renderUserFields === 'function') renderUserFields();
}




document.getElementById('saveColumnWidth').addEventListener('click', function() {
    const width = document.getElementById('column-width').value;
    const id = document.getElementById('activeFieldId').value;
    const block = document.querySelector(`[data-id='${id}']`);

    if (block) {
        block.className = block.className.replace(/col-md-\d+/, 'col-md-' + width);
        bootstrap.Modal.getInstance(document.getElementById('settingsModal')).hide();
    }
});

// CTA selection logic
document.querySelectorAll('.cta-action-btn').forEach(btn => {
    btn.addEventListener('click', function(e) {
        const label = this.textContent;
        const value = this.getAttribute('data-value');
        document.getElementById('selectedCtaText').textContent = label;
        document.getElementById('cta_action').value = value;
    });
});


document.getElementById('setting-submit').addEventListener('click', function() {
    const formData = new FormData();

    formData.append('publish', 'yes');
    formData.append('cta_action', document.getElementById('cta_action').value);
    formData.append('cta_success_message', document.querySelector('input[name="cta_success_message"]').value);
    formData.append('cta_redirect_url', document.querySelector('input[name="cta_redirect_url"]').value);
    formData.append('for_type', document.querySelector('select[name="for_type"]').value);
    formData.append('data_mode', document.querySelector('select[name="data_mode"]').value);
    formData.append('tab_id', '{{ $tab->id }}');
    formData.append('sub_tab_id', '{{ $subTab->id }}');

    const fields = [];
    document.querySelectorAll('.field-block').forEach((block, index) => {
        const match = block.className.match(/col-md-(\d+)/);
        const colWidth = match ? parseInt(match[1]) : 12; // default to 12 if not found

        fields.push({
            id: block.getAttribute('data-id'),
            order: index + 1,
            column_width: colWidth
        });
    });

    console.log(fields);
    formData.append('fields', JSON.stringify(fields));

    fetch("{{ route('form.builder.save') }}", {
            method: "POST",
            body: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(res => {
            if (res.status === 'success') {
                alert(res.message);
            }
        });

});
</script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const toggle = document.getElementById('showLabelToggle');

    toggle.addEventListener('change', function() {
        const show = this.checked;

        document.querySelectorAll('.field-block .field-label').forEach(label => {
            label.style.display = show ? 'block' : 'none';
        });
    });

    // Optional: auto-apply toggle state on load
    toggle.dispatchEvent(new Event('change'));
});
</script>
<script>
function formatGlobalDate(date) {
    const format = document.getElementById('globalDateFormat')?.value || 'yyyy-mm-dd';
    const yyyy = date.getFullYear();
    const mm = String(date.getMonth() + 1).padStart(2, '0');
    const dd = String(date.getDate()).padStart(2, '0');
    const mmm = date.toLocaleString('default', {
        month: 'short'
    });

    switch (format) {
        case 'yyyy-mm-dd':
            return `${yyyy}-${mm}-${dd}`;
        case 'dd-mm-yyyy':
            return `${dd}-${mm}-${yyyy}`;
        case 'mm-dd-yyyy':
            return `${mm}-${dd}-${yyyy}`;
        case 'yyyy/dd/mm':
            return `${yyyy}/${dd}/${mm}`;
            5
        case 'dd M yyyy':
            return `${dd} ${mmm} ${yyyy}`;
        default:
            return `${yyyy}-${mm}-${dd}`;
    }
}

function attachGlobalDateFormatter(input) {
    if (input._hasFormatterAttached) return;

    const display = document.createElement('small');
    display.className = 'text-muted d-block mt-1';
    input.insertAdjacentElement('afterend', display);

    const updateFormatted = () => {
        const val = input.value;
        if (!val) return display.textContent = '';
        const date = new Date(val);
        if (isNaN(date)) return display.textContent = 'Invalid Date';
        display.textContent = `Formatted: ${formatGlobalDate(date)}`;
    };

    input.addEventListener('change', updateFormatted);
    input._hasFormatterAttached = true;
    updateFormatted(); // initial
}

// Auto-scan existing and future date inputs
function observeDateInputsGlobally() {
    document.querySelectorAll('input[type="date"]').forEach(attachGlobalDateFormatter);

    const observer = new MutationObserver(() => {
        document.querySelectorAll('input[type="date"]').forEach(attachGlobalDateFormatter);
    });

    observer.observe(document.body, {
        childList: true,
        subtree: true
    });
}

document.addEventListener('DOMContentLoaded', observeDateInputsGlobally);
</script>


@endsection