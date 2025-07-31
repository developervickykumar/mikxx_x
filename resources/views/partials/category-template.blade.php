@php
    $htmlCode = $grand->code ?? '';

    preg_match('/<style[^>]*>(.*?)<\/style>/is', $htmlCode, $cssMatches);
    $cssCode = $cssMatches[1] ?? '';

    preg_match('/<script[^>]*>(.*?)<\/script>/is', $htmlCode, $jsMatches);
    $jsCode = $jsMatches[1] ?? '';

    $htmlOnly = preg_replace([
        '/<!--.*?-->/s',
        '/<style[^>]*>.*?<\/style>/is',
        '/<script[^>]*>.*?<\/script>/is'
    ], '', $htmlCode);
@endphp

<form method="POST" action="{{ route('page-templates.update', $grand->id) }}"
      id="editMode-{{ $grand->id }}" class="mt-3">
    @csrf
    @method('PUT')
    <input type="hidden" name="id" value="{{ $grand->id }}">
   
    <div id="editSection-{{ $grand->id }}" style="display: none;">

        <!-- Code Tabs -->
        <ul class="nav nav-tabs mt-3" id="codeTabs-{{ $grand->id }}" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="html-tab-{{ $grand->id }}"
                data-bs-toggle="tab" href="#html-{{ $grand->id }}" role="tab">HTML</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="css-tab-{{ $grand->id }}"
                data-bs-toggle="tab" href="#css-{{ $grand->id }}" role="tab">CSS</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="js-tab-{{ $grand->id }}"
                data-bs-toggle="tab" href="#js-{{ $grand->id }}" role="tab">JS</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="report-tab-{{ $grand->id }}"
                data-bs-toggle="tab" href="#report-{{ $grand->id }}" role="tab">Report</a>
            </li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane fade show active" id="html-{{ $grand->id }}" role="tabpanel">
                <textarea class="form-control" rows="6" name="html_input" id="htmlInput_{{ $grand->id }}">{{ $htmlOnly }}</textarea>
            </div>
            <div class="tab-pane fade" id="css-{{ $grand->id }}" role="tabpanel">
                <textarea class="form-control" rows="6" name="css_input" id="cssInput_{{ $grand->id }}">{{ $cssCode }}</textarea>
            </div>
            <div class="tab-pane fade" id="js-{{ $grand->id }}" role="tabpanel">
                <textarea class="form-control" rows="6" name="js_input" id="jsInput_{{ $grand->id }}">{{ $jsCode }}</textarea>
            </div>
            <div class="tab-pane fade" id="report-{{ $grand->id }}" role="tabpanel">
                @include('partials.module-report')
            </div>
        </div>

        <textarea name="html_code" id="html_code_{{ $grand->id }}" class="d-none">{!! $grand->code !!}</textarea>

        <div class="mt-3">
            <button type="button" class="btn btn-success" onclick="saveCode('{{ $grand->id }}')">Save</button>
        </div>
        
    </div>

    

    <iframe id="previewFrame-{{ $grand->id }}"
            style="width:100%; height:80vh; border:1px solid #ccc; margin-top:1rem;"></iframe>
</form>
