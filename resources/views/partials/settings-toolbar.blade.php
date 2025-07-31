<div class="col-md-12">
    <div class="">
        <div style="background-color: #f8f9fa;">

            <div class="row">
                <div class="col-md-12">

                    <div class="d-flex align-items-center">
                        <div class="align-items-center d-flex gap-1 justify-content-center btn-trans btn-trans p-2">
                            <i class="mdi mdi-filter-variant"></i>
                            <span>Filter</span>
                        </div>

                        <div class="align-items-center d-flex gap-1 justify-content-center btn-trans btn-trans p-2">
                            <i class="mdi mdi-sort-variant"></i>
                            <span>Sort</span>
                        </div>
                        <div class="ms-2 p-2">
                            <div class="input-group">
                                <input type="text" id="search" class="form-control m-0 bg-white"
                                    placeholder="Search categories...">
                                <button class="btn btn-primary" id="searchButton">Search</button>

                            </div>
                        </div>
                        <div class="align-items-center d-flex gap-1 justify-content-center btn-trans btn-trans p-2">
                            <i class="mdi mdi-chart-box-outline fs-4 icon-choice"></i>
                            <span> <a href="{{ route('form-report') }}">Report</a></span>
                        </div>

                        <div class="align-items-center d-flex gap-1 justify-content-center btn-trans btn-trans p-2">
                            <i class="mdi mdi-eye-check-outline fs-4 icon-choice" data-bs-toggle="modal"
                                data-bs-target="#permissionModal" style="cursor: pointer;"></i>
                            <span>Show/Hide</span>
                        </div>

                        <div class="align-items-center d-flex gap-1 justify-content-center btn-trans btn-trans p-2">
                            <i class="mdi mdi-code-tags fs-4 icon-choice"></i>
                            <span>Embed</span>
                        </div>

                        <div class="align-items-center d-flex gap-1 justify-content-center btn-trans btn-trans p-2">
                            <i class="mdi mdi-link fs-4 icon-choice"></i>
                            <span>Copy Link</span>
                        </div>

                        <div class="align-items-center d-flex gap-1 justify-content-center btn-trans btn-trans p-2">
                            <i class="mdi mdi-qrcode fs-4 icon-choice"></i>
                            <span>QR Code</span>
                        </div>

                        <div class="align-items-center d-flex gap-1 justify-content-center btn-trans btn-trans p-2">
                            <i class="mdi mdi-export fs-4 icon-choice"></i>
                            <span>Export</span>
                        </div>

                        <div class="align-items-center d-flex gap-1 justify-content-center btn-trans btn-trans p-2">
                            <i class="mdi mdi-import fs-4 icon-choice"></i>
                            <span>Import</span>
                        </div>

                        <div class="align-items-center d-flex gap-1 justify-content-center btn-trans btn-trans p-2">
                            <i class="mdi mdi-code-brackets fs-4 icon-choice"></i>
                            <span>Integrations</span>
                        </div>


                        <div class="align-items-center d-flex gap-1 justify-content-center btn-trans btn-trans p-2">
                            <i class="mdi mdi-api fs-4 icon-choice"></i>
                        </div>

                        <button type="button" 
                                class="btn btn-outline-primary btn-sm"
                                id="editBtn-{{ $child->id }}" 
                                onclick="toggleEdit('{{ $child->id }}')">
                            Edit Code 
                        </button>




                    </div>


                </div>
            </div>
        </div>
    </div>
</div>

