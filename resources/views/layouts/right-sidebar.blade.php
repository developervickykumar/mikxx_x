<div class="right-bar">
    <div data-simplebar class="h-100">
        <div class="rightbar-title px-3 py-4">
            <a href="javascript:void(0);" class="right-bar-toggle float-end">
                <i class="mdi mdi-close noti-icon"></i>
            </a>
            <h5 class="m-0">Modules</h5>
        </div>

        @if(!empty($primaryTabs) && $primaryTabs->count())
        <div class="p-3">
            @foreach($primaryTabs as $group)
            <a href="{{ route('tab.form', ['parent_id' => $group->id]) }}"
                class="d-block py-2 px-3 text-decoration-none border-bottom">
                <i class="{{ $group->icon ?? 'mdi mdi-folder' }}"></i> {{ $group->name }}
            </a>
            @endforeach

        </div>
        @else
        <div class="p-3 text-center text-muted">
            No module settings available.
        </div>
        @endif
    </div>
</div>