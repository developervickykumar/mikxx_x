@php

use App\Models\Category;


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

<div class="setting-block functionality-settings" data-type="unit" style="display: none;">

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

