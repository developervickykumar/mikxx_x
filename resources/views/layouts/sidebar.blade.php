<div class="vertical-menu">
    <div data-simplebar class="h-100">
        <div id="sidebar-menu">
            <ul class="metismenu list-unstyled" id="side-menu">
                
                            
            @php
            use App\Models\Category;
            $sidebarItems = Category::where('parent_id', 133742)->with('children.children')->orderBy('position')->get();
            
            @endphp
            
            @foreach($sidebarItems as $item)
            <li>
                <a href=" ">
                    <i class="{{ $item->icon}}"></i>
                    <span>{{ $item->name }}</span>
                </a>
                @if($item->children->isNotEmpty())
                    <ul>
                        @foreach($item->children as $child)
                            <li>
                                <a href=" ">
                                     <i class="{{ $child->icon}}"></i>
                                    <span>{{ $child->name }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </li>
        @endforeach


                <li>
                    <a href="{{ route('post.index') }}">
                        <i class="mdi mdi-home-outline"></i>
                        <span>Home</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.dashboard') }}">
                        <i class="mdi mdi-view-dashboard-outline icon-choice"></i>
                        <span>Dashboard</span>
                    </a>
                </li>


                 <li>
                    <a href="{{ route('file.manager') }}">
                        <i class="mdi mdi-view-dashboard-outline icon-choice"></i>
                        <span>Page Editor</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('business.create') }}">
                        <i data-feather="plus-circle"></i>
                        <span>Create Business</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('business.create') }}">
                        <i class="mdi mdi-account-group"></i>
                        <span>Friends</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('business.create') }}">
                        <i class="mdi mdi-wallet"></i>
                        <span>Wallet</span>
                    </a>
                </li>

                @auth
                    @if(auth()->user()->is_admin)
                        <li>
                            <a href="javascript: void(0);" class="has-arrow">
                                <i class="mdi mdi-form-textarea"></i>
                                <span data-key="t-authentication">Form</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li>
                                    <a href="{{ route('categories.index') }}">
                                        <i data-feather="chevron-right"></i>
                                        <span>Form Categories</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('form-templates.index') }}">
                                        <i data-feather="chevron-right"></i>
                                        <span>Form Templates</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('tab-form-management') }}">
                                        <i data-feather="chevron-right"></i>
                                        <span>Form Management</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('form-management-view') }}">
                                        <i data-feather="chevron-right"></i>
                                        <span>Form Data</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('form-management-view') }}">
                                        <i data-feather="chevron-right"></i>
                                        <span>Form Management View</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('builder.index') }}">
                                        <i data-feather="chevron-right"></i>
                                        <span>Form Builder</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('modules.index') }}">
                                        <i data-feather="list"></i>
                                        <span data-key="t-list">Modules</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('page-templates.index') }}">
                                        <i data-feather="chevron-right"></i>
                                        <span>Page Templates</span>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li>
                            <a href="{{ route('module-view-management') }}">
                                <i data-feather="user"></i>
                                <span>Module View Management</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('users.index') }}">
                                <i data-feather="user"></i>
                                <span>Users</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('audit.index') }}">
                                <i class="mdi mdi-history"></i>
                                <span>Audit Logs</span>
                            </a>
                        </li>

                        <li>
                            <a href="javascript: void(0);" class="has-arrow">
                                <i class="mdi mdi-store-settings-outline"></i>
                                <span data-key="t-authentication">Cursor</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li>
                                    <a href="{{ route('forms.fields.index', ['form' => 1]) }}">
                                        <i data-feather="chevron-right"></i>
                                        <span>Form Fields</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('field-types.index') }}">
                                        <i data-feather="chevron-right"></i>
                                        <span>Field Types</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('field-categories.index') }}">
                                        <i data-feather="chevron-right"></i>
                                        <span>Field Categories</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('table-builder.templates.index') }}">
                                        <i data-feather="chevron-right"></i>
                                        <span>Table Builder</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif
                @endauth

                <li>
                         
                     <a href="javascript: void(0);" class="has-arrow">
                                <i class="mdi mdi-cog"></i>
                                <span data-key="t-authentication">Settings</span>
                            </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li>
                    <a href="{{ route('user.settings') }}">
                        <i data-feather="chevron-right"></i>
                        <span>Setting</span>
                    </a>
                    </li>
                    <li>
                        <form action="{{url('logout')}}" method="post">
                            @csrf
                         <button class="btn btn btn-primary">
                        <i data-feather="chevron-right"></i>
                        Logout</button>
                        </form>
                    </a>
                    </li>
                    
                     <li>
                    <a href="{{ route('product') }}">
                        <i data-feather="chevron-right"></i>
                        <span>product</span>
                    </a>
                    </li>
                    
                    <a href="{{ route('prodview') }}">
                        <i data-feather="chevron-right"></i>
                        <span>product View</span>
                    </a>
                    </li>
                    
                    
                  </ul>

                
                </li>

            </ul>
        </div>
    </div>
</div>
