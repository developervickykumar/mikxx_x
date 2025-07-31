@php
    $type = strtolower($field->type);
    $label = $field->label;
    $name = Str::slug($label, '_');
    $options = is_string($field->options) ? json_decode($field->options, true) : ($field->options ?? []);
@endphp

<div class="mb-3 col-md-6">
    <label class="form-label">{{ $label }}</label>

    @if(in_array($type, ['text', 'optional', 'username', 'contact', 'social_media', 'address', 'pricelist', 'pricingoption']))
        <input type="text" name="{{ $name }}" class="form-control" placeholder="Enter {{ $label }}" />

    @elseif($type === 'description')
        <textarea name="{{ $name }}" class="form-control" rows="4" placeholder="Enter {{ $label }}"></textarea>

    @elseif(in_array($type, ['email']))
        <input type="email" name="{{ $name }}" class="form-control" placeholder="Enter {{ $label }}" />

    @elseif(in_array($type, ['url']))
        <input type="url" name="{{ $name }}" class="form-control" placeholder="Enter {{ $label }}" />

    @elseif(in_array($type, ['age', 'height', 'weight']))
        <input type="number" name="{{ $name }}" class="form-control" placeholder="Enter {{ $label }}" />

    @elseif(in_array($type, ['file', 'image', 'video']))
        <input type="file" name="{{ $name }}" class="form-control" 
            @if($type === 'image') accept="image/*"
            @elseif($type === 'video') accept="video/*"
            @endif />

    @elseif($type === 'select')
        <select name="{{ $name }}" class="form-select">
            <option value="">Select Option</option>
            @foreach($options as $opt)
                <option value="{{ $opt['name'] }}">{{ $opt['name'] }}</option>
            @endforeach
        </select>

    @elseif($type === 'multiselect')
        <select name="{{ $name }}[]" class="form-select" multiple>
            @foreach($options as $opt)
                <option value="{{ $opt['name'] }}">{{ $opt['name'] }}</option>
            @endforeach
        </select>

    @elseif($type === 'checkbox')
        <div>
            @foreach($options as $opt)
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="{{ $name }}[]" value="{{ $opt['name'] }}">
                    <label class="form-check-label">{{ $opt['name'] }}</label>
                </div>
            @endforeach
        </div>

    @elseif($type === 'radio')
        <div>
            @foreach($options as $opt)
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="{{ $name }}" value="{{ $opt['name'] }}">
                    <label class="form-check-label">{{ $opt['name'] }}</label>
                </div>
            @endforeach
        </div>

    @else
        <input type="text" name="{{ $name }}" class="form-control" placeholder="Enter {{ $label }}" />
    @endif
</div>
