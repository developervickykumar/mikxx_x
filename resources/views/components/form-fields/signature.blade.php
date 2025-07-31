@props(['field', 'disabled' => false])

<div class="signature-field-container" id="signature-container-{{ $field->id }}">
    <div class="canvas-container" style="border: 1px solid #dee2e6; border-radius: 4px; background-color: #fff;">
        <canvas id="signature-canvas-{{ $field->id }}" width="{{ $field->config['width'] ?? 400 }}" height="{{ $field->config['height'] ?? 200 }}"></canvas>
    </div>
    
    <input 
        type="hidden"
        id="field-{{ $field->id }}"
        name="field[{{ $field->id }}]"
        @if($field->required) required @endif
        @if(old('field.' . $field->id, $field->default_value))
            value="{{ old('field.' . $field->id, $field->default_value) }}"
        @endif
        data-field-name="{{ $field->name }}"
        data-field-id="{{ $field->id }}"
        @if($field->conditions->count() > 0) data-has-conditions="true" @endif
    >
    
    <div class="signature-actions mt-2">
        <button type="button" class="btn btn-sm btn-secondary" onclick="clearSignature('{{ $field->id }}')" {{ $disabled ? 'disabled' : '' }}>
            Clear
        </button>
        @if($field->config['show_download'] ?? false)
        <button type="button" class="btn btn-sm btn-secondary ms-2" onclick="downloadSignature('{{ $field->id }}')" {{ $disabled ? 'disabled' : '' }}>
            Download
        </button>
        @endif
    </div>
    
    @if($field->help_text)
        <small class="form-text text-muted mt-2">{{ $field->help_text }}</small>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    initSignaturePad('{{ $field->id }}');
});

function initSignaturePad(fieldId) {
    const canvas = document.getElementById(`signature-canvas-${fieldId}`);
    const hiddenInput = document.getElementById(`field-${fieldId}`);
    let isDrawing = false;
    let ctx = canvas.getContext('2d');
    
    // Set canvas styles
    ctx.lineWidth = {{ $field->config['line_width'] ?? 2 }};
    ctx.strokeStyle = "{{ $field->config['stroke_color'] ?? '#000000' }}";
    ctx.lineJoin = "round";
    
    // Load existing signature if available
    if (hiddenInput.value) {
        const img = new Image();
        img.onload = function() {
            ctx.drawImage(img, 0, 0);
        }
        img.src = hiddenInput.value;
    }
    
    // Set up event listeners for drawing
    @if(!$disabled)
    canvas.addEventListener('mousedown', startDrawing);
    canvas.addEventListener('touchstart', handleTouchStart);
    canvas.addEventListener('mousemove', draw);
    canvas.addEventListener('touchmove', handleTouchMove);
    canvas.addEventListener('mouseup', stopDrawing);
    canvas.addEventListener('touchend', stopDrawing);
    canvas.addEventListener('mouseout', stopDrawing);
    @endif
    
    function startDrawing(e) {
        isDrawing = true;
        draw(e);
    }
    
    function handleTouchStart(e) {
        e.preventDefault();
        const touch = e.touches[0];
        const mouseEvent = new MouseEvent('mousedown', {
            clientX: touch.clientX,
            clientY: touch.clientY
        });
        canvas.dispatchEvent(mouseEvent);
    }
    
    function draw(e) {
        if (!isDrawing) return;
        
        const rect = canvas.getBoundingClientRect();
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;
        
        ctx.lineTo(x, y);
        ctx.stroke();
        ctx.beginPath();
        ctx.moveTo(x, y);
        
        // Save signature data to hidden input
        saveSignature();
    }
    
    function handleTouchMove(e) {
        e.preventDefault();
        const touch = e.touches[0];
        const mouseEvent = new MouseEvent('mousemove', {
            clientX: touch.clientX,
            clientY: touch.clientY
        });
        canvas.dispatchEvent(mouseEvent);
    }
    
    function stopDrawing() {
        isDrawing = false;
        ctx.beginPath();
        saveSignature();
    }
    
    function saveSignature() {
        // Convert canvas to data URL and store in hidden input
        hiddenInput.value = canvas.toDataURL("image/png");
    }
}

function clearSignature(fieldId) {
    const canvas = document.getElementById(`signature-canvas-${fieldId}`);
    const hiddenInput = document.getElementById(`field-${fieldId}`);
    const ctx = canvas.getContext('2d');
    
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    hiddenInput.value = '';
}

function downloadSignature(fieldId) {
    const canvas = document.getElementById(`signature-canvas-${fieldId}`);
    const dataUrl = canvas.toDataURL("image/png");
    
    const a = document.createElement('a');
    a.href = dataUrl;
    a.download = `signature-${fieldId}.png`;
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
}
</script>

<style>
.signature-field-container {
    margin-bottom: 1rem;
}
.canvas-container {
    touch-action: none;
}
</style> 