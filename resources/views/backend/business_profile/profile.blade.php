@extends('layouts.master')

@section('title')
@lang('translation.Profile')
@endsection

@section('content')
@component('components.breadcrumb')
@slot('li_1') Contacts @endslot
@slot('title') {{ ucfirst(Auth::user()->user_type) }} Profile @endslot
@endcomponent

<style>
.btn-trans:hover {
    background-color: #e3e3e3;
    border: none;
}

.nav .nav-item button.active {
    background-color: transparent;
    color: var(--bs-danger) !important;
}

.nav .nav-item button.active::after {
    content: "";
    border-bottom: 4px solid var(--bs-danger);
    width: 100%;
    position: absolute;
    left: 0;
    bottom: -1px;
    border-radius: 5px 5px 0 0;
}
</style>

<div class="container p-5">
    <div class="row">
        <ul class="nav nav-pills mb-3 border-bottom border-2" id="pills-tab" role="tablist">
            @foreach($details as $index=>$group)
            <li class="nav-item" role="presentation">
                <button class="nav-link text-primary fw-semibold active position-relative" id="pills-home-tab"
                    data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab"
                    aria-controls="pills-home" aria-selected="true">{{$group->name}}</button>
            </li>
            @endforeach

        </ul>
    </div>
    <div class="row">
        <div class="col-md-2 col-lg-2">
            <div class="tab-content border rounded-3 border-primary p-3 text-danger" id="pills-tabContent">

                <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                    <ul class="nav nav-pills mb-3 border-bottom border-2" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link text-primary fw-semibold active position-relative" id="home"
                                data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab"
                                aria-controls="pills-home" aria-selected="true">Home</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link text-primary fw-semibold position-relative" id="pills-profile-tab"
                                data-bs-toggle="pill" data-bs-target="#pills" type="button" role="tab"
                                aria-controls="pills-profile" aria-selected="false">Profile</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link text-primary fw-semibold position-relative" id="pills-contact-tab"
                                data-bs-toggle="pill" data-bs-target="#pills-contact" type="button" role="tab"
                                aria-controls="pills-contact" aria-selected="false">Contact</button>
                        </li>
                    </ul>
                </div>

            </div>
        </div>
        <div class="col-md-10 col-lg-10">
            <div class="tab-content border rounded-3 border-primary p-3 text-danger" id="pills-tabContent">
                <div class="tab-pane fade " id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                    <p> Lorem ipsum itia in alias illum sunt. </p>
                </div>

                <div class="tab-pane fade " id="pills" role="tabpanel" aria-labelledby="pills-profile-tab">

                    <p> Lorem ipsum itia in alias illum home </p>
                </div>
                <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
                    <h2>Contact</h2>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function renderIframeContent(html, frameId) {
    const iframe = document.getElementById(frameId);
    if (!iframe) return;

    const doc = iframe.contentDocument || iframe.contentWindow.document;
    const textarea = document.createElement('textarea');
    textarea.innerHTML = html;
    const unescapedHTML = textarea.value;

    doc.open();
    doc.write(unescapedHTML);
    doc.close();
}

function combineCodeParts(id) {
    const html = document.getElementById('htmlInput_' + id)?.value || '';
    const css = document.getElementById('cssInput_' + id)?.value || '';
    const js = document.getElementById('jsInput_' + id)?.value || '';

    const finalCode = html + '\n<style>\n' + css + '\n</style>' + '\n<script>\n' + js + '\n<\/script>';
    const hiddenField = document.getElementById('html_code_' + id);
    if (hiddenField) {
        hiddenField.value = finalCode;
    }
}

function previewCode(id) {
    combineCodeParts(id);
    const html = document.getElementById('html_code_' + id).value;
    renderIframeContent(html, 'previewFrame-' + id);
    console.log(html);
}

function saveCode(id) {
    combineCodeParts(id);
    const form = document.getElementById('editMode-' + id);
    const formData = new FormData(form);

    fetch(form.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: formData
        })
        .then(response => {
            if (!response.ok) throw new Error('Save failed');
            return response.text();
        })
        .then(() => {
            alert('Template updated successfully!');
            const html = document.getElementById('html_code_' + id).value;
            renderIframeContent(html, 'previewFrame-' + id);
        })
        .catch(error => {
            console.error(error);
            alert('An error occurred while saving.');
        });
}


window.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.load-grand-tab').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.dataset.id;
            const container = document.getElementById('dynamic-content-' + id);
            const loader = document.getElementById('loader-' + id);

            if (!container || container.innerHTML.trim() !== '') return;

            loader.style.display = 'block';

            fetch(`/ajax/category/${id}/template`)
                .then(res => res.text())
                .then(html => {
                    container.innerHTML = html;
                    previewCode(id);

                    // ✅ Enable the Edit button after content is injected (optional safety)
                    const editBtn = document.querySelector(`#editBtn-${id}`);
                    if (editBtn) editBtn.removeAttribute('disabled');
                })

                .catch(() => {
                    container.innerHTML =
                        '<p class="text-danger">Failed to load content.</p>';
                })
                .finally(() => {
                    loader.style.display = 'none';
                });
        });
    });
});
</script>

<script>
function toggleEdit(id, attempt = 0) {
    const section = document.getElementById('editSection-' + id);
    console.log(id)

    if (!section) {
        if (attempt > 10) {
            console.warn(`toggleEdit: editSection-${id} not found.`);
            return;
        }
        // Retry 150ms later
        return setTimeout(() => toggleEdit(id, attempt + 1), 150);
    }

    // Toggle visibility
    section.style.display = (section.style.display === 'none' || section.style.display === '') ? 'block' : 'none';
}
</script>

<script>
window.addEventListener('DOMContentLoaded', function() {
    previewCode('');

});
</script>



<script>
let itemCounter = 1;
let descPoints = [];
let allRows = [];
let editId = null;

function showPopup() {
    document.getElementById('popupForm').style.display = 'flex';
}

function hidePopup() {
    document.getElementById('popupForm').style.display = 'none';
    resetForm();
}

function addPoint() {
    const input = document.getElementById("descInput");
    const value = input.value.trim();
    if (!value) return;
    descPoints.push(value);
    input.value = '';
    renderPointList();
}

function renderPointList() {
    const list = document.getElementById("pointList");
    list.innerHTML = '';
    descPoints.forEach((p, i) => {
        list.innerHTML +=
            `<li>${p} <button onclick="removePoint(${i})" style="color:red;">&times;</button></li>`;
    });
}

function removePoint(index) {
    descPoints.splice(index, 1);
    renderPointList();
}

function getPriority(type) {
    if (type === 'Bugs' || type === 'Improvements') return 'High';
    if (type === 'Integrations') return 'Moderate';
    return 'None';
}

function submitAll() {


    const type = document.querySelector('input[name="type"]:checked')?.value;
    const developer = document.getElementById("assignTo").value;

    if (!type || !developer || descPoints.length === 0) {
        alert("Please fill all fields and add at least one point.");
        return;
    }

    const priority = getPriority(type);
    const items = descPoints.map(desc => ({
        type,
        description: desc,
        priority,
        status: 'Pending',
        developer
    }));

    fetch('/improvements', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                category_id: activeGrandId,
                items
            })
        })
        .then(res => res.json())
        .then(() => {
            alert('Saved successfully');
            hidePopup();
            loadImprovements(activeGrandId); // optional refresh
        });
}

// Load on page open
function loadImprovements(categoryId) {
    fetch(`/improvements/${categoryId}`)
        .then(res => res.json())
        .then(data => {
            allRows = data;

            // Wait until filters exist in DOM
            setTimeout(() => {
                resetFilters(); // NEW: Set all filters to blank
                applyFilters(); // Render everything
                updateReport(); // Update summary counts
            }, 100);
        });
}

function resetFilters() {
    const filterType = document.getElementById("filterType");
    const filterStatus = document.getElementById("filterStatus");
    const filterPriority = document.getElementById("filterPriority");

    if (filterType) filterType.value = "";
    if (filterStatus) filterStatus.value = "";
    if (filterPriority) filterPriority.value = "";
}



// Set this ID when grand tab is clicked
let activeGrandId = null;
document.querySelectorAll('.load-grand-tab').forEach(btn => {
    btn.addEventListener('click', () => {
        activeGrandId = btn.dataset.id;
        loadImprovements(activeGrandId);
    });
});

function resetForm() {
    descPoints = [];
    renderPointList();
    document.getElementById("descInput").value = "";
    document.getElementById("assignTo").value = "";
    document.querySelectorAll('input[name="type"]').forEach(r => r.checked = false);
}

function applyFilters() {
    const typeSelect = document.getElementById("filterType");
    const statusSelect = document.getElementById("filterStatus");
    const prioritySelect = document.getElementById("filterPriority");

    // ✅ Set default values if no option is selected yet
    if (typeSelect && !typeSelect.value) typeSelect.value = "";
    if (statusSelect && !statusSelect.value) statusSelect.value = "";
    if (prioritySelect && !prioritySelect.value) prioritySelect.value = "";

    const type = typeSelect?.value || "";
    const status = statusSelect?.value || "";
    const priority = prioritySelect?.value || "";

    const tbody = document.getElementById("listTableBody");
    if (!tbody) return;

    tbody.innerHTML = "";

    // ✅ Filter and render rows
    allRows
        .filter(row =>
            (!type || row.type === type) &&
            (!status || row.status === status) &&
            (!priority || row.priority === priority)
        )
        .forEach(row => {
            const tr = document.createElement("tr");
            tr.innerHTML = `
                <td>${row.id}</td>
                <td>${row.type}</td>
                <td>${row.description}</td>
                <td><span class="badge ${row.priority.toLowerCase()}">${row.priority}</span></td>
                <td>
                  <select onchange="updateField(${row.id}, 'status', this.value)">
                    <option ${row.status === 'Pending' ? 'selected' : ''}>Pending</option>
                    <option ${row.status === 'Done' ? 'selected' : ''}>Done</option>
                  </select>
                </td>
                <td>
                  <select onchange="updateField(${row.id}, 'developer', this.value)">
                    <option ${row.developer === 'Developer 1' ? 'selected' : ''}>Developer 1</option>
                    <option ${row.developer === 'Developer 2' ? 'selected' : ''}>Developer 2</option>
                    <option ${row.developer === 'Developer 3' ? 'selected' : ''}>Developer 3</option>
                    <option ${row.developer === 'Developer 4' ? 'selected' : ''}>Developer 4</option>
                  </select>
                </td>
                <td>
                  <button type="button" onclick="openEditModal(${row.id})">✏️ Edit</button>
                  <button type="button" onclick="deleteRow(${row.id})" style="color:red;">🗑️</button>
                </td>
            `;
            tbody.appendChild(tr);
        });

    updateReport(); // ✅ Ensure summary counts are updated
}

function updateField(id, field, value) {
    const row = allRows.find(r => r.id === id);
    if (row) {
        row[field] = value;
        applyFilters();
        updateReport();
    }
}

function deleteRow(id) {
    allRows = allRows.filter(r => r.id !== id);
    applyFilters();
    updateReport();
}

function openEditModal(id) {
    const row = allRows.find(r => r.id === id);
    if (!row) return;
    editId = id;
    document.getElementById("editDesc").value = row.description;
    document.getElementById("editType").value = row.type;
    document.getElementById("editStatus").value = row.status;
    document.getElementById("editDev").value = row.developer;
    document.getElementById("editModal").style.display = "flex";
}

function closeEditModal() {
    document.getElementById("editModal").style.display = "none";
    editId = null;
}

function saveEdit() {
    const row = allRows.find(r => r.id === editId);
    if (!row) return;

    row.description = document.getElementById("editDesc").value;
    row.type = document.getElementById("editType").value;
    row.status = document.getElementById("editStatus").value;
    row.developer = document.getElementById("editDev").value;
    row.priority = getPriority(row.type);

    closeEditModal();
    applyFilters();
    updateReport();
}


function updateReport() {
    const counts = {
        Bugs: 0,
        Improvements: 0,
        Integrations: 0,
        Notes: 0,
        Prompt: 0,
        Others: 0,
        Pending: 0,
        Done: 0,
        High: 0,
        Moderate: 0,
        None: 0,
        dev1: 0,
        dev2: 0,
        dev3: 0,
        dev4: 0
    };

    allRows.forEach(r => {
        counts[r.type]++;
        counts[r.status]++;
        counts[r.priority]++;
        if (r.developer === 'Developer 1') counts.dev1++;
        if (r.developer === 'Developer 2') counts.dev2++;
        if (r.developer === 'Developer 3') counts.dev3++;
        if (r.developer === 'Developer 4') counts.dev4++;
    });

    document.getElementById("reportSummary").innerHTML = `
        <div class="report row">

            <div class="col-md-3 col-6 mb-3">
            <h6 class="fw-bold text-muted">Types</h6>
            <ul class="list-unstyled">
                <li class="report-item">Bugs: ${counts.Bugs}</li>
                <li class="report-item">Improvements: ${counts.Improvements}</li>
                <li class="report-item">Integrations: ${counts.Integrations}</li>
                <li class="report-item">Notes: ${counts.Notes}</li>
                <li class="report-item">Prompt: ${counts.Prompt}</li>
                <li class="report-item">Others: ${counts.Others}</li>
            </ul>
            </div>

            <div class="col-md-3 col-6 mb-3">
            <h6 class="fw-bold text-muted">Status</h6>
            <ul class="list-unstyled">
                <li class="report-item">Pending: ${counts.Pending}</li>
                <li class="report-item">Done: ${counts.Done}</li>
            </ul>
            </div>

            <div class="col-md-3 col-6 mb-3">
            <h6 class="fw-bold text-muted">Priority</h6>
            <ul class="list-unstyled">
                <li class="report-item">High: ${counts.High}</li>
                <li class="report-item">Moderate: ${counts.Moderate}</li>
                <li class="report-item">None: ${counts.None}</li>
            </ul>
            </div>

            <div class="col-md-3 col-6 mb-3">
            <h6 class="fw-bold text-muted">Assigned Developers</h6>
            <ul class="list-unstyled">
                <li class="report-item">Dev 1: ${counts.dev1}</li>
                <li class="report-item">Dev 2: ${counts.dev2}</li>
                <li class="report-item">Dev 3: ${counts.dev3}</li>
                <li class="report-item">Dev 4: ${counts.dev4}</li>
            </ul>
            </div>

        </div>
        `;


}

setTimeout(() => {
    document.getElementById("filterType").dispatchEvent(new Event('change'));
}, 200);
</script>


@endsection