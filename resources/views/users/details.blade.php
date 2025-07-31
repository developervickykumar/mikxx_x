@extends('layouts.master')

@section('content')

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <section class="bg-white rounded-2xl shadow-sm p-6">
        <h2 class="text-xl font-semibold mb-6 flex items-center gap-2">
            <span class="material-icons-outlined text-blue-500">person</span> User Profile: {{ $user->full_name ?? $user->username }}
        </h2>
        
        
        <div class="flex justify-between items-center mb-6">
          
          <button id="toggleViewBtn" class="capsule-btn bg-gray-200 text-sm font-medium text-gray-800 px-4 py-2 rounded-md">Switch to Tabbed View</button>
        </div>
        
        <div id="classic-view" class="">
        
            <!-- Profile Summary -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="col-span-1">
                    <img src="{{ $user->profile_picture ? asset('uploads/profile_pics/' . $user->profile_picture) : asset('images/default-avatar.png') }}" alt="Profile Picture" class="w-40 h-40 rounded-full object-cover mx-auto">
                    <div class="text-center mt-3">
                        <h3 class="text-lg font-bold">{{ $user->first_name }} {{ $user->last_name }}</h3>
                        <p class="text-sm text-gray-600">{{ $user->role->name ?? 'User' }}</p>
                        <p class="text-xs text-gray-400">Joined: {{ $user->created_at->format('Y-m-d') }}</p>
                    </div>
                </div>
        
                <!-- User Info -->
                <div class="col-span-3 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label>Email</label>
                        <div class="font-medium">{{ $user->email }}</div>
                    </div>
                    <div>
                        <label>Contact</label>
                        <div class="font-medium">{{ $user->contact ?? '-' }}</div>
                    </div>
                    <div>
                        <label>Date of Birth</label>
                        <div class="font-medium">{{ $user->dob ?? '-' }}</div>
                    </div>
                    <div>
                        <label>Gender</label>
                        <div class="font-medium">{{ ucfirst($user->gender) }}</div>
                    </div>
                    <div>
                        <label>Country</label>
                        <div class="font-medium">{{ $user->country_name ?? '-' }}</div>
                    </div>
                    <div>
                        <label>Timezone</label>
                        <div class="font-medium">{{ $user->timezone ?? '-' }}</div>
                    </div>
                    <div>
                        <label>Status</label>
                        <div class="font-medium">{{ $user->status ? 'Active' : 'Inactive' }}</div>
                    </div>
                </div>
            </div>
        
         <!-- Subscription & Wallet -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div class="bg-purple-100 p-4 rounded-xl">
                    <h4 class="font-semibold text-purple-800">Subscription Plan</h4>
                    <p class="mt-1">{{ $subscription->plan_name ?? 'No active plan' }}</p>
                </div>
                <div class="bg-orange-100 p-4 rounded-xl">
                    <h4 class="font-semibold text-orange-800">Wallet Balance</h4>
                    <p class="mt-1">₹{{ number_format($walletBalance, 2) }}</p>
                </div>
            </div>
           
            
            <!-- Business Info -->
            
             @if ($user->businesses->isNotEmpty())
                <div class="mb-8">
                    <h3 class="text-lg font-semibold mb-3">Business Details</h3>

                        @foreach ($user->businesses as $business)
                            <div class="bg-white p-4 border rounded mb-4">
                                <strong>Business Name:</strong> <a class="text-primary" target="_blank" href="{{ route('user.business', $business->slug) }}">{{ $business->name }} </a><br>
                                <strong>Description:</strong> {{ $business->description ?? '-' }}<br>
                                <strong>Website:</strong>  <a class="text-primary" target="_blank" href="{{ $business->website }}">{{ $business->website }}</a> 
                            </div>
                        @endforeach
                    @else
                        <p class="text-gray-500 italic">No business pages created.</p>
                </div>
            @endif
            
            <!-- Profile Fields -->
            <div class="mt-10">
                <h3 class="text-lg font-semibold mb-3">Custom Profile Fields</h3>
                @if ($user->profileFields->count())
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach ($user->profileFields as $field)
                            <div class="bg-gray-50 p-3 rounded">
                                <label class="text-sm text-gray-600">{{ $field->field_name }}</label>
                                <div class="text-sm font-medium text-gray-800">{{ $field->field_value }}</div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 italic">No profile fields available.</p>
                @endif
            </div>
        
            
            <!-- User Media -->
            <div class="mt-10">
                <h3 class="text-lg font-semibold mb-3">User Media</h3>
                @if ($user->media->count())
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        @foreach ($user->media as $media)
                            <div class="border rounded overflow-hidden bg-white shadow-sm">
                                @if($media->media_type == 'image')
                                    <img src="{{ asset('uploads/media/' . $media->file_path) }}" class="w-full h-40 object-cover" alt="Media">
                                @else
                                    <div class="p-4">
                                        <p class="text-sm">{{ ucfirst($media->media_type) }}</p>
                                        <a href="{{ asset('uploads/media/' . $media->file_path) }}" class="text-blue-500 text-xs" target="_blank">View {{ $media->media_type }}</a>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 italic">No media uploaded.</p>
                @endif
            </div>
        
        <!-- Stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                <div class="bg-blue-100 p-4 rounded-xl">
                    <div class="text-sm text-blue-800">Total Logins</div>
                    <div class="text-2xl font-bold">{{ $stats['total_logins'] }}</div>
                </div>
                <div class="bg-yellow-100 p-4 rounded-xl">
                    <div class="text-sm text-yellow-800">Failed Attempts</div>
                    <div class="text-2xl font-bold">{{ $stats['failed_logins'] }}</div>
                </div>
                <div class="bg-green-100 p-4 rounded-xl">
                    <div class="text-sm text-green-800">Posts Created</div>
                    <div class="text-2xl font-bold">{{ '1' }}</div>
                </div>
            </div>
        
        
        
            <!-- Login History -->
            <div class="mb-10">
                <h3 class="text-lg font-semibold mb-3">Login History (Recent 50)</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm border rounded-lg">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-3 py-2">Time</th>
                                <th class="px-3 py-2">IP</th>
                                <th class="px-3 py-2">Device</th>
                                <th class="px-3 py-2">OS</th>
                                <th class="px-3 py-2">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($loginHistory as $log)
                            <tr>
                                <td class="px-3 py-2">{{ $log->login_time }}</td>
                                <td class="px-3 py-2">{{ $log->ip_address }}</td>
                                <td class="px-3 py-2">{{ $log->device_model }}</td>
                                <td class="px-3 py-2">{{ $log->os }}</td>
                                <td class="px-3 py-2">
                                    <span class="status-badge status-{{ $log->status == 'success' ? 'success' : ($log->status == 'failed' ? 'error' : 'blocked') }}">
                                        {{ ucfirst($log->status) }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="5" class="text-center py-4 text-gray-400">No login history found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        
            <!-- Audit Logs -->
            <div>
                <h3 class="text-lg font-semibold mb-3">Recent Activity Logs</h3>
                <ul class="text-sm text-gray-700 space-y-1">
                    @forelse ($audits as $log)
                        <li>• {{ $log->created_at->diffForHumans() }} - {{ $log->action ?? 'N/A' }}</li>
                    @empty
                        <li class="text-gray-500 italic">No audit logs available.</li>
                    @endforelse
                </ul>
            </div>
            
        </div>
        
        <!--  switch view-->
        
        
        
        <div id="tabbed-view" class="hidden">
          <div class="mb-4 border-b border-gray-200">
            <ul class="flex flex-wrap text-sm font-medium text-center" id="tabs">
              <li><button class="tab-link px-4 py-2" data-tab="overview">Overview</button></li>
              <li><button class="tab-link px-4 py-2" data-tab="business">Business</button></li>
              <li><button class="tab-link px-4 py-2" data-tab="wallet">Wallet</button></li>
              <li><button class="tab-link px-4 py-2" data-tab="media">Media</button></li>
              <li><button class="tab-link px-4 py-2" data-tab="interests">Interests</button></li>
              <li><button class="tab-link px-4 py-2" data-tab="logins">Login History</button></li>
            </ul>
          </div>
        
          <div id="tab-content">
            <!-- Overview -->
            <div class="tab-pane" id="tab-overview">
              <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="col-span-1">
                  <img src="{{ $user->profile_picture ? asset('uploads/profile_pics/' . $user->profile_picture) : asset('images/default-avatar.png') }}" class="w-40 h-40 rounded-full object-cover mx-auto">
                  <div class="text-center mt-3">
                    <h3 class="text-lg font-bold">{{ $user->first_name }} {{ $user->last_name }}</h3>
                    <p class="text-sm text-gray-600">{{ $user->role->name ?? 'User' }}</p>
                    <p class="text-xs text-gray-400">Joined: {{ $user->created_at->format('Y-m-d') }}</p>
                  </div>
                </div>
                <div class="col-span-3 grid grid-cols-1 md:grid-cols-2 gap-4">
                  <div><label>Email</label><div class="font-medium">{{ $user->email }}</div></div>
                  <div><label>Contact</label><div class="font-medium">{{ $user->contact ?? '-' }}</div></div>
                  <div><label>Date of Birth</label><div class="font-medium">{{ $user->dob ?? '-' }}</div></div>
                  <div><label>Gender</label><div class="font-medium">{{ ucfirst($user->gender) }}</div></div>
                  <div><label>Country</label><div class="font-medium">{{ $user->country_name ?? '-' }}</div></div>
                  <div><label>Timezone</label><div class="font-medium">{{ $user->timezone ?? '-' }}</div></div>
                  <div><label>Status</label><div class="font-medium">{{ $user->status ? 'Active' : 'Inactive' }}</div></div>
                </div>
              </div>
            </div>
        
            <!-- Business -->
            <div class="tab-pane hidden" id="tab-business">
              <h3 class="text-lg font-semibold mb-3">Business Details</h3>
              @if ($user->business)
              <div class="bg-white p-4 border rounded">
                <strong>Business Name:</strong> {{ $user->business->name }}<br>
                <strong>Type:</strong> {{ $user->business->type ?? '-' }}<br>
                <strong>Status:</strong> {{ $user->business->status ?? '-' }}
              </div>
              @else
              <p class="text-gray-500 italic">No business page created.</p>
              @endif
            </div>
        
            <!-- Wallet -->
            <div class="tab-pane hidden" id="tab-wallet">
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div class="bg-purple-100 p-4 rounded-xl">
                  <h4 class="font-semibold text-purple-800">Subscription Plan</h4>
                  <p class="mt-1">{{ $subscription->plan_name ?? 'No active plan' }}</p>
                </div>
                <div class="bg-orange-100 p-4 rounded-xl">
                  <h4 class="font-semibold text-orange-800">Wallet Balance</h4>
                  <p class="mt-1">₹{{ number_format($walletBalance, 2) }}</p>
                </div>
              </div>
            </div>
        
            <!-- Media -->
            <div class="tab-pane hidden" id="tab-media">
              <h3 class="text-lg font-semibold mb-3">User Media</h3>
              <ul class="list-disc ml-6 text-sm">
                @forelse ($user->media as $media)
                  <li>{{ $media->media_type }} - {{ $media->url }}</li>
                @empty
                  <li class="text-gray-400 italic">No media uploaded.</li>
                @endforelse
              </ul>
            </div>
        
            <!-- Interests -->
            <div class="tab-pane hidden" id="tab-interests">
              <h3 class="text-lg font-semibold mb-3">User Interests</h3>
              <ul class="list-disc ml-6 text-sm">
                @forelse ($user->interests as $interest)
                  <li>{{ $interest->name }}</li>
                @empty
                  <li class="text-gray-400 italic">No interests available.</li>
                @endforelse
              </ul>
            </div>
        
            <!-- Logins -->
            <div class="tab-pane hidden" id="tab-logins">
              <h3 class="text-lg font-semibold mb-3">Login History</h3>
              <table class="min-w-full text-sm border rounded-lg">
                <thead class="bg-gray-100">
                  <tr>
                    <th class="px-3 py-2">Time</th>
                    <th class="px-3 py-2">IP</th>
                    <th class="px-3 py-2">Device</th>
                    <th class="px-3 py-2">OS</th>
                    <th class="px-3 py-2">Status</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($loginHistory as $log)
                  <tr>
                    <td class="px-3 py-2">{{ $log->login_time }}</td>
                    <td class="px-3 py-2">{{ $log->ip_address }}</td>
                    <td class="px-3 py-2">{{ $log->device_model }}</td>
                    <td class="px-3 py-2">{{ $log->os }}</td>
                    <td class="px-3 py-2">
                      <span class="status-badge status-{{ $log->status == 'success' ? 'success' : ($log->status == 'failed' ? 'error' : 'blocked') }}">
                        {{ ucfirst($log->status) }}
                      </span>
                    </td>
                  </tr>
                  @empty
                  <tr><td colspan="5" class="text-center py-4 text-gray-400">No login history found.</td></tr>
                  @endforelse
                </tbody>
              </table>
            </div>
          </div>
        </div>
        
        <script>
            const toggleBtn = document.getElementById('toggleViewBtn');
            const tabbedView = document.getElementById('tabbed-view');
            const classicView = document.getElementById('classic-view');
            
            let tabState = false;
            
            toggleBtn.addEventListener('click', () => {
              tabState = !tabState;
              tabbedView.classList.toggle('hidden', !tabState);
              classicView.classList.toggle('hidden', tabState);
              toggleBtn.innerText = tabState ? 'Switch to Classic View' : 'Switch to Tabbed View';
            });
            
            document.querySelectorAll('.tab-link').forEach(button => {
              button.addEventListener('click', () => {
                document.querySelectorAll('.tab-pane').forEach(tab => tab.classList.add('hidden'));
                document.getElementById('tab-' + button.dataset.tab).classList.remove('hidden');
              });
            });
    </script>
        
        <!---->
        
        
    </section>

@endsection