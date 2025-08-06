@extends('layouts.master')
@section('title') Product Form Builder @endsection

@section('content')
@component('components.breadcrumb')
@slot('li_1') Builder @endslot
@slot('title') Form Builder Product @endslot
@endcomponent
<style>
.vertical-menu {
    display: none;
}

.main-content {
    margin-left: 0;
}

@media(min-width: 1200px) {

    .container,
    .container-lg,
    .container-md,
    .container-sm,
    .container-xl,
    .container-xxl {
        max-width: 100%;
    }
}
</style>
<style>
.form-sidebar {
    max-height: 80vh;
    overflow-y: auto;
    border-right: 1px solid #dee2e6;
    background: #f8f9fa;
}
</style>

<div class="row">
    <div class="col-md-4 col-lg-4 form-sodebae">
        <ul class="nav nav-tabs bg-white px-2 pt-2" id="elementTabs" role="tablist">
            @foreach($groupedsubcategory as $key=>$item)
            <li class="nav-item ms-2">
                <a href="nav-link {{$loop->first ? 'active' : ''}}" id="{{strtolower($key)}}-tab" data-bs-toggle="tab"
                    href="#tab-{{strtolower($key)}}">{{ucfirst($key)}}</a>
            </li>
            @endforeach
        </ul>

        <div class="tab-content p-3" id="elementTabsContent">
            @foreach($groupedsubcategory as $key => $parentcategory)
            <div class="tab-pane fade {{$loop->first ? 'show active' : ''}}" id="tab-{{strtolower($key)}}"
                role="tan-panel">
                @if($parentcategory->isEmpty())
                <p class="text-muted"> No {{$key}} elements available </p>
                @endif
                <div class="accordion" id="accordion-{{strtolower($key)}}">
                    @foreach($parentcategory as $parent)
                    @php
                    $accordionId = \Illuminate\support\str::slug($parent->name .'-'. $key, '_');
                    $children = $parent->children()->where('status','active')->get();
                    @endphp
                    <div class="accordion-item mb-2">
                        <h2 class="accordion-header" id="heading-{{ $accordionId }}">
                            <button style="background:#f1f1f1" class="accordion-button collapsed" type="button"
                                data-bs-toggle="collapse" data-bs-target="#collapse-{{$accordionId}}"
                                aria-expended="false"
                                aria-controls="collapse-{{$accordionId}}">{{$parent->name}}</button>
                        </h2>
                        <div class="accordion-collapse collapse" id="collapse-{{ $accordionId }}"
                            aria-labelledby="heading-{{$accordionId}}" data-bs-parent="#accordion-{{strtolower($key)}}">
                            <div class="accourdion-body left-accordion">
                                @forelse($children as $child)
                                @php
                                $groupviewType= ($child->group_view['unabled'] ?? false) ?
                                strtolower($child->group_view['view_type'] ?? '') : '';
                                $optionAllowed = ($child->advanced['allow_user_options'] ?? false) ?
                                strtolower($child->advanced['allow_user_options'] ?? ''): '';
                                $isForm = (strtolower($child->label_json['label'] ?? '') == 'form');

                                @endphp
                                <div class="form-element" draggable="true" data-label="{{$child->name}}"
                                    data-groupview="{{$groupviewType}}"
                                    data-functionality="{{ strtolower($child->functionality ?? 'text')}}"
                                    data-optionAllowed="{{$optionAllowed}}" data-isForm="{{$isForm ? '1': '0'}}">
                                    <i class="{{$child->icon ?? 'fas fa-tag'}} pb-2"></i>
                                    <p class="mb-0">{{$child->name}}</p>
                                    <div>
                                        @if($isForm)
                                        <span class="badg bg-primary ms-3">Form</span>
                                        @endif
                                        @if($groupviewType)
                                        <span class="badge bg-primary ms-3">Group</span>
                                        @endif
                                    </div>

                                </div>
                                @empty
                                <p class="text-muted mb-0"> No element inside {{$parent->name}}</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                    @endforeach


                </div>

            </div>
            @endforeach
        </div>
    </div>

    <!--Right preview panel-->
    <div class="col-md-8 col-lg-8">
        <!--Layout selector add group  -->
        <div class="d-flex flex-wrwp justify-content-between aline-item-center gap-2 mb-3">
            {{--file name + model--}}
            <div class="aline-item-center d-flex gap-2">
                <input type="text" class="form-control" placeholder="Enter file name" style="width:200px;">
                <select name="" id="" class="form-select" style="width:150px;">
                    <option value="">Select module</option>
                    <option value="form">Form</option>
                    <option value="lead">Lead</option>
                    <option value="post">Post</option>
                    <option value="survey">Survey</option>
                </select>
            </div>

            {{--Desktop Columns Dropdown--}}
            <div class="btn-group">
                <button class="btn btn-outline-secondery dropdown-toggle" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false" title="Desktop Columns">
                    <i class="fas fa-desktop"></i>
                </button>
                <ul class="dropdown-menu p-2">
                    <select name="" id="layoutSelect" class="form-select">
                        @for($i=1; $i<=8; $i++) <option value="col-md-{{ $i}}">{{$i}} Columns {{$i>1 ? 's' : ''}}
                            </option>
                            @endfor
                    </select>
                </ul>
            </div>

            {{--Mobile Columns Dropdown--}}
            <div class="btn-group">
                <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false" title="Mobile Columns">
                    <i class="fas fa-mobile"></i>
                </button>
                <ul class="dropdown-menu p-2">
                    <select name="" id="mobileLayoutSelect" class="form-select">
                        @for($i=1; $i<=12; $i++) <option value="col-md-{{ $i }}" {{$i==12 ? 'selected' : ''}}>
                            {{$i}} Columns {{$i>1 ? 's' : ''}}
                          </option>
                          @endfor
                    </select>
                </ul>
            </div>

            {{--Preview Type Dropdown--}}
            <div class="btn-group">
                <button class="btn btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                aria-expanded="false" title="preview type">
                <i class="fas fa-eye"></i>
                </button>
                <ul class="dropdown-menu p-2">
                 <select name="" id="previewType" class="form-select">
                    <option value="default" selected>Default</option>
                    <option value="vertical-tabs">Vertical Tabs</option>
                    <option value="horizontal-tabs"> Horizontal Tabs</option>
                    <option value="multi-step"> Multi Step</option>
                 </select>
                </ul>
            </div>
            
            {{-- Add Group Spacer--}}
            <div class="d-flex gap-2">
              <button class="btn btn-sm btn-primary" onclick="addNewGroup()" title="Add Group">
                <i class="fas fa-plus"></i>
              </button>

              <button class="btn btn-sm btn-secondary" onclick="addSpacer()" title="Add Spacer">
                <i class="fas fa-arrows-alt-v"></i>
              </button>
            </div>
        </div>
        <div class="text-end mt-3">
            <button class="btn btn-outline-primary" onclick="showFormPreview()">
                <i class="fas fa-eye me-1"></i> Preview form
            </button>
        </div>
        <div class="form-canvas" id="formCanvasWrapper">
            <div id="formCanvas"></div>
             
            <div class="text-center mt-3">
                <button class="btn btn-outline-primary" onclick="addNewGroup()">
                    <i class="fas fa-leyer-group me-1"></i> Insert Group
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="formPreviewModal" tabindex="-1" aria-labelledby="formPreviewLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
     <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="formPreviewLabel">Form Preview</h5>
            <button type="button"class="btn-close" data-bs-dismiss="modal" aria-label="close"></button>
        </div>
        <div class="modal-body" id="formPreviewContent">

        </div>
     </div>
    </div>
</div>

<script>
    let pendingChipViews = [];
    let previewType = 'default';
    let layoutClass = 'col-md-12';
    let draggedElement = null;

    let formStructure = []; 
     
    document.getElementById('previewType').addEventListener('change',function(){
        previevType = this.value;
        renderPreviewLayout();
    });

    document.getElementById('layoutSelect').addEventListener('change',function(){
        layoutClass = this.value;
        applyLayout();
    });
    
    function applyLayout()
    {
        document.querySelectorAll('.form-element').forEach(el=>{
            el.className = `form-element ${layoutClase}`;
        });
    }
    window.addEentListener('DOMContentLoaded',()=>{
        bindSidebarDragEvents();
        addNewGroup();
        renderPreviewLayout();

    });
    function addNewGroup()
    {
        const groupLabel= `Group ${formStructure.length +1}`;
        formStructure.push({
            label: groupLabel,
            element: [],
            columns: 1,
            addMoreBlocks: [],
        });
        renderPreviewLayout();
    }

    function renderPreviewLayout()
    {
        const container = document.getElementById('formCanvas');
        container.innerHTML = '';
        let html = '';
        if(previewType === 'horizontal-tabs'){
            html = `<ul class="nav nav-tabs mb-3" id="tabHeaders"></ul><div class="tab-content" id="tabContents"></div>`;
        }
        else if(previewType === 'vertical-tabs')
        {
            html = `<div class="row">
            <div class="col-md-3"><ul class="nav flex-columns nav-pills" id="tabHeaders"></ul></div>
            <div class="col-md-9"><div class="tab-content" id="tabContents"></div></div>
            </div>`;
        }
        else if(previewType === 'multi-step')
        {
            html = `<div class="d-flex gap-2 mb-3" id="stepNav"></div><div class="tab-content" id="tabContents"></div>`;
        }
        else 
        {
            html= `<div class="accordion" id="formAccordion"></div>`;
        }
      container.innerHTML = html;
      formStructure.forEach((group, index) => {
        renderGroup(group, index);
      });
      bindSidebarDragEvent();
      bindFieldRemoveButton();

    }

</script>
@endsection