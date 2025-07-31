<div class="dropdown-with-subcategory">
    <select name="{{ $fieldName }}" class="form-select dynamic-subcategory-select" data-field-id="{{ $field->id }}" data-field-name="{{ $field->name }}">
        <option value="">Select {{ $field->name }}</option>
        @foreach($field->children as $option)
        <option value="{{ $option->name }}" data-id="{{ $option->id }}" data-name="{{ $option->name }}" {{ $fieldValue == $option->name ? "selected" : "" }}>
            {{ $option->name }}
        </option>
        @endforeach
    </select>

    <!-- Dynamic Button Container -->
    <div class="subcategory-btn-container mt-0"></div>
</div>


<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.dynamic-subcategory-select').forEach(function (selectElem) {
        selectElem.addEventListener('change', function () {
            const selectedOption = this.options[this.selectedIndex];
            const parentId = selectedOption.getAttribute('data-id');
            const parentName = selectedOption.getAttribute('data-name');

            const container = this.closest('.dropdown-with-subcategory').querySelector('.subcategory-btn-container');

            if (parentId && parentName) {
                container.innerHTML = `
                    <button type="button" class="btn btn-soft-primary btn-sm" data-bs-toggle="modal"
                        data-bs-target="#createSubcategoryModal" data-parent-id="${parentId}" data-parent-name="${parentName}">
                        <i class="bx bx-duplicate"></i> Create Subcategory for ${parentName}
                    </button>
                `;
            } else {
                container.innerHTML = ''; // Remove button if no valid selection
            }
        });
    });
});
</script>
