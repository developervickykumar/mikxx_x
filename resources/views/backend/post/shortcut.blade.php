@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Post Something</h2>
        
        <!-- Add Shortcut Button -->
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addShortcutModal">
            <i class="fas fa-plus"></i> Add Shortcut
        </button>
    </div>

    <!-- Shortcuts Grid -->
    <div class="row" id="shortcut-list">
        <!-- Default Shortcuts -->
        <div class="col-md-3 mb-4 shortcut-item" data-type="story">
            <div class="card text-center p-4">
                <i class="fas fa-book-open fa-3x mb-3"></i>
                <h5>Story</h5>
            </div>
        </div>
        <div class="col-md-3 mb-4 shortcut-item" data-type="image">
            <div class="card text-center p-4">
                <i class="fas fa-image fa-3x mb-3"></i>
                <h5>Image</h5>
            </div>
        </div>
        <div class="col-md-3 mb-4 shortcut-item" data-type="video">
            <div class="card text-center p-4">
                <i class="fas fa-video fa-3x mb-3"></i>
                <h5>Video</h5>
            </div>
        </div>
    </div>
</div>

<!-- Modal to Add More Shortcuts -->
<div class="modal fade" id="addShortcutModal" tabindex="-1" aria-labelledby="addShortcutModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        
            <div class="modal-header">
                <h5 class="modal-title" id="addShortcutModalLabel">Add Post Shortcuts</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body">
                <form id="shortcut-form">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="blog" id="shortcut_blog">
                        <label class="form-check-label" for="shortcut_blog">Blog</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="recipe" id="shortcut_recipe">
                        <label class="form-check-label" for="shortcut_recipe">Recipe</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="holiday" id="shortcut_holiday">
                        <label class="form-check-label" for="shortcut_holiday">Holiday Package</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="teach" id="shortcut_teach">
                        <label class="form-check-label" for="shortcut_teach">Teach</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="classified" id="shortcut_classified">
                        <label class="form-check-label" for="shortcut_classified">Classified</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="film" id="shortcut_film">
                        <label class="form-check-label" for="shortcut_film">Film</label>
                    </div>
                </form>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="add-selected-shortcuts">Add Selected</button>
            </div>
            
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {

    const shortcutList = document.getElementById('shortcut-list');
    const addSelectedButton = document.getElementById('add-selected-shortcuts');

    const shortcuts = {
        blog: { icon: 'fas fa-blog', label: 'Blog' },
        recipe: { icon: 'fas fa-utensils', label: 'Recipe' },
        holiday: { icon: 'fas fa-plane-departure', label: 'Holiday Package' },
        teach: { icon: 'fas fa-chalkboard-teacher', label: 'Teach' },
        classified: { icon: 'fas fa-bullhorn', label: 'Classified' },
        film: { icon: 'fas fa-film', label: 'Film' }
    };

    addSelectedButton.addEventListener('click', function() {
        const checkedShortcuts = document.querySelectorAll('#shortcut-form input[type="checkbox"]:checked');
        
        checkedShortcuts.forEach(function(input) {
            const type = input.value;

            // Check if already added
            if (!document.querySelector(`.shortcut-item[data-type="${type}"]`)) {
                const shortcutData = shortcuts[type];

                const newShortcut = `
                    <div class="col-md-3 mb-4 shortcut-item" data-type="${type}">
                        <div class="card text-center p-4">
                            <i class="${shortcutData.icon} fa-3x mb-3"></i>
                            <h5>${shortcutData.label}</h5>
                        </div>
                    </div>
                `;

                shortcutList.insertAdjacentHTML('beforeend', newShortcut);
            }
        });

        // Close modal
        var addShortcutModal = bootstrap.Modal.getInstance(document.getElementById('addShortcutModal'));
        addShortcutModal.hide();
    });

});
</script>
@endpush
@endsection
