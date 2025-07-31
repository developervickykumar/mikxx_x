<div class="tab-pane fade " id="condition" role="tabpanel">

    @props(['field', 'conditions' => [], 'allFields' => []])

    <div class="condition-manager" data-field-id="{{ $field->id }}">


        <!-- Condition Modal -->
        <div class="conditions-list mb-3">
            @foreach($conditions as $condition)
            <div class="condition-item card mb-2" data-condition-id="{{ $condition->id }}">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <strong>When:</strong> {{ $condition->source_field }}
                            <strong>{{ $condition->operator }}</strong> {{ $condition->value }}
                            <strong>then:</strong> {{ $condition->condition_type }} {{ $condition->target_field }}
                        </div>
                        <div>
                            <button class="btn btn-sm btn-danger delete-condition"
                                data-condition-id="{{ $condition->id }}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <form class="condition-form" data-field-id="{{ $field->id }}">
            @csrf
            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Condition Type</label>
                        <select name="condition_type" class="form-select" required>
                            <option value="show">Show Field</option>
                            <option value="hide">Hide Field</option>
                            <option value="enable">Enable Field</option>
                            <option value="disable">Disable Field</option>
                            <option value="require">Make Required</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Target Field</label>
                        <select name="target_field" class="form-select" required>
                            @foreach($allFields as $targetField)
                            @if($targetField->id != $field->id)
                            <option value="{{ $targetField->name }}">{{ $targetField->name }}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Operator</label>
                        <select name="operator" class="form-select" required>
                            <option value="equals">Equals</option>
                            <option value="not_equals">Not Equals</option>
                            <option value="contains">Contains</option>
                            <option value="greater_than">Greater Than</option>
                            <option value="less_than">Less Than</option>
                            <option value="in">In List</option>
                            <option value="not_in">Not In List</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Value</label>
                <input type="text" name="value" class="form-control" required>
                <small class="form-text text-muted">For 'in' and 'not_in' operators, use comma-separated values</small>
            </div>
            <button type="submit" class="btn btn-primary">Add Condition</button>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle condition form submission
    document.querySelectorAll('.condition-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const fieldId = this.dataset.fieldId;
            const formData = new FormData(this);

            fetch(`/form-conditions`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                            .content,
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        form_field_id: fieldId,
                        condition_type: formData.get('condition_type'),
                        target_field: formData.get('target_field'),
                        operator: formData.get('operator'),
                        value: formData.get('value')
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.message === 'Condition created successfully') {
                        location.reload();
                    }
                });
        });
    });

    // Handle condition deletion
    document.querySelectorAll('.delete-condition').forEach(button => {
        button.addEventListener('click', function() {
            const conditionId = this.dataset.conditionId;

            if (confirm('Are you sure you want to delete this condition?')) {
                fetch(`/form-conditions/${conditionId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector(
                                'meta[name="csrf-token"]').content
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.message === 'Condition deleted successfully') {
                            this.closest('.condition-item').remove();
                        }
                    });
            }
        });
    });
});
</script>