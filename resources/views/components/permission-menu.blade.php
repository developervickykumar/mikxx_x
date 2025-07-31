@props(['active' => ''])

<div class="bg-white shadow-sm rounded-lg p-4">
    <h3 class="text-lg font-semibold text-gray-900 mb-4">Permission Management</h3>
    
    <nav class="space-y-1">
        {{-- Business Roles --}}
        <div class="space-y-1">
            <h4 class="text-sm font-medium text-gray-500 px-3">Business Roles</h4>
            <a href="{{ route('business.roles.index') }}" 
               class="group flex items-center px-3 py-2 text-sm font-medium rounded-md {{ $active === 'roles' ? 'bg-indigo-50 text-indigo-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                <svg class="mr-3 h-5 w-5 {{ $active === 'roles' ? 'text-indigo-500' : 'text-gray-400 group-hover:text-gray-500' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                Roles
            </a>
        </div>

        {{-- Permissions --}}
        <div class="space-y-1">
            <h4 class="text-sm font-medium text-gray-500 px-3">Permissions</h4>
            <a href="{{ route('business.permissions.index') }}" 
               class="group flex items-center px-3 py-2 text-sm font-medium rounded-md {{ $active === 'permissions' ? 'bg-indigo-50 text-indigo-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                <svg class="mr-3 h-5 w-5 {{ $active === 'permissions' ? 'text-indigo-500' : 'text-gray-400 group-hover:text-gray-500' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                </svg>
                Permissions
            </a>
        </div>

        {{-- Permission Groups --}}
        <div class="space-y-1">
            <h4 class="text-sm font-medium text-gray-500 px-3">Groups</h4>
            <a href="{{ route('business.permission-groups.index') }}" 
               class="group flex items-center px-3 py-2 text-sm font-medium rounded-md {{ $active === 'groups' ? 'bg-indigo-50 text-indigo-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                <svg class="mr-3 h-5 w-5 {{ $active === 'groups' ? 'text-indigo-500' : 'text-gray-400 group-hover:text-gray-500' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
                Permission Groups
            </a>
        </div>

        {{-- User Roles --}}
        <div class="space-y-1">
            <h4 class="text-sm font-medium text-gray-500 px-3">User Management</h4>
            <a href="{{ route('business.user-roles.index') }}" 
               class="group flex items-center px-3 py-2 text-sm font-medium rounded-md {{ $active === 'user-roles' ? 'bg-indigo-50 text-indigo-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                <svg class="mr-3 h-5 w-5 {{ $active === 'user-roles' ? 'text-indigo-500' : 'text-gray-400 group-hover:text-gray-500' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                User Roles
            </a>
        </div>

        {{-- Audit Logs --}}
        <div class="space-y-1">
            <h4 class="text-sm font-medium text-gray-500 px-3">Audit</h4>
            <a href="{{ route('business.audit-logs.index') }}" 
               class="group flex items-center px-3 py-2 text-sm font-medium rounded-md {{ $active === 'audit-logs' ? 'bg-indigo-50 text-indigo-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                <svg class="mr-3 h-5 w-5 {{ $active === 'audit-logs' ? 'text-indigo-500' : 'text-gray-400 group-hover:text-gray-500' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                </svg>
                Audit Logs
            </a>
        </div>
    </nav>
</div> 