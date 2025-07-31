<style>
.custom-dropdown {
    position: relative;
    display: inline-block;
}

.dropdown-menu {
    padding: 0;
    box-shadow: none;
}

.dropdown-menu-custom {
    position: absolute;
    top: 100%;
    left: 0;
    z-index: 1000;
    display: none;
    background-color: #fff;
    border: 1px solid #ddd;
    padding: 0.5rem;
    width: 220px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.dropdown-menu-custom.show {
    display: block;
}

.dropdown-menu-custom .dropdown-item {
    padding: 5px 10px;
    cursor: pointer;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.dropdown-menu-custom .dropdown-item input {
    border: none;
    background: #f8f9fa;
    width: 70%;
    padding: 0;
    margin: 0;
    outline: none;
    cursor: text;
}

.dropdown-menu-custom input[type="text"]#newOptionInput {
    margin-top: 10px;
    padding: 5px;
    width: 100%;
    border: 1px solid #ccc;
}

#dropdownTrigger {
    cursor: pointer;
    padding: 5px;
    /* border: 1px solid #ccc; */
    border-radius: 5px;
    min-width: 130px;
}

#selectedOption {
    font-size: 14px;
    font-weight: 500;
    color: #adadad;
}

.label-heading {
    font-weight: 600;
    font-size: 14px;
    /* margin-bottom: 5px; */
}
</style>


<style>
.custom-dropdown {
    position: relative;
    display: inline-block;
}

.dropdown-menu {
    padding: 0;
    box-shadow: none;
}

.dropdown-menu-custom {
    position: absolute;
    top: 100%;
    left: 0;
    z-index: 1000;
    display: none;
    background-color: #fff;
    border: 1px solid #ddd;
    padding: 0.5rem;
    width: 220px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.dropdown-menu-custom.show {
    display: block;
}

.dropdown-menu-custom .dropdown-item {
    padding: 5px 10px;
    cursor: pointer;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.dropdown-menu-custom .dropdown-item input {
    border: none;
    background: #f8f9fa;
    width: 70%;
    padding: 0;
    margin: 0;
    outline: none;
    cursor: text;
}

.dropdown-menu-custom input[type="text"]#newOptionInput {
    margin-top: 10px;
    padding: 5px;
    width: 100%;
    border: 1px solid #ccc;
}

#dropdownTrigger {
    cursor: pointer;
    padding: 5px;
    /* border: 1px solid #ccc; */
    border-radius: 5px;
    min-width: 130px;
}

#selectedOption {
    font-size: 14px;
    font-weight: 500;
    color: #adadad;
}

.label-heading {
    font-weight: 600;
    font-size: 14px;
    /* margin-bottom: 5px; */
}
</style>

<div class="modal fade" id="createSubcategoryModal" tabindex="-1" aria-labelledby="createSubcategoryModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createSubcategoryModalLabel">Add Subcategory</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">


                <form id="createSubCategoryForm">
                    @csrf
                    <input type="hidden" name="category_parent_id" id="category_parent_id">

                    <div class="mb-3">
                        <label for="category_parent_name" class="form-label">Parent Category</label>
                        <input type="text" class="form-control" id="category_parent_name" disabled>
                    </div>


                    <div class="mb-1">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <label for="name" class="form-label">Subcategory Name</label>
                            </div>

                            <!-- <div class="custom-dropdown">
                                <div id="dropdownTrigger">
                                    <span id="selectedOption">Categorize Level</span>
                                    <i class="mdi mdi-chevron-down ms-2"></i>
                                </div>

                                <input type="hidden" name="level_name" id="levelNameInput" value="Categorize Level">

                                <div id="dropdownMenu" class="dropdown-menu-custom">
                                    <div id="dropdownOptions">
                                        <div class="dropdown-item"><input type="text" value="Categorize Level" /></div>
                                        <div class="dropdown-item"><input type="text" value="Option A"
                                                class="editable-option" /></div>
                                        <div class="dropdown-item"><input type="text" value="Option B"
                                                class="editable-option" /></div>
                                    </div>
                                    <input type="text" id="newOptionInput" placeholder="Add new option and hit enter" />
                                </div>
                            </div> -->



                        </div>
                    </div>



                    <!--<textarea class="form-control @error('name') is-invalid @enderror" id="name" name="name"-->
                    <!--    required> {{ old('name') }}</textarea>-->
                    <!--<small class="">-->
                    <!--    Bulk Add: Cat, Apple, Dog-->
                    <!--</small>-->
                    
                    
                   <ul class="nav nav-tabs" id="subcategoryModeTabs" role="tablist">
                      <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="bulk-tab" data-bs-toggle="tab" data-bs-target="#bulk-mode" type="button" role="tab" aria-controls="bulk-mode" aria-selected="true">Bulk</button>
                      </li>
                      <li class="nav-item" role="presentation">
                        <button class="nav-link" id="single-tab" data-bs-toggle="tab" data-bs-target="#single-mode" type="button" role="tab" aria-controls="single-mode" aria-selected="false">Single</button>
                      </li>
                    </ul>
                    
                    <div class="tab-content mt-2">
                      <div class="tab-pane fade show active" id="bulk-mode" role="tabpanel" aria-labelledby="bulk-tab">
                        <textarea class="form-control" name="bulk_names">{{ old('bulk_names') }}</textarea>
                        <small class="text-muted">Bulk Add: Separate values with commas (e.g., Cat, Apple, Dog)</small>
                      </div>
                      <div class="tab-pane fade" id="single-mode" role="tabpanel" aria-labelledby="single-tab">
                        <input type="text" class="form-control" name="single_name" value="{{ old('single_name') }}" placeholder="Enter subcategory name" />
                      </div>
                    </div>



                    <!-- <input type="text" class="form-control" id="name" name="name" required placeholder="Enter category name"> -->

            </div>


            <button class="btn btn-primary m-2" type="submit">Create Subcategory</button>
            </form>
        </div>
    </div>
</div>
