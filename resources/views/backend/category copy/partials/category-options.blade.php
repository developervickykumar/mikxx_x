@foreach($categories as $category)
    <option value="{{ $category->id }}">
        {{ str_repeat('—', $category->level) . ' ' . $category->name }}
    </option>
    @if($category->childrenRecursive->count())
        @include('backend.category.partials.category-options', ['categories' => $category->childrenRecursive])
    @endif
@endforeach
