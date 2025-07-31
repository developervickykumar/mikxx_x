<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $business->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Cover Image Section -->
            <div class="relative h-64 md:h-96 mb-6 rounded-lg overflow-hidden">
                @if($business->logo)
                    <img src="{{ $business->logo_url }}" alt="Cover Image" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full bg-gray-300"></div>
                @endif
                <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black to-transparent h-32"></div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <div class="flex flex-col md:flex-row items-center md:items-start gap-6">
                        <!-- Logo -->
                        <div class="w-32 h-32 rounded-full overflow-hidden border-4 border-white shadow-lg">
                            @if($business->logo)
                                <img src="{{ $business->logo_url }}" alt="Logo" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-gray-300 flex items-center justify-center">
                                    <span class="text-gray-500 text-4xl">{{ substr($business->name, 0, 1) }}</span>
                                </div>
                            @endif
                        </div>

                        <!-- Business Details -->
                        <div class="flex-1">
                            <h1 class="text-3xl font-bold">{{ $business->name }}</h1>
                            <p class="text-gray-600 mt-2">{{ $business->description }}</p>
                            
                            <!-- Quick Actions -->
                            <div class="flex flex-wrap gap-4 mt-4">
                                <a href="{{ route('business.businesses.edit', $business) }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                                    <i class="fas fa-edit mr-2"></i> Edit
                                </a>
                                <a href="{{ route('business.businesses.services.index', $business) }}" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
                                    <i class="fas fa-concierge-bell mr-2"></i> Services
                                </a>
                                <a href="{{ route('business.businesses.products.index', $business) }}" class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700">
                                    <i class="fas fa-shopping-bag mr-2"></i> Products
                                </a>
                                <form action="{{ route('business.businesses.destroy', $business) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700" onclick="return confirm('Are you sure?')">
                                        <i class="fas fa-trash mr-2"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Left Column -->
                <div class="space-y-6">
                    <!-- About Section -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <h2 class="text-xl font-bold mb-4">About</h2>
                        <div class="space-y-4">
                            <div>
                                <h3 class="font-semibold">Contact Information</h3>
                                <p class="text-gray-600">{{ $business->address }}</p>
                                <p class="text-gray-600">{{ $business->phone }}</p>
                                <p class="text-gray-600">{{ $business->email }}</p>
                                @if($business->website)
                                    <p class="text-gray-600">
                                        <a href="{{ $business->website }}" target="_blank" class="text-blue-600 hover:underline">
                                            {{ $business->website }}
                                        </a>
                                    </p>
                                @endif
                            </div>
                            <div>
                                <h3 class="font-semibold">Working Hours</h3>
                                <div class="text-gray-600">
                                    @if(is_array(json_decode($business->working_hours, true)))
                                        @foreach(json_decode($business->working_hours, true) as $day => $hours)
                                            <p>{{ ucfirst($day) }}: {{ $hours }}</p>
                                        @endforeach
                                    @else
                                        <p>{{ $business->working_hours }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Middle and Right Columns -->
                <div class="md:col-span-2 space-y-6">
                    <!-- Services Section -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-xl font-bold">Services</h2>
                            <a href="{{ route('business.businesses.services.create', $business) }}" class="text-blue-600 hover:underline">Add New</a>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @forelse($business->services as $service)
                                <div class="border rounded-lg p-4 hover:bg-gray-50">
                                    <h3 class="font-semibold">{{ $service->name }}</h3>
                                    <p class="text-gray-600">{{ $service->description }}</p>
                                    <p class="text-gray-800 font-bold mt-2">{{ number_format($service->price, 2) }}</p>
                                </div>
                            @empty
                                <p class="text-gray-500 col-span-2">No services added yet.</p>
                            @endforelse
                        </div>
                    </div>

                    <!-- Products Section -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-xl font-bold">Products</h2>
                            <a href="{{ route('business.businesses.products.create', $business) }}" class="text-blue-600 hover:underline">Add New</a>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @forelse($business->products as $product)
                                <div class="border rounded-lg p-4 hover:bg-gray-50">
                                    <h3 class="font-semibold">{{ $product->name }}</h3>
                                    <p class="text-gray-600">{{ $product->description }}</p>
                                    <p class="text-gray-800 font-bold mt-2">{{ number_format($product->price, 2) }}</p>
                                </div>
                            @empty
                                <p class="text-gray-500 col-span-2">No products added yet.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

