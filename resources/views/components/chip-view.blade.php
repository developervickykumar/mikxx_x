

<div id="chip-wrapper-{{ $fieldName }}"
     class="chip-input-wrapper border rounded p-2 d-flex flex-wrap gap-2">
    @foreach($selectedValues ?? [] as $val)
        <span class="badge bg-primary chip" data-value="{{ $val }}">
            {{ $val }}
            <button type="button" class="btn-close btn-close-white btn-sm ms-1 remove-chip"></button>
        </span>
    @endforeach

    <input type="text"
           class="chip-input border-0 flex-grow-1"
           id="chip-input-{{ $fieldName }}"
           placeholder="Type and press Enter"
           autocomplete="off"
           style="min-width: 150px; outline: none;">
</div>

<!-- Suggestion List -->
<div id="suggestions-{{ $fieldName }}"
     class=" show w-100 mt-1 shadow-sm d-none"
     style="max-height: 200px; overflow-y: auto;"></div>

<!-- Hidden input -->
<input type="hidden" name="{{ $fieldName }}" id="chip-hidden-{{ $fieldName }}"
       value="{{ implode(',', $selectedValues ?? []) }}">


<script>
document.addEventListener('DOMContentLoaded', function () {
    const input = document.querySelector('#chip-input-{{ $fieldName }}');
    const chipWrapper = document.querySelector('#chip-wrapper-{{ $fieldName }}');
    const chipHidden = document.querySelector('#chip-hidden-{{ $fieldName }}');
    const suggestionsBox = document.querySelector('#suggestions-{{ $fieldName }}');

    const suggestions = @json($suggestions ?? []);
    const allowCustom = @json($allowUserOptions ?? false);

    function updateHidden() {
        const chips = [...chipWrapper.querySelectorAll('.chip')].map(c => c.dataset.value);
        chipHidden.value = chips.join(',');
    }

    function addChip(value, label = null) {
    if (!value || chipWrapper.querySelector(`.chip[data-value="${value}"]`)) return;

    const chip = document.createElement('span');
    chip.className = 'badge bg-primary chip d-flex align-items-center';
    chip.dataset.value = value;
    chip.innerHTML = `${value}  <!-- Always show only value here -->
        <button type="button" class="btn-close btn-close-white btn-sm ms-1 remove-chip"></button>`;

    chipWrapper.insertBefore(chip, input);
    updateHidden();
}


    function filterSuggestions(term) {
    const filtered = suggestions.filter(s => s.label.toLowerCase().includes(term.toLowerCase()));
    suggestionsBox.innerHTML = '';
    if (filtered.length) {
        filtered.forEach(s => {
            const div = document.createElement('div');
            div.className = 'dropdown-item';
            div.textContent = s.label;
            div.dataset.value = s.value;
            suggestionsBox.appendChild(div);
        });
        suggestionsBox.classList.remove('d-none');
    } else {
        suggestionsBox.classList.add('d-none');
    }
}


    input.addEventListener('input', function () {
        const term = this.value.trim();
        if (term.length > 0) {
            filterSuggestions(term);
        } else {
            suggestionsBox.classList.add('d-none');
        }
    });

    input.addEventListener('keydown', function (e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            const val = this.value.trim();
            if (!val) return;

            if (suggestions.includes(val) || allowCustom) {
                addChip(val);
                this.value = '';
                suggestionsBox.classList.add('d-none');
            } else {
                alert('Only suggestions are allowed.');
            }
        }
    });

    suggestionsBox.addEventListener('click', function (e) {
    if (e.target.classList.contains('dropdown-item')) {
        const value = e.target.dataset.value;
        const label = e.target.textContent;
        addChip(value, label);
        input.value = '';
        suggestionsBox.classList.add('d-none');
    }
});


    chipWrapper.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-chip')) {
            e.target.closest('.chip').remove();
            updateHidden();
        }
    });
});
</script>