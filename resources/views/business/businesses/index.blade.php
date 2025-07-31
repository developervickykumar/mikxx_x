<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('My Businesses') }}
            </h2>
            <a href="{{ route('business.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Create New Business
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($businesses->isEmpty())
                        <div class="text-center py-8">
                            <h3 class="text-lg font-medium text-gray-900 mb-2">No Businesses Found</h3>
                            <p class="text-gray-500 mb-4">You haven't created any businesses yet.</p>
                            <a href="{{ route('business.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                                Create Your First Business
                            </a>
                        </div>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($businesses as $business)
                                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                                    @if($business->cover_image)
                                        <img src="{{ Storage::url($business->cover_image) }}" alt="{{ $business->name }}" class="w-full h-48 object-cover">
                                    @else
                                        <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                            <span class="text-gray-400">No cover image</span>
                                        </div>
                                    @endif
                                    
                                    <div class="p-6">
                                        <div class="flex items-center mb-4">
                                            @if($business->logo)
                                                <img src="{{ Storage::url($business->logo) }}" alt="{{ $business->name }}" class="w-12 h-12 rounded-full object-cover">
                                            @else
                                                <div class="w-12 h-12 rounded-full bg-gray-200 flex items-center justify-center">
                                                    <span class="text-gray-400 text-xs">No logo</span>
                                                </div>
                                            @endif
                                            <h3 class="ml-4 text-xl font-semibold text-gray-900">{{ $business->name }}</h3>
                                        </div>
                                        
                                        <p class="text-gray-600 mb-4">{{ Str::limit($business->description, 100) }}</p>
                                        
                                        <div class="flex flex-wrap gap-2 mb-4">
                                            <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">
                                                {{ $business->email }}
                                            </span>
                                            <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">
                                                {{ $business->phone }}
                                            </span>
                                        </div>
                                        
                                        <div class="flex justify-between items-center">
                                            <a href="{{ route('business.show', $business) }}" class="text-blue-600 hover:text-blue-800">
                                                View Details
                                            </a>
                                            <div class="flex space-x-2">
                                                <a href="{{ route('business.edit', $business) }}" class="text-gray-600 hover:text-gray-800">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('business.destroy', $business) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-800" onclick="return confirm('Are you sure you want to delete this business?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <div class="mt-6">
                            {{ $businesses->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 