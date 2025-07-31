<ul class="nav nav-pills gap-1" id="postTabs">
    @foreach ($postTypes as $postType)
    <li class="card nav-item p-0 py-2">
        <a class="nav-link" href="javascript:void(0);" onclick="showCreateForm('{{ $postType->name }}')">
            <i class="{{ $postType->icon }}"></i>
            <p class="card-text font-size-card mt-2">{{ $postType->name }}
            </p>
        </a>
    </li>
    @endforeach
</ul>