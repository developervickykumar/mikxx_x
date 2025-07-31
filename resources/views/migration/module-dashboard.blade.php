@extends('layouts.admin')

@section('title', 'Module Dashboard')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Migration Section -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold text-gray-800">Database Migrations</h2>
            <div class="flex space-x-4">
                <button id="checkStatus" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    Check Status
                </button>
                <button id="runMigrations" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    Run Migrations
                </button>
                <button id="rollbackMigrations" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/>
                    </svg>
                    Rollback
                </button>
                <button id="runSeeder" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    Run Seeder
                </button>
            </div>
        </div>
        
        <!-- Migration Status -->
        <div id="migrationStatus" class="hidden">
            <div class="bg-gray-50 rounded-lg p-4 mb-4">
                <h3 class="text-lg font-medium text-gray-900 mb-2">Migration Status</h3>
                <pre id="statusOutput" class="bg-gray-100 p-4 rounded-lg overflow-x-auto text-sm"></pre>
            </div>
        </div>

        <!-- Migration Output -->
        <div id="migrationOutput" class="hidden">
            <div class="bg-gray-50 rounded-lg p-4">
                <h3 class="text-lg font-medium text-gray-900 mb-2">Migration Output</h3>
                <pre id="outputContent" class="bg-gray-100 p-4 rounded-lg overflow-x-auto text-sm"></pre>
            </div>
        </div>
    </div>

    <!-- Existing Module List Section -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Generated Modules</h1>
        <button onclick="location.href='{{ route('admin.modules.create') }}'" 
                class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            New Module
        </button>
    </div>

    <!-- ... rest of the existing dashboard code ... -->
</div>

<!-- PIN Confirmation Modal -->
<div id="pinModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-medium text-gray-900">Confirm Action</h3>
            <button onclick="closePinModal()" class="text-gray-400 hover:text-gray-500">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <div class="mt-2">
            <p class="text-sm text-gray-500 mb-4">
                Please enter your 6-digit PIN to confirm this action.
            </p>
            <div class="mb-4">
                <input type="password" id="migrationPin" 
                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                       placeholder="Enter 6-digit PIN"
                       maxlength="6"
                       pattern="\d{6}">
            </div>
            <div class="flex justify-end space-x-3">
                <button onclick="closePinModal()" 
                        class="px-4 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200">
                    Cancel
                </button>
                <button onclick="confirmAction()" 
                        class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                    Confirm
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
let currentAction = null;

function showPinModal(action) {
    currentAction = action;
    document.getElementById('pinModal').classList.remove('hidden');
    document.getElementById('migrationPin').focus();
}

function closePinModal() {
    document.getElementById('pinModal').classList.add('hidden');
    document.getElementById('migrationPin').value = '';
    currentAction = null;
}

function confirmAction() {
    const pin = document.getElementById('migrationPin').value;
    if (pin.length !== 6) {
        showToast('Please enter a valid 6-digit PIN', 'error');
        return;
    }

    switch (currentAction) {
        case 'migrate':
            runMigrations(pin);
            break;
        case 'rollback':
            rollbackMigrations(pin);
            break;
        case 'seed':
            runSeeder(pin);
            break;
    }

    closePinModal();
}

async function runMigrations(pin) {
    try {
        const response = await fetch('/admin/run-migrations', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ pin })
        });

        const data = await response.json();

        if (!response.ok) {
            throw new Error(data.message || 'Migration failed');
        }

        showToast(data.message, 'success');
        document.getElementById('migrationOutput').classList.remove('hidden');
        document.getElementById('outputContent').textContent = data.message;

        // Check status after a short delay
        setTimeout(checkMigrationStatus, 2000);
    } catch (error) {
        showToast(error.message, 'error');
        document.getElementById('migrationOutput').classList.remove('hidden');
        document.getElementById('outputContent').textContent = error.message;
    }
}

async function rollbackMigrations(pin) {
    try {
        const response = await fetch('/admin/rollback-migrations', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ pin })
        });

        const data = await response.json();

        if (!response.ok) {
            throw new Error(data.message || 'Rollback failed');
        }

        showToast(data.message, 'success');
        document.getElementById('migrationOutput').classList.remove('hidden');
        document.getElementById('outputContent').textContent = data.message;

        // Check status after a short delay
        setTimeout(checkMigrationStatus, 2000);
    } catch (error) {
        showToast(error.message, 'error');
        document.getElementById('migrationOutput').classList.remove('hidden');
        document.getElementById('outputContent').textContent = error.message;
    }
}

async function runSeeder(pin) {
    try {
        const response = await fetch('/admin/run-seeder', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ pin })
        });

        const data = await response.json();

        if (!response.ok) {
            throw new Error(data.message || 'Seeding failed');
        }

        showToast(data.message, 'success');
        document.getElementById('migrationOutput').classList.remove('hidden');
        document.getElementById('outputContent').textContent = data.message;
    } catch (error) {
        showToast(error.message, 'error');
        document.getElementById('migrationOutput').classList.remove('hidden');
        document.getElementById('outputContent').textContent = error.message;
    }
}

async function checkMigrationStatus() {
    try {
        const response = await fetch('/admin/migration-status');
        const data = await response.json();

        if (!response.ok) {
            throw new Error(data.message || 'Failed to get migration status');
        }

        document.getElementById('migrationStatus').classList.remove('hidden');
        document.getElementById('statusOutput').textContent = data.data;
    } catch (error) {
        showToast(error.message, 'error');
    }
}

function showToast(message, type = 'success') {
    const toast = document.createElement('div');
    toast.className = `fixed bottom-4 right-4 px-6 py-3 rounded-lg text-white ${
        type === 'success' ? 'bg-green-500' : 'bg-red-500'
    }`;
    toast.textContent = message;
    document.body.appendChild(toast);
    setTimeout(() => toast.remove(), 3000);
}

// Event Listeners
document.getElementById('runMigrations').addEventListener('click', () => {
    if (confirm('Are you sure you want to run migrations? This action cannot be undone.')) {
        showPinModal('migrate');
    }
});

document.getElementById('rollbackMigrations').addEventListener('click', () => {
    if (confirm('Are you sure you want to rollback the last migration? This action cannot be undone.')) {
        showPinModal('rollback');
    }
});

document.getElementById('runSeeder').addEventListener('click', () => {
    if (confirm('Are you sure you want to run the database seeder? This will populate your database with test data.')) {
        showPinModal('seed');
    }
});

document.getElementById('checkStatus').addEventListener('click', checkMigrationStatus);

// PIN input validation
document.getElementById('migrationPin').addEventListener('input', function(e) {
    this.value = this.value.replace(/[^0-9]/g, '').slice(0, 6);
});
</script>
@endpush 