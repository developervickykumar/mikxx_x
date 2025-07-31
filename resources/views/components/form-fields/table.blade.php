@props(['field', 'disabled' => false])

@php
    $columns = $field->config['columns'] ?? [];
    $rows = old('field.' . $field->id, $field->default_value ?? []);
    $rows = is_array($rows) ? $rows : [];
    $min_rows = $field->config['min_rows'] ?? 1;
    $max_rows = $field->config['max_rows'] ?? null;
    $allow_add = $field->config['allow_add'] ?? true;
    $allow_remove = $field->config['allow_remove'] ?? true;
    $button_text = $field->config['button_text'] ?? 'Add Row';
    
    // Ensure we have at least the minimum number of rows
    if (count($rows) < $min_rows) {
        $empty_row = [];
        foreach ($columns as $column) {
            $empty_row[$column['key']] = '';
        }
        $rows = array_pad($rows, $min_rows, $empty_row);
    }
@endphp

<div class="table-field-container">
    <table class="table table-bordered" id="table-{{ $field->id }}">
        <thead>
            <tr>
                @foreach($columns as $column)
                    <th>{{ $column['label'] }}</th>
                @endforeach
                @if($allow_remove && !$disabled)
                    <th class="table-action-column">Actions</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach($rows as $row_index => $row)
                <tr class="table-row" data-row="{{ $row_index }}">
                    @foreach($columns as $column_index => $column)
                        <td>
                            @if($column['type'] === 'text')
                                <input 
                                    type="text"
                                    name="field[{{ $field->id }}][{{ $row_index }}][{{ $column['key'] }}]"
                                    class="form-control"
                                    value="{{ $row[$column['key']] ?? '' }}"
                                    @if($disabled) disabled @endif
                                    @if(($field->required && $row_index == 0) && $column['required'] ?? false) required @endif
                                    placeholder="{{ $column['placeholder'] ?? '' }}"
                                >
                            @elseif($column['type'] === 'number')
                                <input 
                                    type="number"
                                    name="field[{{ $field->id }}][{{ $row_index }}][{{ $column['key'] }}]"
                                    class="form-control"
                                    value="{{ $row[$column['key']] ?? '' }}"
                                    @if($disabled) disabled @endif
                                    @if(($field->required && $row_index == 0) && $column['required'] ?? false) required @endif
                                    placeholder="{{ $column['placeholder'] ?? '' }}"
                                    @if(isset($column['min'])) min="{{ $column['min'] }}" @endif
                                    @if(isset($column['max'])) max="{{ $column['max'] }}" @endif
                                    @if(isset($column['step'])) step="{{ $column['step'] }}" @endif
                                >
                            @elseif($column['type'] === 'select')
                                <select 
                                    name="field[{{ $field->id }}][{{ $row_index }}][{{ $column['key'] }}]"
                                    class="form-control"
                                    @if($disabled) disabled @endif
                                    @if(($field->required && $row_index == 0) && $column['required'] ?? false) required @endif
                                >
                                    @if(isset($column['placeholder']))
                                        <option value="">{{ $column['placeholder'] }}</option>
                                    @endif
                                    @foreach($column['options'] ?? [] as $option)
                                        <option 
                                            value="{{ $option['value'] ?? $option['label'] }}" 
                                            {{ isset($row[$column['key']]) && $row[$column['key']] == ($option['value'] ?? $option['label']) ? 'selected' : '' }}
                                        >
                                            {{ $option['label'] }}
                                        </option>
                                    @endforeach
                                </select>
                            @elseif($column['type'] === 'checkbox')
                                <div class="form-check">
                                    <input 
                                        type="checkbox"
                                        name="field[{{ $field->id }}][{{ $row_index }}][{{ $column['key'] }}]"
                                        class="form-check-input"
                                        value="1"
                                        {{ isset($row[$column['key']]) && $row[$column['key']] ? 'checked' : '' }}
                                        @if($disabled) disabled @endif
                                    >
                                </div>
                            @endif
                        </td>
                    @endforeach
                    @if($allow_remove && !$disabled)
                        <td class="table-action-column">
                            <button type="button" class="btn btn-sm btn-danger remove-row" 
                                {{ count($rows) <= $min_rows ? 'disabled' : '' }}
                                onclick="removeTableRow(this, '{{ $field->id }}')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
    
    @if($allow_add && !$disabled && (!isset($max_rows) || count($rows) < $max_rows))
        <button type="button" class="btn btn-secondary mt-2" 
            onclick="addTableRow('{{ $field->id }}', {{ json_encode($columns) }})">
            {{ $button_text }}
        </button>
    @endif
    
    @if(isset($max_rows))
        <small class="form-text text-muted">
            Maximum {{ $max_rows }} {{ Str::plural('row', $max_rows) }}
        </small>
    @endif
</div>

<script>
function addTableRow(fieldId, columns) {
    const table = document.getElementById(`table-${fieldId}`);
    const tbody = table.querySelector('tbody');
    const rows = tbody.querySelectorAll('tr');
    const max_rows = {{ $max_rows ?? 'null' }};
    
    // Check if we've reached the maximum number of rows
    if (max_rows !== null && rows.length >= max_rows) {
        return;
    }
    
    const row_index = rows.length;
    
    // Create a new row
    const newRow = document.createElement('tr');
    newRow.className = 'table-row';
    newRow.dataset.row = row_index;
    
    // Add cells for each column
    columns.forEach(column => {
        const cell = document.createElement('td');
        
        let input;
        
        if (column.type === 'text') {
            input = document.createElement('input');
            input.type = 'text';
            input.name = `field[${fieldId}][${row_index}][${column.key}]`;
            input.className = 'form-control';
            input.placeholder = column.placeholder || '';
            
            if (column.required) {
                input.required = true;
            }
        } else if (column.type === 'number') {
            input = document.createElement('input');
            input.type = 'number';
            input.name = `field[${fieldId}][${row_index}][${column.key}]`;
            input.className = 'form-control';
            input.placeholder = column.placeholder || '';
            
            if (column.min !== undefined) input.min = column.min;
            if (column.max !== undefined) input.max = column.max;
            if (column.step !== undefined) input.step = column.step;
            
            if (column.required) {
                input.required = true;
            }
        } else if (column.type === 'select') {
            input = document.createElement('select');
            input.name = `field[${fieldId}][${row_index}][${column.key}]`;
            input.className = 'form-control';
            
            if (column.placeholder) {
                const placeholderOption = document.createElement('option');
                placeholderOption.value = '';
                placeholderOption.textContent = column.placeholder;
                input.appendChild(placeholderOption);
            }
            
            if (column.options) {
                column.options.forEach(option => {
                    const optionEl = document.createElement('option');
                    optionEl.value = option.value || option.label;
                    optionEl.textContent = option.label;
                    input.appendChild(optionEl);
                });
            }
            
            if (column.required) {
                input.required = true;
            }
        } else if (column.type === 'checkbox') {
            const div = document.createElement('div');
            div.className = 'form-check';
            
            input = document.createElement('input');
            input.type = 'checkbox';
            input.name = `field[${fieldId}][${row_index}][${column.key}]`;
            input.className = 'form-check-input';
            input.value = '1';
            
            div.appendChild(input);
            cell.appendChild(div);
        }
        
        if (column.type !== 'checkbox') {
            cell.appendChild(input);
        }
        
        newRow.appendChild(cell);
    });
    
    // Add action cell if remove is allowed
    if ({{ $allow_remove ? 'true' : 'false' }}) {
        const actionCell = document.createElement('td');
        actionCell.className = 'table-action-column';
        
        const removeButton = document.createElement('button');
        removeButton.type = 'button';
        removeButton.className = 'btn btn-sm btn-danger remove-row';
        removeButton.onclick = function() { removeTableRow(this, fieldId); };
        
        const icon = document.createElement('i');
        icon.className = 'fas fa-trash';
        
        removeButton.appendChild(icon);
        actionCell.appendChild(removeButton);
        newRow.appendChild(actionCell);
    }
    
    tbody.appendChild(newRow);
    
    // If we've reached the maximum, hide the add button
    if (max_rows !== null && rows.length + 1 >= max_rows) {
        const addButton = table.nextElementSibling;
        if (addButton && addButton.tagName === 'BUTTON') {
            addButton.style.display = 'none';
        }
    }
    
    // Enable all remove buttons
    enableRemoveButtons(fieldId);
}

function removeTableRow(button, fieldId) {
    const table = document.getElementById(`table-${fieldId}`);
    const tbody = table.querySelector('tbody');
    const rows = tbody.querySelectorAll('tr');
    const min_rows = {{ $min_rows ?? 1 }};
    const max_rows = {{ $max_rows ?? 'null' }};
    
    // Check if we have more than the minimum number of rows
    if (rows.length > min_rows) {
        const row = button.closest('tr');
        row.remove();
        
        // Reindex remaining rows
        const remainingRows = tbody.querySelectorAll('tr');
        remainingRows.forEach((row, index) => {
            row.dataset.row = index;
            
            // Update input names
            const inputs = row.querySelectorAll('input, select');
            inputs.forEach(input => {
                input.name = input.name.replace(/\[\d+\]/, `[${index}]`);
            });
        });
        
        // If we're below the maximum again, show the add button
        if (max_rows !== null && rows.length - 1 < max_rows) {
            const addButton = table.nextElementSibling;
            if (addButton && addButton.tagName === 'BUTTON') {
                addButton.style.display = 'inline-block';
            }
        }
        
        // Disable remove buttons if at minimum rows
        if (rows.length - 1 <= min_rows) {
            disableRemoveButtons(fieldId);
        }
    }
}

function enableRemoveButtons(fieldId) {
    const table = document.getElementById(`table-${fieldId}`);
    const removeButtons = table.querySelectorAll('.remove-row');
    removeButtons.forEach(button => {
        button.disabled = false;
    });
}

function disableRemoveButtons(fieldId) {
    const table = document.getElementById(`table-${fieldId}`);
    const removeButtons = table.querySelectorAll('.remove-row');
    removeButtons.forEach(button => {
        button.disabled = true;
    });
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    @if(count($rows) <= $min_rows)
        disableRemoveButtons('{{ $field->id }}');
    @endif
});
</script>

<style>
.table-action-column {
    width: 70px;
    text-align: center;
}
</style> 