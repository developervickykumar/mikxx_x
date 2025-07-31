<style>
.iconContainer div {
    width: 50px;
}

.icon-box {
    cursor: pointer;
    border: 1px solid #eee;
    border-radius: 10px;
    padding: 10px;
    transition: 0.2s ease;
}

.icon-box:hover {
    background-color: #f8f9fa;
    transform: scale(1.05);
}

.tab-content>.active {
    display: flex;
    flex-wrap: wrap;
}
</style>

<div class="modal fade" id="iconSelectionModal" tabindex="-1" aria-labelledby="iconSelectionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title w-25">Select Icon</h5>
                <input type="text" id="iconSearch" class="form-control w-75" placeholder="Search icon...">
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-tabs mb-3" id="iconTabs" role="tablist">
                    <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#dripicons">Dripicons</button></li>
                    <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#boxicons">Boxicons</button></li>
                    <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#fontawesome">FontAwesome</button></li>
                    <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#materialdesign">Material Design</button></li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane fade show active" id="dripicons"><div class="row iconContainer" id="dripiconsContainer"></div></div>
                    <div class="tab-pane fade" id="boxicons"><div class="row iconContainer" id="boxiconsContainer"></div></div>
                    <div class="tab-pane fade" id="fontawesome"><div class="row iconContainer" id="fontawesomeContainer"></div></div>
                    <div class="tab-pane fade" id="materialdesign"><div class="row iconContainer" id="materialdesignContainer"></div></div>
                </div>
            </div>
        </div>
    </div>
</div>
