<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Business Profile') }}
            </h2>
            <a href="{{ route('business.profile.edit') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Edit Profile
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
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Business Logo and Cover Image -->
                        <div class="md:col-span-3">
                            @if($business->cover_image)
                                <div class="relative h-48 rounded-lg overflow-hidden">
                                    <img src="{{ Storage::url($business->cover_image) }}" alt="{{ $business->name }}" class="w-full h-full object-cover">
                                    @if($business->logo)
                                        <div class="absolute bottom-0 left-0 transform translate-y-1/2 ml-6">
                                            <img src="{{ Storage::url($business->logo) }}" alt="{{ $business->name }}" class="w-24 h-24 rounded-full border-4 border-white object-cover">
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>

                        <!-- Business Information -->
                        <div class="md:col-span-2">
                            <h3 class="text-2xl font-bold mb-4">{{ $business->name }}</h3>
                            <p class="text-gray-600 mb-6">{{ $business->description }}</p>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                                <div>
                                    <h4 class="font-semibold text-gray-700 mb-2">Contact Information</h4>
                                    <p class="text-gray-600"><i class="fas fa-phone mr-2"></i>{{ $business->phone }}</p>
                                    <p class="text-gray-600"><i class="fas fa-envelope mr-2"></i>{{ $business->email }}</p>
                                    <p class="text-gray-600"><i class="fas fa-map-marker-alt mr-2"></i>{{ $business->address }}</p>
                                    @if($business->website)
                                        <p class="text-gray-600"><i class="fas fa-globe mr-2"></i><a href="{{ $business->website }}" target="_blank" class="text-blue-600 hover:underline">{{ $business->website }}</a></p>
                                    @endif
                                    @if($business->gst_number)
                                        <p class="text-gray-600"><i class="fas fa-hashtag mr-2"></i>GST: {{ $business->gst_number }}</p>
                                    @endif
                                </div>

                                <div>
                                    <h4 class="font-semibold text-gray-700 mb-2">Working Hours</h4>
                                    @foreach(json_decode($business->working_hours, true) as $day => $hours)
                                        <p class="text-gray-600">
                                            <span class="font-medium">{{ ucfirst($day) }}:</span>
                                            {{ $hours['start'] }} - {{ $hours['end'] }}
                                        </p>
                                    @endforeach
                                </div>
                            </div>

                            @if($business->social_media)
                                <div>
                                    <h4 class="font-semibold text-gray-700 mb-2">Social Media</h4>
                                    <div class="flex space-x-4">
                                        @foreach(json_decode($business->social_media, true) as $platform => $url)
                                            @if($url)
                                                <a href="{{ $url }}" target="_blank" class="text-gray-600 hover:text-gray-900">
                                                    <i class="fab fa-{{ $platform }} text-2xl"></i>
                                                </a>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Quick Actions -->
                        <div class="md:col-span-1">
                            <div class="bg-gray-50 rounded-lg p-4">
                                <h4 class="font-semibold text-gray-700 mb-4">Quick Actions</h4>
                                <div class="space-y-2">
                                    <a href="{{ route('business.services.index', $business) }}" class="block w-full text-center bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700">
                                        Manage Services
                                    </a>
                                    <a href="{{ route('business.products.index', $business) }}" class="block w-full text-center bg-green-600 text-white py-2 px-4 rounded hover:bg-green-700">
                                        Manage Products
                                    </a>
                                    <a href="{{ route('business.appointments.index', $business) }}" class="block w-full text-center bg-purple-600 text-white py-2 px-4 rounded hover:bg-purple-700">
                                        View Appointments
                                    </a>
                                    <a href="{{ route('business.team.index', $business) }}" class="block w-full text-center bg-yellow-600 text-white py-2 px-4 rounded hover:bg-yellow-700">
                                        Manage Team
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 