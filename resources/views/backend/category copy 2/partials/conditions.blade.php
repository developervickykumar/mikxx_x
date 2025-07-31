<div class="col-md-6 mt-3" id="functionality-conditions">
    {{-- Default --}}
    <div class="mb-3 col-md-6 condition condition-common">
        <label class="form-label">Required</label>
        <select name="conditions[required]" class="form-select">
            <option value="">Select</option>
            <option value="true" {{ $conditions['required'] ?? '' == 'true' ? 'selected' : '' }}>Yes</option>
            <option value="false" {{ $conditions['required'] ?? '' == 'false' ? 'selected' : '' }}>No</option>
        </select>
    </div>

    {{-- For Radio --}}
    <div class="mb-3 col-md-6 condition condition-radio d-none">
        <label class="form-label">Orientation</label>
        <select name="conditions[orientation]" class="form-select">
            <option value="vertical" {{ $conditions['orientation'] ?? '' == 'vertical' ? 'selected' : '' }}>Vertical</option>
            <option value="horizontal" {{ $conditions['orientation'] ?? '' == 'horizontal' ? 'selected' : '' }}>Horizontal</option>
        </select>
    </div>

    {{-- For Unit --}}
    <div class="mb-3 col-md-6 condition condition-unit d-none">
        <label class="form-label">Unit Type</label>
        <select name="conditions[unit_type]" class="form-select">
            <option value="weight" {{ $conditions['unit_type'] ?? '' == 'weight' ? 'selected' : '' }}>Weight</option>
            <option value="volume" {{ $conditions['unit_type'] ?? '' == 'volume' ? 'selected' : '' }}>Volume</option>
            <option value="length" {{ $conditions['unit_type'] ?? '' == 'length' ? 'selected' : '' }}>Length</option>
        </select>
    </div>
</div>
