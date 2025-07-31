@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Form Preview: {{ $form->title }}</span>
                    <div>
                        <a href="{{ route('forms.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to Forms
                        </a>
                        <a href="{{ route('forms.edit', $form) }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="mb-4">
                        <h5>Form Details</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tr>
                                    <th style="width: 200px;">Title</th>
                                    <td>{{ $form->title }}</td>
                                </tr>
                                <tr>
                                    <th>Slug</th>
                                    <td><code>{{ $form->slug }}</code></td>
                                </tr>
                                <tr>
                                    <th>Description</th>
                                    <td>{{ $form->description ?: 'No description provided' }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        @if($form->is_active)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-secondary">Inactive</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Total Fields</th>
                                    <td>{{ $form->fields->count() }}</td>
                                </tr>
                                <tr>
                                    <th>Created</th>
                                    <td>{{ $form->created_at->format('M d, Y') }}</td>
                                </tr>
                                <tr>
                                    <th>Last Updated</th>
                                    <td>{{ $form->updated_at->format('M d, Y') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <hr>

                    <h5>Form Preview</h5>
                    
                    @if($form->fields->isEmpty())
                        <div class="alert alert-warning">
                            This form has no fields yet. <a href="{{ route('forms.fields.create', $form) }}">Add fields</a> to see a preview.
                        </div>
                    @else
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> This is a preview of how your form will appear to users.
                        </div>
                        
                        <div class="card">
                            <div class="card-body">
                                @include('components.dynamic-form', [
                                    'form' => $form,
                                    'fieldsBySection' => $fieldsBySection,
                                    'previewMode' => true
                                ])
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 