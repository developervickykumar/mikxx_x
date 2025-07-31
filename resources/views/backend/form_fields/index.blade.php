@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Fields for: {{ $form->title }}</span>
                    <div>
                        <a href="{{ route('forms.edit', $form) }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to Form
                        </a>
                        <a href="{{ route('forms.fields.create', $form) }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Add New Field
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> Drag and drop fields to reorder them. Click on a field to edit it.
                    </div>

                    <div id="sortable-fields">
                        @if($form->fields->isEmpty())
                            <div class="alert alert-warning">
                                No fields have been added to this form yet. <a href="{{ route('forms.fields.create', $form) }}">Add your first field</a>.
                            </div>
                        @else
                            @foreach($form->getFieldsBySection() as $section => $fields)
                                <div class="card mb-3">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0">
                                            {{ $section === 'default' ? 'Default Section' : $section }}
                                        </h6>
                                    </div>
                                    <div class="list-group list-group-flush sortable-section" data-section="{{ $section }}">
                                        @foreach($fields as $field)
                                            <div class="list-group-item d-flex justify-content-between align-items-center" data-id="{{ $field->id }}">
                                                <div>
                                                    <span class="handle me-2"><i class="fas fa-grip-vertical text-muted"></i></span>
                                                    <strong>{{ $field->label }}</strong>
                                                    <span class="text-muted"> ({{ $field->type->name }})</span>
                                                    
                                                    @if($field->required)
                                                        <span class="badge bg-danger ms-1">Required</span>
                                                    @endif
                                                    
                                                    @if(!$field->is_enabled)
                                                        <span class="badge bg-secondary ms-1">Disabled</span>
                                                    @endif
                                                </div>
                                                <div class="btn-group">
                                                    <a href="{{ route('forms.fields.edit', [$form, $field]) }}" class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-sm btn-outline-danger"
                                                            onclick="confirmDeleteField('{{ $field->id }}')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                    <form id="delete-field-{{ $field->id }}" 
                                                          action="{{ route('forms.fields.destroy', [$form, $field]) }}" 
                                                          method="POST" 
                                                          style="display: none;">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
    function confirmDeleteField(fieldId) {
        if (confirm('Are you sure you want to delete this field? This action cannot be undone.')) {
            document.getElementById('delete-field-' + fieldId).submit();
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Here you would implement drag and drop functionality using a library like SortableJS
        // Example implementation:
        /*
        const sortableSections = document.querySelectorAll('.sortable-section');
        
        sortableSections.forEach(section => {
            new Sortable(section, {
                handle: '.handle',
                animation: 150,
                onEnd: function(evt) {
                    // Send the new order to the server
                    const items = Array.from(evt.to.children).map((el, index) => {
                        return {
                            id: el.dataset.id,
                            order: index
                        };
                    });
                    
                    fetch('/admin/forms/{{ $form->id }}/fields/order', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({
                            items: items,
                            section: evt.to.dataset.section
                        })
                    }).then(response => {
                        if (!response.ok) {
                            console.error('Error updating field order');
                        }
                    });
                }
            });
        });
        */
    });
</script>
@endsection
@endsection 