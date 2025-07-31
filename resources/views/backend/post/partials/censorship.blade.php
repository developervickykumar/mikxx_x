<!-- resources/views/posts/partials/censorship.blade.php -->
<div class="mb-3">
    <label for="censorship_type" class="form-label">Censorship Type</label>

    @php
    use App\Models\Category;
    $censorship_types = Category::where('parent_id', 55902)->get();

    // Fix: Use loop to collect all child categories
    $censorship_type_child = collect();
    foreach ($censorship_types as $type) {
    $censorship_type_child = $censorship_type_child->merge($type->childrenRecursive()->get());
    }
    @endphp

    <div class="row">
        
    <div class="col-md-3">
        <select class="form-select mb-2" id="censorship_type" name="censorship_type">
            <option value="">Select Censorship Type</option>
            @foreach ($censorship_types as $censorship_type)
            <option value="{{ $censorship_type->id }}"
                {{ old('censorship_type') == $censorship_type->id ? 'selected' : '' }}>
                {{ $censorship_type->name }}
            </option>
            @endforeach
        </select>

    </div>

    <div class="col-md-3">
    <!-- Child Dropdown -->
        <select class="form-select" id="censorship_type_child" name="censorship_type_child">
            <option value="">Select Sub Type</option>
        </select>
    </div>

    
    </div>

    <!-- AJAX Script -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const parent = document.getElementById('censorship_type');
        const child = document.getElementById('censorship_type_child');

        parent.addEventListener('change', function() {
            const parentId = this.value;
            child.innerHTML = '<option value="">Loading...</option>';

            if (parentId) {
                fetch(`/categories/${parentId}/childrens`)
                    .then(response => response.json())
                    .then(data => {
                        child.innerHTML = '<option value="">Select Sub Type</option>';
                        if (data.length > 0) {
                            data.forEach(sub => {
                                child.innerHTML +=
                                    `<option value="${sub.id}">${sub.name}</option>`;
                            });
                        } else {
                            child.innerHTML = '<option value="">No subtypes found</option>';
                        }
                    });
            } else {
                child.innerHTML = '<option value="">Select Sub Type</option>';
            }
        });
    });
    </script>

</div>