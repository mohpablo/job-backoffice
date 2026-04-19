<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __("Add Job categories") }}
        </h2>
    </x-slot>

    <div class="overflow-x-auto p-6">
        <div class="max-w-2xl mx-auto p-6 bg-white shadow-md rounded">
            <form action="{{ route('job-categories.store') }}" method="post">
                @csrf
                <x-input-label for="name" :value="__('Job Category Name')" />
                <!-- <input id="name" class='border-gray-300 w-full mt-2 {{ $errors->has('name') ? 'border-red-500' : '' }} focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm'> -->
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
                <div class="flex justify-end space-x-4 mt-2">
                    <a href="{{ route('job-categories.index') }}"
                        class="px-4 py-2 rounded-md text-gray-500 hover:text-gray-700">
                        Cancel
                    </a>
                    <x-primary-button>
                        {{ __('Add Category') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>