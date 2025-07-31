@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Field Categories</span>
                    <a href="{{ route('field-categories.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Create New Category
                    </a>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($categories->isEmpty())
                        <div class="alert alert-info">
                            No field categories found. <a href="{{ route('field-categories.create') }}">Create a new category</a> to get started.
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Order</th>
                                        <th>Field Types</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="sortable-categories">
                                    @foreach($categories as $category)
                                        <tr data-id="{{ $category->id }}">
                                            <td>{{ $category->id }}</td>
                                            <td>
                                                <span class="handle me-2"><i class="fas fa-grip-vertical text-muted"></i></span>
                                                {{ $category->name }}
                                            </td>
                                            <td>{{ $category->description }}</td>
                                            <td>{{ $category->order }}</td>
                                            <td>{{ $category->fieldTypes->count() }}</td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="{{ route('field-categories.edit', $category) }}" class="btn btn-sm btn-primary">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-sm btn-danger" 
                                                            onclick="confirmDelete('{{ $category->id }}')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                    <form id="delete-form-{{ $category->id }}" 
                                                          action="{{ route('field-categories.destroy', $category) }}" 
                                                          method="POST" 
                                                          style="display: none;">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
    function confirmDelete(categoryId) {
        if (confirm('Are you sure you want to delete this category? This action cannot be undone.')) {
            document.getElementById('delete-form-' + categoryId).submit();
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Implement drag and drop functionality for reordering categories
        // Example implementation (you would need to include Sortable.js in your page)
        /*
        const sortableCategories = document.getElementById('sortable-categories');
        if (sortableCategories) {
            new Sortable(sortableCategories, {
                handle: '.handle',
                animation: 150,
                onEnd: function(evt) {
                    const items = Array.from(evt.to.children).map((el, index) => {
                        return {
                            id: el.dataset.id,
                            order: index + 1
                        };
                    });
                    
                    fetch('{{ route('field-categories.updateOrder') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({
                            items: items
                        })
                    }).then(response => {
                        if (!response.ok) {
                            console.error('Error updating category order');
                        }
                    });
                }
            });
        }
        */
    });
</script>
@endsection
@endsection 