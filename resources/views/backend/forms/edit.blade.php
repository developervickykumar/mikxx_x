@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Edit Form: {{ $form->title }}</span>
                    <div>
                        <a href="{{ route('forms.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to Forms
                        </a>
                        <a href="{{ route('forms.show', $form) }}" class="btn btn-info btn-sm">
                            <i class="fas fa-eye"></i> Preview
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <ul class="nav nav-tabs mb-4" id="formTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="settings-tab" data-bs-toggle="tab" 
                                    data-bs-target="#settings" type="button" role="tab" 
                                    aria-controls="settings" aria-selected="true">
                                Form Settings
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="fields-tab" data-bs-toggle="tab" 
                                    data-bs-target="#fields" type="button" role="tab" 
                                    aria-controls="fields" aria-selected="false">
                                Form Fields <span class="badge bg-secondary rounded-pill">{{ $form->fields->count() }}</span>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="permissions-tab" data-bs-toggle="tab" 
                                    data-bs-target="#permissions" type="button" role="tab" 
                                    aria-controls="permissions" aria-selected="false">
                                Permissions
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content" id="formTabsContent">
                        <!-- Form Settings Tab -->
                        <div class="tab-pane fade show active" id="settings" role="tabpanel" aria-labelledby="settings-tab">
                            <form method="POST" action="{{ route('forms.update', $form) }}">
                                @csrf
                                @method('PUT')

                                <div class="row mb-3">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="title">Title <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                                   id="title" name="title" value="{{ old('title', $form->title) }}" required>
                                            @error('title')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="is_active">Status</label>
                                            <div class="form-check mt-2">
                                                <input class="form-check-input" type="checkbox" id="is_active" 
                                                       name="is_active" {{ old('is_active', $form->is_active) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="is_active">
                                                    Active
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="description">Description</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" 
                                            id="description" name="description" rows="3">{{ old('description', $form->description) }}</textarea>
                                    @error('description')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="submit_button_text">Submit Button Text</label>
                                            <input type="text" class="form-control @error('submit_button_text') is-invalid @enderror" 
                                                   id="submit_button_text" name="submit_button_text" 
                                                   value="{{ old('submit_button_text', $form->submit_button_text ?? 'Submit') }}">
                                            @error('submit_button_text')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="cancel_button_text">Cancel Button Text</label>
                                            <input type="text" class="form-control @error('cancel_button_text') is-invalid @enderror" 
                                                   id="cancel_button_text" name="cancel_button_text" 
                                                   value="{{ old('cancel_button_text', $form->cancel_button_text ?? 'Cancel') }}">
                                            @error('cancel_button_text')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="success_message">Success Message</label>
                                    <textarea class="form-control @error('success_message') is-invalid @enderror" 
                                            id="success_message" name="success_message" rows="2">{{ old('success_message', $form->success_message ?? 'Thank you! Your form has been submitted successfully.') }}</textarea>
                                    @error('success_message')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="redirect_url">Redirect URL (optional)</label>
                                    <input type="url" class="form-control @error('redirect_url') is-invalid @enderror" 
                                           id="redirect_url" name="redirect_url" value="{{ old('redirect_url', $form->redirect_url) }}">
                                    @error('redirect_url')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <small class="form-text text-muted">
                                        Where to redirect after form submission. Leave empty to stay on the same page.
                                    </small>
                                </div>

                                <hr>
                                
                                <h5>Advanced Settings</h5>
                                
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Form Layout</label>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="settings[layout]" 
                                                       id="layout_standard" value="standard" 
                                                       {{ old('settings.layout', $form->settings['layout'] ?? 'standard') == 'standard' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="layout_standard">
                                                    Standard (Labels above fields)
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="settings[layout]" 
                                                       id="layout_horizontal" value="horizontal"
                                                       {{ old('settings.layout', $form->settings['layout'] ?? '') == 'horizontal' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="layout_horizontal">
                                                    Horizontal (Labels beside fields)
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Additional Options</label>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="settings[show_required]" 
                                                       id="show_required" value="1"
                                                       {{ old('settings.show_required', $form->settings['show_required'] ?? '1') == '1' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="show_required">
                                                    Show required field indicators
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="settings[show_cancel]" 
                                                       id="show_cancel" value="1"
                                                       {{ old('settings.show_cancel', $form->settings['show_cancel'] ?? '1') == '1' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="show_cancel">
                                                    Show cancel button
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Update Form Settings
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Form Fields Tab -->
                        <div class="tab-pane fade" id="fields" role="tabpanel" aria-labelledby="fields-tab">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="mb-0">Form Fields</h5>
                                <a href="{{ route('forms.fields.create', $form) }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-plus"></i> Add New Field
                                </a>
                            </div>

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
                                                            <a href="{{ route('fields.edit', $field) }}" class="btn btn-sm btn-outline-primary">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                            <button type="button" class="btn btn-sm btn-outline-danger"
                                                                    onclick="confirmDeleteField('{{ $field->id }}')">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                            <form id="delete-field-{{ $field->id }}" 
                                                                  action="{{ route('fields.destroy', $field) }}" 
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

                        <!-- Permissions Tab -->
                        <div class="tab-pane fade" id="permissions" role="tabpanel" aria-labelledby="permissions-tab">
                            <form method="POST" action="{{ route('forms.update', $form) }}">
                                @csrf
                                @method('PUT')

                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle"></i> Configure who can view and submit this form.
                                </div>

                                <div class="form-group mb-3">
                                    <label>Form Visibility</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="permissions[visibility]" 
                                               id="visibility_public" value="public" 
                                               {{ old('permissions.visibility', $form->permissions['visibility'] ?? 'public') == 'public' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="visibility_public">
                                            <strong>Public</strong> - Anyone can view and submit this form
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="permissions[visibility]" 
                                               id="visibility_registered" value="registered"
                                               {{ old('permissions.visibility', $form->permissions['visibility'] ?? '') == 'registered' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="visibility_registered">
                                            <strong>Registered Users</strong> - Only logged-in users can view and submit
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="permissions[visibility]" 
                                               id="visibility_specific" value="specific"
                                               {{ old('permissions.visibility', $form->permissions['visibility'] ?? '') == 'specific' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="visibility_specific">
                                            <strong>Specific Roles</strong> - Only users with selected roles can view and submit
                                        </label>
                                    </div>
                                </div>

                                <div id="specific-roles" class="card p-3 mb-3 {{ old('permissions.visibility', $form->permissions['visibility'] ?? '') == 'specific' ? '' : 'd-none' }}">
                                    <div class="form-group">
                                        <label>Select Roles</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="permissions[roles][]" 
                                                   id="role_admin" value="admin"
                                                   {{ in_array('admin', old('permissions.roles', $form->permissions['roles'] ?? [])) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="role_admin">
                                                Administrators
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="permissions[roles][]" 
                                                   id="role_manager" value="manager"
                                                   {{ in_array('manager', old('permissions.roles', $form->permissions['roles'] ?? [])) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="role_manager">
                                                Managers
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="permissions[roles][]" 
                                                   id="role_editor" value="editor"
                                                   {{ in_array('editor', old('permissions.roles', $form->permissions['roles'] ?? [])) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="role_editor">
                                                Editors
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Update Permissions
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function confirmDeleteField(fieldId) {
        if (confirm('Are you sure you want to delete this field? This action cannot be undone.')) {
            document.getElementById('delete-field-' + fieldId).submit();
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Toggle specific roles section based on visibility selection
        const visibilityInputs = document.querySelectorAll('input[name="permissions[visibility]"]');
        const specificRolesSection = document.getElementById('specific-roles');
        
        visibilityInputs.forEach(input => {
            input.addEventListener('change', function() {
                if (this.value === 'specific' && this.checked) {
                    specificRolesSection.classList.remove('d-none');
                } else {
                    specificRolesSection.classList.add('d-none');
                }
            });
        });
    });
</script>
@endsection 