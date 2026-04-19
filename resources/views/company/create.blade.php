<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __("Add Job categories") }}
        </h2>
    </x-slot>

    <div class="overflow-x-auto p-4">
        <div class="max-w-2xl   mx-auto p-6 bg-white shadow-md rounded">
            <form action="{{ route('companies.store') }}" method="post">
                @csrf
                <!-- company details -->
                <div class="mb-4 p-6 bg-gray-50 border-gray-100 rounded-lg shadow-sm">
                    <h3 class="text-lg font-bold">Company Details</h3>
                    <p class="text-sm mb-4 ">Enter the details of your company</p>
                    <!-- company name -->
                    <div class="mb-4"> <x-input-label for="name" :value="__('Company Name')" />
                        <input
                            id="name"
                            name="name"
                            type="text"
                            value="{{ old('name') }}"
                            class="w-full mt-2 border-gray-300 rounded-md shadow-sm
                    focus:outline-none
                    focus:border-indigo-500
                    focus:ring-2 focus:ring-indigo-500
                    {{ $errors->has('name') ? 'border-red-500 focus:ring-red-500' : '' }}" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>
                    <!-- company address -->
                    <div class="mb-4">
                        <x-input-label for="address" :value="__('Company Address')" />
                        <input
                            id="address"
                            name="address"
                            type="text"
                            value="{{ old('address') }}"
                            class="w-full mt-2 border-gray-300 rounded-md shadow-sm
                    focus:outline-none
                    focus:border-indigo-500
                    focus:ring-2 focus:ring-indigo-500
                    {{ $errors->has('address') ? 'border-red-500 focus:ring-red-500' : '' }}" />
                        <x-input-error :messages="$errors->get('address')" class="mt-2" />
                    </div>
                    <!-- company industry -->
                    <div class="mb-4">
                        <label for="industry" class="block text-sm font-medium text-gray-700">Industry</label>
                        <div class="mt-1 relative">
                            <select
                                name="industry"
                                id="industry"
                                class="block w-full appearance-none rounded-md border border-gray-300 bg-white px-3 py-2 pr-8 text-gray-700 shadow-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 sm:text-sm">
                                @foreach ($industries as $industry)
                                <option value="{{ $industry }}">{{ $industry }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <!-- company website -->
                    <div class="mb-4">
                        <x-input-label for="website" :value="__('Company Website (optional)')" />
                        <input
                            id="website"
                            name="website"
                            type="text"
                            value="{{ old('website') }}"
                            class="w-full mt-2 border-gray-300 rounded-md shadow-sm
                    focus:outline-none
                    focus:border-indigo-500
                    focus:ring-2 focus:ring-indigo-500
                    {{ $errors->has('website') ? 'border-red-500 focus:ring-red-500' : '' }}" />
                        <x-input-error :messages="$errors->get('website')" class="mt-2" />
                    </div>
                </div>
                <!-- company owner -->
                <div class="mb-4 p-6 bg-gray-50 border-gray-100 rounded-lg shadow-sm">
                    <h3 class="text-lg font-bold">Company Owner</h3>
                    <span>Enter the details of your company owner</span>
                    <div class="mt-4">
                        <div>
                            <x-input-label for="owner_name" :value="__('Owner Name')" />
                            <x-text-input id="owner_name" class="block mt-1 w-full" type="text" name="owner_name" :value="old('owner_email')"  autofocus autocomplete="username" />
                            <x-input-error :messages="$errors->get('owner_name')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="owner_email" :value="__('Owner Email')" />
                            <x-text-input id="owner_email" class="block mt-1 w-full" type="email" name="owner_email" :value="old('owner_email')"  autofocus autocomplete="username" />
                            <x-input-error :messages="$errors->get('owner_email')" class="mt-2" />
                        </div>

                        <!-- Password -->
                        <div class="mt-4">
                            <x-input-label for="owner_password" :value="__('Owner Password')" />

                            <div class="relative" x-data="{ showPassword : false}">
                                <x-text-input id="owner_password" class="block mt-1 w-full"
                                    name="owner_password"
                                    x-bind:type="showPassword ? 'text' : 'password'"
                                     autocomplete="current-password" />
                                <button type="button" @click="showPassword = !showPassword" class="absolute inset-y-0 right-2 flex items-center text-gray-500 ">
                                    <!-- eye close-->
                                    <svg x-show="!showPassword" class="w-6 h-6" width="800px" height="800px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M2.99902 3L20.999 21M9.8433 9.91364C9.32066 10.4536 8.99902 11.1892 8.99902 12C8.99902 13.6569 10.3422 15 11.999 15C12.8215 15 13.5667 14.669 14.1086 14.133M6.49902 6.64715C4.59972 7.90034 3.15305 9.78394 2.45703 12C3.73128 16.0571 7.52159 19 11.9992 19C13.9881 19 15.8414 18.4194 17.3988 17.4184M10.999 5.04939C11.328 5.01673 11.6617 5 11.9992 5C16.4769 5 20.2672 7.94291 21.5414 12C21.2607 12.894 20.8577 13.7338 20.3522 14.5" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <!-- eye open -->
                                    <svg x-show="showPassword" class="w-6 h-6" width="800px" height="800px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M15.0007 12C15.0007 13.6569 13.6576 15 12.0007 15C10.3439 15 9.00073 13.6569 9.00073 12C9.00073 10.3431 10.3439 9 12.0007 9C13.6576 9 15.0007 10.3431 15.0007 12Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M12.0012 5C7.52354 5 3.73326 7.94288 2.45898 12C3.73324 16.0571 7.52354 19 12.0012 19C16.4788 19 20.2691 16.0571 21.5434 12C20.2691 7.94291 16.4788 5 12.0012 5Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </button>
                            </div>
                            <x-input-error :messages="$errors->get('owner_password')" class="mt-2" />
                        </div>
                    </div>
                </div>

                <!-- company buttons -->

                <div class="flex justify-end space-x-4 mt-2">
                    <a href="{{ route('companies.index') }}"
                        class="px-4 py-2 rounded-md text-gray-500 hover:text-gray-700">
                        Cancel
                    </a>
                    <x-primary-button>
                        {{ __('Add Company') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>