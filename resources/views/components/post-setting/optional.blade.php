<div class="setting-block functionality-settings" data-type="optional" style="display: none;">
    <div class="draggable-buttons">
        <div class="draggable" draggable="true" id="categoryBtn">Category</div>
    </div>

    <div class="form-canvas" id="dropZone">Drop Here to Build Form</div>

    <div class="preview-container" id="preview"></div>

    <!-- Popup -->
    <div id="conditionForm">
        <span class="close-btn" onclick="closeForm()">X</span>
        <h3>Category Condition Settings</h3>

        <label>Select Type</label>
        <input type="radio" name="typeSelect" value="single" checked> Single Select
        <input type="radio" name="typeSelect" value="multiple"> Multiple Choice

        <label>Select Dropdown Type</label>
        <select id="dropdownType">
            <option>Dropdown</option>
            <option>Checkbox Group</option>
            <option>Radio Button</option>
            <option>Toggle Switch</option>
            <option>Button Group</option>
            <option>Multiselect Dropdown</option>
            <option>Checkbox Dropdown</option>
            <option>Chip View Dropdown</option>
            <option>Expandable Dropdown</option>
            <option>Grouped Dropdown</option>
            <option>Country Picker</option>
            <option>Region Picker</option>
            <option>City Dropdown</option>
            <option>Dropdown with Search</option>
        </select>

        <label>Add Subcategories (comma separated)</label>
        <textarea id="subCategories"></textarea>

        <label>Optional</label>
        <input type="checkbox" id="addIcon"> Add Icon
        <input type="checkbox" id="addGallery"> Add Gallery

        <label>Select View</label>
        <input type="radio" name="viewType" value="list" checked> List View
        <input type="radio" name="viewType" value="grid"> Grid View
        <input type="radio" name="viewType" value="icon"> Icon View
        <input type="radio" name="viewType" value="image"> Image View
        <input type="radio" name="viewType" value="button"> Button View

        <label>Add Form on Subcategories</label>
        <textarea id="subForm" placeholder="Optional sub-form..."></textarea>

        <button onclick="applySettings()">Add</button>
    </div>

    <script>
    let currentBlock = null;

    document.getElementById('categoryBtn').addEventListener('dragstart', function(e) {
        e.dataTransfer.setData('text/plain', 'category');
    });

    document.getElementById('dropZone').addEventListener('dragover', function(e) {
        e.preventDefault();
    });

    document.getElementById('dropZone').addEventListener('drop', function(e) {
        e.preventDefault();
        const field = document.createElement('div');
        field.classList.add('field-block');
        field.innerHTML =
            'Category Field <span class="condition-icon">⚙️</span>';
        field.querySelector('.condition-icon').addEventListener('click',
            function() {
                currentBlock = field;
                document.getElementById('conditionForm').style.display =
                    'block';
            });
        this.appendChild(field);
    });

    function closeForm() {
        document.getElementById('conditionForm').style.display = 'none';
    }

    function applySettings() {
        const type = document.querySelector('input[name="typeSelect"]:checked').value;
        const dropdownType = document.getElementById('dropdownType').value;
        const subcategories = document.getElementById('subCategories').value.split(',')
            .map(s => s.trim()).filter(Boolean);
        const viewType = document.querySelector('input[name="viewType"]:checked').value;
        const addIcon = document.getElementById('addIcon').checked;
        const addGallery = document.getElementById('addGallery').checked;
        const subForm = document.getElementById('subForm').value;

        // Create preview
        let previewHTML = `<div><strong>Category Field</strong><br>`;
        previewHTML +=
            `Type: ${type}, Dropdown: ${dropdownType}, View: ${viewType}<br>`;
        previewHTML += `Subcategories: ${subcategories.join(', ')}<br>`;
        if (addIcon) previewHTML += `Includes Icons<br>`;
        if (addGallery) previewHTML += `Includes Gallery<br>`;
        if (subForm) previewHTML += `Sub Form: ${subForm}<br>`;
        previewHTML += `</div><hr>`;

        document.getElementById('preview').innerHTML += previewHTML;
        document.getElementById('conditionForm').style.display = 'none';
    }
    </script>

</div>