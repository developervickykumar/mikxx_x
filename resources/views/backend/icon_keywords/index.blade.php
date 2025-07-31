@extends('layouts.master')

@section('content')
@php
    $iconJson = json_decode(file_get_contents(public_path('json/materialdesign-icons.json')), true);
@endphp

<div class=" py-4">
    <h2 class="mb-4">🎨 Icon Keyword Mapper</h2>

    <div class="mb-3">
        <input type="text" id="iconSearch" class="form-control" placeholder="🔍 Search icons...">
    </div>

    <div class="alert alert-success d-none" id="saveAlert">✅ Saved</div>

    <div class="row" id="iconGrid">
        @foreach($iconJson as $iconClass)
            @php
                $keywords = $iconMappings[$iconClass->name ?? $iconClass]->keywords ?? '';
            @endphp
            <div class="col-md-4 mb-3 icon-tile" data-icon="{{ $iconClass }}" data-keywords="{{ strtolower($keywords) }}">
                <div class="d-flex align-items-center gap-3">
                    <i class="{{ $iconClass }}" style="font-size: 24px; width: 32px;"></i>
                    <input type="text"
                           class="form-control keyword-input"
                           data-icon-class="{{ $iconClass }}"
                           placeholder="e.g. student, school"
                           value="{{ $keywords }}">
                </div>
            </div>
        @endforeach
    </div>
</div>

<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
    
document.getElementById('iconSearch').addEventListener('input', function () {
    const val = this.value.toLowerCase();
    document.querySelectorAll('.icon-tile').forEach(tile => {
        const icon = tile.getAttribute('data-icon').toLowerCase();
        const keywords = tile.getAttribute('data-keywords') || '';
        tile.style.display = (icon.includes(val) || keywords.includes(val)) ? '' : 'none';
    });
});

    document.querySelectorAll('.keyword-input').forEach(input => {
        input.addEventListener('blur', function () {
            const iconClass = this.dataset.iconClass;
            const keywords = this.value;
    
            fetch("{{ route('icon-keywords.store') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    icon_class: iconClass,
                    keywords: keywords
                })
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    console.log('✅ Mapping saved!');
                    if (data.updated_categories.length > 0) {
                        console.log('📦 Categories updated:');
                        data.updated_categories.forEach(name => {
                            console.log('→ ' + name);
                        });
                    } else {
                        console.log('No matching categories found.');
                    }
    
                    // Optional: Show a quick visual alert
                    let alertBox = document.getElementById('saveAlert');
                    alertBox.classList.remove('d-none');
                    setTimeout(() => alertBox.classList.add('d-none'), 1500);
                }
            });
        });
    });

</script>
@endsection
