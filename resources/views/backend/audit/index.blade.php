@extends('layouts.master')

@section('content')
 
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    .tab-btn.active {
      background-color: #3b82f6;
      color: white;
    }
    .input-field {
      border-radius: 9999px;
      padding: 0.5rem 1rem;
      border: 1px solid #e5e7eb;
    }
    .input-field:focus {
      border-color: #3b82f6;
      outline: none;
      box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.1);
    }
    .status-badge {
      padding: 0.25rem 0.75rem;
      border-radius: 9999px;
      font-size: 0.75rem;
      font-weight: 500;
    }
    .status-success { background-color: #dcfce7; color: #166534; }
    .status-warning { background-color: #fef3c7; color: #92400e; }
    .status-error { background-color: #fee2e2; color: #991b1b; }
    .card-hover:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }
    .capsule-btn {
      border-radius: 9999px;
      padding: 0.5rem 1.5rem;
      font-weight: 500;
      transition: background 0.2s;
    }
  </style>
 
  <div>
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row justify-between items-center mb-6">
      <h1 class="text-2xl font-bold text-center md:text-left">Audit Logs & Activity Tracking</h1>
      <div class="flex gap-2 mt-4 md:mt-0">
        <button class="capsule-btn bg-blue-600 text-white font-medium flex items-center gap-1 hover:bg-blue-700 transition">
          <span class="material-icons-outlined">notifications</span>
          <span class="hidden md:inline">Notifications</span>
        </button>
        <button class="capsule-btn bg-blue-600 text-white font-medium flex items-center gap-1 hover:bg-blue-700 transition">
          <span class="material-icons-outlined">help_outline</span>
          <span class="hidden md:inline">Help</span>
        </button>
      </div>
    </div>
    
    <!---->
    <section class="bg-white rounded-2xl shadow-sm p-6">
        <h2 class="text-xl font-semibold mb-4 flex items-center gap-2">
            <span class="material-icons-outlined text-blue-500">admin_panel_settings</span>
            Admin Login History
        </h2>
    
        <!-- Admin Overview -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-blue-50 rounded-xl p-4">
                <div class="text-sm text-blue-600">Total Logins</div>
                <div class="text-2xl font-bold">{{ $summary['total_logins'] }}</div>
                <div class="text-xs text-gray-500">Last 30 Days</div>
            </div>
            <div class="bg-green-50 rounded-xl p-4">
                <div class="text-sm text-green-600">Active Admins</div>
                <div class="text-2xl font-bold">{{ $summary['active_users'] }}</div>
                <div class="text-xs text-gray-500">Last 24 Hours</div>
            </div>
            <div class="bg-yellow-50 rounded-xl p-4">
                <div class="text-sm text-yellow-600">Failed Attempts</div>
                <div class="text-2xl font-bold">{{ $summary['failed_attempts'] }}</div>
                <div class="text-xs text-gray-500">Last 30 Days</div>
            </div>
            <div class="bg-red-50 rounded-xl p-4">
                <div class="text-sm text-red-600">Blocked IPs</div>
                <div class="text-2xl font-bold">{{ $summary['blocked_ips'] }}</div>
                <div class="text-xs text-gray-500">Last 30 Days</div>
            </div>
        </div>
    
        <!-- Admin Controls -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
            <div class="flex gap-2 flex-wrap">
                <button class="capsule-btn bg-blue-600 text-white font-semibold flex items-center gap-1">
                    <span class="material-icons-outlined">file_download</span> Export Logs
                </button>
                <button class="capsule-btn bg-green-600 text-white font-semibold flex items-center gap-1">
                    <span class="material-icons-outlined">filter_list</span> Filter
                </button>
            </div>
            <div class="flex gap-2 flex-wrap items-center">
                <input type="text" class="input-field" placeholder="Search admin logs...">
                <select class="input-field">
                    <option>All Logins</option>
                    <option>Successful</option>
                    <option>Failed</option>
                    <option>Blocked</option>
                </select>
            </div>
        </div>
    
        <!-- Admin Logs Table -->
        <div class="overflow-x-auto mb-6">
            <table class="min-w-full text-sm border rounded-lg">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-3 py-2">Log ID</th>
                        <th class="px-3 py-2">User</th>
                        <th class="px-3 py-2">Location</th>
                        <th class="px-3 py-2">Status</th>
                        <th class="px-3 py-2">IP Address</th>
                        <th class="px-3 py-2">Device</th>
                        <th class="px-3 py-2">Date/Time</th>
                        <th class="px-3 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($logs as $log)
                        <tr>
                            <td class="px-3 py-2">ADM{{ str_pad($log->id, 3, '0', STR_PAD_LEFT) }}</td>
                            <td class="px-3 py-2">{{ $log->user->first_name ?? 'N/A' }} {{ $log->user->last_name ?? '' }}</td>
                            <td class="px-3 py-2">{{ $log->location }}</td>
                            <td class="px-3 py-2">
                                <span class="status-badge status-{{ $log->status == 'success' ? 'success' : ($log->status == 'failed' ? 'error' : 'warning') }}">
                                    {{ ucfirst($log->status) }}
                                </span>
                            </td>
                            <td class="px-3 py-2">{{ $log->ip_address }}</td>
                            <td class="px-3 py-2">{{ $log->browser }}/{{ $log->os }}</td>
                            <td class="px-3 py-2">{{ $log->login_time->format('Y-m-d H:i') }}</td>
                            <td class="px-3 py-2">
                                <a href="{{ route('user.detail', ['id' => $log->user->id]) }}" class="capsule-btn bg-blue-600 text-white text-xs">View</a>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    
        <!-- Admin Analytics -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-gray-50 rounded-xl p-4">
                <h3 class="font-semibold mb-4">Login Attempts by Role</h3>
                <canvas id="adminRoleChart" height="200"></canvas>
            </div>
            <div class="bg-gray-50 rounded-xl p-4">
                <h3 class="font-semibold mb-4">Login Success Rate</h3>
                <canvas id="adminSuccessChart" height="200"></canvas>
            </div>
        </div>
    </section>

    
    <!---->
    
    <div class="flex flex-col md:flex-row gap-6">
      <!-- Vertical Tabs -->
      <nav class="w-72 flex-shrink-0">
        <div class="sticky top-4">
          <div class="mb-4">
            <input type="text" placeholder="Search..." class="input-field w-full"/>
          </div>
         <ul class="flex flex-col gap-2 text-sm font-medium">
              <li><button id="tab-0" class="tab-btn w-full flex items-center gap-2 px-4 py-3 rounded-full bg-blue-600 text-white font-semibold focus:outline-none"><span class="material-icons-outlined">home</span> Dashboard</button></li>
              <li><button id="tab-1" class="tab-btn w-full flex items-center gap-2 px-4 py-3 rounded-full hover:bg-gray-100 transition"><span class="material-icons-outlined">fact_check</span> Audit Log Dashboard</button></li>
              <li><button id="tab-2" class="tab-btn w-full flex items-center gap-2 px-4 py-3 rounded-full hover:bg-gray-100 transition"><span class="material-icons-outlined">history_edu</span> User Activity Logs</button></li>
              <li><button id="tab-3" class="tab-btn w-full flex items-center gap-2 px-4 py-3 rounded-full hover:bg-gray-100 transition"><span class="material-icons-outlined">admin_panel_settings</span> Admin Login History</button></li>
              <li><button id="tab-4" class="tab-btn w-full flex items-center gap-2 px-4 py-3 rounded-full hover:bg-gray-100 transition"><span class="material-icons-outlined">update</span> Page Update History</button></li>
              <li><button id="tab-5" class="tab-btn w-full flex items-center gap-2 px-4 py-3 rounded-full hover:bg-gray-100 transition"><span class="material-icons-outlined">timeline</span> Data Change Timeline</button></li>
              <li><button id="tab-6" class="tab-btn w-full flex items-center gap-2 px-4 py-3 rounded-full hover:bg-gray-100 transition"><span class="material-icons-outlined">assignment_turned_in</span> Form Submission History</button></li>
              <li><button id="tab-7" class="tab-btn w-full flex items-center gap-2 px-4 py-3 rounded-full hover:bg-gray-100 transition"><span class="material-icons-outlined">vpn_key</span> Permission Change Logs</button></li>
              <li><button id="tab-8" class="tab-btn w-full flex items-center gap-2 px-4 py-3 rounded-full hover:bg-gray-100 transition"><span class="material-icons-outlined">error</span> Failed Action Logs</button></li>
              <li><button id="tab-9" class="tab-btn w-full flex items-center gap-2 px-4 py-3 rounded-full hover:bg-gray-100 transition"><span class="material-icons-outlined">file_download</span> Export Logs</button></li>
              <li><button id="tab-10" class="tab-btn w-full flex items-center gap-2 px-4 py-3 rounded-full hover:bg-gray-100 transition"><span class="material-icons-outlined">devices</span> IP & Device Logs</button></li>
              <li><button id="tab-11" class="tab-btn w-full flex items-center gap-2 px-4 py-3 rounded-full hover:bg-gray-100 transition"><span class="material-icons-outlined">warning_amber</span> Suspicious Activity</button></li>
              <li><button id="tab-12" class="tab-btn w-full flex items-center gap-2 px-4 py-3 rounded-full hover:bg-gray-100 transition"><span class="material-icons-outlined">analytics</span> Analytics Dashboard</button></li>
              <li><button id="tab-13" class="tab-btn w-full flex items-center gap-2 px-4 py-3 rounded-full hover:bg-gray-100 transition"><span class="material-icons-outlined">security</span> Security Compliance</button></li>
              <li><button id="tab-14" class="tab-btn w-full flex items-center gap-2 px-4 py-3 rounded-full hover:bg-gray-100 transition"><span class="material-icons-outlined">backup</span> Log Backup & Archive</button></li>
              <li><button id="tab-15" class="tab-btn w-full flex items-center gap-2 px-4 py-3 rounded-full hover:bg-gray-100 transition"><span class="material-icons-outlined">integration_instructions</span> API & Integration Logs</button></li>
              <li><button id="tab-16" class="tab-btn w-full flex items-center gap-2 px-4 py-3 rounded-full hover:bg-gray-100 transition"><span class="material-icons-outlined">people</span> Demography</button></li>
              <li><button id="tab-17" class="tab-btn w-full flex items-center gap-2 px-4 py-3 rounded-full hover:bg-gray-100 transition"><span class="material-icons-outlined">search</span> Search Report</button></li>
              <li><button id="tab-18" class="tab-btn w-full flex items-center gap-2 px-4 py-3 rounded-full hover:bg-gray-100 transition"><span class="material-icons-outlined">bug_report</span> Complaints & Bugs</button></li>
              <li><button id="tab-19" class="tab-btn w-full flex items-center gap-2 px-4 py-3 rounded-full hover:bg-gray-100 transition"><span class="material-icons-outlined">gavel</span> Police & Government Audit</button></li>
              <li><button id="tab-20" class="tab-btn w-full flex items-center gap-2 px-4 py-3 rounded-full hover:bg-gray-100 transition"><span class="material-icons-outlined">devices_other</span> User Devices Information</button></li>
            </ul>

        </div>
      </nav>
      <!-- Tab Content -->
      <div class="flex-1">
          
          <!-- Dashboard Tab Content -->
        <div class="tab-content" id="content-0">
          <section class="bg-white rounded-2xl shadow-sm p-6 mb-6">
            <h3 class="text-lg font-semibold mb-4">Audit Log Report</h3>
            <div class="grid grid-cols-1  gap-4">
               <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                <div class="bg-blue-100 rounded-xl p-4 flex flex-col items-center card-hover">
                  <span class="material-icons-outlined text-3xl text-blue-400 mb-2">fact_check</span>
                  <div class="text-lg font-bold">1,200</div>
                  <div class="text-sm text-gray-500">Total Logs</div>
                </div>
                <div class="bg-green-100 rounded-xl p-4 flex flex-col items-center card-hover">
                  <span class="material-icons-outlined text-3xl text-green-400 mb-2">check_circle</span>
                  <div class="text-lg font-bold">1,100</div>
                  <div class="text-sm text-gray-500">Success</div>
                </div>
                <div class="bg-yellow-100 rounded-xl p-4 flex flex-col items-center card-hover">
                  <span class="material-icons-outlined text-3xl text-yellow-400 mb-2">error</span>
                  <div class="text-lg font-bold">100</div>
                  <div class="text-sm text-gray-500">Failed</div>
                </div>
              </div>
            </div>
         
            <h3 class="text-lg font-semibold mb-4">Admin Login History</h3>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
              <div class="bg-blue-50 rounded-xl p-4">
                <div class="text-sm text-blue-600">Total Logins</div>
                <div class="text-2xl font-bold">1,234</div>
                <div class="text-xs text-gray-500">Last 30 Days</div>
              </div>
              <div class="bg-green-50 rounded-xl p-4">
                <div class="text-sm text-green-600">Active Admins</div>
                <div class="text-2xl font-bold">45</div>
                <div class="text-xs text-gray-500">Last 24 Hours</div>
              </div>
              <div class="bg-yellow-50 rounded-xl p-4">
                <div class="text-sm text-yellow-600">Failed Attempts</div>
                <div class="text-2xl font-bold">23</div>
                <div class="text-xs text-gray-500">Last 30 Days</div>
              </div>
              <div class="bg-red-50 rounded-xl p-4">
                <div class="text-sm text-red-600">Blocked IPs</div>
                <div class="text-2xl font-bold">5</div>
                <div class="text-xs text-gray-500">Last 30 Days</div>
              </div>
            </div>

          </section>
        </div>
            

        <!-- Audit Log Dashboard -->
        <div class="tab-content hidden" id="content-1">
          <section class="bg-white rounded-2xl shadow-sm p-6 mb-6">
            <h2 class="text-xl font-semibold mb-4 flex items-center gap-2"><span class="material-icons-outlined text-blue-500">fact_check</span> Audit Log Dashboard</h2>
            <!-- Controls Bar -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-4">
              <div class="flex gap-2 flex-wrap">
                <button class="capsule-btn bg-blue-600 text-white font-semibold flex items-center gap-1"><span class="material-icons-outlined">file_download</span> Export Logs</button>
                <button class="capsule-btn bg-green-600 text-white font-semibold flex items-center gap-1"><span class="material-icons-outlined">file_upload</span> Import</button>
                <button class="capsule-btn bg-gray-600 text-white font-semibold flex items-center gap-1"><span class="material-icons-outlined">integration_instructions</span> Integrate</button>
                <button class="capsule-btn bg-yellow-600 text-white font-semibold flex items-center gap-1"><span class="material-icons-outlined">code</span> Embed</button>
              </div>
              <div class="flex gap-2 flex-wrap items-center">
                <input type="text" class="input-field" placeholder="Search logs..."/>
                <select class="input-field">
                  <option>All Types</option>
                  <option>User</option>
                  <option>Admin</option>
                  <option>Page</option>
                  <option>Permission</option>
                  <option>Form</option>
                  <option>Failed</option>
                  <option>Suspicious</option>
                </select>
                <select class="input-field">
                  <option>Sort By</option>
                  <option>Date</option>
                  <option>Type</option>
                  <option>User</option>
                </select>
              </div>
            </div>
            <!-- List/Grid/Post View Toggle -->
            <div class="flex gap-2 mb-4">
              <button class="view-toggle px-2 py-1 rounded bg-blue-100 text-blue-700" data-view="list"><span class="material-icons-outlined">view_list</span></button>
              <button class="view-toggle px-2 py-1 rounded hover:bg-blue-100" data-view="grid"><span class="material-icons-outlined">grid_view</span></button>
              <button class="view-toggle px-2 py-1 rounded hover:bg-blue-100" data-view="post"><span class="material-icons-outlined">article</span></button>
            </div>
            <!-- Table/List View -->
            <div class="overflow-x-auto view-section" data-view="list">
              <table class="min-w-full text-sm border rounded-lg">
                <thead class="bg-gray-100">
                  <tr>
                    <th class="px-3 py-2"><input type="checkbox"/></th>
                    <th class="px-3 py-2">Log ID</th>
                    <th class="px-3 py-2">Type</th>
                    <th class="px-3 py-2">User/Admin</th>
                    <th class="px-3 py-2">Action</th>
                    <th class="px-3 py-2">Page/Resource</th>
                    <th class="px-3 py-2">Date/Time</th>
                    <th class="px-3 py-2">IP Address</th>
                    <th class="px-3 py-2">Device/Browser</th>
                    <th class="px-3 py-2">Status</th>
                    <th class="px-3 py-2">Details</th>
                    <th class="px-3 py-2">Attachments</th>
                    <th class="px-3 py-2">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td class="px-3 py-2"><input type="checkbox"/></td>
                    <td class="px-3 py-2">LOG001</td>
                    <td class="px-3 py-2">User</td>
                    <td class="px-3 py-2">Alice Smith</td>
                    <td class="px-3 py-2">Login</td>
                    <td class="px-3 py-2">Dashboard</td>
                    <td class="px-3 py-2">2024-06-12 09:00</td>
                    <td class="px-3 py-2">192.168.1.10</td>
                    <td class="px-3 py-2">Chrome/Win10</td>
                    <td class="px-3 py-2"><span class="status-badge status-success">Success</span></td>
                    <td class="px-3 py-2">-</td>
                    <td class="px-3 py-2">-</td>
                    <td class="px-3 py-2 flex gap-1">
                      <button class="capsule-btn bg-green-600 text-white text-xs">View</button>
                      <button class="capsule-btn bg-red-600 text-white text-xs">Delete</button>
                    </td>
                  </tr>
                  <tr>
                    <td class="px-3 py-2"><input type="checkbox"/></td>
                    <td class="px-3 py-2">LOG002</td>
                    <td class="px-3 py-2">Admin</td>
                    <td class="px-3 py-2">John Doe</td>
                    <td class="px-3 py-2">Update</td>
                    <td class="px-3 py-2">User Settings</td>
                    <td class="px-3 py-2">2024-06-12 09:15</td>
                    <td class="px-3 py-2">192.168.1.11</td>
                    <td class="px-3 py-2">Firefox/MacOS</td>
                    <td class="px-3 py-2"><span class="status-badge status-success">Success</span></td>
                    <td class="px-3 py-2">Updated user permissions</td>
                    <td class="px-3 py-2">config.json</td>
                    <td class="px-3 py-2 flex gap-1">
                      <button class="capsule-btn bg-green-600 text-white text-xs">View</button>
                      <button class="capsule-btn bg-red-600 text-white text-xs">Delete</button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <!-- Grid View -->
            <div class="hidden view-section grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4" data-view="grid">
              <div class="bg-gray-50 rounded-xl p-4 shadow flex flex-col card-hover">
                <div class="font-semibold">Alice Smith</div>
                <div class="text-xs text-gray-500 mb-1">Log ID: LOG001</div>
                <div class="text-xs text-gray-500 mb-1">Type: User</div>
                <div class="text-xs text-gray-500 mb-1">Action: Login</div>
                <div class="text-xs text-gray-500 mb-1">Page: Dashboard</div>
                <div class="text-xs text-gray-500 mb-1">Date/Time: 2024-06-12 09:00</div>
                <div class="text-xs text-gray-500 mb-1">IP: 192.168.1.10</div>
                <div class="text-xs text-gray-500 mb-1">Device: Chrome/Win10</div>
                <div class="text-xs text-gray-500 mb-1">Status: <span class="status-badge status-success">Success</span></div>
                <div class="text-xs text-gray-500 mb-1">Details: -</div>
                <div class="text-xs text-gray-500 mb-1">Attachments: -</div>
                <div class="flex gap-2 mt-2">
                  <button class="capsule-btn bg-green-600 text-white text-xs">View</button>
                  <button class="capsule-btn bg-red-600 text-white text-xs">Delete</button>
                </div>
              </div>
              <div class="bg-gray-50 rounded-xl p-4 shadow flex flex-col card-hover">
                <div class="font-semibold">John Doe</div>
                <div class="text-xs text-gray-500 mb-1">Log ID: LOG002</div>
                <div class="text-xs text-gray-500 mb-1">Type: Admin</div>
                <div class="text-xs text-gray-500 mb-1">Action: Update</div>
                <div class="text-xs text-gray-500 mb-1">Page: User Settings</div>
                <div class="text-xs text-gray-500 mb-1">Date/Time: 2024-06-12 09:15</div>
                <div class="text-xs text-gray-500 mb-1">IP: 192.168.1.11</div>
                <div class="text-xs text-gray-500 mb-1">Device: Firefox/MacOS</div>
                <div class="text-xs text-gray-500 mb-1">Status: <span class="status-badge status-success">Success</span></div>
                <div class="text-xs text-gray-500 mb-1">Details: Updated user permissions</div>
                <div class="text-xs text-gray-500 mb-1">Attachments: config.json</div>
                <div class="flex gap-2 mt-2">
                  <button class="capsule-btn bg-green-600 text-white text-xs">View</button>
                  <button class="capsule-btn bg-red-600 text-white text-xs">Delete</button>
                </div>
              </div>
            </div>
            <!-- Post View -->
            <div class="hidden view-section" data-view="post">
              <div class="bg-gray-50 rounded-xl p-4 shadow flex flex-col card-hover">
                <div class="font-semibold">Alice Smith</div>
                <div class="text-xs text-gray-500 mb-1">Log ID: LOG001</div>
                <div class="text-xs text-gray-500 mb-1">Type: User</div>
                <div class="text-xs text-gray-500 mb-1">Action: Login</div>
                <div class="text-xs text-gray-500 mb-1">Page: Dashboard</div>
                <div class="text-xs text-gray-500 mb-1">Date/Time: 2024-06-12 09:00</div>
                <div class="text-xs text-gray-500 mb-1">IP: 192.168.1.10</div>
                <div class="text-xs text-gray-500 mb-1">Device: Chrome/Win10</div>
                <div class="text-xs text-gray-500 mb-1">Status: <span class="status-badge status-success">Success</span></div>
                <div class="text-xs text-gray-500 mb-1">Details: -</div>
                <div class="text-xs text-gray-500 mb-1">Attachments: -</div>
                <div class="flex gap-2 mt-2">
                  <button class="capsule-btn bg-green-600 text-white text-xs">View</button>
                  <button class="capsule-btn bg-red-600 text-white text-xs">Delete</button>
                </div>
              </div>
              <div class="bg-gray-50 rounded-xl p-4 shadow flex flex-col card-hover mt-4">
                <div class="font-semibold">John Doe</div>
                <div class="text-xs text-gray-500 mb-1">Log ID: LOG002</div>
                <div class="text-xs text-gray-500 mb-1">Type: Admin</div>
                <div class="text-xs text-gray-500 mb-1">Action: Update</div>
                <div class="text-xs text-gray-500 mb-1">Page: User Settings</div>
                <div class="text-xs text-gray-500 mb-1">Date/Time: 2024-06-12 09:15</div>
                <div class="text-xs text-gray-500 mb-1">IP: 192.168.1.11</div>
                <div class="text-xs text-gray-500 mb-1">Device: Firefox/MacOS</div>
                <div class="text-xs text-gray-500 mb-1">Status: <span class="status-badge status-success">Success</span></div>
                <div class="text-xs text-gray-500 mb-1">Details: Updated user permissions</div>
                <div class="text-xs text-gray-500 mb-1">Attachments: config.json</div>
                <div class="flex gap-2 mt-2">
                  <button class="capsule-btn bg-green-600 text-white text-xs">View</button>
                  <button class="capsule-btn bg-red-600 text-white text-xs">Delete</button>
                </div>
              </div>
            </div>
            <!-- Reports Section -->
            <div class="mt-8 bg-gray-50 rounded-xl p-4">
              <h3 class="text-lg font-semibold mb-4">Audit Log Report</h3>
              <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                <div class="bg-blue-100 rounded-xl p-4 flex flex-col items-center card-hover">
                  <span class="material-icons-outlined text-3xl text-blue-400 mb-2">fact_check</span>
                  <div class="text-lg font-bold">1,200</div>
                  <div class="text-sm text-gray-500">Total Logs</div>
                </div>
                <div class="bg-green-100 rounded-xl p-4 flex flex-col items-center card-hover">
                  <span class="material-icons-outlined text-3xl text-green-400 mb-2">check_circle</span>
                  <div class="text-lg font-bold">1,100</div>
                  <div class="text-sm text-gray-500">Success</div>
                </div>
                <div class="bg-yellow-100 rounded-xl p-4 flex flex-col items-center card-hover">
                  <span class="material-icons-outlined text-3xl text-yellow-400 mb-2">error</span>
                  <div class="text-lg font-bold">100</div>
                  <div class="text-sm text-gray-500">Failed</div>
                </div>
              </div>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                  <h4 class="font-semibold mb-2">Log Type Distribution</h4>
                  <ul class="list-disc pl-6 text-gray-700 space-y-1">
                    <li>User: 600</li>
                    <li>Admin: 200</li>
                    <li>Page: 150</li>
                    <li>Permission: 100</li>
                    <li>Form: 80</li>
                    <li>Failed: 50</li>
                    <li>Suspicious: 20</li>
                  </ul>
                </div>
                <div>
                  <h4 class="font-semibold mb-2">Recent Activity</h4>
                  <ul class="list-disc pl-6 text-gray-700 space-y-1">
                    <li>User login: Alice Smith</li>
                    <li>Permission changed: Bob Lee</li>
                    <li>Failed login: Jane Doe</li>
                  </ul>
                </div>
              </div>
              <div class="mt-4">
                <canvas id="auditLogChart" height="120"></canvas>
              </div>
            </div>
         
          </section>
        </div>

        <!-- User Activity Logs -->
        <div class="tab-content hidden" id="content-2">
          <section class="bg-white rounded-2xl shadow-sm p-6">
            <h2 class="text-xl font-semibold mb-4 flex items-center gap-2"><span class="material-icons-outlined text-blue-500">history_edu</span> User Activity Logs</h2>
            
            <!-- Activity Overview -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
              <div class="bg-blue-50 rounded-xl p-4">
                <div class="text-sm text-blue-600">Total Activities</div>
                <div class="text-2xl font-bold">8,234</div>
                <div class="text-xs text-gray-500">Last 30 Days</div>
              </div>
              <div class="bg-green-50 rounded-xl p-4">
                <div class="text-sm text-green-600">Active Users</div>
                <div class="text-2xl font-bold">1,234</div>
                <div class="text-xs text-gray-500">Last 24 Hours</div>
              </div>
              <div class="bg-yellow-50 rounded-xl p-4">
                <div class="text-sm text-yellow-600">Avg. Session Time</div>
                <div class="text-2xl font-bold">12m</div>
                <div class="text-xs text-gray-500">Last 30 Days</div>
              </div>
              <div class="bg-purple-50 rounded-xl p-4">
                <div class="text-sm text-purple-600">Page Views</div>
                <div class="text-2xl font-bold">45,678</div>
                <div class="text-xs text-gray-500">Last 30 Days</div>
              </div>
            </div>

            <!-- Activity Controls -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
              <div class="flex gap-2 flex-wrap">
                <button class="capsule-btn bg-blue-600 text-white font-semibold flex items-center gap-1">
                  <span class="material-icons-outlined">file_download</span> Export Logs
                </button>
                <button class="capsule-btn bg-green-600 text-white font-semibold flex items-center gap-1">
                  <span class="material-icons-outlined">filter_list</span> Filter
                </button>
              </div>
              <div class="flex gap-2 flex-wrap items-center">
                <input type="text" class="input-field" placeholder="Search activities..."/>
                <select class="input-field">
                  <option>All Activities</option>
                  <option>Login</option>
                  <option>Logout</option>
                  <option>Profile Update</option>
                  <option>Settings Change</option>
                </select>
              </div>
            </div>

            <!-- Activity Logs Table -->
            <div class="overflow-x-auto mb-6">
              <table class="min-w-full text-sm border rounded-lg">
                <thead class="bg-gray-100">
                  <tr>
                    <th class="px-3 py-2">Log ID</th>
                    <th class="px-3 py-2">User</th>
                    <th class="px-3 py-2">Activity</th>
                    <th class="px-3 py-2">Page/Resource</th>
                    <th class="px-3 py-2">Date/Time</th>
                    <th class="px-3 py-2">IP Address</th>
                    <th class="px-3 py-2">Device</th>
                    <th class="px-3 py-2">Status</th>
                    <th class="px-3 py-2">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td class="px-3 py-2">ACT001</td>
                    <td class="px-3 py-2">Sarah Wilson</td>
                    <td class="px-3 py-2">Profile Update</td>
                    <td class="px-3 py-2">/profile/settings</td>
                    <td class="px-3 py-2">2024-06-12 10:30</td>
                    <td class="px-3 py-2">192.168.1.100</td>
                    <td class="px-3 py-2">Chrome/MacOS</td>
                    <td class="px-3 py-2"><span class="status-badge status-success">Success</span></td>
                    <td class="px-3 py-2">
                      <button class="capsule-btn bg-blue-600 text-white text-xs">View</button>
                    </td>
                  </tr>
                  <tr>
                    <td class="px-3 py-2">ACT002</td>
                    <td class="px-3 py-2">Mike Johnson</td>
                    <td class="px-3 py-2">Login</td>
                    <td class="px-3 py-2">/auth/login</td>
                    <td class="px-3 py-2">2024-06-12 10:35</td>
                    <td class="px-3 py-2">192.168.1.101</td>
                    <td class="px-3 py-2">Firefox/Windows</td>
                    <td class="px-3 py-2"><span class="status-badge status-success">Success</span></td>
                    <td class="px-3 py-2">
                      <button class="capsule-btn bg-blue-600 text-white text-xs">View</button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>

            <!-- Activity Analytics -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div class="bg-gray-50 rounded-xl p-4">
                <h3 class="font-semibold mb-4">Activity by Type</h3>
                <canvas id="userActivityTypeChart" height="200"></canvas>
              </div>
              <div class="bg-gray-50 rounded-xl p-4">
                <h3 class="font-semibold mb-4">Hourly Activity</h3>
                <canvas id="userHourlyActivityChart" height="200"></canvas>
              </div>
            </div>
          </section>
        </div>

        <!-- Admin Login History -->
        <div class="tab-content hidden" id="content-3">
          <section class="bg-white rounded-2xl shadow-sm p-6">
            <h2 class="text-xl font-semibold mb-4 flex items-center gap-2"><span class="material-icons-outlined text-blue-500">admin_panel_settings</span> Admin Login History</h2>
            
            <!-- Admin Overview -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
              <div class="bg-blue-50 rounded-xl p-4">
                <div class="text-sm text-blue-600">Total Logins</div>
                <div class="text-2xl font-bold">1,234</div>
                <div class="text-xs text-gray-500">Last 30 Days</div>
              </div>
              <div class="bg-green-50 rounded-xl p-4">
                <div class="text-sm text-green-600">Active Admins</div>
                <div class="text-2xl font-bold">45</div>
                <div class="text-xs text-gray-500">Last 24 Hours</div>
              </div>
              <div class="bg-yellow-50 rounded-xl p-4">
                <div class="text-sm text-yellow-600">Failed Attempts</div>
                <div class="text-2xl font-bold">23</div>
                <div class="text-xs text-gray-500">Last 30 Days</div>
              </div>
              <div class="bg-red-50 rounded-xl p-4">
                <div class="text-sm text-red-600">Blocked IPs</div>
                <div class="text-2xl font-bold">5</div>
                <div class="text-xs text-gray-500">Last 30 Days</div>
              </div>
            </div>

            <!-- Admin Controls -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
              <div class="flex gap-2 flex-wrap">
                <button class="capsule-btn bg-blue-600 text-white font-semibold flex items-center gap-1">
                  <span class="material-icons-outlined">file_download</span> Export Logs
                </button>
                <button class="capsule-btn bg-green-600 text-white font-semibold flex items-center gap-1">
                  <span class="material-icons-outlined">filter_list</span> Filter
                </button>
              </div>
              <div class="flex gap-2 flex-wrap items-center">
                <input type="text" class="input-field" placeholder="Search admin logs..."/>
                <select class="input-field">
                  <option>All Logins</option>
                  <option>Successful</option>
                  <option>Failed</option>
                  <option>Blocked</option>
                </select>
              </div>
            </div>

            <!-- Admin Logs Table -->
            <div class="overflow-x-auto mb-6">
              <table class="min-w-full text-sm border rounded-lg">
                <thead class="bg-gray-100">
                  <tr>
                    <th class="px-3 py-2">Log ID</th>
                    <th class="px-3 py-2">Admin</th>
                    <th class="px-3 py-2">Role</th>
                    <th class="px-3 py-2">Status</th>
                    <th class="px-3 py-2">IP Address</th>
                    <th class="px-3 py-2">Device</th>
                    <th class="px-3 py-2">Date/Time</th>
                    <th class="px-3 py-2">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td class="px-3 py-2">ADM001</td>
                    <td class="px-3 py-2">John Admin</td>
                    <td class="px-3 py-2">Super Admin</td>
                    <td class="px-3 py-2"><span class="status-badge status-success">Success</span></td>
                    <td class="px-3 py-2">192.168.1.100</td>
                    <td class="px-3 py-2">Chrome/MacOS</td>
                    <td class="px-3 py-2">2024-06-12 09:00</td>
                    <td class="px-3 py-2">
                      <button class="capsule-btn bg-blue-600 text-white text-xs">View</button>
                    </td>
                  </tr>
                  <tr>
                    <td class="px-3 py-2">ADM002</td>
                    <td class="px-3 py-2">Jane Manager</td>
                    <td class="px-3 py-2">Content Admin</td>
                    <td class="px-3 py-2"><span class="status-badge status-error">Failed</span></td>
                    <td class="px-3 py-2">192.168.1.101</td>
                    <td class="px-3 py-2">Firefox/Windows</td>
                    <td class="px-3 py-2">2024-06-12 09:15</td>
                    <td class="px-3 py-2">
                      <button class="capsule-btn bg-blue-600 text-white text-xs">View</button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>

            <!-- Admin Analytics -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div class="bg-gray-50 rounded-xl p-4">
                <h3 class="font-semibold mb-4">Login Attempts by Role</h3>
                <canvas id="adminRoleChart" height="200"></canvas>
              </div>
              <div class="bg-gray-50 rounded-xl p-4">
                <h3 class="font-semibold mb-4">Login Success Rate</h3>
                <canvas id="adminSuccessChart" height="200"></canvas>
              </div>
            </div>
          </section>
        </div>

        <!-- Page Update History -->
        <div class="tab-content hidden" id="content-4">
          <section class="bg-white rounded-2xl shadow-sm p-6">
            <h2 class="text-xl font-semibold mb-4 flex items-center gap-2"><span class="material-icons-outlined text-blue-500">update</span> Page Update History</h2>
            
            <!-- Update Overview -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
              <div class="bg-blue-50 rounded-xl p-4">
                <div class="text-sm text-blue-600">Total Updates</div>
                <div class="text-2xl font-bold">567</div>
                <div class="text-xs text-gray-500">Last 30 Days</div>
              </div>
              <div class="bg-green-50 rounded-xl p-4">
                <div class="text-sm text-green-600">Updated Pages</div>
                <div class="text-2xl font-bold">45</div>
                <div class="text-xs text-gray-500">Last 30 Days</div>
              </div>
              <div class="bg-yellow-50 rounded-xl p-4">
                <div class="text-sm text-yellow-600">Pending Reviews</div>
                <div class="text-2xl font-bold">12</div>
                <div class="text-xs text-gray-500">Last 30 Days</div>
              </div>
              <div class="bg-purple-50 rounded-xl p-4">
                <div class="text-sm text-purple-600">Active Editors</div>
                <div class="text-2xl font-bold">23</div>
                <div class="text-xs text-gray-500">Last 30 Days</div>
              </div>
            </div>

            <!-- Update Controls -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
              <div class="flex gap-2 flex-wrap">
                <button class="capsule-btn bg-blue-600 text-white font-semibold flex items-center gap-1">
                  <span class="material-icons-outlined">file_download</span> Export History
                </button>
                <button class="capsule-btn bg-green-600 text-white font-semibold flex items-center gap-1">
                  <span class="material-icons-outlined">filter_list</span> Filter
                </button>
              </div>
              <div class="flex gap-2 flex-wrap items-center">
                <input type="text" class="input-field" placeholder="Search updates..."/>
                <select class="input-field">
                  <option>All Updates</option>
                  <option>Content</option>
                  <option>Design</option>
                  <option>Structure</option>
                  <option>Media</option>
                </select>
              </div>
            </div>

            <!-- Update History Table -->
            <div class="overflow-x-auto mb-6">
              <table class="min-w-full text-sm border rounded-lg">
                <thead class="bg-gray-100">
                  <tr>
                    <th class="px-3 py-2">Update ID</th>
                    <th class="px-3 py-2">Page</th>
                    <th class="px-3 py-2">Type</th>
                    <th class="px-3 py-2">Updated By</th>
                    <th class="px-3 py-2">Date/Time</th>
                    <th class="px-3 py-2">Status</th>
                    <th class="px-3 py-2">Changes</th>
                    <th class="px-3 py-2">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td class="px-3 py-2">UPD001</td>
                    <td class="px-3 py-2">Home Page</td>
                    <td class="px-3 py-2">Content</td>
                    <td class="px-3 py-2">Sarah Editor</td>
                    <td class="px-3 py-2">2024-06-12 11:00</td>
                    <td class="px-3 py-2"><span class="status-badge status-success">Published</span></td>
                    <td class="px-3 py-2">Updated hero section</td>
                    <td class="px-3 py-2">
                      <button class="capsule-btn bg-blue-600 text-white text-xs">View</button>
                    </td>
                  </tr>
                  <tr>
                    <td class="px-3 py-2">UPD002</td>
                    <td class="px-3 py-2">About Page</td>
                    <td class="px-3 py-2">Design</td>
                    <td class="px-3 py-2">Mike Designer</td>
                    <td class="px-3 py-2">2024-06-12 11:30</td>
                    <td class="px-3 py-2"><span class="status-badge status-warning">Pending</span></td>
                    <td class="px-3 py-2">Updated layout</td>
                    <td class="px-3 py-2">
                      <button class="capsule-btn bg-blue-600 text-white text-xs">View</button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>

            <!-- Update Analytics -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div class="bg-gray-50 rounded-xl p-4">
                <h3 class="font-semibold mb-4">Updates by Type</h3>
                <canvas id="updateTypeChart" height="200"></canvas>
              </div>
              <div class="bg-gray-50 rounded-xl p-4">
                <h3 class="font-semibold mb-4">Update Frequency</h3>
                <canvas id="updateFrequencyChart" height="200"></canvas>
              </div>
            </div>
          </section>
        </div>

        <!-- Data Change Timeline -->
        <div class="tab-content hidden" id="content-5">
          <section class="bg-white rounded-2xl shadow-sm p-6">
            <h2 class="text-xl font-semibold mb-4 flex items-center gap-2"><span class="material-icons-outlined text-blue-500">timeline</span> Data Change Timeline</h2>
            <div class="space-y-6">
              <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div class="flex gap-2 flex-wrap">
                  <button class="capsule-btn bg-blue-600 text-white font-semibold flex items-center gap-1"><span class="material-icons-outlined">file_download</span> Export Timeline</button>
                  <button class="capsule-btn bg-green-600 text-white font-semibold flex items-center gap-1"><span class="material-icons-outlined">filter_list</span> Filter</button>
                </div>
                <div class="flex gap-2 flex-wrap items-center">
                  <input type="text" class="input-field" placeholder="Search changes..."/>
                  <select class="input-field">
                    <option>All Changes</option>
                    <option>Created</option>
                    <option>Updated</option>
                    <option>Deleted</option>
                  </select>
                </div>
              </div>
              <div class="relative border-l-2 border-blue-200 ml-4">
                <div class="mb-8 ml-6">
                  <div class="absolute w-4 h-4 bg-blue-500 rounded-full -left-[9px]"></div>
                  <div class="bg-gray-50 rounded-xl p-4 shadow-sm">
                    <div class="flex justify-between items-start">
                      <div>
                        <h3 class="font-semibold">User Profile Updated</h3>
                        <p class="text-sm text-gray-600">Changed email and phone number</p>
                      </div>
                      <span class="text-xs text-gray-500">2 hours ago</span>
                    </div>
                    <div class="mt-2 text-sm">
                      <div class="flex items-center gap-2">
                        <span class="material-icons-outlined text-blue-500 text-sm">person</span>
                        <span>John Doe</span>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="mb-8 ml-6">
                  <div class="absolute w-4 h-4 bg-green-500 rounded-full -left-[9px]"></div>
                  <div class="bg-gray-50 rounded-xl p-4 shadow-sm">
                    <div class="flex justify-between items-start">
                      <div>
                        <h3 class="font-semibold">New User Created</h3>
                        <p class="text-sm text-gray-600">Added new user account</p>
                      </div>
                      <span class="text-xs text-gray-500">4 hours ago</span>
                    </div>
                    <div class="mt-2 text-sm">
                      <div class="flex items-center gap-2">
                        <span class="material-icons-outlined text-green-500 text-sm">person_add</span>
                        <span>Jane Smith</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </section>
        </div>

        <!-- Form Submission History -->
        <div class="tab-content hidden" id="content-6">
          <section class="bg-white rounded-2xl shadow-sm p-6">
            <h2 class="text-xl font-semibold mb-4 flex items-center gap-2"><span class="material-icons-outlined text-blue-500">assignment_turned_in</span> Form Submission History</h2>
            <div class="space-y-6">
              <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div class="flex gap-2 flex-wrap">
                  <button class="capsule-btn bg-blue-600 text-white font-semibold flex items-center gap-1"><span class="material-icons-outlined">file_download</span> Export Submissions</button>
                  <button class="capsule-btn bg-green-600 text-white font-semibold flex items-center gap-1"><span class="material-icons-outlined">filter_list</span> Filter</button>
                </div>
                <div class="flex gap-2 flex-wrap items-center">
                  <input type="text" class="input-field" placeholder="Search submissions..."/>
                  <select class="input-field">
                    <option>All Forms</option>
                    <option>Contact</option>
                    <option>Registration</option>
                    <option>Feedback</option>
                  </select>
                </div>
              </div>
              <div class="overflow-x-auto">
                <table class="min-w-full text-sm border rounded-lg">
                  <thead class="bg-gray-100">
                    <tr>
                      <th class="px-3 py-2">Form ID</th>
                      <th class="px-3 py-2">Form Type</th>
                      <th class="px-3 py-2">Submitted By</th>
                      <th class="px-3 py-2">Date/Time</th>
                      <th class="px-3 py-2">Status</th>
                      <th class="px-3 py-2">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td class="px-3 py-2">FORM001</td>
                      <td class="px-3 py-2">Contact</td>
                      <td class="px-3 py-2">Mike Johnson</td>
                      <td class="px-3 py-2">2024-06-12 10:30</td>
                      <td class="px-3 py-2"><span class="status-badge status-success">Processed</span></td>
                      <td class="px-3 py-2">
                        <button class="capsule-btn bg-blue-600 text-white text-xs">View</button>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </section>
        </div>

        <!-- Permission Change Logs -->
        <div class="tab-content hidden" id="content-7">
          <section class="bg-white rounded-2xl shadow-sm p-6">
            <h2 class="text-xl font-semibold mb-4 flex items-center gap-2"><span class="material-icons-outlined text-blue-500">vpn_key</span> Permission Change Logs</h2>
            <div class="space-y-6">
              <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div class="flex gap-2 flex-wrap">
                  <button class="capsule-btn bg-blue-600 text-white font-semibold flex items-center gap-1"><span class="material-icons-outlined">file_download</span> Export Logs</button>
                  <button class="capsule-btn bg-green-600 text-white font-semibold flex items-center gap-1"><span class="material-icons-outlined">filter_list</span> Filter</button>
                </div>
                <div class="flex gap-2 flex-wrap items-center">
                  <input type="text" class="input-field" placeholder="Search permissions..."/>
                  <select class="input-field">
                    <option>All Changes</option>
                    <option>Added</option>
                    <option>Removed</option>
                    <option>Modified</option>
                  </select>
                </div>
              </div>
              <div class="overflow-x-auto">
                <table class="min-w-full text-sm border rounded-lg">
                  <thead class="bg-gray-100">
                    <tr>
                      <th class="px-3 py-2">Log ID</th>
                      <th class="px-3 py-2">User</th>
                      <th class="px-3 py-2">Changed By</th>
                      <th class="px-3 py-2">Permission</th>
                      <th class="px-3 py-2">Action</th>
                      <th class="px-3 py-2">Date/Time</th>
                      <th class="px-3 py-2">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td class="px-3 py-2">PERM001</td>
                      <td class="px-3 py-2">Sarah Wilson</td>
                      <td class="px-3 py-2">Admin User</td>
                      <td class="px-3 py-2">Admin Access</td>
                      <td class="px-3 py-2">Added</td>
                      <td class="px-3 py-2">2024-06-12 11:15</td>
                      <td class="px-3 py-2">
                        <button class="capsule-btn bg-blue-600 text-white text-xs">View</button>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </section>
        </div>

        <!-- Failed Action Logs -->
        <div class="tab-content hidden" id="content-8">
          <section class="bg-white rounded-2xl shadow-sm p-6">
            <h2 class="text-xl font-semibold mb-4 flex items-center gap-2"><span class="material-icons-outlined text-blue-500">error</span> Failed Action Logs</h2>
            <div class="space-y-6">
              <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div class="flex gap-2 flex-wrap">
                  <button class="capsule-btn bg-blue-600 text-white font-semibold flex items-center gap-1"><span class="material-icons-outlined">file_download</span> Export Logs</button>
                  <button class="capsule-btn bg-green-600 text-white font-semibold flex items-center gap-1"><span class="material-icons-outlined">filter_list</span> Filter</button>
                </div>
                <div class="flex gap-2 flex-wrap items-center">
                  <input type="text" class="input-field" placeholder="Search failed actions..."/>
                  <select class="input-field">
                    <option>All Types</option>
                    <option>Login</option>
                    <option>Permission</option>
                    <option>Data Access</option>
                    <option>API</option>
                  </select>
                </div>
              </div>
              <div class="overflow-x-auto">
                <table class="min-w-full text-sm border rounded-lg">
                  <thead class="bg-gray-100">
                    <tr>
                      <th class="px-3 py-2">Log ID</th>
                      <th class="px-3 py-2">Action</th>
                      <th class="px-3 py-2">User</th>
                      <th class="px-3 py-2">Error Type</th>
                      <th class="px-3 py-2">Date/Time</th>
                      <th class="px-3 py-2">Details</th>
                      <th class="px-3 py-2">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td class="px-3 py-2">FAIL001</td>
                      <td class="px-3 py-2">Login</td>
                      <td class="px-3 py-2">Unknown</td>
                      <td class="px-3 py-2">Invalid Credentials</td>
                      <td class="px-3 py-2">2024-06-12 12:00</td>
                      <td class="px-3 py-2">Failed login attempt</td>
                      <td class="px-3 py-2">
                        <button class="capsule-btn bg-blue-600 text-white text-xs">View</button>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </section>
        </div>

        <!-- Export Logs -->
        <div class="tab-content hidden" id="content-9">
          <section class="bg-white rounded-2xl shadow-sm p-6">
            <h2 class="text-xl font-semibold mb-4 flex items-center gap-2"><span class="material-icons-outlined text-blue-500">file_download</span> Export Logs</h2>
            <div class="space-y-6">
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-gray-50 rounded-xl p-6">
                  <h3 class="text-lg font-semibold mb-4">Export Options</h3>
                  <div class="space-y-4">
                    <div>
                      <label class="block text-sm font-medium mb-2">Export Format</label>
                      <select class="input-field w-full">
                        <option>CSV</option>
                        <option>Excel</option>
                        <option>PDF</option>
                        <option>JSON</option>
                      </select>
                    </div>
                    <div>
                      <label class="block text-sm font-medium mb-2">Date Range</label>
                      <div class="flex gap-2">
                        <input type="date" class="input-field flex-1"/>
                        <input type="date" class="input-field flex-1"/>
                      </div>
                    </div>
                    <div>
                      <label class="block text-sm font-medium mb-2">Log Types</label>
                      <div class="space-y-2">
                        <label class="flex items-center gap-2">
                          <input type="checkbox" class="rounded"/>
                          <span>User Activity</span>
                        </label>
                        <label class="flex items-center gap-2">
                          <input type="checkbox" class="rounded"/>
                          <span>Admin Actions</span>
                        </label>
                        <label class="flex items-center gap-2">
                          <input type="checkbox" class="rounded"/>
                          <span>System Events</span>
                        </label>
                      </div>
                    </div>
                    <button class="capsule-btn bg-blue-600 text-white font-semibold w-full">Export Logs</button>
                  </div>
                </div>
                <div class="bg-gray-50 rounded-xl p-6">
                  <h3 class="text-lg font-semibold mb-4">Recent Exports</h3>
                  <div class="space-y-4">
                    <div class="flex items-center justify-between p-3 bg-white rounded-lg">
                      <div>
                        <div class="font-medium">User Activity Logs</div>
                        <div class="text-sm text-gray-500">CSV • 2.5MB</div>
                      </div>
                      <button class="capsule-btn bg-blue-600 text-white text-xs">Download</button>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-white rounded-lg">
                      <div>
                        <div class="font-medium">System Events</div>
                        <div class="text-sm text-gray-500">PDF • 1.8MB</div>
                      </div>
                      <button class="capsule-btn bg-blue-600 text-white text-xs">Download</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </section>
        </div>

        <!-- IP & Device Logs -->
        <div class="tab-content hidden" id="content-10">
          <section class="bg-white rounded-2xl shadow-sm p-6">
            <h2 class="text-xl font-semibold mb-4 flex items-center gap-2"><span class="material-icons-outlined text-blue-500">devices</span> IP & Device Logs</h2>
            <div class="space-y-6">
              <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div class="flex gap-2 flex-wrap">
                  <button class="capsule-btn bg-blue-600 text-white font-semibold flex items-center gap-1"><span class="material-icons-outlined">file_download</span> Export Logs</button>
                  <button class="capsule-btn bg-green-600 text-white font-semibold flex items-center gap-1"><span class="material-icons-outlined">filter_list</span> Filter</button>
                </div>
                <div class="flex gap-2 flex-wrap items-center">
                  <input type="text" class="input-field" placeholder="Search IP/device..."/>
                  <select class="input-field">
                    <option>All Types</option>
                    <option>IP Address</option>
                    <option>Device</option>
                    <option>Browser</option>
                    <option>OS</option>
                  </select>
                </div>
              </div>
              <div class="overflow-x-auto">
                <table class="min-w-full text-sm border rounded-lg">
                  <thead class="bg-gray-100">
                    <tr>
                      <th class="px-3 py-2">Log ID</th>
                      <th class="px-3 py-2">User</th>
                      <th class="px-3 py-2">IP Address</th>
                      <th class="px-3 py-2">Device</th>
                      <th class="px-3 py-2">Browser</th>
                      <th class="px-3 py-2">OS</th>
                      <th class="px-3 py-2">Date/Time</th>
                      <th class="px-3 py-2">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td class="px-3 py-2">IP001</td>
                      <td class="px-3 py-2">Tom Brown</td>
                      <td class="px-3 py-2">192.168.1.20</td>
                      <td class="px-3 py-2">iPhone 13</td>
                      <td class="px-3 py-2">Safari</td>
                      <td class="px-3 py-2">iOS 15</td>
                      <td class="px-3 py-2">2024-06-12 13:00</td>
                      <td class="px-3 py-2">
                        <button class="capsule-btn bg-blue-600 text-white text-xs">View</button>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </section>
        </div>

        <!-- Suspicious Activity -->
        <div class="tab-content hidden" id="content-11">
          <section class="bg-white rounded-2xl shadow-sm p-6">
            <h2 class="text-xl font-semibold mb-4 flex items-center gap-2"><span class="material-icons-outlined text-blue-500">warning_amber</span> Suspicious Activity</h2>
            <div class="space-y-6">
              <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div class="bg-red-50 rounded-xl p-4">
                  <div class="flex items-center gap-2 text-red-600">
                    <span class="material-icons-outlined">warning</span>
                    <span class="font-semibold">High Risk</span>
                  </div>
                  <div class="text-2xl font-bold mt-2">12</div>
                  <div class="text-sm text-gray-600">Activities</div>
                </div>
                <div class="bg-yellow-50 rounded-xl p-4">
                  <div class="flex items-center gap-2 text-yellow-600">
                    <span class="material-icons-outlined">warning</span>
                    <span class="font-semibold">Medium Risk</span>
                  </div>
                  <div class="text-2xl font-bold mt-2">28</div>
                  <div class="text-sm text-gray-600">Activities</div>
                </div>
                <div class="bg-blue-50 rounded-xl p-4">
                  <div class="flex items-center gap-2 text-blue-600">
                    <span class="material-icons-outlined">security</span>
                    <span class="font-semibold">Blocked IPs</span>
                  </div>
                  <div class="text-2xl font-bold mt-2">5</div>
                  <div class="text-sm text-gray-600">Addresses</div>
                </div>
              </div>
              <div class="overflow-x-auto">
                <table class="min-w-full text-sm border rounded-lg">
                  <thead class="bg-gray-100">
                    <tr>
                      <th class="px-3 py-2">ID</th>
                      <th class="px-3 py-2">Type</th>
                      <th class="px-3 py-2">Risk Level</th>
                      <th class="px-3 py-2">IP Address</th>
                      <th class="px-3 py-2">Details</th>
                      <th class="px-3 py-2">Date/Time</th>
                      <th class="px-3 py-2">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td class="px-3 py-2">SUSP001</td>
                      <td class="px-3 py-2">Multiple Failed Logins</td>
                      <td class="px-3 py-2"><span class="status-badge status-error">High</span></td>
                      <td class="px-3 py-2">192.168.1.100</td>
                      <td class="px-3 py-2">10 failed attempts in 5 minutes</td>
                      <td class="px-3 py-2">2024-06-12 14:00</td>
                      <td class="px-3 py-2">
                        <button class="capsule-btn bg-red-600 text-white text-xs">Block IP</button>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </section>
        </div>

        <!-- Analytics Dashboard -->
        <div class="tab-content hidden" id="content-12">
          <section class="bg-white rounded-2xl shadow-sm p-6">
            <h2 class="text-xl font-semibold mb-4 flex items-center gap-2"><span class="material-icons-outlined text-blue-500">analytics</span> Analytics Dashboard</h2>
            <div class="space-y-6">
              <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="bg-blue-50 rounded-xl p-4">
                  <div class="text-sm text-blue-600">Total Logs</div>
                  <div class="text-2xl font-bold">1,234</div>
                  <div class="text-xs text-gray-500">+12% from last week</div>
                </div>
                <div class="bg-green-50 rounded-xl p-4">
                  <div class="text-sm text-green-600">Active Users</div>
                  <div class="text-2xl font-bold">456</div>
                  <div class="text-xs text-gray-500">+5% from last week</div>
                </div>
                <div class="bg-yellow-50 rounded-xl p-4">
                  <div class="text-sm text-yellow-600">Failed Actions</div>
                  <div class="text-2xl font-bold">23</div>
                  <div class="text-xs text-gray-500">-8% from last week</div>
                </div>
                <div class="bg-purple-50 rounded-xl p-4">
                  <div class="text-sm text-purple-600">API Calls</div>
                  <div class="text-2xl font-bold">789</div>
                  <div class="text-xs text-gray-500">+15% from last week</div>
                </div>
              </div>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-gray-50 rounded-xl p-4">
                  <h3 class="font-semibold mb-4">Activity by Type</h3>
                  <canvas id="activityTypeChart" height="200"></canvas>
                </div>
                <div class="bg-gray-50 rounded-xl p-4">
                  <h3 class="font-semibold mb-4">Hourly Activity</h3>
                  <canvas id="hourlyActivityChart" height="200"></canvas>
                </div>
              </div>
            </div>
          </section>
        </div>

        <!-- Security Compliance -->
        <div class="tab-content hidden" id="content-13">
          <section class="bg-white rounded-2xl shadow-sm p-6">
            <h2 class="text-xl font-semibold mb-4 flex items-center gap-2"><span class="material-icons-outlined text-blue-500">security</span> Security Compliance</h2>
            
            <!-- Compliance Overview -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
              <div class="bg-green-50 rounded-xl p-4">
                <div class="flex items-center gap-2 text-green-600">
                  <span class="material-icons-outlined">check_circle</span>
                  <span class="font-semibold">Compliance Score</span>
                </div>
                <div class="text-2xl font-bold mt-2">92%</div>
                <div class="text-sm text-gray-600">Overall Score</div>
              </div>
              <div class="bg-blue-50 rounded-xl p-4">
                <div class="flex items-center gap-2 text-blue-600">
                  <span class="material-icons-outlined">security</span>
                  <span class="font-semibold">Security Checks</span>
                </div>
                <div class="text-2xl font-bold mt-2">24/25</div>
                <div class="text-sm text-gray-600">Passed</div>
              </div>
              <div class="bg-yellow-50 rounded-xl p-4">
                <div class="flex items-center gap-2 text-yellow-600">
                  <span class="material-icons-outlined">warning</span>
                  <span class="font-semibold">Pending Actions</span>
                </div>
                <div class="text-2xl font-bold mt-2">3</div>
                <div class="text-sm text-gray-600">Required Updates</div>
              </div>
              <div class="bg-red-50 rounded-xl p-4">
                <div class="flex items-center gap-2 text-red-600">
                  <span class="material-icons-outlined">error</span>
                  <span class="font-semibold">Critical Issues</span>
                </div>
                <div class="text-2xl font-bold mt-2">1</div>
                <div class="text-sm text-gray-600">Needs Attention</div>
              </div>
            </div>

            <!-- Compliance Checklist -->
            <div class="bg-gray-50 rounded-xl p-4 mb-6">
              <h3 class="font-semibold mb-4">Compliance Checklist</h3>
              <div class="space-y-4">
                <div class="flex items-center justify-between p-3 bg-white rounded-lg">
                  <div class="flex items-center gap-2">
                    <span class="material-icons-outlined text-green-500">check_circle</span>
                    <span>Password Policy</span>
                  </div>
                  <span class="text-sm text-green-600">Compliant</span>
                </div>
                <div class="flex items-center justify-between p-3 bg-white rounded-lg">
                  <div class="flex items-center gap-2">
                    <span class="material-icons-outlined text-yellow-500">warning</span>
                    <span>Data Encryption</span>
                  </div>
                  <span class="text-sm text-yellow-600">Needs Update</span>
                </div>
                <div class="flex items-center justify-between p-3 bg-white rounded-lg">
                  <div class="flex items-center gap-2">
                    <span class="material-icons-outlined text-green-500">check_circle</span>
                    <span>Access Control</span>
                  </div>
                  <span class="text-sm text-green-600">Compliant</span>
                </div>
                <div class="flex items-center justify-between p-3 bg-white rounded-lg">
                  <div class="flex items-center gap-2">
                    <span class="material-icons-outlined text-red-500">error</span>
                    <span>Backup Policy</span>
                  </div>
                  <span class="text-sm text-red-600">Critical</span>
                </div>
              </div>
            </div>

            <!-- Security Recommendations -->
            <div class="bg-gray-50 rounded-xl p-4 mb-6">
              <h3 class="font-semibold mb-4">Security Recommendations</h3>
              <div class="space-y-4">
                <div class="p-3 bg-white rounded-lg">
                  <div class="flex items-center gap-2 text-yellow-600 mb-2">
                    <span class="material-icons-outlined">priority_high</span>
                    <span class="font-medium">Enable Two-Factor Authentication</span>
                  </div>
                  <p class="text-sm text-gray-600">Implement 2FA for all admin accounts to enhance security.</p>
                </div>
                <div class="p-3 bg-white rounded-lg">
                  <div class="flex items-center gap-2 text-yellow-600 mb-2">
                    <span class="material-icons-outlined">priority_high</span>
                    <span class="font-medium">Update SSL Certificates</span>
                  </div>
                  <p class="text-sm text-gray-600">SSL certificates will expire in 30 days. Please renew them.</p>
                </div>
              </div>
            </div>

            <!-- Security Audit Log -->
            <div class="bg-gray-50 rounded-xl p-4">
              <h3 class="font-semibold mb-4">Security Audit Log</h3>
              <div class="overflow-x-auto">
                <table class="min-w-full text-sm border rounded-lg">
                  <thead class="bg-gray-100">
                    <tr>
                      <th class="px-3 py-2">Date/Time</th>
                      <th class="px-3 py-2">Action</th>
                      <th class="px-3 py-2">User</th>
                      <th class="px-3 py-2">IP Address</th>
                      <th class="px-3 py-2">Status</th>
                      <th class="px-3 py-2">Details</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td class="px-3 py-2">2024-06-12 15:00</td>
                      <td class="px-3 py-2">Security Policy Update</td>
                      <td class="px-3 py-2">Admin User</td>
                      <td class="px-3 py-2">192.168.1.100</td>
                      <td class="px-3 py-2"><span class="status-badge status-success">Success</span></td>
                      <td class="px-3 py-2">Updated password policy</td>
                    </tr>
                    <tr>
                      <td class="px-3 py-2">2024-06-12 14:30</td>
                      <td class="px-3 py-2">Access Control Change</td>
                      <td class="px-3 py-2">Security Admin</td>
                      <td class="px-3 py-2">192.168.1.101</td>
                      <td class="px-3 py-2"><span class="status-badge status-warning">Warning</span></td>
                      <td class="px-3 py-2">Modified user permissions</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </section>
        </div>

        <!-- Log Backup & Archive -->
        <div class="tab-content hidden" id="content-14">
          <section class="bg-white rounded-2xl shadow-sm p-6">
            <h2 class="text-xl font-semibold mb-4 flex items-center gap-2"><span class="material-icons-outlined text-blue-500">backup</span> Log Backup & Archive</h2>
            <div class="space-y-6">
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-gray-50 rounded-xl p-6">
                  <h3 class="text-lg font-semibold mb-4">Backup Settings</h3>
                  <div class="space-y-4">
                    <div>
                      <label class="block text-sm font-medium mb-2">Backup Frequency</label>
                      <select class="input-field w-full">
                        <option>Daily</option>
                        <option>Weekly</option>
                        <option>Monthly</option>
                      </select>
                    </div>
                    <div>
                      <label class="block text-sm font-medium mb-2">Retention Period</label>
                      <select class="input-field w-full">
                        <option>30 Days</option>
                        <option>90 Days</option>
                        <option>1 Year</option>
                      </select>
                    </div>
                    <div>
                      <label class="block text-sm font-medium mb-2">Storage Location</label>
                      <select class="input-field w-full">
                        <option>Local Storage</option>
                        <option>Cloud Storage</option>
                        <option>Hybrid</option>
                      </select>
                    </div>
                    <div>
                      <label class="block text-sm font-medium mb-2">Compression Level</label>
                      <select class="input-field w-full">
                        <option>None</option>
                        <option>Low</option>
                        <option>Medium</option>
                        <option>High</option>
                      </select>
                    </div>
                    <button class="capsule-btn bg-blue-600 text-white font-semibold w-full">Save Settings</button>
                  </div>
                </div>
                <div class="bg-gray-50 rounded-xl p-6">
                  <h3 class="text-lg font-semibold mb-4">Recent Backups</h3>
                  <div class="space-y-4">
                    <div class="flex items-center justify-between p-3 bg-white rounded-lg">
                      <div>
                        <div class="font-medium">Daily Backup</div>
                        <div class="text-sm text-gray-500">2024-06-12 • 2.5GB</div>
                      </div>
                      <div class="flex gap-2">
                        <button class="capsule-btn bg-blue-600 text-white text-xs">Restore</button>
                        <button class="capsule-btn bg-green-600 text-white text-xs">Download</button>
                      </div>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-white rounded-lg">
                      <div>
                        <div class="font-medium">Weekly Archive</div>
                        <div class="text-sm text-gray-500">2024-06-05 • 15.8GB</div>
                      </div>
                      <div class="flex gap-2">
                        <button class="capsule-btn bg-blue-600 text-white text-xs">Restore</button>
                        <button class="capsule-btn bg-green-600 text-white text-xs">Download</button>
                      </div>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-white rounded-lg">
                      <div>
                        <div class="font-medium">Monthly Archive</div>
                        <div class="text-sm text-gray-500">2024-05-01 • 45.2GB</div>
                      </div>
                      <div class="flex gap-2">
                        <button class="capsule-btn bg-blue-600 text-white text-xs">Restore</button>
                        <button class="capsule-btn bg-green-600 text-white text-xs">Download</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="bg-gray-50 rounded-xl p-4">
                <h3 class="font-semibold mb-4">Backup Schedule</h3>
                <div class="overflow-x-auto">
                  <table class="min-w-full text-sm border rounded-lg">
                    <thead class="bg-gray-100">
                      <tr>
                        <th class="px-3 py-2">Type</th>
                        <th class="px-3 py-2">Frequency</th>
                        <th class="px-3 py-2">Last Backup</th>
                        <th class="px-3 py-2">Next Backup</th>
                        <th class="px-3 py-2">Status</th>
                        <th class="px-3 py-2">Size</th>
                        <th class="px-3 py-2">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td class="px-3 py-2">Full Backup</td>
                        <td class="px-3 py-2">Daily</td>
                        <td class="px-3 py-2">2024-06-12 00:00</td>
                        <td class="px-3 py-2">2024-06-13 00:00</td>
                        <td class="px-3 py-2"><span class="status-badge status-success">Completed</span></td>
                        <td class="px-3 py-2">2.5GB</td>
                        <td class="px-3 py-2">
                          <button class="capsule-btn bg-blue-600 text-white text-xs">View</button>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </section>
        </div>

        <!-- API & Integration Logs -->
        <div class="tab-content hidden" id="content-15">
          <section class="bg-white rounded-2xl shadow-sm p-6">
            <h2 class="text-xl font-semibold mb-4 flex items-center gap-2"><span class="material-icons-outlined text-blue-500">integration_instructions</span> API & Integration Logs</h2>
            
            <!-- API Overview -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
              <div class="bg-blue-50 rounded-xl p-4">
                <div class="text-sm text-blue-600">Total Requests</div>
                <div class="text-2xl font-bold">12,345</div>
                <div class="text-xs text-gray-500">Last 24 hours</div>
              </div>
              <div class="bg-green-50 rounded-xl p-4">
                <div class="text-sm text-green-600">Success Rate</div>
                <div class="text-2xl font-bold">99.8%</div>
                <div class="text-xs text-gray-500">Last 24 hours</div>
              </div>
              <div class="bg-yellow-50 rounded-xl p-4">
                <div class="text-sm text-yellow-600">Avg Response Time</div>
                <div class="text-2xl font-bold">150ms</div>
                <div class="text-xs text-gray-500">Last 24 hours</div>
              </div>
              <div class="bg-red-50 rounded-xl p-4">
                <div class="text-sm text-red-600">Error Rate</div>
                <div class="text-2xl font-bold">0.2%</div>
                <div class="text-xs text-gray-500">Last 24 hours</div>
              </div>
            </div>

            <!-- API Controls -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
              <div class="flex gap-2 flex-wrap">
                <button class="capsule-btn bg-blue-600 text-white font-semibold flex items-center gap-1">
                  <span class="material-icons-outlined">file_download</span> Export Logs
                </button>
                <button class="capsule-btn bg-green-600 text-white font-semibold flex items-center gap-1">
                  <span class="material-icons-outlined">filter_list</span> Filter
                </button>
              </div>
              <div class="flex gap-2 flex-wrap items-center">
                <input type="text" class="input-field" placeholder="Search API logs..."/>
                <select class="input-field">
                  <option>All Endpoints</option>
                  <option>GET</option>
                  <option>POST</option>
                  <option>PUT</option>
                  <option>DELETE</option>
                </select>
              </div>
            </div>

            <!-- API Logs Table -->
            <div class="overflow-x-auto mb-6">
              <table class="min-w-full text-sm border rounded-lg">
                <thead class="bg-gray-100">
                  <tr>
                    <th class="px-3 py-2">Log ID</th>
                    <th class="px-3 py-2">Endpoint</th>
                    <th class="px-3 py-2">Method</th>
                    <th class="px-3 py-2">Status</th>
                    <th class="px-3 py-2">Response Time</th>
                    <th class="px-3 py-2">IP Address</th>
                    <th class="px-3 py-2">Date/Time</th>
                    <th class="px-3 py-2">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td class="px-3 py-2">API001</td>
                    <td class="px-3 py-2">/api/users</td>
                    <td class="px-3 py-2">GET</td>
                    <td class="px-3 py-2"><span class="status-badge status-success">200</span></td>
                    <td class="px-3 py-2">150ms</td>
                    <td class="px-3 py-2">192.168.1.100</td>
                    <td class="px-3 py-2">2024-06-12 15:00</td>
                    <td class="px-3 py-2">
                      <button class="capsule-btn bg-blue-600 text-white text-xs">View</button>
                    </td>
                  </tr>
                  <tr>
                    <td class="px-3 py-2">API002</td>
                    <td class="px-3 py-2">/api/orders</td>
                    <td class="px-3 py-2">POST</td>
                    <td class="px-3 py-2"><span class="status-badge status-error">400</span></td>
                    <td class="px-3 py-2">200ms</td>
                    <td class="px-3 py-2">192.168.1.101</td>
                    <td class="px-3 py-2">2024-06-12 15:01</td>
                    <td class="px-3 py-2">
                      <button class="capsule-btn bg-blue-600 text-white text-xs">View</button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>

            <!-- Integration Status -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div class="bg-gray-50 rounded-xl p-4">
                <h3 class="font-semibold mb-4">Integration Status</h3>
                <div class="space-y-4">
                  <div class="flex items-center justify-between p-3 bg-white rounded-lg">
                    <div class="flex items-center gap-2">
                      <span class="material-icons-outlined text-green-500">check_circle</span>
                      <span>Payment Gateway</span>
                    </div>
                    <span class="text-sm text-green-600">Active</span>
                  </div>
                  <div class="flex items-center justify-between p-3 bg-white rounded-lg">
                    <div class="flex items-center gap-2">
                      <span class="material-icons-outlined text-green-500">check_circle</span>
                      <span>Email Service</span>
                    </div>
                    <span class="text-sm text-green-600">Active</span>
                  </div>
                  <div class="flex items-center justify-between p-3 bg-white rounded-lg">
                    <div class="flex items-center gap-2">
                      <span class="material-icons-outlined text-yellow-500">warning</span>
                      <span>Analytics API</span>
                    </div>
                    <span class="text-sm text-yellow-600">Degraded</span>
                  </div>
                </div>
              </div>
              <div class="bg-gray-50 rounded-xl p-4">
                <h3 class="font-semibold mb-4">API Performance</h3>
                <canvas id="apiPerformanceChart" height="200"></canvas>
              </div>
            </div>
          </section>
        </div>

        <!-- Demography -->
        <div class="tab-content hidden" id="content-16">
          <section class="bg-white rounded-2xl shadow-sm p-6">
            <h2 class="text-xl font-semibold mb-4 flex items-center gap-2"><span class="material-icons-outlined text-blue-500">people</span> Demography</h2>
            
            <!-- User Overview -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
              <div class="bg-blue-50 rounded-xl p-4">
                <div class="text-sm text-blue-600">Total Users</div>
                <div class="text-2xl font-bold">10,234</div>
                <div class="text-xs text-gray-500">All Time</div>
              </div>
              <div class="bg-green-50 rounded-xl p-4">
                <div class="text-sm text-green-600">Active Users</div>
                <div class="text-2xl font-bold">7,891</div>
                <div class="text-xs text-gray-500">Last 30 Days</div>
              </div>
              <div class="bg-yellow-50 rounded-xl p-4">
                <div class="text-sm text-yellow-600">Verified Accounts</div>
                <div class="text-2xl font-bold">8,456</div>
                <div class="text-xs text-gray-500">82.6%</div>
              </div>
              <div class="bg-red-50 rounded-xl p-4">
                <div class="text-sm text-red-600">Deleted Accounts</div>
                <div class="text-2xl font-bold">234</div>
                <div class="text-xs text-gray-500">Last 30 Days</div>
              </div>
            </div>

            <!-- Age Distribution -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
              <div class="bg-gray-50 rounded-xl p-4">
                <h3 class="font-semibold mb-4">Age Distribution</h3>
                <div class="space-y-4">
                  <div class="flex items-center justify-between p-3 bg-white rounded-lg">
                    <div class="flex items-center gap-2">
                      <span class="material-icons-outlined text-blue-500">child_care</span>
                      <span>18-24</span>
                    </div>
                    <div class="flex items-center gap-2">
                      <span class="text-sm font-medium">2,345</span>
                      <span class="text-sm text-gray-500">(22.9%)</span>
                    </div>
                  </div>
                  <div class="flex items-center justify-between p-3 bg-white rounded-lg">
                    <div class="flex items-center gap-2">
                      <span class="material-icons-outlined text-green-500">person</span>
                      <span>25-34</span>
                    </div>
                    <div class="flex items-center gap-2">
                      <span class="text-sm font-medium">3,456</span>
                      <span class="text-sm text-gray-500">(33.8%)</span>
                    </div>
                  </div>
                  <div class="flex items-center justify-between p-3 bg-white rounded-lg">
                    <div class="flex items-center gap-2">
                      <span class="material-icons-outlined text-yellow-500">elderly</span>
                      <span>35-44</span>
                    </div>
                    <div class="flex items-center gap-2">
                      <span class="text-sm font-medium">2,123</span>
                      <span class="text-sm text-gray-500">(20.7%)</span>
                    </div>
                  </div>
                  <div class="flex items-center justify-between p-3 bg-white rounded-lg">
                    <div class="flex items-center gap-2">
                      <span class="material-icons-outlined text-purple-500">elderly_woman</span>
                      <span>45+</span>
                    </div>
                    <div class="flex items-center gap-2">
                      <span class="text-sm font-medium">2,310</span>
                      <span class="text-sm text-gray-500">(22.6%)</span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="bg-gray-50 rounded-xl p-4">
                <h3 class="font-semibold mb-4">Gender Distribution</h3>
                <div class="space-y-4">
                  <div class="flex items-center justify-between p-3 bg-white rounded-lg">
                    <div class="flex items-center gap-2">
                      <span class="material-icons-outlined text-blue-500">male</span>
                      <span>Male</span>
                    </div>
                    <div class="flex items-center gap-2">
                      <span class="text-sm font-medium">5,234</span>
                      <span class="text-sm text-gray-500">(51.1%)</span>
                    </div>
                  </div>
                  <div class="flex items-center justify-between p-3 bg-white rounded-lg">
                    <div class="flex items-center gap-2">
                      <span class="material-icons-outlined text-pink-500">female</span>
                      <span>Female</span>
                    </div>
                    <div class="flex items-center gap-2">
                      <span class="text-sm font-medium">4,567</span>
                      <span class="text-sm text-gray-500">(44.6%)</span>
                    </div>
                  </div>
                  <div class="flex items-center justify-between p-3 bg-white rounded-lg">
                    <div class="flex items-center gap-2">
                      <span class="material-icons-outlined text-purple-500">transgender</span>
                      <span>Other</span>
                    </div>
                    <div class="flex items-center gap-2">
                      <span class="text-sm font-medium">433</span>
                      <span class="text-sm text-gray-500">(4.3%)</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- User Locations -->
            <div class="bg-gray-50 rounded-xl p-4 mb-6">
              <h3 class="font-semibold mb-4">User Locations</h3>
              <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-white rounded-lg p-4">
                  <h4 class="font-medium mb-2">Top Countries</h4>
                  <div class="space-y-2">
                    <div class="flex justify-between">
                      <span>United States</span>
                      <span class="text-gray-600">3,456</span>
                    </div>
                    <div class="flex justify-between">
                      <span>United Kingdom</span>
                      <span class="text-gray-600">1,234</span>
                    </div>
                    <div class="flex justify-between">
                      <span>Canada</span>
                      <span class="text-gray-600">987</span>
                    </div>
                  </div>
                </div>
                <div class="bg-white rounded-lg p-4">
                  <h4 class="font-medium mb-2">Top Cities</h4>
                  <div class="space-y-2">
                    <div class="flex justify-between">
                      <span>New York</span>
                      <span class="text-gray-600">1,234</span>
                    </div>
                    <div class="flex justify-between">
                      <span>London</span>
                      <span class="text-gray-600">987</span>
                    </div>
                    <div class="flex justify-between">
                      <span>Toronto</span>
                      <span class="text-gray-600">765</span>
                    </div>
                  </div>
                </div>
                <div class="bg-white rounded-lg p-4">
                  <h4 class="font-medium mb-2">Time Zones</h4>
                  <div class="space-y-2">
                    <div class="flex justify-between">
                      <span>EST</span>
                      <span class="text-gray-600">3,456</span>
                    </div>
                    <div class="flex justify-between">
                      <span>GMT</span>
                      <span class="text-gray-600">2,345</span>
                    </div>
                    <div class="flex justify-between">
                      <span>PST</span>
                      <span class="text-gray-600">1,234</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- User Activity Status -->
            <div class="bg-gray-50 rounded-xl p-4">
              <h3 class="font-semibold mb-4">User Activity Status</h3>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                  <canvas id="userActivityChart" height="200"></canvas>
                </div>
                <div class="space-y-4">
                  <div class="flex items-center justify-between p-3 bg-white rounded-lg">
                    <div class="flex items-center gap-2">
                      <span class="material-icons-outlined text-green-500">check_circle</span>
                      <span>Active Users</span>
                    </div>
                    <span class="text-sm text-green-600">7,891 (77.1%)</span>
                  </div>
                  <div class="flex items-center justify-between p-3 bg-white rounded-lg">
                    <div class="flex items-center gap-2">
                      <span class="material-icons-outlined text-yellow-500">schedule</span>
                      <span>Inactive Users</span>
                    </div>
                    <span class="text-sm text-yellow-600">2,109 (20.6%)</span>
                  </div>
                  <div class="flex items-center justify-between p-3 bg-white rounded-lg">
                    <div class="flex items-center gap-2">
                      <span class="material-icons-outlined text-red-500">delete</span>
                      <span>Deleted Accounts</span>
                    </div>
                    <span class="text-sm text-red-600">234 (2.3%)</span>
                  </div>
                </div>
              </div>
            </div>
          </section>
        </div>

        <!-- Search Report -->
        <div class="tab-content hidden" id="content-17">
          <section class="bg-white rounded-2xl shadow-sm p-6">
            <h2 class="text-xl font-semibold mb-4 flex items-center gap-2"><span class="material-icons-outlined text-blue-500">search</span> Search Report</h2>
            
            <!-- Search Overview -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
              <div class="bg-blue-50 rounded-xl p-4">
                <div class="text-sm text-blue-600">Total Searches</div>
                <div class="text-2xl font-bold">45,678</div>
                <div class="text-xs text-gray-500">Last 30 Days</div>
              </div>
              <div class="bg-green-50 rounded-xl p-4">
                <div class="text-sm text-green-600">Unique Searches</div>
                <div class="text-2xl font-bold">12,345</div>
                <div class="text-xs text-gray-500">Last 30 Days</div>
              </div>
              <div class="bg-yellow-50 rounded-xl p-4">
                <div class="text-sm text-yellow-600">Avg. Search Time</div>
                <div class="text-2xl font-bold">2.3s</div>
                <div class="text-xs text-gray-500">Last 30 Days</div>
              </div>
              <div class="bg-purple-50 rounded-xl p-4">
                <div class="text-sm text-purple-600">Search Success</div>
                <div class="text-2xl font-bold">94.5%</div>
                <div class="text-xs text-gray-500">Last 30 Days</div>
              </div>
            </div>

            <!-- Most Searched Terms -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
              <div class="bg-gray-50 rounded-xl p-4">
                <h3 class="font-semibold mb-4">Most Searched Terms</h3>
                <div class="space-y-4">
                  <div class="flex items-center justify-between p-3 bg-white rounded-lg">
                    <div class="flex items-center gap-2">
                      <span class="material-icons-outlined text-blue-500">trending_up</span>
                      <span>Product A</span>
                    </div>
                    <div class="flex items-center gap-2">
                      <span class="text-sm font-medium">1,234</span>
                      <span class="text-sm text-gray-500">searches</span>
                    </div>
                  </div>
                  <div class="flex items-center justify-between p-3 bg-white rounded-lg">
                    <div class="flex items-center gap-2">
                      <span class="material-icons-outlined text-blue-500">trending_up</span>
                      <span>Service B</span>
                    </div>
                    <div class="flex items-center gap-2">
                      <span class="text-sm font-medium">987</span>
                      <span class="text-sm text-gray-500">searches</span>
                    </div>
                  </div>
                  <div class="flex items-center justify-between p-3 bg-white rounded-lg">
                    <div class="flex items-center gap-2">
                      <span class="material-icons-outlined text-blue-500">trending_up</span>
                      <span>Category C</span>
                    </div>
                    <div class="flex items-center gap-2">
                      <span class="text-sm font-medium">765</span>
                      <span class="text-sm text-gray-500">searches</span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="bg-gray-50 rounded-xl p-4">
                <h3 class="font-semibold mb-4">Search Categories</h3>
                <canvas id="searchCategoryChart" height="200"></canvas>
              </div>
            </div>

            <!-- Search Trends -->
            <div class="bg-gray-50 rounded-xl p-4 mb-6">
              <h3 class="font-semibold mb-4">Search Trends</h3>
              <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-white rounded-lg p-4">
                  <h4 class="font-medium mb-2">Daily Trends</h4>
                  <canvas id="dailySearchChart" height="150"></canvas>
                </div>
                <div class="bg-white rounded-lg p-4">
                  <h4 class="font-medium mb-2">Weekly Trends</h4>
                  <canvas id="weeklySearchChart" height="150"></canvas>
                </div>
                <div class="bg-white rounded-lg p-4">
                  <h4 class="font-medium mb-2">Monthly Trends</h4>
                  <canvas id="monthlySearchChart" height="150"></canvas>
                </div>
              </div>
            </div>

            <!-- Search Performance -->
            <div class="bg-gray-50 rounded-xl p-4">
              <h3 class="font-semibold mb-4">Search Performance</h3>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white rounded-lg p-4">
                  <h4 class="font-medium mb-2">Search Success Rate</h4>
                  <div class="space-y-4">
                    <div class="flex items-center justify-between">
                      <span>Successful Searches</span>
                      <span class="text-green-600">94.5%</span>
                    </div>
                    <div class="flex items-center justify-between">
                      <span>No Results</span>
                      <span class="text-yellow-600">4.2%</span>
                    </div>
                    <div class="flex items-center justify-between">
                      <span>Failed Searches</span>
                      <span class="text-red-600">1.3%</span>
                    </div>
                  </div>
                </div>
                <div class="bg-white rounded-lg p-4">
                  <h4 class="font-medium mb-2">Search Response Time</h4>
                  <canvas id="searchResponseChart" height="200"></canvas>
                </div>
              </div>
            </div>
          </section>
        </div>

        <!-- Complaints & Bugs -->
        <div class="tab-content hidden" id="content-18">
          <section class="bg-white rounded-2xl shadow-sm p-6">
            <h2 class="text-xl font-semibold mb-4 flex items-center gap-2"><span class="material-icons-outlined text-blue-500">bug_report</span> Complaints & Bugs</h2>
            
            <!-- Overview -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
              <div class="bg-red-50 rounded-xl p-4">
                <div class="text-sm text-red-600">Open Issues</div>
                <div class="text-2xl font-bold">45</div>
                <div class="text-xs text-gray-500">Active</div>
              </div>
              <div class="bg-yellow-50 rounded-xl p-4">
                <div class="text-sm text-yellow-600">In Progress</div>
                <div class="text-2xl font-bold">23</div>
                <div class="text-xs text-gray-500">Being Addressed</div>
              </div>
              <div class="bg-green-50 rounded-xl p-4">
                <div class="text-sm text-green-600">Resolved</div>
                <div class="text-2xl font-bold">156</div>
                <div class="text-xs text-gray-500">Last 30 Days</div>
              </div>
              <div class="bg-blue-50 rounded-xl p-4">
                <div class="text-sm text-blue-600">Avg. Resolution</div>
                <div class="text-2xl font-bold">2.5d</div>
                <div class="text-xs text-gray-500">Last 30 Days</div>
              </div>
            </div>

            <!-- Controls -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
              <div class="flex gap-2 flex-wrap">
                <button class="capsule-btn bg-blue-600 text-white font-semibold flex items-center gap-1">
                  <span class="material-icons-outlined">add</span> New Issue
                </button>
                <button class="capsule-btn bg-green-600 text-white font-semibold flex items-center gap-1">
                  <span class="material-icons-outlined">filter_list</span> Filter
                </button>
              </div>
              <div class="flex gap-2 flex-wrap items-center">
                <input type="text" class="input-field" placeholder="Search issues..."/>
                <select class="input-field">
                  <option>All Types</option>
                  <option>Bug</option>
                  <option>Complaint</option>
                  <option>Feature Request</option>
                  <option>Security Issue</option>
                </select>
              </div>
            </div>

            <!-- Issues Table -->
            <div class="overflow-x-auto mb-6">
              <table class="min-w-full text-sm border rounded-lg">
                <thead class="bg-gray-100">
                  <tr>
                    <th class="px-3 py-2">ID</th>
                    <th class="px-3 py-2">Type</th>
                    <th class="px-3 py-2">Title</th>
                    <th class="px-3 py-2">Reported By</th>
                    <th class="px-3 py-2">Priority</th>
                    <th class="px-3 py-2">Status</th>
                    <th class="px-3 py-2">Date</th>
                    <th class="px-3 py-2">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td class="px-3 py-2">BUG001</td>
                    <td class="px-3 py-2">Bug</td>
                    <td class="px-3 py-2">Login Page Not Loading</td>
                    <td class="px-3 py-2">John User</td>
                    <td class="px-3 py-2"><span class="status-badge status-error">High</span></td>
                    <td class="px-3 py-2"><span class="status-badge status-warning">In Progress</span></td>
                    <td class="px-3 py-2">2024-06-12</td>
                    <td class="px-3 py-2">
                      <button class="capsule-btn bg-blue-600 text-white text-xs">View</button>
                    </td>
                  </tr>
                  <tr>
                    <td class="px-3 py-2">COMP001</td>
                    <td class="px-3 py-2">Complaint</td>
                    <td class="px-3 py-2">Slow Response Time</td>
                    <td class="px-3 py-2">Sarah Customer</td>
                    <td class="px-3 py-2"><span class="status-badge status-warning">Medium</span></td>
                    <td class="px-3 py-2"><span class="status-badge status-success">Resolved</span></td>
                    <td class="px-3 py-2">2024-06-11</td>
                    <td class="px-3 py-2">
                      <button class="capsule-btn bg-blue-600 text-white text-xs">View</button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>

            <!-- Issue Categories -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div class="bg-gray-50 rounded-xl p-4">
                <h3 class="font-semibold mb-4">Issue Categories</h3>
                <canvas id="issueCategoryChart" height="200"></canvas>
              </div>
              <div class="bg-gray-50 rounded-xl p-4">
                <h3 class="font-semibold mb-4">Resolution Time</h3>
                <canvas id="resolutionTimeChart" height="200"></canvas>
              </div>
            </div>
          </section>
        </div>

        <!-- Police & Government Audit -->
        <div class="tab-content hidden" id="content-19">
          <section class="bg-white rounded-2xl shadow-sm p-6">
            <h2 class="text-xl font-semibold mb-4 flex items-center gap-2"><span class="material-icons-outlined text-blue-500">gavel</span> Police & Government Audit</h2>
            
            <!-- Overview -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
              <div class="bg-blue-50 rounded-xl p-4">
                <div class="text-sm text-blue-600">Total Requests</div>
                <div class="text-2xl font-bold">234</div>
                <div class="text-xs text-gray-500">Last 30 Days</div>
              </div>
              <div class="bg-green-50 rounded-xl p-4">
                <div class="text-sm text-green-600">Completed</div>
                <div class="text-2xl font-bold">198</div>
                <div class="text-xs text-gray-500">Last 30 Days</div>
              </div>
              <div class="bg-yellow-50 rounded-xl p-4">
                <div class="text-sm text-yellow-600">Pending</div>
                <div class="text-2xl font-bold">36</div>
                <div class="text-xs text-gray-500">Active</div>
              </div>
              <div class="bg-purple-50 rounded-xl p-4">
                <div class="text-sm text-purple-600">Avg. Response</div>
                <div class="text-2xl font-bold">1.2d</div>
                <div class="text-xs text-gray-500">Last 30 Days</div>
              </div>
            </div>

            <!-- Controls -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
              <div class="flex gap-2 flex-wrap">
                <button class="capsule-btn bg-blue-600 text-white font-semibold flex items-center gap-1">
                  <span class="material-icons-outlined">add</span> New Request
                </button>
                <button class="capsule-btn bg-green-600 text-white font-semibold flex items-center gap-1">
                  <span class="material-icons-outlined">filter_list</span> Filter
                </button>
              </div>
              <div class="flex gap-2 flex-wrap items-center">
                <input type="text" class="input-field" placeholder="Search requests..."/>
                <select class="input-field">
                  <option>All Types</option>
                  <option>Police</option>
                  <option>Government</option>
                  <option>Legal</option>
                  <option>Compliance</option>
                </select>
              </div>
            </div>

            <!-- Requests Table -->
            <div class="overflow-x-auto mb-6">
              <table class="min-w-full text-sm border rounded-lg">
                <thead class="bg-gray-100">
                  <tr>
                    <th class="px-3 py-2">Request ID</th>
                    <th class="px-3 py-2">Type</th>
                    <th class="px-3 py-2">Agency</th>
                    <th class="px-3 py-2">Purpose</th>
                    <th class="px-3 py-2">Status</th>
                    <th class="px-3 py-2">Date</th>
                    <th class="px-3 py-2">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td class="px-3 py-2">REQ001</td>
                    <td class="px-3 py-2">Police</td>
                    <td class="px-3 py-2">NYPD</td>
                    <td class="px-3 py-2">User Data Request</td>
                    <td class="px-3 py-2"><span class="status-badge status-warning">Pending</span></td>
                    <td class="px-3 py-2">2024-06-12</td>
                    <td class="px-3 py-2">
                      <button class="capsule-btn bg-blue-600 text-white text-xs">View</button>
                    </td>
                  </tr>
                  <tr>
                    <td class="px-3 py-2">REQ002</td>
                    <td class="px-3 py-2">Government</td>
                    <td class="px-3 py-2">IRS</td>
                    <td class="px-3 py-2">Tax Records</td>
                    <td class="px-3 py-2"><span class="status-badge status-success">Completed</span></td>
                    <td class="px-3 py-2">2024-06-11</td>
                    <td class="px-3 py-2">
                      <button class="capsule-btn bg-blue-600 text-white text-xs">View</button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>

            <!-- Compliance Status -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div class="bg-gray-50 rounded-xl p-4">
                <h3 class="font-semibold mb-4">Request Types</h3>
                <canvas id="requestTypeChart" height="200"></canvas>
              </div>
              <div class="bg-gray-50 rounded-xl p-4">
                <h3 class="font-semibold mb-4">Response Time</h3>
                <canvas id="responseTimeChart" height="200"></canvas>
              </div>
            </div>
          </section>
        </div>

        <!-- User Devices Information -->
        <div class="tab-content hidden" id="content-20">
          <section class="bg-white rounded-2xl shadow-sm p-6">
            <h2 class="text-xl font-semibold mb-4 flex items-center gap-2"><span class="material-icons-outlined text-blue-500">devices_other</span> User Devices Information</h2>
            
            <!-- Overview -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
              <div class="bg-blue-50 rounded-xl p-4">
                <div class="text-sm text-blue-600">Total Devices</div>
                <div class="text-2xl font-bold">12,345</div>
                <div class="text-xs text-gray-500">Active</div>
              </div>
              <div class="bg-green-50 rounded-xl p-4">
                <div class="text-sm text-green-600">Unique Users</div>
                <div class="text-2xl font-bold">8,234</div>
                <div class="text-xs text-gray-500">With Devices</div>
              </div>
              <div class="bg-yellow-50 rounded-xl p-4">
                <div class="text-sm text-yellow-600">Suspicious Activity</div>
                <div class="text-2xl font-bold">23</div>
                <div class="text-xs text-gray-500">Last 24 Hours</div>
              </div>
              <div class="bg-red-50 rounded-xl p-4">
                <div class="text-sm text-red-600">Blocked Devices</div>
                <div class="text-2xl font-bold">45</div>
                <div class="text-xs text-gray-500">Total</div>
              </div>
            </div>

            <!-- Controls -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
              <div class="flex gap-2 flex-wrap">
                <button class="capsule-btn bg-blue-600 text-white font-semibold flex items-center gap-1">
                  <span class="material-icons-outlined">file_download</span> Export Data
                </button>
                <button class="capsule-btn bg-green-600 text-white font-semibold flex items-center gap-1">
                  <span class="material-icons-outlined">filter_list</span> Filter
                </button>
                <button class="capsule-btn bg-red-600 text-white font-semibold flex items-center gap-1">
                  <span class="material-icons-outlined">block</span> Block Device
                </button>
              </div>
              <div class="flex gap-2 flex-wrap items-center">
                <input type="text" class="input-field" placeholder="Search devices..."/>
                <select class="input-field">
                  <option>All Types</option>
                  <option>Mobile</option>
                  <option>Desktop</option>
                  <option>Tablet</option>
                  <option>Other</option>
                </select>
              </div>
            </div>

            <!-- Device Information Table -->
            <div class="overflow-x-auto mb-6">
              <table class="min-w-full text-sm border rounded-lg">
                <thead class="bg-gray-100">
                  <tr>
                    <th class="px-3 py-2">Device ID</th>
                    <th class="px-3 py-2">User</th>
                    <th class="px-3 py-2">Device Type</th>
                    <th class="px-3 py-2">Model</th>
                    <th class="px-3 py-2">OS</th>
                    <th class="px-3 py-2">Browser</th>
                    <th class="px-3 py-2">IP Address</th>
                    <th class="px-3 py-2">Location</th>
                    <th class="px-3 py-2">Last Active</th>
                    <th class="px-3 py-2">Status</th>
                    <th class="px-3 py-2">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td class="px-3 py-2">DEV001</td>
                    <td class="px-3 py-2">John Doe</td>
                    <td class="px-3 py-2">iPhone 13 Pro</td>
                    <td class="px-3 py-2">A2482</td>
                    <td class="px-3 py-2">iOS 15.4.1</td>
                    <td class="px-3 py-2">Safari 15.4</td>
                    <td class="px-3 py-2">192.168.1.100</td>
                    <td class="px-3 py-2">New York, USA</td>
                    <td class="px-3 py-2">2024-06-12 15:30</td>
                    <td class="px-3 py-2"><span class="status-badge status-success">Active</span></td>
                    <td class="px-3 py-2">
                      <button class="capsule-btn bg-blue-600 text-white text-xs">Details</button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>

            <!-- Detailed Device Information -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
              <div class="bg-gray-50 rounded-xl p-4">
                <h3 class="font-semibold mb-4">Device Details</h3>
                <div class="space-y-4">
                  <div class="bg-white rounded-lg p-4">
                    <h4 class="font-medium mb-2">Hardware Information</h4>
                    <div class="space-y-2 text-sm">
                      <div class="flex justify-between">
                        <span class="text-gray-600">Device ID:</span>
                        <span>DEV001</span>
                      </div>
                      <div class="flex justify-between">
                        <span class="text-gray-600">Serial Number:</span>
                        <span>SN123456789</span>
                      </div>
                      <div class="flex justify-between">
                        <span class="text-gray-600">MAC Address:</span>
                        <span>00:1A:2B:3C:4D:5E</span>
                      </div>
                      <div class="flex justify-between">
                        <span class="text-gray-600">IMEI:</span>
                        <span>123456789012345</span>
                      </div>
                      <div class="flex justify-between">
                        <span class="text-gray-600">Processor:</span>
                        <span>A15 Bionic</span>
                      </div>
                      <div class="flex justify-between">
                        <span class="text-gray-600">RAM:</span>
                        <span>6GB</span>
                      </div>
                    </div>
                  </div>
                  <div class="bg-white rounded-lg p-4">
                    <h4 class="font-medium mb-2">Network Information</h4>
                    <div class="space-y-2 text-sm">
                      <div class="flex justify-between">
                        <span class="text-gray-600">IP Address:</span>
                        <span>192.168.1.100</span>
                      </div>
                      <div class="flex justify-between">
                        <span class="text-gray-600">ISP:</span>
                        <span>Verizon Fios</span>
                      </div>
                      <div class="flex justify-between">
                        <span class="text-gray-600">Connection Type:</span>
                        <span>WiFi</span>
                      </div>
                      <div class="flex justify-between">
                        <span class="text-gray-600">SSID:</span>
                        <span>Home_Network</span>
                      </div>
                      <div class="flex justify-between">
                        <span class="text-gray-600">VPN Status:</span>
                        <span>Not Active</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="bg-gray-50 rounded-xl p-4">
                <h3 class="font-semibold mb-4">Activity Log</h3>
                <div class="space-y-4">
                  <div class="bg-white rounded-lg p-4">
                    <h4 class="font-medium mb-2">Recent Activity</h4>
                    <div class="space-y-2 text-sm">
                      <div class="flex justify-between">
                        <span class="text-gray-600">Last Login:</span>
                        <span>2024-06-12 15:30</span>
                      </div>
                      <div class="flex justify-between">
                        <span class="text-gray-600">Login Location:</span>
                        <span>New York, USA</span>
                      </div>
                      <div class="flex justify-between">
                        <span class="text-gray-600">Login Method:</span>
                        <span>Biometric</span>
                      </div>
                      <div class="flex justify-between">
                        <span class="text-gray-600">Session Duration:</span>
                        <span>45 minutes</span>
                      </div>
                      <div class="flex justify-between">
                        <span class="text-gray-600">Data Usage:</span>
                        <span>2.5GB</span>
                      </div>
                    </div>
                  </div>
                  <div class="bg-white rounded-lg p-4">
                    <h4 class="font-medium mb-2">Security Status</h4>
                    <div class="space-y-2 text-sm">
                      <div class="flex justify-between">
                        <span class="text-gray-600">Screen Lock:</span>
                        <span>Enabled</span>
                      </div>
                      <div class="flex justify-between">
                        <span class="text-gray-600">Encryption:</span>
                        <span>Enabled</span>
                      </div>
                      <div class="flex justify-between">
                        <span class="text-gray-600">2FA Status:</span>
                        <span>Enabled</span>
                      </div>
                      <div class="flex justify-between">
                        <span class="text-gray-600">Last Security Update:</span>
                        <span>2024-06-10</span>
                      </div>
                      <div class="flex justify-between">
                        <span class="text-gray-600">Security Score:</span>
                        <span>High</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Device Analytics -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div class="bg-gray-50 rounded-xl p-4">
                <h3 class="font-semibold mb-4">Device Distribution</h3>
                <canvas id="deviceDistributionChart" height="200"></canvas>
              </div>
              <div class="bg-gray-50 rounded-xl p-4">
                <h3 class="font-semibold mb-4">Activity Timeline</h3>
                <canvas id="deviceActivityChart" height="200"></canvas>
              </div>
            </div>
          </section>
        </div>
      </div>
    
    </div>
  </div>
  <script>
    // Tab switching logic
    const tabBtns = document.querySelectorAll('.tab-btn');
    const tabContents = document.querySelectorAll('.tab-content');
    tabBtns.forEach((btn, idx) => {
      btn.addEventListener('click', () => {
        tabBtns.forEach(b => b.classList.remove('bg-blue-600', 'text-white'));
        btn.classList.add('bg-blue-600', 'text-white');
        tabContents.forEach((c, i) => {
          if (i === idx) {
            c.classList.remove('hidden');
          } else {
            c.classList.add('hidden');
          }
        });
      });
    });

    // View toggle logic
    const viewToggles = document.querySelectorAll('.view-toggle');
    const viewSections = document.querySelectorAll('.view-section');
    viewToggles.forEach(toggle => {
      toggle.addEventListener('click', () => {
        const view = toggle.dataset.view;
        viewToggles.forEach(t => t.classList.remove('bg-blue-100', 'text-blue-700'));
        toggle.classList.add('bg-blue-100', 'text-blue-700');
        viewSections.forEach(section => {
          if (section.dataset.view === view) {
            section.classList.remove('hidden');
          } else {
            section.classList.add('hidden');
          }
        });
      });
    });

    // Chart initialization
    if(window.Chart) {
      const auditLogCtx = document.getElementById('auditLogChart')?.getContext('2d');
      if(auditLogCtx) {
        new Chart(auditLogCtx, {
          type: 'line',
          data: {
            labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            datasets: [{
              label: 'Logs',
              data: [150, 200, 180, 220, 190, 170, 160],
              borderColor: '#3b82f6',
              tension: 0.4,
              fill: true,
              backgroundColor: 'rgba(59, 130, 246, 0.1)'
            }]
          },
          options: {
            responsive: true,
            plugins: {
              legend: {
                display: false
              }
            },
            scales: {
              y: {
                beginAtZero: true,
                grid: {
                  color: 'rgba(0, 0, 0, 0.1)'
                }
              },
              x: {
                grid: {
                  display: false
                }
              }
            }
          }
        });
      }

      // User Activity Chart
      const userActivityCtx = document.getElementById('userActivityChart')?.getContext('2d');
      if(userActivityCtx) {
        new Chart(userActivityCtx, {
          type: 'doughnut',
          data: {
            labels: ['Active', 'Inactive', 'Deleted'],
            datasets: [{
              data: [7891, 2109, 234],
              backgroundColor: ['#22c55e', '#eab308', '#ef4444']
            }]
          },
          options: {
            responsive: true,
            plugins: {
              legend: {
                position: 'bottom'
              }
            }
          }
        });
      }

      // Search Category Chart
      const searchCategoryCtx = document.getElementById('searchCategoryChart')?.getContext('2d');
      if(searchCategoryCtx) {
        new Chart(searchCategoryCtx, {
          type: 'bar',
          data: {
            labels: ['Products', 'Services', 'Categories', 'Users', 'Content'],
            datasets: [{
              label: 'Searches',
              data: [1234, 987, 765, 543, 321],
              backgroundColor: '#3b82f6'
            }]
          },
          options: {
            responsive: true,
            plugins: {
              legend: {
                display: false
              }
            },
            scales: {
              y: {
                beginAtZero: true,
                grid: {
                  color: 'rgba(0, 0, 0, 0.1)'
                }
              },
              x: {
                grid: {
                  display: false
                }
              }
            }
          }
        });
      }

      // Daily Search Chart
      const dailySearchCtx = document.getElementById('dailySearchChart')?.getContext('2d');
      if(dailySearchCtx) {
        new Chart(dailySearchCtx, {
          type: 'line',
          data: {
            labels: ['00:00', '04:00', '08:00', '12:00', '16:00', '20:00'],
            datasets: [{
              label: 'Searches',
              data: [100, 150, 300, 400, 350, 200],
              borderColor: '#3b82f6',
              tension: 0.4,
              fill: true,
              backgroundColor: 'rgba(59, 130, 246, 0.1)'
            }]
          },
          options: {
            responsive: true,
            plugins: {
              legend: {
                display: false
              }
            },
            scales: {
              y: {
                beginAtZero: true,
                grid: {
                  color: 'rgba(0, 0, 0, 0.1)'
                }
              },
              x: {
                grid: {
                  display: false
                }
              }
            }
          }
        });
      }

      // Weekly Search Chart
      const weeklySearchCtx = document.getElementById('weeklySearchChart')?.getContext('2d');
      if(weeklySearchCtx) {
        new Chart(weeklySearchCtx, {
          type: 'line',
          data: {
            labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            datasets: [{
              label: 'Searches',
              data: [1500, 1800, 1600, 2000, 1900, 1700, 1600],
              borderColor: '#3b82f6',
              tension: 0.4,
              fill: true,
              backgroundColor: 'rgba(59, 130, 246, 0.1)'
            }]
          },
          options: {
            responsive: true,
            plugins: {
              legend: {
                display: false
              }
            },
            scales: {
              y: {
                beginAtZero: true,
                grid: {
                  color: 'rgba(0, 0, 0, 0.1)'
                }
              },
              x: {
                grid: {
                  display: false
                }
              }
            }
          }
        });
      }

      // Monthly Search Chart
      const monthlySearchCtx = document.getElementById('monthlySearchChart')?.getContext('2d');
      if(monthlySearchCtx) {
        new Chart(monthlySearchCtx, {
          type: 'line',
          data: {
            labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
            datasets: [{
              label: 'Searches',
              data: [6000, 7000, 6500, 8000],
              borderColor: '#3b82f6',
              tension: 0.4,
              fill: true,
              backgroundColor: 'rgba(59, 130, 246, 0.1)'
            }]
          },
          options: {
            responsive: true,
            plugins: {
              legend: {
                display: false
              }
            },
            scales: {
              y: {
                beginAtZero: true,
                grid: {
                  color: 'rgba(0, 0, 0, 0.1)'
                }
              },
              x: {
                grid: {
                  display: false
                }
              }
            }
          }
        });
      }

      // Search Response Chart
      const searchResponseCtx = document.getElementById('searchResponseChart')?.getContext('2d');
      if(searchResponseCtx) {
        new Chart(searchResponseCtx, {
          type: 'line',
          data: {
            labels: ['00:00', '04:00', '08:00', '12:00', '16:00', '20:00'],
            datasets: [{
              label: 'Response Time (ms)',
              data: [2.1, 2.2, 2.3, 2.4, 2.3, 2.2],
              borderColor: '#3b82f6',
              tension: 0.4,
              fill: true,
              backgroundColor: 'rgba(59, 130, 246, 0.1)'
            }]
          },
          options: {
            responsive: true,
            plugins: {
              legend: {
                display: false
              }
            },
            scales: {
              y: {
                beginAtZero: true,
                grid: {
                  color: 'rgba(0, 0, 0, 0.1)'
                }
              },
              x: {
                grid: {
                  display: false
                }
              }
            }
          }
        });
      }

      // Issue Category Chart
      const issueCategoryCtx = document.getElementById('issueCategoryChart')?.getContext('2d');
      if(issueCategoryCtx) {
        new Chart(issueCategoryCtx, {
          type: 'pie',
          data: {
            labels: ['Bugs', 'Complaints', 'Feature Requests', 'Security Issues'],
            datasets: [{
              data: [45, 30, 15, 10],
              backgroundColor: ['#ef4444', '#eab308', '#3b82f6', '#8b5cf6']
            }]
          },
          options: {
            responsive: true,
            plugins: {
              legend: {
                position: 'bottom'
              }
            }
          }
        });
      }

      // Resolution Time Chart
      const resolutionTimeCtx = document.getElementById('resolutionTimeChart')?.getContext('2d');
      if(resolutionTimeCtx) {
        new Chart(resolutionTimeCtx, {
          type: 'bar',
          data: {
            labels: ['< 1 day', '1-2 days', '2-3 days', '3-4 days', '> 4 days'],
            datasets: [{
              label: 'Issues',
              data: [30, 45, 25, 15, 10],
              backgroundColor: '#3b82f6'
            }]
          },
          options: {
            responsive: true,
            plugins: {
              legend: {
                display: false
              }
            },
            scales: {
              y: {
                beginAtZero: true,
                grid: {
                  color: 'rgba(0, 0, 0, 0.1)'
                }
              },
              x: {
                grid: {
                  display: false
                }
              }
            }
          }
        });
      }

      // Request Type Chart
      const requestTypeCtx = document.getElementById('requestTypeChart')?.getContext('2d');
      if(requestTypeCtx) {
        new Chart(requestTypeCtx, {
          type: 'doughnut',
          data: {
            labels: ['Police', 'Government', 'Legal', 'Compliance'],
            datasets: [{
              data: [40, 30, 20, 10],
              backgroundColor: ['#3b82f6', '#22c55e', '#eab308', '#ef4444']
            }]
          },
          options: {
            responsive: true,
            plugins: {
              legend: {
                position: 'bottom'
              }
            }
          }
        });
      }

      // Response Time Chart
      const responseTimeCtx = document.getElementById('responseTimeChart')?.getContext('2d');
      if(responseTimeCtx) {
        new Chart(responseTimeCtx, {
          type: 'line',
          data: {
            labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            datasets: [{
              label: 'Avg. Response Time (days)',
              data: [1.2, 1.3, 1.1, 1.4, 1.2, 1.1, 1.0],
              borderColor: '#3b82f6',
              tension: 0.4,
              fill: true,
              backgroundColor: 'rgba(59, 130, 246, 0.1)'
            }]
          },
          options: {
            responsive: true,
            plugins: {
              legend: {
                display: false
              }
            },
            scales: {
              y: {
                beginAtZero: true,
                grid: {
                  color: 'rgba(0, 0, 0, 0.1)'
                }
              },
              x: {
                grid: {
                  display: false
                }
              }
            }
          }
        });
      }

      // Device Distribution Chart
      const deviceDistributionCtx = document.getElementById('deviceDistributionChart')?.getContext('2d');
      if(deviceDistributionCtx) {
        new Chart(deviceDistributionCtx, {
          type: 'pie',
          data: {
            labels: ['Mobile', 'Desktop', 'Tablet', 'Other'],
            datasets: [{
              data: [45, 35, 15, 5],
              backgroundColor: ['#3b82f6', '#22c55e', '#eab308', '#ef4444']
            }]
          },
          options: {
            responsive: true,
            plugins: {
              legend: {
                position: 'bottom'
              }
            }
          }
        });
      }

      // Device Activity Chart
      const deviceActivityCtx = document.getElementById('deviceActivityChart')?.getContext('2d');
      if(deviceActivityCtx) {
        new Chart(deviceActivityCtx, {
          type: 'line',
          data: {
            labels: ['00:00', '04:00', '08:00', '12:00', '16:00', '20:00'],
            datasets: [{
              label: 'Active Devices',
              data: [100, 80, 200, 300, 250, 180],
              borderColor: '#3b82f6',
              tension: 0.4,
              fill: true,
              backgroundColor: 'rgba(59, 130, 246, 0.1)'
            }]
          },
          options: {
            responsive: true,
            plugins: {
              legend: {
                display: false
              }
            },
            scales: {
              y: {
                beginAtZero: true,
                grid: {
                  color: 'rgba(0, 0, 0, 0.1)'
                }
              },
              x: {
                grid: {
                  display: false
                }
              }
            }
          }
        });
      }
    }
  </script>
 
@endsection
