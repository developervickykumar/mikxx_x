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


<meta name="csrf-token" content="{{ csrf_token() }}">


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

.functionality-settings {
    display: none;
}
</style>

<div class="row">
    <div class="col-xl-9 col-lg-8">
        <div class="card">
            <div class="card-body">

                <h3 class=" pb-2"> {{ $formName ?? 'No Form Title' }} </h3>


                <ul class="nav nav-tabs-custom card-header-tabs " id="pills-tab" role="tablist">
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
                                id="vtab-{{ Str::slug($tab->name) }}-{{ Str::slug($subTab->name) }}" role="tabpanel"
                                data-tab-id="{{ $tab->id }}" data-sub-tab-id="{{ $subTab->id }}">

                                <div class="d-flex justify-content-between ">
                                    <h4>{{ $subTab->name }} </h4>

                                    <div>
                                        <span class="form-setting ms-3" role="button" data-bs-toggle="modal"
                                            data-bs-target="#formSettingsModal">⋮</span>

                                        <button type="button" class="btn btn-soft-primary btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#createSubcategoryModal" data-parent-id="{{ $subTab->id }}"
                                            data-parent-name="{{ $subTab->name }}">
                                            <i class="bx bx-duplicate"></i>
                                        </button>
                                    </div>


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
                                            data-id="{{ $field->id }}"
                                            data-settings="{{ json_encode($field->settings ?? []) }}">
                                            <div class="border p-2 position-relative bg-light">
                                                <!-- Settings Gear Icon -->

                                                <button type="button"
                                                    class="btn btn-sm fs-5 position-absolute top-0 end-0 m-1 open-settings"
                                                    data-functionality="{{ $field->functionality }}"
                                                    data-field-id="{{ $field->id }}" data-form-id="{{ $subTab->id }}"
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
                                        <span id="selectedCtaText">Post </span>
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


                            </div>
                            @endforeach

                            <div class="p-md-3">


                                <div class="col-md-2">
                                    <button id="setting-submit" class="btn btn-sm btn-primary">Save
                                        Settings</button>
                                </div>

                                <div class="d-flex gap-2">
                                    <button type="button" class="btn btn-light" data-bs-toggle="modal"
                                        data-bs-target="#postSettingsModal">
                                        <i class="fas fa-cog"></i> Settings
                                    </button>
                                    <button type="button" class="btn btn-light" data-bs-toggle="modal"
                                        data-bs-target="#postSettingsModal">
                                        <i class="bx bx-purchase-tag"></i> Tags
                                    </button>
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


</div>
<!-- end row -->



<div class="modal fade" id="postSettingsModal" tabindex="-1" aria-labelledby="postSettingsModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="postSettingsModalLabel">Post Settings</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-md-3 border-end">
                        <!-- Vertical Nav Pills -->
                        <div class="nav flex-column nav-pills" id="postSettingsTabs" role="tablist"
                            aria-orientation="vertical">
                            <button class="nav-link active" id="tab-basic-tab" data-bs-toggle="pill"
                                data-bs-target="#tab-basic-post-setting" type="button" role="tab"
                                aria-controls="tab-basic" aria-selected="true">Basic</button>
                            <button class="nav-link" id="tab-addon-tab" data-bs-toggle="pill"
                                data-bs-target="#tab-addon-post-setting" type="button" role="tab"
                                aria-controls="tab-addon" aria-selected="false">Addon</button>
                            <button class="nav-link" id="tab-cta-tab" data-bs-toggle="pill" data-bs-target="#tab-cta"
                                type="button" role="tab" aria-controls="tab-cta" aria-selected="false">Call to
                                Action</button>
                            <button class="nav-link" id="tab-boost-tab" data-bs-toggle="pill"
                                data-bs-target="#tab-boost" type="button" role="tab" aria-controls="tab-boost"
                                aria-selected="false">Boost Post</button>
                            <button class="nav-link" id="tab-eligibility-tab" data-bs-toggle="pill"
                                data-bs-target="#tab-eligibility" type="button" role="tab"
                                aria-controls="tab-eligibility" aria-selected="false">Eligibility</button>
                            <button class="nav-link" id="tab-report-tab" data-bs-toggle="pill"
                                data-bs-target="#tab-report" type="button" role="tab" aria-controls="tab-report"
                                aria-selected="false">Report</button>
                            <button class="nav-link" id="tab-leads-tab" data-bs-toggle="pill"
                                data-bs-target="#tab-leads" type="button" role="tab" aria-controls="tab-leads"
                                aria-selected="false">Leads</button>
                        </div>
                    </div>

                    <div class="col-md-9">
                        <!-- Tab Content Area -->
                        <div class="tab-content" id="postSettingsTabsContent">
                            <div class="tab-pane fade show active" id="tab-basic-post-setting" role="tabpanel"
                                aria-labelledby="tab-basic-tab">
                                <h6>Post Type</h6>
                                <p>Image, Video, Music, File, Questions, Poll, Recipes, Blog, Classifieds, Social
                                    Updates, Event, Product, Service, Offers, Story, Holiday Package</p>
                                <h6>Post Buttons</h6>
                                <p>Like, Comment, Share, Gift, Save, Embed</p>

                                @include('backend.post.partials.schedule')
                                @include('backend.post.partials.censorship')
                                @include('backend.post.partials.form_fields')
                                @include('backend.post.partials.cta_buttons')

                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="is_premium"
                                            name="is_premium" value="1" {{ old('is_premium') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_premium">
                                            Make this a Premium Post
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="tab-addon-post-setting" role="tabpanel"
                                aria-labelledby="tab-addon-tab">
                                <h6>Tags</h6>
                                <p>Friends, Hashtags, Location, Activity, Brand, Product</p>
                                <input type="file" class="form-control my-2">
                                <label>Add Timer</label>
                                <input type="datetime-local" class="form-control mb-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="makePremium">
                                    <label class="form-check-label" for="makePremium">Make Premium</label>
                                </div>
                                <label class="mt-2">Censorship Type</label>
                                <select class="form-select">
                                    <option value="">Select</option>
                                    <option value="none">None</option>
                                    <option value="18+">18+</option>
                                    <option value="restricted">Restricted</option>
                                </select>
                                <label class="mt-2">Schedule Post</label>
                                <input type="datetime-local" class="form-control">
                                <label class="mt-2">Post Collaboration</label>
                                <div class="form-check"><input class="form-check-input" type="checkbox"> Allow
                                    Co-authors</div>
                                <div class="form-check"><input class="form-check-input" type="checkbox"> Brand Partners
                                </div>
                                <div class="form-check"><input class="form-check-input" type="checkbox"> Contributors
                                </div>



                            </div>

                            <div class="tab-pane fade" id="tab-cta" role="tabpanel" aria-labelledby="tab-cta-tab">
                                <h6>Form Type</h6>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="ctaFormType" checked> Single Form
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="ctaFormType"> Multiple Inquiry
                                    Form
                                </div>
                                <h6 class="mt-3">Subcategory Form Names</h6>
                                <textarea class="form-control" placeholder="Form 1, Form 2, Form 3"></textarea>
                            </div>

                            <div class="tab-pane fade" id="tab-boost" role="tabpanel" aria-labelledby="tab-boost-tab">
                                <h6>Select Budget</h6>
                                <input type="number" class="form-control mb-2" placeholder="₹">
                                <h6>Duration (in days)</h6>
                                <input type="number" class="form-control">
                            </div>

                            <div class="tab-pane fade" id="tab-eligibility" role="tabpanel"
                                aria-labelledby="tab-eligibility-tab">
                                <input type="text" class="form-control mb-2" placeholder="Profile Type">
                                <input type="text" class="form-control mb-2" placeholder="Business Type">
                                <input type="text" class="form-control mb-2" placeholder="Age Group">
                                <select class="form-select mb-2">
                                    <option>Gender</option>
                                    <option>Male</option>
                                    <option>Female</option>
                                    <option>Other</option>
                                </select>
                                <input type="text" class="form-control mb-2" placeholder="Location">
                                <input type="text" class="form-control mb-2" placeholder="Internet & Hobbies">
                                <input type="text" class="form-control mb-2" placeholder="Vitals (optional)">
                            </div>

                            <div class="tab-pane fade" id="tab-report" role="tabpanel" aria-labelledby="tab-report-tab">
                                <div class="form-check"><input class="form-check-input" type="checkbox"> Demography
                                </div>
                                <div class="form-check"><input class="form-check-input" type="checkbox"> Location</div>
                                <div class="form-check"><input class="form-check-input" type="checkbox"> Date & Time
                                </div>
                                <div class="form-check"><input class="form-check-input" type="checkbox"> Status</div>
                                <div class="form-check"><input class="form-check-input" type="checkbox"> Priority</div>
                                <div class="form-check"><input class="form-check-input" type="checkbox"> Form
                                    Engagements</div>
                                <div class="form-check"><input class="form-check-input" type="checkbox"> Comparisons
                                </div>
                                <div class="form-check"><input class="form-check-input" type="checkbox"> Devices</div>
                            </div>

                            <div class="tab-pane fade" id="tab-leads" role="tabpanel" aria-labelledby="tab-leads-tab">
                                <h6>Assign Lead</h6>
                                <div class="form-check"><input class="form-check-input" type="radio" name="assignLead"
                                        value="self" checked> Self</div>
                                <div class="form-check"><input class="form-check-input" type="radio" name="assignLead"
                                        value="user"> User</div>
                                <div class="form-check"><input class="form-check-input" type="radio" name="assignLead"
                                        value="department"> Department</div>

                                <div id="leadUserSearch" class="mt-2" style="display:none;">
                                    <label>Search User</label>
                                    <input type="text" class="form-control">
                                </div>

                                <div id="leadDeptSelect" class="mt-3" style="display:none;">
                                    <label>Select Departments</label>
                                    <div class="form-check"><input class="form-check-input" type="checkbox"> Sales &
                                        Marketing</div>
                                    <div class="form-check"><input class="form-check-input" type="checkbox"> Call Center
                                    </div>
                                    <div class="form-check"><input class="form-check-input" type="checkbox"> Logistics
                                    </div>
                                    <div class="form-check"><input class="form-check-input" type="checkbox"> Accounting
                                    </div>
                                    <div class="form-check"><input class="form-check-input" type="checkbox"> Production
                                    </div>
                                    <div class="form-check"><input class="form-check-input" type="checkbox"> Help Center
                                    </div>
                                </div>

                                <div id="leadDeptForm" class="mt-3" style="display:none;">
                                    <label>Department Form</label>
                                    <textarea class="form-control"
                                        placeholder="Enter department form content..."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Lead visibility logic
document.querySelectorAll('input[name="assignLead"]').forEach(el => {
    el.addEventListener('change', function() {
        const isUser = this.value === 'user';
        const isDept = this.value === 'department';
        document.getElementById('leadUserSearch').style.display = isUser ? 'block' : 'none';
        document.getElementById('leadDeptSelect').style.display = isDept ? 'block' : 'none';
        document.getElementById('leadDeptForm').style.display = isDept ? 'block' : 'none';
    });
});
</script>


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
                            <button class="text-start nav-link" id="condition-tab" data-bs-toggle="pill"
                                data-bs-target="#condition" type="button" role="tab">Condition</button>

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
                                    <select class="form-select" id="customFunctionalitySelect" name="functionality">
                                        <option value="">Select functionality</option>
                                        @foreach ($functionalityOptions as $index => $option)
                                        <optgroup label="{{ $option->name }}">
                                            @foreach ($option->children as $subOption)
                                            <option value="{{ strtolower($subOption->name) }}">{{ $subOption->name }}
                                            </option>
                                            @endforeach
                                        </optgroup>
                                        @endforeach
                                    </select>
                                </div>

                                <script>
                                document.addEventListener('DOMContentLoaded', () => {
                                    const functionalitySelect = document.getElementById(
                                        'customFunctionalitySelect');

                                    const toggleSettingsBlock = () => {
                                        // Hide all blocks
                                        document.querySelectorAll('.functionality-settings').forEach(el => {
                                            el.style.display = 'none';
                                        });

                                        // Get selected option value
                                        const selected = functionalitySelect.value.toLowerCase();

                                        if (selected) {
                                            const target = document.querySelector(
                                                `.functionality-settings[data-type="${selected}"]`);
                                            if (target) {
                                                target.style.display = 'block';
                                            }
                                        }
                                    };

                                    // Event listener on select change
                                    functionalitySelect.addEventListener('change', toggleSettingsBlock);

                                    // Trigger on page load in case a value is already selected
                                    toggleSettingsBlock();
                                });
                                </script>



                                @include("components.post-setting.user")

                                @include("components.post-setting.optional")

                                @include("components.post-setting.address")

                                @include("components.post-setting.dateandtime")

                                @include("components.post-setting.subcategory")

                                @include("components.post-setting.unit")

                                @include("components.post-setting.table")

                                @include("components.post-setting.media")

                                @include("components.post-setting.popup")







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

                            <!-- Condition Tab -->

                            @include("components.condition-manager")


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
                                <option value="For Other Users">For Other Users</option>
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
@include('backend.category.partials.create-subcategory')


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
let currentFormId = null;

document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.open-settings').forEach(button => {
        button.addEventListener('click', () => {
            currentFieldId = button.getAttribute('data-field-id');
            currentFormId = button.getAttribute('data-form-id');

            const settings = JSON.parse(button.getAttribute('data-settings') || '{}');
            const type = button.getAttribute('data-settings-type') || '';

            populateModal(settings, type);

            document.getElementById('currentFieldId').value = currentFieldId;
            document.getElementById('formId').value = currentFormId;
        });
    });

    document.getElementById('saveColumnWidth').addEventListener('click', () => {
        const getVal = (id) => document.getElementById(id)?.value || '';
        const getCheck = (id) => document.getElementById(id)?.checked ? 1 : 0;

        const newSettings = {
            form_id: currentFormId,
            category_id: currentFieldId,
            input_type: getVal('input_type'),
            label: getVal('label'),
            placeholder: getVal('placeholder'),
            tooltip: getVal('tooltip'),
            default_value: getVal('default_value'),
            is_required: getCheck('is_required'),
            validation_rules: getVal('validation_rules'),
            is_visible: getCheck('is_visible'),
            is_readonly: getCheck('is_readonly'),
            is_disabled: getCheck('is_disabled'),
            column_span: getVal('column_span') || '1',
            custom_css_class: getVal('custom_css_class'),
            position: parseInt(getVal('position')) || 0,
            group_name: getVal('group_name'),
            help_text: getVal('help_text'),
            icon: getVal('icon'),
            has_child: getCheck('has_child'),
            child_display_type: getVal('child_display_type'),
            condition_on: getVal('condition_on'),
            condition_value: getVal('condition_value'),

            // optional nested json object
            extra_settings: JSON.stringify({
                min: getVal('min') || null,
                max: getVal('max') || null,
                step: getVal('step') || null,
                custom_note: getVal('custom_note') || '',
            }),
        };

        console.log('Saving settings:', newSettings); // debug log

        fetch('/form-field-settings/save', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify(newSettings)
            })
            .then(async res => {
                const contentType = res.headers.get('content-type');
                if (contentType.includes('application/json')) {
                    const data = await res.json();
                    alert('Settings saved!');
                    location.reload();
                } else {
                    const text = await res.text();
                    console.error('Unexpected non-JSON response:', text);
                    alert('Unexpected response received.');
                }
            })
            .catch(err => {
                console.error('Save error:', err);
                alert('Error saving settings.');
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
    const activeSubTab = document.querySelector('.tab-pane.show.active[data-tab-id][data-sub-tab-id]');
    if (activeSubTab) {
        const tabId = activeSubTab.getAttribute('data-tab-id');
        const subTabId = activeSubTab.getAttribute('data-sub-tab-id');
        formData.append('tab_id', tabId);
        formData.append('sub_tab_id', subTabId);
    } else {
        alert('No active sub-tab found!');
        return;
    }


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