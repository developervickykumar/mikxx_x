<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Business') }}: {{ $business->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('business.businesses.update', $business) }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Business Name -->
                        <div>
                            <x-input-label for="name" :value="__('Business Name')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $business->name)" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>

                        <!-- Description -->
                        <div>
                            <x-input-label for="description" :value="__('Description')" />
                            <textarea id="description" name="description" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="4" required>{{ old('description', $business->description) }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('description')" />
                        </div>

                        <!-- Logo -->
                        <div>
                            <x-input-label for="logo" :value="__('Logo')" />
                            @if($business->logo)
                                <div class="mt-2 mb-4">
                                    <img src="{{ $business->logo_url }}" alt="Current Logo" class="h-20 w-20 object-cover rounded-full">
                                    <p class="text-sm text-gray-500 mt-1">Current Logo</p>
                                </div>
                            @endif
                            <x-text-input id="logo" name="logo" type="file" class="mt-1 block w-full" accept="image/*" />
                            <x-input-error class="mt-2" :messages="$errors->get('logo')" />
                        </div>

                        <!-- Cover Image -->
                        <div>
                            <x-input-label for="cover_image" :value="__('Cover Image')" />
                            @if($business->cover_image)
                                <div class="mt-2 mb-4">
                                    <img src="{{ $business->cover_image_url }}" alt="Current Cover Image" class="h-32 w-full object-cover rounded">
                                    <p class="text-sm text-gray-500 mt-1">Current Cover Image</p>
                                </div>
                            @endif
                            <x-text-input id="cover_image" name="cover_image" type="file" class="mt-1 block w-full" accept="image/*" />
                            <x-input-error class="mt-2" :messages="$errors->get('cover_image')" />
                        </div>

                        <!-- Address -->
                        <div>
                            <x-input-label for="address" :value="__('Address')" />
                            <x-text-input id="address" name="address" type="text" class="mt-1 block w-full" :value="old('address', $business->address)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('address')" />
                        </div>

                        <!-- Phone -->
                        <div>
                            <x-input-label for="phone" :value="__('Phone')" />
                            <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" :value="old('phone', $business->phone)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('phone')" />
                        </div>

                        <!-- Email -->
                        <div>
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $business->email)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('email')" />
                        </div>

                        <!-- Website -->
                        <div>
                            <x-input-label for="website" :value="__('Website')" />
                            <x-text-input id="website" name="website" type="url" class="mt-1 block w-full" :value="old('website', $business->website)" />
                            <x-input-error class="mt-2" :messages="$errors->get('website')" />
                        </div>

                        <!-- GST Number -->
                        <div>
                            <x-input-label for="gst_number" :value="__('GST Number')" />
                            <x-text-input id="gst_number" name="gst_number" type="text" class="mt-1 block w-full" :value="old('gst_number', $business->gst_number)" />
                            <x-input-error class="mt-2" :messages="$errors->get('gst_number')" />
                        </div>

                        <!-- Working Hours -->
                        <div>
                            <x-input-label for="working_hours" :value="__('Working Hours')" />
                            <textarea id="working_hours" name="working_hours" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="4" required>{{ old('working_hours', is_array($business->working_hours) ? json_encode($business->working_hours) : $business->working_hours) }}</textarea>
                            <p class="mt-1 text-sm text-gray-500">Enter working hours in JSON format. Example: {"monday": "9:00-17:00", "tuesday": "9:00-17:00"}</p>
                            <x-input-error class="mt-2" :messages="$errors->get('working_hours')" />
                        </div>

                        <!-- Social Media -->
                        <div>
                            <x-input-label for="social_media" :value="__('Social Media')" />
                            <textarea id="social_media" name="social_media" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="4">{{ old('social_media', is_array($business->social_media) ? json_encode($business->social_media) : $business->social_media) }}</textarea>
                            <p class="mt-1 text-sm text-gray-500">Enter social media links in JSON format. Example: {"facebook": "https://facebook.com/yourpage", "instagram": "https://instagram.com/yourpage"}</p>
                            <x-input-error class="mt-2" :messages="$errors->get('social_media')" />
                        </div>

                        <div class="flex items-center justify-end gap-4">
                            <a href="{{ route('business.businesses.show', $business) }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-300 active:bg-gray-300 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                                {{ __('Cancel') }}
                            </a>
                            <x-primary-button>
                                {{ __('Update Business') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

