<!-- resources/views/posts/partials/form_fields.blade.php -->
<div class="mb-3">
    <!-- Toggle Input vs Table -->
    <label class="form-label"><strong>Select Field Type</strong></label>
    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="fieldOption" id="optionInput" value="input" checked>
        <label class="form-check-label" for="optionInput">Single Input Field</label>
    </div>
    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="fieldOption" id="optionTable" value="table">
        <label class="form-check-label" for="optionTable">Specification Table</label>
    </div>

    <!-- Single Text Field -->
    <div id="fieldBuilder" class="mt-4">
        <label class="form-label">Field Label</label>
        <input type="text" class="form-control mb-2" id="fieldLabel" placeholder="Enter label (e.g. 'Color')">

        <button class="btn btn-primary" id="addFieldBtn">Add Field</button>
    </div>

    <!-- Specification Table -->
    <div id="tableBuilder" class="mt-4" style="display: none;">
        <label class="form-label">Table Rows</label>
        <input type="number" id="tableRows" class="form-control mb-2" placeholder="e.g. 3">
        <label class="form-label">Table Columns</label>
        <input type="number" id="tableCols" class="form-control mb-2" placeholder="e.g. 2">
        <button class="btn btn-secondary" id="createTableBtn">Generate Table</button>
    </div>

    <!-- Output -->
    <div class="field-preview mt-4" id="fieldPreview"></div>
    <div class="table-preview mt-4" id="tablePreview"></div>

    <script>
        const optionInput = document.getElementById('optionInput');
        const optionTable = document.getElementById('optionTable');
        const fieldBuilder = document.getElementById('fieldBuilder');
        const tableBuilder = document.getElementById('tableBuilder');
        const fieldPreview = document.getElementById('fieldPreview');
        const tablePreview = document.getElementById('tablePreview');

        // Toggle between input field and table view
        document.querySelectorAll('input[name="fieldOption"]').forEach(el => {
            el.addEventListener('change', () => {
                const isInput = optionInput.checked;
                fieldBuilder.style.display = isInput ? 'block' : 'none';
                tableBuilder.style.display = isInput ? 'none' : 'block';
                fieldPreview.innerHTML = '';
                tablePreview.innerHTML = '';
            });
        });

        // Add single text field
        document.getElementById('addFieldBtn').addEventListener('click', () => {
            const label = document.getElementById('fieldLabel').value;
            if (!label.trim()) return alert("Please enter a field label.");

            const inputHTML = `<label class="form-label">${label}</label>
                               <input type="text" class="form-control" placeholder="${label}">`;
            fieldPreview.innerHTML = inputHTML;
        });

        // Create specification table
        document.getElementById('createTableBtn').addEventListener('click', () => {
            const rows = parseInt(document.getElementById('tableRows').value);
            const cols = parseInt(document.getElementById('tableCols').value);

            if (!rows || !cols || rows < 1 || cols < 1) {
                return alert("Please enter valid row and column numbers.");
            }

            let tableHTML = `<table class="table table-bordered spec-table"><tbody>`;
            for (let i = 0; i < rows; i++) {
                tableHTML += '<tr>';
                for (let j = 0; j < cols; j++) {
                    tableHTML += `<td><input type="text" class="form-control" placeholder="R${i + 1}C${j + 1}"></td>`;
                }
                tableHTML += '</tr>';
            }
            tableHTML += `</tbody></table>`;

            tablePreview.innerHTML = tableHTML;
        });
    </script>
</div>
