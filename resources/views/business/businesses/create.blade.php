<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create New Business') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('business.store') }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <!-- Business Name -->
                        <div>
                            <x-input-label for="name" :value="__('Business Name')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name')" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>

                        <!-- Description -->
                        <div>
                            <x-input-label for="description" :value="__('Description')" />
                            <textarea id="description" name="description" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="4" required>{{ old('description') }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('description')" />
                        </div>

                        <!-- Address -->
                        <div>
                            <x-input-label for="address" :value="__('Address')" />
                            <x-text-input id="address" name="address" type="text" class="mt-1 block w-full" :value="old('address')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('address')" />
                        </div>

                        <!-- Phone -->
                        <div>
                            <x-input-label for="phone" :value="__('Phone Number')" />
                            <x-text-input id="phone" name="phone" type="tel" class="mt-1 block w-full" :value="old('phone')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('phone')" />
                        </div>

                        <!-- Email -->
                        <div>
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('email')" />
                        </div>

                        <!-- Website -->
                        <div>
                            <x-input-label for="website" :value="__('Website (Optional)')" />
                            <x-text-input id="website" name="website" type="url" class="mt-1 block w-full" :value="old('website')" />
                            <x-input-error class="mt-2" :messages="$errors->get('website')" />
                        </div>

                        <!-- GST Number -->
                        <div>
                            <x-input-label for="gst_number" :value="__('GST Number (Optional)')" />
                            <x-text-input id="gst_number" name="gst_number" type="text" class="mt-1 block w-full" :value="old('gst_number')" />
                            <x-input-error class="mt-2" :messages="$errors->get('gst_number')" />
                        </div>

                        <!-- Logo -->
                        <div>
                            <x-input-label for="logo" :value="__('Business Logo')" />
                            <input type="file" id="logo" name="logo" class="mt-1 block w-full" accept="image/*" />
                            <x-input-error class="mt-2" :messages="$errors->get('logo')" />
                        </div>

                        <!-- Cover Image -->
                        <div>
                            <x-input-label for="cover_image" :value="__('Cover Image')" />
                            <input type="file" id="cover_image" name="cover_image" class="mt-1 block w-full" accept="image/*" />
                            <x-input-error class="mt-2" :messages="$errors->get('cover_image')" />
                        </div>

                        <!-- Working Hours -->
                        <div>
                            <x-input-label :value="__('Working Hours')" />
                            <div class="grid grid-cols-2 gap-4 mt-2">
                                @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                                    <div class="space-y-2">
                                        <label class="block text-sm font-medium text-gray-700">{{ $day }}</label>
                                        <div class="flex space-x-2">
                                            <input type="time" name="working_hours[{{ strtolower($day) }}][start]" 
                                                class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                                value="{{ old('working_hours.'.strtolower($day).'.start') }}">
                                            <input type="time" name="working_hours[{{ strtolower($day) }}][end]" 
                                                class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                                value="{{ old('working_hours.'.strtolower($day).'.end') }}">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <x-input-error class="mt-2" :messages="$errors->get('working_hours')" />
                        </div>

                        <!-- Social Media -->
                        <div>
                            <x-input-label :value="__('Social Media Links (Optional)')" />
                            <div class="space-y-2 mt-2">
                                <div>
                                    <x-input-label for="facebook" :value="__('Facebook')" />
                                    <x-text-input id="facebook" name="social_media[facebook]" type="url" class="mt-1 block w-full" :value="old('social_media.facebook')" />
                                </div>
                                <div>
                                    <x-input-label for="twitter" :value="__('Twitter')" />
                                    <x-text-input id="twitter" name="social_media[twitter]" type="url" class="mt-1 block w-full" :value="old('social_media.twitter')" />
                                </div>
                                <div>
                                    <x-input-label for="instagram" :value="__('Instagram')" />
                                    <x-text-input id="instagram" name="social_media[instagram]" type="url" class="mt-1 block w-full" :value="old('social_media.instagram')" />
                                </div>
                                <div>
                                    <x-input-label for="linkedin" :value="__('LinkedIn')" />
                                    <x-text-input id="linkedin" name="social_media[linkedin]" type="url" class="mt-1 block w-full" :value="old('social_media.linkedin')" />
                                </div>
                            </div>
                            <x-input-error class="mt-2" :messages="$errors->get('social_media')" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button>
                                {{ __('Create Business') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

