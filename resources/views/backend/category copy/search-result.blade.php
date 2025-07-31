@if ($categories->count() > 0)
   

        @foreach ($categories as $categorie)
            <tr id="category-{{ $categorie->id }}" data-id="{{ $categorie->id }}" data-parent-id="{{ $categorie->parent_id }}">
                <td><input type="checkbox" class="category-checkbox" value="{{ $categorie->id }}"></td>
                <td>{{ $loop->iteration }}</td>

                <td>
                    @include('backend.components.icon-selector', [
                        'inputId' => "iconInput-{$categorie->id}",
                        'iconClass' => $categorie->icon ?? 'dripicons-photo',
                        'categoryId' => $categorie->id
                    ])
                </td>

                <td class="border-0 d-flex justify-content-between">
                    <div>
                        <small style="font-size:10px">{{ $categorie->level_name }}</small><br>
                        <a href="#"
   class="category-link"
   data-category-id="{{ $categorie->id }}"
   data-category-name="{{ $categorie->name }}"
   data-breadcrumb='@json($categorie->breadcrumbPath)'>
   {{ $categorie->name }} ({{ $categorie->children->count() }})
</a>
<br>
                      
                    </div>

                    <div>
                        <button type="button" class="btn btn-soft-danger btn-sm" data-bs-toggle="modal"
                            data-bs-target="#createSubcategoryModal" data-parent-id="{{ $categorie->id }}" data-parent-name="{{ $categorie->name }}">
                            <i class="bx bx-duplicate"></i>
                        </button>

                       

                        <button type="button" class="btn btn-soft-primary btn-sm" data-bs-toggle="modal"
                            data-bs-target="#createAppLabelModal" data-category-id="{{ $categorie->id }}"
                            data-parent-id="{{ $categorie->id }}" data-parent-name="{{ $categorie->name }}">
                            <i class="bx bx-purchase-tag fs-6 icon-choice"></i>
                        </button>
                    </div>
                </td>

                <td>
                    @include('backend.components.image-uploader', [
                        'inputId' => "imageInput-{$categorie->id}",
                        'imageUrl' => $categorie->image ? asset('storage/category/images/' . $categorie->image) : asset('images/no-img.jpg'),
                        'categoryId' => $categorie->id
                    ])
                </td>

                <td>
                    <button type="button" class="btn btn-soft-secondary btn-sm edit-category"
                        data-bs-toggle="modal" data-bs-target="#editCategoryModal"
                        data-id="{{ $categorie->id }}" data-name="{{ $categorie->name }}" data-status="{{ $categorie->status }}">
                        <i class="bx bx-edit-alt"></i>
                    </button>

                    @php
                        $isactive = match($categorie->status) {
                            'premium' => 'btn-info',
                            'enterprices' => 'btn-success',
                            'admin' => 'btn-danger',
                            default => 'btn-secondary'
                        };
                    @endphp

                    <button class="btn btn-sm lock-btn {{ $categorie->is_protected ? 'btn-secondary' : 'btn-soft-secondary' }}"
                        data-id="{{ $categorie->id }}" title="Toggle Protection">
                        <i class="bx bx-lock-alt"></i>
                    </button>

                    @if(!$categorie->is_protected)
                    <button class="btn btn-soft-secondary btn-sm delete-category" data-id="{{ $categorie->id }}" data-name="{{ $categorie->name }}">
                        <i class="bx bx-trash"></i>
                    </button>
                    @endif
                </td>
            </tr>
        @endforeach
 
@else
    <tr>
        <td colspan="6" class="text-center">No categories found.</td>
    </tr>
@endif
