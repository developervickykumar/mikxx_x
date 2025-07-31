@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Create New Form</span>
                    <a href="{{ route('forms.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Back to Forms
                    </a>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('forms.store') }}">
                        @csrf

                        <div class="row mb-3">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="title">Title <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                           id="title" name="title" value="{{ old('title') }}" required>
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
                                               name="is_active" {{ old('is_active') ? 'checked' : '' }}>
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
                                    id="description" name="description" rows="3">{{ old('description') }}</textarea>
                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <small class="form-text text-muted">
                                Provide a brief description of what this form is for.
                            </small>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="submit_button_text">Submit Button Text</label>
                                    <input type="text" class="form-control @error('submit_button_text') is-invalid @enderror" 
                                           id="submit_button_text" name="submit_button_text" 
                                           value="{{ old('submit_button_text', 'Submit') }}">
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
                                           value="{{ old('cancel_button_text', 'Cancel') }}">
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
                                    id="success_message" name="success_message" rows="2">{{ old('success_message', 'Thank you! Your form has been submitted successfully.') }}</textarea>
                            @error('success_message')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="redirect_url">Redirect URL (optional)</label>
                            <input type="url" class="form-control @error('redirect_url') is-invalid @enderror" 
                                   id="redirect_url" name="redirect_url" value="{{ old('redirect_url') }}">
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
                        <p class="text-muted small">These settings are optional and can be configured later.</p>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Form Layout</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="settings[layout]" 
                                               id="layout_standard" value="standard" 
                                               {{ old('settings.layout', 'standard') == 'standard' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="layout_standard">
                                            Standard (Labels above fields)
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="settings[layout]" 
                                               id="layout_horizontal" value="horizontal"
                                               {{ old('settings.layout') == 'horizontal' ? 'checked' : '' }}>
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
                                               {{ old('settings.show_required', '1') == '1' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="show_required">
                                            Show required field indicators
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="settings[show_cancel]" 
                                               id="show_cancel" value="1"
                                               {{ old('settings.show_cancel', '1') == '1' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="show_cancel">
                                            Show cancel button
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Create Form
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 