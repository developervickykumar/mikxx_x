@foreach ($categories as $categorie)
@php
    $published = collect($categorie->children)->filter(fn($child) => !empty($child['code']))->count();
    $pending = collect($categorie->children)->filter(fn($child) => empty($child['code']))->count();
    $units = $published + $pending;
    $label = data_get($categorie->label_json, 'label');
@endphp

      <div class="category-card  @if($categorie->is_excluded == 1) bg-light @endif" id="category-{{ $categorie->id }}" data-id="{{ $categorie->id }}"
        data-parent-id="{{ $categorie->parent_id }}">
        <div class="category-header">
            <div class="category-info">
                <input type="checkbox" class="category-checkbox me-2" value="{{ $categorie->id }}">

                @include('backend.components.image-uploader', [
                'inputId' => "imageInput-{$categorie->id}",
                'imageUrl' => $categorie->image ? asset('storage/category/images/' . $categorie->image)
                : asset('images/no-img.jpg'),
                'categoryId' => $categorie->id
                ])
                <div class="category-details">
                    <div class="d-flex">
                    @include('backend.components.icon-selector', [
                    'inputId' => "iconInput-{$categorie->id}",
                    'iconClass' => $categorie->icon ? $categorie->icon : 'dripicons-italic',
                    'categoryId' => $categorie->id
                    ])


                        <div class="category-name ps-2">

                            <p class="mb-0 text-info font-size-11">{{ $categorie->level_name }}</p>
                            <a href="#" class="category-link" data-category-id="{{ $categorie->id }}"
                                data-category-name="{{ $categorie->name }}">
                                {{ $categorie->name }}
                            </a>

                            <div class="category-meta">

                                @php
                                    $label = data_get($categorie->label_json, 'label'); // No json_decode needed
                                @endphp
                                
                                <span class="text-info category-badge badge-{{ strtolower($categorie->status) }}">
                                    {{ ucfirst($categorie->label) }}
                                </span>

                                <small>Subcategories: {{ $categorie->children->count() }}</small>
                                <div class="expand-icon" data-category-id="{{ $categorie->id }}"
                                    onclick="toggleCategory(this)">
                                    <i class="bx bx-chevron-down"></i>
                                </div>

                            </div>
                            
                            <style>
                                .badge.disabled {
                                pointer-events: none;
                                opacity: 0.6;
                            }

                            </style>
                            
                            @php $badgeClass = $categorie->is_published ? 'bg-success' : 'bg-warning'; @endphp
                            <span class="badge {{ $badgeClass }} toggle-publish-status"
                                  data-id="{{ $categorie->id }}"
                                  style="cursor: pointer;"
                                  id="status-badge-{{ $categorie->id }}">
                                {{ $categorie->is_published ? 'Published' : 'Draft' }}
                            </span>
                            
                            
                             @if( $categorie->label == 'Page')
                             
                                <button
                                    type="button"
                                    class="btn btn-soft-success action-button edit-page"
                                    data-id="{{ $categorie->id }}"
                                    data-name="{{ $categorie->name }}"
                                    data-path="/categories"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editDynamicPageModal">
                                    <i class="mdi mdi-pencil"></i>
                                    <span>Edit Page</span>
                                </button>
                                
                                @endif
                                
                            
                        <!-- <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#routeModal-{{ $categorie->id }}">-->
                        <!--➕ Add Route/Page-->
                        <!--</button>-->

                            
                            <span class="badge bg-secondary">Units: {{ $units }} </span>
                            <!--<span class="badge bg-success">Published: {{ $published }}</span>-->
                            <span class="badge bg-warning">Pending: {{ $pending }}</span>
                            <span class="badge bg-danger"> Bugs: {{ '1' }} </span>

                        </div>
                    </div>
                </div>
            </div>

            <div class="action-buttons">
                <div class="action-group">
                    <button type="button" class="btn btn-soft-primary action-button"
                        data-bs-toggle="modal" data-bs-target="#createSubcategoryModal"
                        data-parent-id="{{ $categorie->id }}" data-parent-name="{{ $categorie->name }}">
                    <i class="bx bx-duplicate"></i>
                        <span>Add Sub</span>
                </button>
                <button type="button" class="btn btn-soft-secondary action-button edit-category"
                data-bs-toggle="modal" data-bs-target="#editCategoryModal"
                data-id="{{ $categorie->id }}" data-name="{{ $categorie->name }}"
                data-status="{{ $categorie->status }}">
                <i class="bx bx-edit-alt"></i>
                        <span>Edit</span>
            </button>

                    <button type="button" class="btn btn-soft-success action-button edit-html"
                        data-id="{{ $categorie->id }}" data-name="{{ $categorie->name }}"
                          data-bs-toggle="modal"
                        data-bs-target="#editHtmlModal">
                        <i class="mdi mdi-code-tags icon-choice " style="cursor:pointer;"
                            title="edit html"></i>
                        <span>Edit HTML</span>
                    </button>

                    <button onclick="openChecklistById({{ $categorie->id }})">🧾 Checklist</button>

                    @php
                    $categoriesJson = $categories->map(function ($c) {
                        return [
                            'id' => $c->id,
                            'name' => $c->name,
                            'type' => data_get($c->label_json, 'label') ?? 'Unknown'
                        ];
                    })->values();
                @endphp

                    <script>
                        window.categoriesFromLaravel = @json($categoriesJson);
                        console.log(categoriesFromLaravel);
                    </script>

            </div>

                <div class="action-group">
                    
                    <!-- <button type="button" class="btn btn-soft-secondary action-button edit-product"
                data-id="{{ $categorie->id }}" data-name="{{ $categorie->name }}"
                data-status="{{ $categorie->status }}">
                        <i class="bx bx-box"></i>
                        <span>Product</span>
            </button>
                    <button type="button" class="btn btn-soft-secondary action-button edit-service"
                data-id="{{ $categorie->id }}" data-name="{{ $categorie->name }}"
                data-status="{{ $categorie->status }}">
                        <i class="fas fa-user-nurse"></i>
                        <span>Service</span>
                    </button> -->
                </div>
                <div class="action-group">
            <button
                        class="btn btn-soft-secondary action-button lock-btn {{ $categorie->is_protected ? 'btn-secondary' : '' }}"
                data-id="{{ $categorie->id }}" title="Toggle Protection">
                <i class="bx bx-lock-alt"></i>
                        <span>Protect</span>
            </button>
            @if(!$categorie->is_protected)
                    <button class="btn btn-soft-secondary action-button delete-category"
                        data-id="{{ $categorie->id }}" data-name="{{ $categorie->name }}">
                <i class="bx bx-trash"></i>
                        <span>Delete</span>
            </button>
            @endif
                </div>
            </div>
       
        </div>
        <div class="category-content">
            <!-- Category details and additional content -->
            <div class="row">
                <div class="col-md-4">
                    <h6>Category Details</h6>
                    <p><strong>Description:</strong> {{ $categorie->description ?? 'No description' }}
                    </p>
                    <p><strong>Functionality:</strong>
                        {{ $categorie->functionality ?? 'Not specified' }}</p>

                        <div class="col-md-5 categoryStatsExpanded">
                            <span>Loading stats...</span>
                        </div>
                </div>

                <div class="col-md-4">
                    <h6>Actions</h6>
                    <!--<button type="button" class="btn btn-soft-primary action-button"-->
                    <!--    data-bs-toggle="modal" data-bs-target="#createAppLabelModal"-->
                    <!--    data-category-id="{{ $categorie->id }}" data-parent-id="{{ $categorie->id }}"-->
                    <!--    data-parent-name="{{ $categorie->name }}">-->
                    <!--    <i class="{{ $categorie->icon ?? 'dripicons-photo' }}"></i>-->
                    <!--    <span>App Label</span>-->
                    <!--</button>-->

                    <div class="action-group">
                        <button class="btn btn-soft-success action-button">
                            <i class="dripicons-code"></i>
                            <span>Copy ID</span>
                        </button>
                        <button class="btn btn-soft-secondary action-button">
                            <i class="mdi mdi-animation-outline"></i>
                            <span>Copy Sub</span>
                        </button>
                        <button class="btn btn-soft-warning action-button">
                            <i class="mdi mdi-emoticon-happy-outline"></i>
                            <span>Copy Icon</span>
                        </button>
                    </div>
                </div>

                <div class="col-md-4">

                    <div class="subcategories-container" id="subcategories-{{ $categorie->id }}">
                        <!-- Loaded via AJAX -->
                    </div>


                </div>




            </div>
        </div>
    </div>
    
@endforeach



   <script>
  
    document.querySelectorAll('.toggle-publish-status').forEach(function (el) {
        el.addEventListener('click', function (e) {
            
            e.preventDefault(); // prevent default behavior if any
            const badge = this;
            const categoryId = badge.dataset.id;

            // Prevent double click
            if (badge.classList.contains('disabled')) return;

            badge.classList.add('disabled');

            fetch('{{ route('category.toggle-publish') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ id: categoryId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    badge.textContent = data.new_status;
                    badge.className = `badge toggle-publish-status ${data.new_class}`;
                }
            })
            .catch(error => {
                console.error('Error updating publish status:', error);
            })
            .finally(() => {
                badge.classList.remove('disabled');
            });
        });
    });
 
</script>


