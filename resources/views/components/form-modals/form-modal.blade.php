

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
                            <button class="nav-link" id="tab-cta-premium-tab" data-bs-toggle="pill"
                                data-bs-target="#tab-cta-premium" type="button" role="tab"
                                aria-controls="tab-cta-premium" aria-selected="false">Make Premium</button>
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
                            <button class="nav-link" id="tab-fields-tab" data-bs-toggle="pill"
                                data-bs-target="#tab-fields" type="button" role="tab" aria-controls="tab-fields"
                                aria-selected="false">Add Fields</button>
                        </div>
                    </div>

                    <div class="col-md-9">
                        <!-- Tab Content Area -->
                        <div class="tab-content" id="postSettingsTabsContent">
                            <div class="tab-pane fade show active" id="tab-basic-post-setting" role="tabpanel"
                                aria-labelledby="tab-basic-tab">
                                <h6>Post Buttons</h6>


                                <div class="mb-3">
                                    <label class="form-label d-block"><strong>Select Post Buttons</strong></label>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="btnLike" checked
                                            value="Like">
                                        <label class="form-check-label" for="btnLike">Like</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="btnComment" value="Comment"
                                            checked>
                                        <label class="form-check-label" for="btnComment">Comment</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="btnShare" value="Share"
                                            checked>
                                        <label class="form-check-label" for="btnShare">Share</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="btnGift" value="Gift"
                                            checked>
                                        <label class="form-check-label" for="btnGift">Gift</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="btnSave" value="Save"
                                            checked>
                                        <label class="form-check-label" for="btnSave">Save</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="btnEmbed" value="Embed"
                                            checked>
                                        <label class="form-check-label" for="btnEmbed">Embed</label>
                                    </div>
                                </div>

                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="datetime-local" id="schedulePostCheckbox">
                                    <label class="form-check-label" for="schedulePostCheckbox">Schedule Post</label>
                                </div>




                                @include('backend.post.partials.schedule')
                                @include('backend.post.partials.censorship')
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

                            <div class="tab-pane fade" id="tab-cta-premium" role="tabpanel"
                                aria-labelledby="tab-cta-premium-tab">

                                <form id="makePremiumForm" class="p-3 border rounded">
                                    <h5 class="mb-3">Make Premium Settings</h5>

                                    <!-- A. View Options -->
                                    <div class="mb-4">
                                        <label class="form-label d-block"><strong>A. View Options</strong></label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="viewOption"
                                                id="viewLifetime" value="lifetime" checked>
                                            <label class="form-check-label" for="viewLifetime">1. Lifetime</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="viewOption"
                                                id="viewOneTime" value="onetime">
                                            <label class="form-check-label" for="viewOneTime">2. One Time</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="viewOption"
                                                id="viewLimit" value="limit">
                                            <label class="form-check-label" for="viewLimit">3. Limit Views</label>
                                        </div>
                                        <input type="number" class="form-control mt-2" id="limitViewInput"
                                            placeholder="Enter view limit" style="display: none;">
                                    </div>

                                    <!-- B. Pay Options -->
                                    <div class="mb-4">
                                        <label class="form-label d-block"><strong>B. Pay Options</strong></label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="payGift" value="gift">
                                            <label class="form-check-label" for="payGift">1. Gifts</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="payCash" value="cash">
                                            <label class="form-check-label" for="payCash">2. Cash</label>
                                        </div>
                                        <input type="number" class="form-control mt-2" id="premiumAmount"
                                            placeholder="Enter required amount" required>
                                    </div>

                                    <!-- Submit Button -->
                                    <button type="submit" class="btn btn-primary">Save Setting</button>
                                </form>

                                <script>
                                // Show/hide limit view input when "Limit Views" is selected
                                document.querySelectorAll('input[name="viewOption"]').forEach(el => {
                                    el.addEventListener('change', () => {
                                        const isLimit = document.getElementById('viewLimit').checked;
                                        const limitInput = document.getElementById('limitViewInput');
                                        if (isLimit) {
                                            limitInput.style.display = 'block';
                                            limitInput.setAttribute('required', true);
                                        } else {
                                            limitInput.style.display = 'none';
                                            limitInput.removeAttribute('required');
                                            limitInput.value = '';
                                        }
                                    });
                                });

                                // Optional: Submit logic (console output for now)
                                document.getElementById('makePremiumForm').addEventListener('submit', function(e) {
                                    e.preventDefault();

                                    const selectedView = document.querySelector(
                                        'input[name="viewOption"]:checked').value;
                                    const limitViews = selectedView === 'limit' ? parseInt(document
                                        .getElementById('limitViewInput').value || 0) : null;
                                    const payOptions = [];
                                    if (document.getElementById('payGift').checked) payOptions.push('gift');
                                    if (document.getElementById('payCash').checked) payOptions.push('cash');
                                    const amount = parseFloat(document.getElementById('premiumAmount').value ||
                                        0);

                                    const premiumSettings = {
                                        view: selectedView,
                                        limit_views: limitViews,
                                        pay_modes: payOptions,
                                        amount: amount
                                    };

                                    console.log('Saved Premium Settings:', premiumSettings);

                                    // You can send this object via AJAX or form submission as needed
                                });
                                </script>



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

                            <div class="tab-pane fade" id="tab-fields" role="tabpanel" aria-labelledby="tab-fields-tab">
                                @include('backend.post.partials.form_fields')

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

                    <input type="hidden" id="currentFieldId" value="{{ $field->id }}"> 
                    <input type="hidden" id="formId" value="">
                        <div class="nav flex-column nav-pills" id="settings-tab" role="tablist"
                            aria-orientation="vertical">
                            <button class="text-start nav-link active" id="edit-tab" data-bs-toggle="pill"
                                data-bs-target="#edit" type="button" role="tab">Edit</button>

                            <button class="text-start nav-link" id="settings-tab" data-bs-toggle="pill"
                                data-bs-target="#settings" type="button" role="tab">Settings</button>

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

                                <!-- Edit Field -->
                                <div class="mb-3">
                                    <label for="edit_field" class="form-label">Edit Field</label>
                                    <input type="text" class="form-control" id="edit_field" name="edit_field"
                                        placeholder="Edit Field">
                                </div>

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

                                <div class="mb-3">
                                    <input type="checkbox" class="form-check-input" id="addMoreFunctionality"
                                        name="addMoreFunctionality">
                                    <label for="addMoreFunctionality" class="form-label ms-1">Add More</label>
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

                            </div>

                            <!-- Settings Tab -->

                            <div class="tab-pane fade" id="settings" role="tabpanel">
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
                <button type="button" class="btn btn-primary" id="saveSettingsBtn">Save changes</button>
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
                                <option value="post">Post</option>
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
