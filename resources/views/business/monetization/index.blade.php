@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold">Monetization Dashboard</h1>
        <div class="flex space-x-4">
            <a href="{{ route('business.monetization.pricing-plans') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                Manage Pricing Plans
            </a>
            <a href="{{ route('business.monetization.transactions') }}" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">
                View Transactions
            </a>
        </div>
    </div>

    <!-- Revenue Overview -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold mb-2">Total Revenue</h3>
            <p class="text-3xl font-bold text-green-600">${{ number_format($totalRevenue, 2) }}</p>
            <p class="text-sm text-gray-500">+{{ $revenueGrowth }}% from last month</p>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold mb-2">Active Subscriptions</h3>
            <p class="text-3xl font-bold text-blue-600">{{ $activeSubscriptions }}</p>
            <p class="text-sm text-gray-500">{{ $subscriptionGrowth }}% growth</p>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold mb-2">Average Order Value</h3>
            <p class="text-3xl font-bold text-purple-600">${{ number_format($averageOrderValue, 2) }}</p>
            <p class="text-sm text-gray-500">Based on last 30 days</p>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold mb-2">Churn Rate</h3>
            <p class="text-3xl font-bold text-red-600">{{ $churnRate }}%</p>
            <p class="text-sm text-gray-500">Last 30 days</p>
        </div>
    </div>

    <!-- Revenue Chart -->
    <div class="bg-white rounded-lg shadow p-6 mb-8">
        <h2 class="text-xl font-semibold mb-4">Revenue Trends</h2>
        <div class="h-64">
            <!-- Add your chart component here -->
            <canvas id="revenueChart"></canvas>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Transactions -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold">Recent Transactions</h2>
                <a href="{{ route('business.monetization.transactions') }}" class="text-blue-500 hover:text-blue-600">
                    View All
                </a>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Date
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Customer
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Amount
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($recentTransactions as $transaction)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $transaction->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $transaction->customer_name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                ${{ number_format($transaction->amount, 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $transaction->status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ ucfirst($transaction->status) }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Subscription Overview -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold">Subscription Overview</h2>
                <a href="{{ route('business.monetization.subscriptions') }}" class="text-blue-500 hover:text-blue-600">
                    Manage Subscriptions
                </a>
            </div>
            <div class="space-y-4">
                @foreach($subscriptionPlans as $plan)
                <div class="flex justify-between items-center p-4 bg-gray-50 rounded-lg">
                    <div>
                        <h3 class="font-medium text-gray-900">{{ $plan->name }}</h3>
                        <p class="text-sm text-gray-500">{{ $plan->active_subscribers }} active subscribers</p>
                    </div>
                    <div class="text-right">
                        <p class="text-lg font-semibold text-gray-900">${{ number_format($plan->revenue, 2) }}</p>
                        <p class="text-sm text-gray-500">Monthly revenue</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Add your chart initialization code here
    const ctx = document.getElementById('revenueChart').getContext('2d');
    const revenueChart = new Chart(ctx, {
        // Chart configuration
    });
</script>
@endpush
@endsection 