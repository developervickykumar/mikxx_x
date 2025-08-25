
<style>
.fade:not(.show) {
    display: none !important;
}

.nav-link {
    padding: 2px 10px;
    text-align: left;
}
</style>

<!-- Edit Category Modal -->
<div class="modal fade modal-lg" id="editCategoryModal" tabindex="-1" aria-labelledby="editCategoryModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCategoryModalLabel">Edit Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form id="editCategoryForm">
                    @csrf
                    <input type="hidden" id="edit_category_id">

                    <div class="row">
                        <!-- Vertical Tabs -->
                        <div class="col-md-3 border-end">
                            <div class="nav flex-column nav-pills" id="editCategoryTab" role="tablist"
                                aria-orientation="vertical">
                                <button class="nav-link active" id="edit-tab" data-bs-toggle="pill"
                                data-bs-target="#edit" type="button" role="tab">Edit</button>
                                 
                                <button class="nav-link" id="product-tab" data-bs-toggle="pill" data-bs-target="#product" type="button" role="tab" >Product</button>
                                <button class="nav-link" id="module-tab" data-bs-toggle="pill" data-bs-target="#module" type="button" role="tab" >Module</button>
                                <button class="nav-link" id="form-tab" data-bs-toggle="pill" data-bs-target="#form" type="button" role="tab">Form Settings</button>
                                <button class="nav-link" id="page_elements-tab" data-bs-toggle="pill" data-bs-target="#page_elements" type="button" role="tab">Page Elements</button>
                                <button class="nav-link" id="tools-tab" data-bs-toggle="pill" data-bs-target="#tools" type="button" role="tab">Tools</button>
                                 
                                    
                                <button class="nav-link" id="view-tab" data-bs-toggle="pill" data-bs-target="#view"
                                    type="button" role="tab">Display Settings</button>

                                <button class="nav-link" id="message-tab" data-bs-toggle="pill"
                                    data-bs-target="#message" type="button" role="tab">Message</button>
                                <button class="nav-link" id="notification-tab" data-bs-toggle="pill"
                                    data-bs-target="#notification" type="button" role="tab">Notifications</button>
                                <button class="nav-link" id="goods-and-service-tab" data-bs-toggle="pill"
                                    data-bs-target="#goods-and-service" type="button" role="tab">Goods &
                                    Service</button>
                                <button class="nav-link" id="code-tab" data-bs-toggle="pill" data-bs-target="#code"
                                    type="button" role="tab">Code</button>
                                <button class="nav-link" id="integration-tab" data-bs-toggle="pill"
                                    data-bs-target="#integration" type="button" role="tab">Integration</button>
                                
                                <button class="nav-link" id="size-tab" data-bs-toggle="pill" data-bs-target="#size"
                                    type="button" role="tab">Size</button>
                                <button class="nav-link" id="variants-tab" data-bs-toggle="pill"
                                    data-bs-target="#variants" type="button" role="tab">Variants</button>
                                <button class="nav-link" id="filters-tab" data-bs-toggle="pill"
                                    data-bs-target="#filters" type="button" role="tab">Filters</button>
                                <button class="nav-link" id="features-tab" data-bs-toggle="pill"
                                    data-bs-target="#features" type="button" role="tab">Features</button>
                                <button class="nav-link" id="specifications-tab" data-bs-toggle="pill"
                                    data-bs-target="#specifications" type="button" role="tab">Specifications</button>
                                <button class="nav-link" id="ratingsAndReviews-tab" data-bs-toggle="pill"
                                    data-bs-target="#ratingsAndReviews" type="button" role="tab">Rating Reviews</button>
                                <button class="nav-link" id="subscriptions-tab" data-bs-toggle="pill"
                                    data-bs-target="#subscriptions" type="button" role="tab">Subscriptions</button>
                                <button class="nav-link" id="keywords-tab" data-bs-toggle="pill"
                                    data-bs-target="#keywords" type="button" role="tab">Keywords</button>
                                <button class="nav-link" id="table-tab" data-bs-toggle="pill" data-bs-target="#table"
                                    type="button" role="tab">Table</button>
                                <button class="nav-link" id="media-tab" data-bs-toggle="pill" data-bs-target="#media"
                                    type="button" role="tab">Media</button>
                                <button class="nav-link" id="mapping-tab" data-bs-toggle="pill"
                                    data-bs-target="#mapping" type="button" role="tab">Mapping</button>
                            </div>
                        </div>

                        <!-- Tab Content -->
                        <div class="col-md-9">
                            <div class="tab-content" id="editCategoryTabContent">
                                <!-- Edit Tab -->
                                <div class="tab-pane fade show active" id="edit" role="tabpanel">
                                    <div class="row">
                                        <div class="mb-3 col-md-6">
                                            <label for="edit_name" class="form-label">Edit Category Name</label>
                                            <input type="text" class="form-control" id="edit_name" name="name" required>
                                        </div>

                                        <div class="mb-3 col-md-6">
                                            <label for="edit_level_name" class="form-label">Category Level
                                                Name</label>
                                            <input type="text" class="form-control" name="level_name"
                                                id="edit_level_name" value="Select Subcategory">
                                        </div>
                                        

                                        <div class="mb-3 col-md-6">
                                            <label for="labelSelect" class="form-label">Select App Label</label>
                                            <select name="label" id="labelSelect" class="form-control labelSelect">
                                                <option value="">Loading App Labels...</option>
                                            </select>
                                        </div>
                                        
                                        <!--<div class="mb-3 col-md-6">-->
                                        <!--    <label for="labelSelect" class="form-label">Select Label</label>-->
                                        <!--    <select name="label" id="edit_label" class="form-control">-->
                                        <!--        <option value="Home"> Home </option>-->
                                        <!--        <option value="Sector"> Sector </option>-->
                                        <!--        <option value="Department"> Department </option>-->
                                        <!--        <option value="Segment"> Segment</option>-->
                                        <!--        <option value="Page"> Page</option>-->
                                        <!--        <option value="Form"> Forms</option>-->
                                        <!--    </select>-->
                                        <!--</div>-->




                                       

                                        <div class="mb-3 col-md-12">
                                            <input type="checkbox" name="groupCategory" id="groupCategory" value="1">
                                            <label for="groupCategory" class="form-label mb-0">Add Group
                                                Categories</label><br>

                                            <input type="radio" name="group_view_type" value="Accordion"
                                                id="accordionView">
                                            <label for="accordionView">Accordion</label>

                                            <input type="radio" name="group_view_type" value="List" id="listView">
                                            <label for="listView">List</label>

                                            <input type="radio" name="group_view_type" value="Vertical Tab"
                                                id="verticalTab">
                                            <label for="verticalTab">Vertical Tab</label>

                                            <input type="radio" name="group_view_type" value="Horizontal Tab"
                                                id="horizontalTab">
                                            <label for="horizontalTab">Horizontal Tab</label>

                                            <input type="radio" name="group_view_type" value="Tile View" id="tileView">
                                            <label for="tileView">Tile View</label>

                                            <input type="radio" name="group_view_type" value="Result View"
                                                id="resultView">
                                            <label for="resultView">Result View</label>

                                            <p style="font-size:9px">User can create multiple categories by
                                                themselves</p>
                                        </div>

                                       


                                        <div class="mb-3 col-md-12">
                                            <label for="edit_description" class="form-label">Description</label>
                                            <textarea class="form-control" id="edit_description"
                                                name="description"></textarea>
                                        </div>

                                    </div>
                                </div>

                                <!--product tab-->

                                <div class="tab-pane fade" id="product" role="tabpanel">
                                    <!-- Product Type Section --> 
                                    <div class="mb-3 col-md-12">
                                        <label for="product_type" class="form-label">Product Type</label>
                                        <select class="form-select" name="price_list[product_type]" id="product_type">
                                            <option value="">Select Product Type</option>
                                            <option value="digital">Digital Product</option>
                                            <option value="service">Service</option>
                                            <option value="event">Event Ticket</option>
                                            <option value="saas">SaaS</option>
                                        </select>
                                    </div>
                                    
                                    <!-- Digital Fields -->
                                    <div id="digitalFields" class="product-fields" style="display: none;">
                                        <div class="row">
                                            <div class="mb-3 col-md-6">
                                                <label for="gift_value" class="form-label">Price / Value</label>
                                                <input type="number" step="0.01" name="price_list[value]" class="form-control">
                                            </div>
                                    
                                            <div class="mb-3 col-md-6">
                                                <label class="form-label">Value Type</label>
                                                <select name="price_list[value_type]" class="form-select">
                                                    <option value="coin">Coins</option>
                                                    <option value="money">Money</option>
                                                </select>
                                            </div>
                                    
                                            <div class="mb-3 col-md-6">
                                                <label class="form-label">Conversion Rate</label>
                                                <input type="number" step="0.01" name="price_list[conversion_rate]" class="form-control">
                                            </div>
                                    
                                            <div class="mb-3 col-md-6">
                                                <label class="form-label">Theme</label>
                                                <input type="text" name="price_list[theme]" class="form-control" placeholder="e.g., Valentine2025">
                                            </div>
                                    
                                            <div class="mb-3 col-md-6">
                                                <label class="form-label">Is Collectible?</label>
                                                <select name="price_list[is_collectible]" class="form-select">
                                                    <option value="1">Yes</option>
                                                    <option value="0">No</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Service Fields -->
                                    <div id="serviceFields" class="product-fields" style="display: none;">
                                        <div class="row">
                                            <div class="mb-3 col-md-6">
                                                <label class="form-label">Service Duration (in days)</label>
                                                <input type="number" name="price_list[service_duration]" class="form-control">
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label class="form-label">Service Area</label>
                                                <input type="text" name="price_list[service_area]" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Event Fields -->
                                    <div id="eventFields" class="product-fields" style="display: none;">
                                        <div class="row">
                                            <div class="mb-3 col-md-6">
                                                <label class="form-label">Event Date</label>
                                                <input type="date" name="price_list[event_date]" class="form-control">
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label class="form-label">Event Location</label>
                                                <input type="text" name="price_list[event_location]" class="form-control">
                                            </div>
                                        </div>
                                    </div>


                                </div>
                                
                                <script>
                                    document.addEventListener('DOMContentLoaded', function () {
                                        const productTypeSelect = document.getElementById('product_type');
                                        const allFields = document.querySelectorAll('.product-fields');
                                
                                        productTypeSelect.addEventListener('change', function () {
                                            const selectedType = this.value;
                                
                                            allFields.forEach(group => group.style.display = 'none');
                                
                                            if (selectedType === 'digital') {
                                                document.getElementById('digitalFields').style.display = 'block';
                                            } else if (selectedType === 'service') {
                                                document.getElementById('serviceFields').style.display = 'block';
                                            } else if (selectedType === 'event') {
                                                document.getElementById('eventFields').style.display = 'block';
                                            }
                                            // You can add more like `saasFields` similarly
                                        });
                                    });
                                </script> 

                                
                                <div class="tab-pane fade" id="module" role="tabpanel">
                                    <!-- Module Type Section -->
                                    <div class="row">
                                        <div class="mb-3 col-md-12">
                                            <label for="module_type" class="form-label">Module Type</label>
                                            <select class="form-select" name="module_type" id="module_type">
                                                <option value="">Select Module Type</option>
                                                <option value="utility">Utility</option>
                                                <option value="download">Download</option>
                                                <option value="generator">Generator</option>
                                                <option value="calculator">Calculator</option>
                                                <option value="integration">Integration</option>
                                                <option value="management">Management</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                
                                 
                                <div class="tab-pane fade" id="page_elements" role="tabpanel">
                                    <!-- Page Elements Section -->
                                    <div class="row">
                                        <div class="mb-3 col-md-12">
                                            <label for="page_element_type" class="form-label">Page Element Type</label>
                                            <select class="form-select" name="page_element_type" id="page_element_type">
                                                <option value="">Select Element Type</option>
                                                <option value="input">Input</option>
                                                <option value="datetime">Date and Time</option>
                                                <option value="category">Category</option>
                                                <option value="table">Table</option>
                                                <option value="others">Others</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="tab-pane fade" id="tools" role="tabpanel">
                                    <!-- Tools Section -->
                                    <div class="row">
                                        <div class="mb-3 col-md-12">
                                            <label for="tool_type" class="form-label">Tool Type</label>
                                            <select class="form-select" name="tool_type" id="tool_type">
                                                <option value="">Select Tool Type</option>
                                                <option value="text">Text</option>
                                                <option value="object">Object</option>
                                                <option value="shapes">Shapes</option>
                                                <option value="others">Others</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- View Tab -->
                                <div class="tab-pane fade" id="view" role="tabpanel">
                                    <div class="row">
                                        <div class="mb-3 col-md-12">
                                            <label for="page_display_type" class="form-label">Page Display</label>
                                            <select class="form-select" name="page_display_type" id="page_display_type">
                                                <option value="User">User</option>
                                                <option value="Page">Page</option>
                                            </select>

                                            <label class="form-label">Display At</label>
                                            <div class="d-flex flex-wrap gap-2">
                                                <div><input type="checkbox" name="display_at[]" value="Left Menu">
                                                    Left Menu</div>
                                                <div><input type="checkbox" name="display_at[]" value="Right Menu">
                                                    Right Menu</div>
                                                <div><input type="checkbox" name="display_at[]" value="Right Accordion">
                                                    Right Accordion</div>
                                                <div><input type="checkbox" name="display_at[]" value="Center">
                                                    Center</div>
                                            </div>
                                        </div>


                                        <div class="mb-3 col-md-12">

                                            <label for="">Select Subscription Type</label>

                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="status"
                                                    value="default" id="statusDefault">
                                                <label class="form-check-label" for="statusDefault">Default</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="status"
                                                    value="premium" id="statusPremium">
                                                <label class="form-check-label" for="statusPremium">Premium</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="status"
                                                    value="enterprices" id="statusEnterprices">
                                                <label class="form-check-label"
                                                    for="statusEnterprices">Enterprices</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="status"
                                                    value="admin" id="statusAdmin">
                                                <label class="form-check-label" for="statusAdmin">Admin</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Message Tab -->
                                <div class="tab-pane fade" id="message" role="tabpanel">
                                    <div class="row">
                                        <div class="mb-3 col-md-6">
                                            <label for="edit_user_message" class="form-label">User</label>
                                            <input type="text" class="form-control" id="edit_user_message"
                                                name="user_message">
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label for="edit_own_message" class="form-label">Own</label>
                                            <input type="text" class="form-control" id="edit_own_message"
                                                name="own_message">
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label for="edit_custom_message" class="form-label">Custom</label>
                                            <input type="text" class="form-control" id="edit_custom_message"
                                                name="custom_message">
                                        </div>
                                    </div>
                                </div>

                                <!-- Notifications Tab -->
                                <div class="tab-pane fade" id="notification" role="tabpanel">
                                    <div class="row">
                                        <div class="mb-3 col-md-6">
                                            <label for="edit_user_notification" class="form-label">User</label>
                                            <input type="text" class="form-control" id="edit_user_notification"
                                                name="user_notification">
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label for="edit_own_notification" class="form-label">Own</label>
                                            <input type="text" class="form-control" id="edit_own_notification"
                                                name="own_notification">
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label for="edit_custom_notification" class="form-label">Custom</label>
                                            <input type="text" class="form-control" id="edit_custom_notification"
                                                name="custom_notification">
                                        </div>
                                    </div>
                                </div>


                                <div class="tab-pane fade" id="goods-and-service" role="tabpanel">


                                    <div class="container">
                                        <!-- Nav Tabs -->
                                        <ul class="nav nav-tabs" id="goodsServiceTabs" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <a class="nav-link active" id="owned-tab" data-bs-toggle="tab"
                                                    href="#owned" role="tab" aria-controls="owned"
                                                    aria-selected="true">Owned</a>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <a class="nav-link" id="suggestions-tab" data-bs-toggle="tab"
                                                    href="#suggestions" role="tab" aria-controls="suggestions"
                                                    aria-selected="false">Suggestions</a>
                                            </li>
                                        </ul>

                                        <!-- Tab Panes -->
                                        <div class="tab-content mt-3" id="goodsServiceTabsContent">
                                            <!-- Owned Tab Pane -->
                                            <div class="tab-pane fade show active" id="owned" role="tabpanel"
                                                aria-labelledby="owned-tab">


                                                <div class="row">


                                                    <div class="mb-3 col-md-6">
                                                        <label for="owned-goods" class="form-label">Goods</label>
                                                        <input type="text" name="advanced[goods_services][owned_goods]"
                                                            id="owned-goods" class="form-control">

                                                    </div>
                                                    <div class="mb-3 col-md-6">
                                                        <label for="owned-services" class="form-label">Services</label>
                                                        <input type="text"
                                                            name="advanced[goods_services][owned_services]"
                                                            id="owned-services" class="form-control">
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Suggestions Tab Pane -->
                                            <div class="tab-pane fade" id="suggestions" role="tabpanel"
                                                aria-labelledby="suggestions-tab">
                                                <div class="row">
                                                    <div class="mb-3 col-md-6">
                                                        <label for="suggestions-goods" class="form-label">Goods</label>
                                                        <input type="text"
                                                            name="advanced[goods_services][suggestions_goods]"
                                                            id="suggestions-goods" class="form-control">
                                                    </div>
                                                    <div class="mb-3 col-md-6">
                                                        <label for="suggestions-services"
                                                            class="form-label">Services</label>
                                                        <input type="text"
                                                            name="advanced[goods_services][suggestions_services]"
                                                            id="suggestions-services" class="form-control">
                                                    </div>
                                                    <div class="mb-3 col-md-6">
                                                        <label for="suggestions-machinery"
                                                            class="form-label">Machinery</label>
                                                        <input type="text" class="form-control"
                                                            id="suggestions-machinery" name="suggestions-machinery">
                                                    </div>
                                                    <div class="mb-3 col-md-6">
                                                        <label for="suggestions-tools" class="form-label">Tools</label>
                                                        <input type="text" class="form-control" id="suggestions-tools"
                                                            name="suggestions-tools">
                                                    </div>
                                                    <div class="mb-3 col-md-6">
                                                        <label for="suggestions-vendors"
                                                            class="form-label">Vendors</label>
                                                        <input type="text" class="form-control" id="suggestions-vendors"
                                                            name="suggestions-vendors">
                                                    </div>
                                                    <div class="mb-3 col-md-6">
                                                        <label for="suggestions-profile-type" class="form-label">Profile
                                                            Type</label>
                                                        <input type="text" class="form-control"
                                                            id="suggestions-profile-type"
                                                            name="suggestions-profile-type">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </div>

                                <div class="tab-pane fade" id="code" role="tabpanel">
                                    <div class="mb-3 col-md-12">
                                        <label for="edit_price_list" class="form-label">Write Code</label>
                                        <textarea name="code" id="edit_code_area" class="form-control"
                                            style="height:300%"></textarea>
                                    </div>
                                </div>
                                <!-- Form Tab -->
                                <div class="tab-pane fade" id="form" role="tabpanel">
                                    
                                    <div class="row">
                                    
                                        <div class="mb-3 col-md-6">
                                            <label for="form_type" class="form-label">Form Type</label>
                                            <select class="form-select form-control" name="form_type" id="form_type">
                                                <option value="">Select Form Type</option>
                                                <option value="user">User Form</option>
                                                <option value="business">Business Form</option>
                                                <option value="module">Module Form</option>
                                                <option value="public">Public Form</option>
                                            </select>
                                        </div>
                                        
                                        <div class="mb-3 col-md-6">
                                            <label for="edit_create_form" class="form-label">Form Name</label>
                                            <input type="text" name="form_name" class="form-control" id="edit_create_form">
    
                                        </div>
                                        @php
                                            use App\Models\Category;
                                            $fieldType = Category::where('parent_id',134510)
                                            ->with('child')
                                            ->get();
                                        @endphp
                                        <div class="mb-3 col-md-6">
                                            <label for="edit_functionality_select" class="form-label">Functionality</label>
                                            <select name="functionality" id="edit_functionality_select" class="form-control">
                                                @foreach($fieldType as $field)
                                                <optgroup label="{{$field->name}}">
                                                    @foreach($field->child as $field)
                                                    <option value="{{$field->id}}">{{$field->name}}</option>
                                                    @endforeach
                                                </optgroup>
                                                @endforeach
                                           
                                            </select>
    
                                        </div>
    
    
    
                                            @include('backend.category.partials.conditions', ['conditions' =>
                                            $category->conditions ?? []])
    
    
                                             <div class="mb-3 col-md-6">
                                                <label for="edit_validation" class="form-label">Validation</label>
                                                <input type="text" class="form-control" id="edit_validation"
                                                    name="validation">
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="edit_tooltip" class="form-label">Tooltip</label>
                                                <input type="text" class="form-control" id="edit_tooltip" name="tooltip">
                                            </div>
    
    
                                            <div class="mb-3 col-md-12">
    
                                                <input type="checkbox" name="allow_user_options" id="allow_user_options">
                                                <label for="allow_user_options" class="form-label mb-0">Add
                                                    Options</label>
                                                <p style="font-size:9px">User can add categories by themselves</p>
                                            </div>
    
    
                                             <div class="mb-3 col-md-12">
                                                <input type="checkbox" name="create_form_enabled" id="createFormCheckbox"
                                                    class="form-check-input">
    
                                                <label for="createFormCheckbox" class="form-label">Create Form</label>
                                                <a class="fs-6 ms-2">Preview Form</a>
                                                <div class="mt-2" id="formNameWrapper" style="display:none;">
                                                    <label for="formName" class="form-label">Form Name</label>
                                                    <input type="text" name="form_name" id="formName" class="form-control">
                                                </div>
                                            </div>
                                    </div>

                                </div>

                                <!-- Integration Tab -->
                                <div class="tab-pane fade" id="integration" role="tabpanel">

                                    <div>

                                        <div id="integration_container"></div>
                                        <button type="button" class="btn btn-sm btn-primary mt-2"
                                            onclick="addIntegration()">+ Add Integration</button>
                                    </div>


                                    <script>
                                    let integrationCount = 0;

                                    // Detect when the Integration tab is shown
                                    document.addEventListener("DOMContentLoaded", function() {
                                        addIntegration();
                                        const integrationTab = document.querySelector(
                                            'a[data-bs-target="#integration"]');

                                        if (integrationTab) {
                                            integrationTab.addEventListener('shown.bs.tab', function() {
                                                const container = document.getElementById(
                                                    'integration_container');
                                                if (container.childElementCount === 0) {
                                                    addIntegration
                                                        (); // Add default integration only once
                                                }
                                            });
                                        }
                                    });

                                    function addIntegration(index = integrationCount++, data = {}) {
                                        const container = document.getElementById('integration_container');
                                        const html = `
                                            <div class="border p-3 mb-2 rounded">
                                                <h5>Category: <strong>${currentCategoryName || 'Unknown Category'}</strong></h5>
                                                <h6>Integration #${index + 1}</h6>
                                                <input name="integrations[${index}][name]" value="${data.name || ''}" class="form-control mb-2" placeholder="Integration Name">
                                                <select name="integrations[${index}][type]" class="form-select mb-2">
                                                    <option value="">Select Type</option>
                                                    <option value="script" ${data.type === 'script' ? 'selected' : ''}>Script</option>
                                                    <option value="webhook" ${data.type === 'webhook' ? 'selected' : ''}>Webhook URL</option>
                                                    <option value="api_key" ${data.type === 'api_key' ? 'selected' : ''}>API Key</option>
                                                    <option value="oauth" ${data.type === 'oauth' ? 'selected' : ''}>OAuth Token</option>
                                                </select>
                                                <input name="integrations[${index}][code]" value="${data.code || ''}" class="form-control mb-2" placeholder="Code / URL / Key">
                                                <textarea name="integrations[${index}][description]" class="form-control mb-2" placeholder="Description">${data.description || ''}</textarea>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="integrations[${index}][enabled]" value="1" ${data.enabled ? 'checked' : ''}>
                                                    <label class="form-check-label">Enable</label>
                                                </div>
                                                <button type="button" class="btn btn-sm btn-danger mt-2" onclick="this.closest('.border').remove()">Remove</button>
                                            </div>
                                        `;
                                        container.insertAdjacentHTML('beforeend', html);
                                    }
                                    </script>





                                </div>

                                <div class="tab-pane fade" id="module-tab" role="tabpanel">
                                    <ul class="nav nav-tabs w-100" id="moduleTabs" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link active" id="user-module-tab" data-bs-toggle="tab"
                                                href="#user" role="tab" aria-controls="user"
                                                aria-selected="true">User</a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link" id="page-module-tab" data-bs-toggle="tab" href="#page"
                                                role="tab" aria-controls="page" aria-selected="false">Page</a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link" id="crm-module-tab" data-bs-toggle="tab" href="#crm"
                                                role="tab" aria-controls="crm" aria-selected="false">CRM</a>
                                        </li>
                                    </ul>

                                    <!-- Tab Content -->
                                    <div class="tab-content mt-3">
                                        <!-- User Tab -->
                                        <div class="tab-pane fade show active" id="user" role="tabpanel"
                                            aria-labelledby="user-module-tab">
                                            <div class="accordion" id="userAccordion">
                                                <!-- Accordion Item 1 -->
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="userHeadingOne">
                                                        <button class="accordion-button" type="button"
                                                            data-bs-toggle="collapse" data-bs-target="#userCollapseOne"
                                                            aria-expanded="true" aria-controls="userCollapseOne">
                                                            Section 1
                                                        </button>
                                                    </h2>
                                                    <div id="userCollapseOne" class="accordion-collapse collapse show"
                                                        aria-labelledby="userHeadingOne"
                                                        data-bs-parent="#userAccordion">
                                                        <div class="accordion-body">
                                                            <label><input type="checkbox" /> Checkbox 1</label><br>
                                                            <label><input type="checkbox" /> Checkbox 2</label><br>
                                                            <label><input type="checkbox" /> Checkbox 3</label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Accordion Item 2 -->
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="userHeadingTwo">
                                                        <button class="accordion-button collapsed" type="button"
                                                            data-bs-toggle="collapse" data-bs-target="#userCollapseTwo"
                                                            aria-expanded="false" aria-controls="userCollapseTwo">
                                                            Section 2
                                                        </button>
                                                    </h2>
                                                    <div id="userCollapseTwo" class="accordion-collapse collapse"
                                                        aria-labelledby="userHeadingTwo"
                                                        data-bs-parent="#userAccordion">
                                                        <div class="accordion-body">
                                                            <label><input type="checkbox" /> Checkbox 4</label><br>
                                                            <label><input type="checkbox" /> Checkbox 5</label><br>
                                                            <label><input type="checkbox" /> Checkbox 6</label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Accordion Item 3 -->
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="userHeadingThree">
                                                        <button class="accordion-button collapsed" type="button"
                                                            data-bs-toggle="collapse"
                                                            data-bs-target="#userCollapseThree" aria-expanded="false"
                                                            aria-controls="userCollapseThree">
                                                            Section 3
                                                        </button>
                                                    </h2>
                                                    <div id="userCollapseThree" class="accordion-collapse collapse"
                                                        aria-labelledby="userHeadingThree"
                                                        data-bs-parent="#userAccordion">
                                                        <div class="accordion-body">
                                                            <label><input type="checkbox" /> Checkbox 7</label><br>
                                                            <label><input type="checkbox" /> Checkbox 8</label><br>
                                                            <label><input type="checkbox" /> Checkbox 9</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Page Tab -->
                                        <div class="tab-pane fade" id="page" role="tabpanel"
                                            aria-labelledby="page-module-tab">
                                            <div class="accordion" id="pageAccordion">
                                                <!-- Accordion Item 1 -->
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="pageHeadingOne">
                                                        <button class="accordion-button" type="button"
                                                            data-bs-toggle="collapse" data-bs-target="#pageCollapseOne"
                                                            aria-expanded="true" aria-controls="pageCollapseOne">
                                                            Page Section 1
                                                        </button>
                                                    </h2>
                                                    <div id="pageCollapseOne" class="accordion-collapse collapse show"
                                                        aria-labelledby="pageHeadingOne"
                                                        data-bs-parent="#pageAccordion">
                                                        <div class="accordion-body">
                                                            <label><input type="checkbox" /> Checkbox A</label><br>
                                                            <label><input type="checkbox" /> Checkbox B</label><br>
                                                            <label><input type="checkbox" /> Checkbox C</label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Accordion Item 2 -->
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="pageHeadingTwo">
                                                        <button class="accordion-button collapsed" type="button"
                                                            data-bs-toggle="collapse" data-bs-target="#pageCollapseTwo"
                                                            aria-expanded="false" aria-controls="pageCollapseTwo">
                                                            Page Section 2
                                                        </button>
                                                    </h2>
                                                    <div id="pageCollapseTwo" class="accordion-collapse collapse"
                                                        aria-labelledby="pageHeadingTwo"
                                                        data-bs-parent="#pageAccordion">
                                                        <div class="accordion-body">
                                                            <label><input type="checkbox" /> Checkbox D</label><br>
                                                            <label><input type="checkbox" /> Checkbox E</label><br>
                                                            <label><input type="checkbox" /> Checkbox F</label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Accordion Item 3 -->
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="pageHeadingThree">
                                                        <button class="accordion-button collapsed" type="button"
                                                            data-bs-toggle="collapse"
                                                            data-bs-target="#pageCollapseThree" aria-expanded="false"
                                                            aria-controls="pageCollapseThree">
                                                            Page Section 3
                                                        </button>
                                                    </h2>
                                                    <div id="pageCollapseThree" class="accordion-collapse collapse"
                                                        aria-labelledby="pageHeadingThree"
                                                        data-bs-parent="#pageAccordion">
                                                        <div class="accordion-body">
                                                            <label><input type="checkbox" /> Checkbox G</label><br>
                                                            <label><input type="checkbox" /> Checkbox H</label><br>
                                                            <label><input type="checkbox" /> Checkbox I</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- CRM Tab -->
                                        <div class="tab-pane fade" id="crm" role="tabpanel"
                                            aria-labelledby="crm-module-tab">
                                            <div class="accordion" id="crmAccordion">
                                                <!-- Accordion Item 1 -->
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="crmHeadingOne">
                                                        <button class="accordion-button" type="button"
                                                            data-bs-toggle="collapse" data-bs-target="#crmCollapseOne"
                                                            aria-expanded="true" aria-controls="crmCollapseOne">
                                                            CRM Section 1
                                                        </button>
                                                    </h2>
                                                    <div id="crmCollapseOne" class="accordion-collapse collapse show"
                                                        aria-labelledby="crmHeadingOne" data-bs-parent="#crmAccordion">
                                                        <div class="accordion-body">
                                                            <label><input type="checkbox" /> Checkbox X</label><br>
                                                            <label><input type="checkbox" /> Checkbox Y</label><br>
                                                            <label><input type="checkbox" /> Checkbox Z</label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Accordion Item 2 -->
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="crmHeadingTwo">
                                                        <button class="accordion-button collapsed" type="button"
                                                            data-bs-toggle="collapse" data-bs-target="#crmCollapseTwo"
                                                            aria-expanded="false" aria-controls="crmCollapseTwo">
                                                            CRM Section 2
                                                        </button>
                                                    </h2>
                                                    <div id="crmCollapseTwo" class="accordion-collapse collapse"
                                                        aria-labelledby="crmHeadingTwo" data-bs-parent="#crmAccordion">
                                                        <div class="accordion-body">
                                                            <label><input type="checkbox" /> Checkbox P</label><br>
                                                            <label><input type="checkbox" /> Checkbox Q</label><br>
                                                            <label><input type="checkbox" /> Checkbox R</label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Accordion Item 3 -->
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="crmHeadingThree">
                                                        <button class="accordion-button collapsed" type="button"
                                                            data-bs-toggle="collapse" data-bs-target="#crmCollapseThree"
                                                            aria-expanded="false" aria-controls="crmCollapseThree">
                                                            CRM Section 3
                                                        </button>
                                                    </h2>
                                                    <div id="crmCollapseThree" class="accordion-collapse collapse"
                                                        aria-labelledby="crmHeadingThree"
                                                        data-bs-parent="#crmAccordion">
                                                        <div class="accordion-body">
                                                            <label><input type="checkbox" /> Checkbox U</label><br>
                                                            <label><input type="checkbox" /> Checkbox V</label><br>
                                                            <label><input type="checkbox" /> Checkbox W</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                @php
                                $unitCategory = \App\Models\Category::getCategoryTreeByName('Unit');
                                @endphp

                                <div class="tab-pane fade" id="size" role="tabpanel">
                                    <!-- Main Unit Selection -->
                                    <select name="unit_id" id="unit_id" class="form-select">
                                        <option value="">Select Unit</option>
                                        @if($unitCategory)
                                        @foreach($unitCategory->children as $child)
                                        <option value="{{ $child->id }}" data-name="{{ $child->name }}">
                                            {{ $child->name }}
                                        </option>
                                        @endforeach
                                        @endif
                                    </select>

                                    <!-- Select how many inputs -->
                                    <select name="field_count" id="field_count" class="form-select mt-2">
                                        <option value="">Select Number of Input Fields</option>
                                        @for($i = 1; $i <= 3; $i++) <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                    </select>

                                    <!-- Dynamic Fields Container -->
                                    <div id="dynamic_fields" class="mt-3 d-block w-100"></div>

                                    <div>
                                        <input type="radio" class="mt-2" name="editable_type" id="editable"
                                            value="editable">
                                        <label for="editable" class="mt-2">Editable</label>


                                        <input type="radio" class="mt-2 ms-2" name="editable_type" id="non_editable"
                                            value="non_editable">
                                        <label for="non_editable" class="mt-2">Non Editable</label>
                                    </div>



                                </div>

                                <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    let selectedChildCategories = [];

                                    // Event listener for changes in the 'unit_id' or 'field_count' select elements
                                    document.addEventListener('change', function(e) {
                                        const unitId = document.getElementById('unit_id').value;
                                        const fieldCount = parseInt(document.getElementById(
                                            'field_count').value);
                                        const dynamicFieldsDiv = document.getElementById(
                                            'dynamic_fields');

                                        // If the unit selection changes
                                        if (e.target.id === 'unit_id' && unitId) {
                                            fetch(`/admin/category/${unitId}/children`)
                                                .then(res => res.json())
                                                .then(data => {
                                                    selectedChildCategories = data;
                                                    renderInputFields(fieldCount,
                                                        selectedChildCategories);
                                                });
                                        }

                                        // If the number of fields selection changes
                                        if (e.target.id === 'field_count' && unitId) {
                                            renderInputFields(fieldCount, selectedChildCategories);
                                        }
                                    });

                                    // Function to render input fields based on the selected count
                                    function renderInputFields(count, units) {
                                        const dynamicFieldsDiv = document.getElementById('dynamic_fields');
                                        if (!count || !units || units.length === 0) return;

                                        // Clear the previous dynamic fields
                                        dynamicFieldsDiv.innerHTML = '';

                                        // Generate input rows with title + value
                                        for (let i = 0; i < count; i++) {
                                            const row = document.createElement('div');
                                            row.className = 'd-flex gap-2 mb-2';

                                            // Title input
                                            const titleInput = document.createElement('input');
                                            titleInput.type = 'text';
                                            titleInput.name = `unit_inputs[${i}][title]`;
                                            titleInput.placeholder = 'Enter Title';
                                            titleInput.className = 'form-control w-50';

                                            // Value input
                                            const valueInput = document.createElement('input');
                                            valueInput.type = 'text';
                                            valueInput.name = `unit_inputs[${i}][value]`;
                                            valueInput.placeholder = 'Enter Value';
                                            valueInput.className = 'form-control w-50';

                                            row.appendChild(titleInput);
                                            row.appendChild(valueInput);
                                            dynamicFieldsDiv.appendChild(row);
                                        }

                                        // Single unit dropdown for all inputs
                                        const unitRow = document.createElement('div');
                                        unitRow.className = 'mb-3';

                                        const select = document.createElement('select');
                                        select.name = 'common_unit_id';
                                        select.className = 'form-select';
                                        select.innerHTML = `<option value="">Select Unit</option>`;

                                        units.forEach(unit => {
                                            select.innerHTML +=
                                                `<option value="${unit.id}">${unit.name}</option>`;
                                        });

                                        unitRow.appendChild(select);
                                        dynamicFieldsDiv.appendChild(unitRow);
                                    }
                                });
                                </script>

                                <!-- Variant Tab -->
                                <div class="tab-pane fade" id="variants" role="tabpanel">

                                    <!-- Static initial variant fields -->
                                    <div id="variant_container">
                                        <div class="row g-2 mb-2 border p-2 rounded">
                                            <div class="col"><input name="variants[0][name]" value="Size"
                                                    placeholder="Variant Name" class="form-control" /></div>
                                            <div class="col"><input name="variants[0][price]" value="10.00"
                                                    placeholder="Price" class="form-control" /></div>
                                            <div class="col"><input name="variants[0][stock]" value="100"
                                                    placeholder="Stock" class="form-control" /></div>
                                            <div class="col"><button type="button"
                                                    onclick="this.closest('.row').remove()"
                                                    class="btn btn-danger btn-sm">Remove</button></div>
                                        </div>
                                        <div class="row g-2 mb-2 border p-2 rounded">
                                            <div class="col"><input name="variants[1][name]" value="Color"
                                                    placeholder="Variant Name" class="form-control" /></div>
                                            <div class="col"><input name="variants[1][price]" value="15.00"
                                                    placeholder="Price" class="form-control" /></div>
                                            <div class="col"><input name="variants[1][stock]" value="50"
                                                    placeholder="Stock" class="form-control" /></div>
                                            <div class="col"><button type="button"
                                                    onclick="this.closest('.row').remove()"
                                                    class="btn btn-danger btn-sm">Remove</button></div>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-primary mt-2" onclick="addVariant()">+
                                        Add Variant</button>
                                </div>

                                <!-- Filter Tab -->
                                <div class="tab-pane fade" id="filters" role="tabpanel">

                                    <!-- Static initial filter fields -->
                                    <div id="filter_container" class="w-100">
                                        <div class="row g-2 mb-2">
                                            <div class="col"><input name="filters[0][label]" value="Material"
                                                    placeholder="Filter Label" class="form-control" /></div>
                                            <div class="col"><input name="filters[0][value]" value="Cotton"
                                                    placeholder="Filter Value" class="form-control" /></div>
                                            <div class="col"><button type="button"
                                                    onclick="this.closest('.row').remove()"
                                                    class="btn btn-danger btn-sm">Remove</button></div>
                                        </div>
                                        <div class="row g-2 mb-2">
                                            <div class="col"><input name="filters[1][label]" value="Size"
                                                    placeholder="Filter Label" class="form-control" /></div>
                                            <div class="col"><input name="filters[1][value]" value="L"
                                                    placeholder="Filter Value" class="form-control" /></div>
                                            <div class="col"><button type="button"
                                                    onclick="this.closest('.row').remove()"
                                                    class="btn btn-danger btn-sm">Remove</button></div>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-primary mt-2" onclick="addFilter()">+
                                        Add Filter</button>
                                </div>

                                <!-- Features Tab -->
                                <div class="tab-pane fade" id="features" role="tabpanel">

                                    <!-- Static initial feature fields -->
                                    <div id="feature_container" class="w-100">
                                        <div class="row g-2 mb-2">
                                            <div class="col"><input name="features[0]" value="Waterproof"
                                                    placeholder="Feature (e.g., Waterproof)" class="form-control" />
                                            </div>
                                            <div class="col"><button type="button"
                                                    onclick="this.closest('.row').remove()"
                                                    class="btn btn-danger btn-sm">Remove</button></div>
                                        </div>
                                        <div class="row g-2 mb-2">
                                            <div class="col"><input name="features[1]" value="Eco-friendly"
                                                    placeholder="Feature (e.g., Waterproof)" class="form-control" />
                                            </div>
                                            <div class="col"><button type="button"
                                                    onclick="this.closest('.row').remove()"
                                                    class="btn btn-danger btn-sm">Remove</button></div>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-primary mt-2" onclick="addFeature()">+
                                        Add Feature</button>
                                </div>

                                <script>
                                // Variant Counter
                                let variantCount = 2; // Since we already have 2 variants
                                // Filter Counter
                                let filterCount = 2; // Since we already have 2 filters
                                // Feature Counter
                                let featureCount = 2; // Since we already have 2 features

                                // Add Variant Function
                                function addVariant() {
                                    const container = document.getElementById('variant_container');
                                    const index = variantCount++;
                                    const html = `
                                                <div class="row g-2 mb-2 border p-2 rounded">
                                                    <div class="col"><input name="variants[${index}][name]" placeholder="Variant Name" class="form-control" /></div>
                                                    <div class="col"><input name="variants[${index}][price]" placeholder="Price" class="form-control" /></div>
                                                    <div class="col"><input name="variants[${index}][stock]" placeholder="Stock" class="form-control" /></div>
                                                    <div class="col"><button type="button" onclick="this.closest('.row').remove()" class="btn btn-danger btn-sm">Remove</button></div>
                                                </div>
                                            `;
                                    container.insertAdjacentHTML('beforeend', html);
                                }

                                // Add Filter Function
                                function addFilter() {
                                    const container = document.getElementById('filter_container');
                                    const index = filterCount++;
                                    const html = `
                                            <div class="row g-2 mb-2">
                                                <div class="col"><input name="filters[${index}][label]" placeholder="Filter Label" class="form-control" /></div>
                                                <div class="col"><input name="filters[${index}][value]" placeholder="Filter Value" class="form-control" /></div>
                                                <div class="col"><button type="button" onclick="this.closest('.row').remove()" class="btn btn-danger btn-sm">Remove</button></div>
                                            </div>
                                        `;
                                    container.insertAdjacentHTML('beforeend', html);
                                }

                                // Add Feature Function
                                function addFeature() {
                                    const container = document.getElementById('feature_container');
                                    const index = featureCount++;
                                    const html = `
                                                    <div class="row g-2 mb-2">
                                                        <div class="col"><input name="features[${index}]" placeholder="Feature (e.g., Waterproof)" class="form-control" /></div>
                                                        <div class="col"><button type="button" onclick="this.closest('.row').remove()" class="btn btn-danger btn-sm">Remove</button></div>
                                                    </div>
                                                `;
                                    container.insertAdjacentHTML('beforeend', html);
                                }
                                </script>

                                <div class="tab-pane fade" id="specifications" role="tabpanel">

                                    <div id="default_spec_container" class="w-100">
                                        <div class="row g-2 mb-2">
                                            <div class="col"><input name="default_specifications[key][]"
                                                    placeholder="Particular" class="form-control" /></div>
                                            <div class="col"><input name="default_specifications[value][]"
                                                    placeholder="Description" class="form-control" /></div>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-primary" onclick="addDefaultSpec()">+
                                        Add Row</button>

                                    <script>
                                    function addDefaultSpec() {
                                        const container = document.getElementById('default_spec_container');
                                        const html = `
                                            <div class="row g-2 mb-2">
                                                <div class="col"><input name="default_specifications[key][]" placeholder="Particular" class="form-control" /></div>
                                                <div class="col"><input name="default_specifications[value][]" placeholder="Description" class="form-control" /></div>
                                            </div>`;
                                        container.insertAdjacentHTML('beforeend', html);
                                    }
                                    </script>

                                </div>

                                <div class="tab-pane fade" id="keywords" role="tabpanel">
                                    <div class="d-block w-100 p-2">
                                        <h5 class="mt-4">SEO Details</h5>

                                        <div class="mb-3">
                                            <label for="meta_title" class="form-label">Meta Title</label>
                                            <input type="text" name="meta_title" id="meta_title" class="form-control"
                                                placeholder="Enter Meta Title (Optional)">
                                        </div>

                                        <div class="mb-3">
                                            <label for="meta_description" class="form-label">Meta Description</label>
                                            <textarea name="meta_description" id="meta_description" class="form-control"
                                                rows="3"
                                                placeholder="Enter a short description for search engines"></textarea>
                                        </div>

                                        <div class="mb-3">
                                            <label for="meta_keywords" class="form-label">Meta Keywords</label>
                                            <input type="text" name="meta_keywords" id="meta_keywords"
                                                class="form-control"
                                                placeholder="Comma separated keywords (e.g. shoes, men, nike)">
                                        </div>


                                    </div>

                                </div>

                                <div class="tab-pane fade" id="ratingsAndReviews" role="tabpanel">

                                    <div class="mb-3 w-100">
                                        <label for="review_text" class="form-label">Rating Parameters</label>
                                        <textarea name="review_text" id="review_text" class="form-control" rows="4"
                                            placeholder="Eg, durability, color, size ..."></textarea>
                                    </div>




                                </div>

                                <div class="tab-pane fade" id="subscriptions" role="tabpanel">


                                    <div id="subscription_container"></div>
                                    <button type="button" class="btn btn-sm btn-primary mt-2"
                                        onclick="addSubscriptionPlan()">+ Add Subscription Plan</button>


                                    <script>
                                    window.onload = function() {
                                        addSubscriptionPlan(); // Automatically adds one plan when the page loads
                                    };
                                    let subscriptionCount = 0;

                                    function addSubscriptionPlan(index = subscriptionCount++, plan = {}) {
                                        const container = document.getElementById('subscription_container');
                                        const html = `
                                            <div class="border p-3 rounded mb-3">
                                                <h6>Subscription Plan #${index + 1}</h6>
                                                <div class="mb-2">
                                                    <input name="subscription_plans[${index}][title]" class="form-control" value="${plan.title || ''}" placeholder="Plan Title">
                                                </div>
                                                <div class="row g-2 mb-2">
                                                    <div class="col-md-4">
                                                        <select name="subscription_plans[${index}][type]" class="form-select">
                                                            <option value="">Select Type</option>
                                                            <option value="trial" ${plan.type === 'trial' ? 'selected' : ''}>Trial</option>
                                                            <option value="monthly" ${plan.type === 'monthly' ? 'selected' : ''}>Monthly</option>
                                                            <option value="yearly" ${plan.type === 'yearly' ? 'selected' : ''}>Yearly</option>
                                                            <option value="lifetime" ${plan.type === 'lifetime' ? 'selected' : ''}>Lifetime</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <input type="number" step="0.01" name="subscription_plans[${index}][price]" class="form-control" value="${plan.price || ''}" placeholder="Price">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <input type="number" name="subscription_plans[${index}][duration]" class="form-control" value="${plan.duration || ''}" placeholder="Duration (days)">
                                                    </div>
                                                </div>
                                                <div class="mb-2">
                                                    <textarea name="subscription_plans[${index}][description]" rows="2" class="form-control" placeholder="Description">${plan.description || ''}</textarea>
                                                </div>
                                                <div>
                                                    <label>Plan Features</label>
                                                    <div id="feature_wrapper_${index}"></div>
                                                    <button type="button" class="btn btn-sm btn-secondary mt-2" onclick="addFeatureRow(${index})">+ Add Feature</button>
                                                </div>
                                                <button type="button" class="btn btn-sm btn-danger mt-3" onclick="this.closest('.border').remove()">Remove Plan</button>
                                            </div>
                                        `;
                                        container.insertAdjacentHTML('beforeend', html);

                                        if (Array.isArray(plan.features)) {
                                            plan.features.forEach(f => addFeatureRow(index, f));
                                        }
                                    }
                                    </script>

                                    <script>
                                    function addFeatureRow(planIndex, value = '') {
                                        const featureWrapper = document.getElementById(`feature_wrapper_${planIndex}`);
                                        const inputHTML = `
                                            <div class="d-flex gap-2 mb-2">
                                                <input type="text" name="subscription_plans[${planIndex}][features][]" class="form-control" value="${value}" placeholder="Enter feature (e.g. Access to videos)">
                                                <button type="button" class="btn btn-sm btn-danger" onclick="this.parentElement.remove()">Remove</button>
                                            </div>
                                        `;
                                        featureWrapper.insertAdjacentHTML('beforeend', inputHTML);
                                    }
                                    </script>





                                </div>

                                <div class="tab-pane fade" id="table" role="tabpanel">
                                    <div class="row">
                                        <div class="mb-3 col-md-12">
                                            <label for="page_display_type" class="form-label">Page Display</label>
                                            <select class="form-select" name="page_display_type" id="page_display_type">
                                                <option value="User">User</option>
                                                <option value="Page">Page</option>
                                            </select>

                                            <label class="form-label">Display At</label>
                                            <div class="d-flex flex-wrap gap-2">
                                                <div><input type="checkbox" name="display_at[]" value="Left Menu">
                                                    Left Menu</div>
                                                <div><input type="checkbox" name="display_at[]" value="Right Menu">
                                                    Right Menu</div>
                                                <div><input type="checkbox" name="display_at[]" value="Right Accordion">
                                                    Right Accordion</div>
                                                <div><input type="checkbox" name="display_at[]" value="Center">
                                                    Center</div>
                                            </div>
                                        </div>


                                    </div>
                                </div>

                                <div class="tab-pane fade" id="media" role="tabpanel">
                                    <div class="row">
                                        <div class="mb-3 col-md-12">
                                            @include('backend.components.media-uploader', [
                                            'inputId' => "mediaInput-edit", // STATIC input ID for modal editing
                                            'categoryId' => null, // We'll fetch this dynamically via JS
                                            'uploadUrl' => route('category.media.upload')
                                            ])


                                        </div>


                                    </div>
                                </div>

                                <div class="tab-pane fade" id="mapping" role="tabpanel">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <input type="hidden" name="product_mappings_json"
                                                id="product_mappings_json">

                                            <!-- Product Section -->
                                            <label class="label" for="productInput">Add Products
                                                (comma-separated)</label>
                                            <input class="form-control" type="text" id="productInput"
                                                placeholder="e.g. Fridge, Microwave, Washing Machine..."
                                                autocomplete="off" />
                                            <!-- 💡 Suggestions -->
                                            <div id="productSuggestions"
                                                style="border: 1px solid #ccc; background: #fff; max-height: 150px; overflow-y: auto; display: none; position: absolute; z-index: 10;">
                                            </div>

                                            <!-- Chips Display -->
                                            <div class="chip-container" id="productChips"
                                                style="display: flex; flex-wrap: wrap; gap: 8px; margin-top: 10px;">
                                            </div>


                                            <div class="output-box mt-3" id="productOutput"
                                                style="background: #f8f9fa; padding: 10px; border: 1px dashed #ccc;">
                                            </div>

                                            <script>
                                            let selectedProducts = [];
                                            let allProducts = [];

                                            async function fetchAllProducts() {
                                                if (allProducts.length === 0) {
                                                    const [res1, res2] = await Promise.all([
                                                        fetch(
                                                            '/admin/categories/children-by-name/Households'
                                                        ),
                                                        fetch(
                                                            '/admin/categories/children-by-name/Industrial Products'
                                                        )
                                                    ]);

                                                    const [data1, data2] = await Promise.all([res1.json(), res2
                                                        .json()
                                                    ]);

                                                    const merged = [];

                                                    if (data1.status) merged.push(...data1.children);
                                                    if (data2.status) merged.push(...data2.children);

                                                    allProducts = merged;
                                                }

                                                return allProducts;
                                            }


                                            function renderProductSuggestions(matches) {
                                                const suggestionBox = document.getElementById("productSuggestions");
                                                suggestionBox.innerHTML = "";
                                                if (matches.length === 0) {
                                                    suggestionBox.style.display = "none";
                                                    return;
                                                }
                                                matches.forEach(product => {
                                                    const div = document.createElement("div");
                                                    div.style.padding = "8px";
                                                    div.style.cursor = "pointer";
                                                    div.textContent =
                                                        `${product.name} (${product.level_name || "Product"})`;
                                                    div.onclick = () => {
                                                        addProductChip(product);
                                                        document.getElementById("productInput").value = "";
                                                        suggestionBox.style.display = "none";
                                                    };
                                                    suggestionBox.appendChild(div);
                                                });
                                                suggestionBox.style.display = "block";
                                            }

                                            function addProductChip(product) {
                                                const exists = selectedProducts.find(p => p.name.toLowerCase() ===
                                                    product.name.toLowerCase());
                                                if (!exists) {
                                                    selectedProducts.push({
                                                        id: product.id,
                                                        name: product.name,
                                                        category: product.level_name || product.parent_name ||
                                                            "Product"
                                                    });
                                                    renderProductChips();
                                                }
                                            }

                                            document.getElementById("productInput").addEventListener("input",
                                                async function(e) {
                                                    const value = e.target.value.trim();
                                                    if (value.length === 0) {
                                                        document.getElementById("productSuggestions").style
                                                            .display = "none";
                                                        return;
                                                    }

                                                    const products = await fetchAllProducts();
                                                    const matches = products.filter(p => p.name.toLowerCase()
                                                        .startsWith(value.toLowerCase()));
                                                    renderProductSuggestions(matches);
                                                });

                                            document.getElementById("productInput").addEventListener("keydown",
                                                async function(e) {
                                                    if (e.key === "," || e.key === "Enter") {
                                                        e.preventDefault();
                                                        const input = e.target.value.trim().replace(/,$/, "");
                                                        if (input) {
                                                            const product = allProducts.find(p => p.name
                                                                .toLowerCase() === input.toLowerCase());
                                                            if (product) {
                                                                addProductChip(product);
                                                            } else {
                                                                alert(`Product not found: "${input}"`);
                                                            }
                                                        }
                                                        e.target.value = "";
                                                        document.getElementById("productSuggestions").style
                                                            .display = "none";
                                                    }
                                                });

                                            function renderProductChips() {
                                                const chipBox = document.getElementById("productChips");
                                                chipBox.innerHTML = "";
                                                selectedProducts.forEach((product, i) => {
                                                    const chip = document.createElement("div");
                                                    chip.className = "chip";
                                                    chip.style =
                                                        "display: inline-flex; align-items: center; padding: 6px 12px; background-color: #e8f5e9; border-radius: 20px; font-size: 14px; border: 1px solid #66bb6a;";
                                                    chip.innerHTML =
                                                        `${product.name}  <span class="remove" onclick="removeProductChip(${i})" style="margin-left: 8px; cursor: pointer; color: red;">&times;</span>`;
                                                    chipBox.appendChild(chip);
                                                });
                                            }

                                            function removeProductChip(index) {
                                                selectedProducts.splice(index, 1);
                                                renderProductChips();
                                            }

                                            function saveProductData() {
                                                if (selectedProducts.length === 0) {
                                                    // alert("Please select at least one product");
                                                    return;
                                                }

                                                // Prepare data
                                                const mappedProducts = selectedProducts.map(p => ({
                                                    id: p.id,
                                                    name: p.name,
                                                    category: p.category
                                                }));

                                                // Store in hidden input
                                                document.getElementById("product_mappings_json").value = JSON.stringify(
                                                    mappedProducts);

                                                // Optional debug
                                                document.getElementById("productOutput").innerText =
                                                    "Saved Products:\n" + JSON.stringify(mappedProducts, null, 2);
                                            }


                                            // Close suggestions if clicked outside
                                            document.addEventListener("click", function(e) {
                                                const box = document.getElementById("productSuggestions");
                                                if (!box.contains(e.target) && e.target.id !== "productInput") {
                                                    box.style.display = "none";
                                                }
                                            });
                                            </script>



                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="status" id="edit_status">
                    <div class="mt-4 text-end">
                        <button class="btn btn-primary" type="submit">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Category Modal -->
<!-- <div class="modal fade modal-lg" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProductModalLabel">Edit Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div> -->

            <!--<div class="mb-3">-->
            <!--    <label class="form-label fw-semibold d-block mb-2">Product Core Option:</label>-->
            <!--    <div class="form-check form-check-inline">-->
            <!--        <input class="form-check-input" type="radio" name="product_core_option" id="productRadio" value="product">-->
            <!--        <label class="form-check-label" for="productRadio">Product</label>-->
            <!--    </div>-->
            <!--    <div class="form-check form-check-inline">-->
            <!--        <input class="form-check-input" type="radio" name="product_core_option" id="serviceRadio" value="service">-->
            <!--        <label class="form-check-label" for="serviceRadio">Service</label>-->
            <!--    </div>-->
            <!--    <div class="form-check form-check-inline">-->
            <!--        <input class="form-check-input" type="radio" name="product_core_option" id="rentalRadio" value="rental">-->
            <!--        <label class="form-check-label" for="rentalRadio">Rental</label>-->
            <!--    </div>-->
            <!--    <div class="form-check form-check-inline">-->
            <!--        <input class="form-check-input" type="radio" name="product_core_option" id="eventRadio" value="event">-->
            <!--        <label class="form-check-label" for="eventRadio">Event</label>-->
            <!--    </div>-->
            <!--    <div class="form-check form-check-inline">-->
            <!--        <input class="form-check-input" type="radio" name="product_core_option" id="saasRadio" value="saas">-->
            <!--        <label class="form-check-label" for="saasRadio">SaaS</label>-->
            <!--    </div>-->
            <!--</div>-->

            <!--<div class="row">-->
            <!--     <div class="mb-3  col-md-3">-->
            <!--        <label class="form-label fw-semibold">Master Category</label>-->
            <!--        <select class="form-select" name="master_category_id" id="masterCategory">-->
            <!--            <option value="">Select Master Category</option>-->
            <!-- Populate via AJAX or backend -->
            <!--        </select>-->
            <!--    </div>-->

            <!--    <div class="mb-3 col-md-3">-->
            <!--        <label class="form-label fw-semibold">Main Category</label>-->
            <!--        <select class="form-select" name="main_category_id" id="mainCategory">-->
            <!--            <option value="">Select Main Category</option>-->
            <!--        </select>-->
            <!--    </div>-->

            <!--    <div class="mb-3 col-md-3">-->
            <!--        <label class="form-label fw-semibold">Category</label>-->
            <!--        <select class="form-select" name="category_id" id="category">-->
            <!--            <option value="">Select Category</option>-->
            <!--        </select>-->
            <!--    </div>-->

            <!--    <div class="mb-3 col-md-3">-->
            <!--        <label class="form-label fw-semibold">Subcategory</label>-->
            <!--        <select class="form-select" name="subcategory_id" id="subcategory">-->
            <!--            <option value="">Select Subcategory</option>-->
            <!--        </select>-->
            <!--    </div>-->

            <!-- 🔧 Specifications (Key-Value Pairs) -->
            <!--    <div class="mb-3">-->
            <!--        <label class="form-label fw-semibold d-block">Specifications</label>-->
            <!--        <div id="specContainer"></div>-->
            <!--        <button type="button" class="btn btn-sm btn-outline-primary mt-2" onclick="addSpecification()">+ Add Specification</button>-->
            <!--    </div>-->

            <!-- ✨ Features (Single Input List) -->
            <!--    <div class="mb-3">-->
            <!--        <label class="form-label fw-semibold d-block">Features</label>-->
            <!--        <div id="featureContainer"></div>-->
            <!--        <button type="button" class="btn btn-sm btn-outline-primary mt-2" onclick="addFeature()">+ Add Feature</button>-->
            <!--    </div>-->

            <!-- 🎨 Variants (Title + Option List) -->
            <!--    <div class="mb-3">-->
            <!--        <label class="form-label fw-semibold d-block">Variants</label>-->
            <!--        <div id="variantContainer"></div>-->
            <!--        <button type="button" class="btn btn-sm btn-outline-primary mt-2" onclick="addVariant()">+ Add Variant</button>-->
            <!--    </div>-->





            <!--</div>-->


            <!-- <div class="modal-body">

                <label class="label" for="brandInput">Add Brands (comma-separated)</label>
                <input type="text" id="brandInput" placeholder="e.g. LG, Samsung, Whirlpool..." autocomplete="off" />
                <div id="brandSuggestions"
                    style="border: 1px solid #ccc; background: #fff; max-height: 150px; overflow-y: auto; display: none; position: absolute; z-index: 10;">
                </div>
                <div class="chip-container" id="brandChips"
                    style="display: flex; flex-wrap: wrap; gap: 8px; margin-top: 10px;"></div>
                    <div class="row">-->

                <!--    <div class="col-md-3">-->
                <!--         <label for="edit_functionality" class="form-label">Select Category</label>-->

                <!--          <select name="functionality" id="edit_functionality" class="form-control">-->

                <!--              <option value="Checkbox">Electronics</option>-->
                <!--              <option value="MultiSelect">Clothing</option>-->

                <!--          </select>-->
                <!--    </div>-->

                <!--     <div class="col-md-9">-->

                <!--     </div>-->
                <!--</div>- 




                <button onclick="saveBrandData()" class="btn btn-primary mt-3">Save Brand Mapping</button>

                <div class="output-box mt-3" id="brandOutput"
                    style="background: #f8f9fa; padding: 10px; border: 1px dashed #ccc;"></div>

                <script>
                let selectedBrands = [];
                let allBrands = [];

                async function fetchAllBrands() {
                    if (allBrands.length === 0) {
                        const res = await fetch('/admin/categories/children-by-name/Brands');
                        const data = await res.json();
                        if (data.status) {
                            allBrands = data.children;
                        }
                    }
                    return allBrands;
                }

                function renderSuggestions(matches) {
                    const suggestionBox = document.getElementById("brandSuggestions");
                    suggestionBox.innerHTML = "";
                    if (matches.length === 0) {
                        suggestionBox.style.display = "none";
                        return;
                    }
                    matches.forEach(brand => {
                        const div = document.createElement("div");
                        div.style.padding = "8px";
                        div.style.cursor = "pointer";
                        div.textContent = `${brand.name} (${brand.level_name || "Brand"})`;
                        div.onclick = () => {
                            addBrandChip(brand);
                            document.getElementById("brandInput").value = "";
                            suggestionBox.style.display = "none";
                        };
                        suggestionBox.appendChild(div);
                    });
                    suggestionBox.style.display = "block";
                }

                function addBrandChip(brand) {
                    const exists = selectedBrands.find(p => p.name.toLowerCase() === brand.name.toLowerCase());
                    if (!exists) {
                        selectedBrands.push({
                            id: brand.id,
                            name: brand.name,
                            category: brand.level_name || brand.parent_name || "Brand"
                        });
                        renderBrandChips();
                    }
                }

                document.getElementById("brandInput").addEventListener("input", async function(e) {
                    const value = e.target.value.trim();
                    if (value.length === 0) {
                        document.getElementById("brandSuggestions").style.display = "none";
                        return;
                    }

                    const brands = await fetchAllBrands();
                    const matches = brands.filter(b => b.name.toLowerCase().startsWith(value
                        .toLowerCase()));
                    renderSuggestions(matches);
                });

                document.getElementById("brandInput").addEventListener("keydown", async function(e) {
                    if (e.key === "," || e.key === "Enter") {
                        e.preventDefault();
                        const input = e.target.value.trim().replace(/,$/, "");
                        if (input) {
                            const brand = allBrands.find(b => b.name.toLowerCase() === input.toLowerCase());
                            if (brand) {
                                addBrandChip(brand);
                            } else {
                                alert(`Brand not found: "${input}"`);
                            }
                        }
                        e.target.value = "";
                        document.getElementById("brandSuggestions").style.display = "none";
                    }
                });

                function renderBrandChips() {
                    const chipBox = document.getElementById("brandChips");
                    chipBox.innerHTML = "";
                    selectedBrands.forEach((brand, i) => {
                        const chip = document.createElement("div");
                        chip.className = "chip";
                        chip.style =
                            "display: inline-flex; align-items: center; padding: 6px 12px; background-color: #fce4ec; border-radius: 20px; font-size: 14px; border: 1px solid #ec407a;";
                        chip.innerHTML =
                            `${brand.name} (${brand.category}) <span class="remove" onclick="removeBrandChip(${i})" style="margin-left: 8px; cursor: pointer; color: red;">&times;</span>`;
                        chipBox.appendChild(chip);
                    });
                }

                function removeBrandChip(index) {
                    selectedBrands.splice(index, 1);
                    renderBrandChips();
                }

                function saveBrandData() {
                    if (selectedBrands.length === 0) {
                        alert("Please select at least one brand");
                        return;
                    }

                    const output = {
                        brand_ids: selectedBrands.map(p => p.id),
                        brands: selectedBrands
                    };

                    document.getElementById("brandOutput").innerText = "Saved Brands:\n" + JSON.stringify(output, null,
                        2);
                }

                // Close suggestions if clicked outside
                document.addEventListener("click", function(e) {
                    const box = document.getElementById("brandSuggestions");
                    if (!box.contains(e.target) && e.target.id !== "brandInput") {
                        box.style.display = "none";
                    }
                });
                </script>

            </div>

        </div>
    </div>
</div>-->


<!-- <div class="modal fade modal-lg" id="editServiceModal" tabindex="-1" aria-labelledby="editServiceModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editServiceModalLabel">Edit Service</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">

            </div>


        </div>
    </div>
</div> -->

 
 
<div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Select Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="statusForm">
                    @csrf
                    <input type="hidden" name="category_id" id="statusCategoryId">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" value="default" id="statusDefault">
                        <label class="form-check-label" for="statusDefault">Default</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" value="premium" id="statusPremium">
                        <label class="form-check-label" for="statusPremium">Premium</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" value="enterprices"
                            id="statusEnterprices">
                        <label class="form-check-label" for="statusEnterprices">Enterprices</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" value="admin" id="statusAdmin">
                        <label class="form-check-label" for="statusAdmin">Admin</label>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="editDynamicPageModal" tabindex="-1" aria-labelledby="editDynamicPageLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editDynamicPageLabel">Edit Dynamic Page</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

        <ul class="nav nav-tabs" id="dynamicTabs">
          <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tab-route">Route</button></li>
          <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-controller">Controller</button></li>
          <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-view">View</button></li>
          <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-model">Model</button></li>
        </ul>

        <div class="tab-content mt-2">

            <div class="tab-pane fade show active" id="tab-route">
              <label class="form-label mt-2">Routes Template:</label>
              <textarea id="routeEditor" class="form-control" rows="15"></textarea>
            </div>
            
            <div class="tab-pane fade" id="tab-controller">
              <label class="form-label mt-2">Controller Methods:</label>
              <textarea id="controllerEditor" class="form-control" rows="15"></textarea>
            </div>
            
            <div class="tab-pane fade" id="tab-view">
              <label for="viewType" class="form-label mt-2">Select View Type:</label>
              <select class="form-select mb-2" id="viewType" onchange="updateViewTemplate()">
                <option value="form">Form</option>
                <option value="table">Table</option>
                <option value="report">Report</option>
                <option value="custom">Custom</option>
              </select>
              <textarea id="viewEditor" class="form-control" rows="15"></textarea>
            </div>
            
            <div class="tab-pane fade" id="tab-model">
              <label class="form-label mt-2">Model Template:</label>
              <textarea id="modelEditor" class="form-control" rows="15"></textarea>
            </div>

        </div>

        <div class="mt-3">
          <input type="text" id="pageSlug" class="form-control mb-2" placeholder="Enter Page Slug (e.g. services/seo)">
          <button class="btn btn-success" onclick="saveDynamicPageFiles()">Save All</button>
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="saveDynamicPage()">Save</button>
      </div>
    </div>
  </div>
</div>
