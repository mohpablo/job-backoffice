<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __("Edit Job Vacancy") }}
        </h2>
    </x-slot>

    <div class="max-w-3xl mx-auto p-6">
        <div class="bg-white shadow-md rounded-lg p-6">
            <form action="{{ route('job-vacancies.update', ['job_vacancy' => $job->id,'redirecttolist' => request()->query('redirecttolist')]) }}" method="post">
                @csrf
                @method('Patch')
                <!-- Job Vacancy Details Card -->
                <div class="mb-6 p-6 bg-gray-50 border border-gray-200 rounded-lg">
                    <h3 class="text-lg font-semibold mb-2">Job Vacancy Details</h3>
                    <p class="text-sm text-gray-500 mb-4">Enter the details of your Job Vacancy</p>

                    <!-- Title -->
                    <div class="mb-4">
                        <x-input-label for="title" :value="__('Job Vacancy Title')" />
                        <x-text-input id="title" name="title" type="text" :value="old('title',$job->title)"
                            class="mt-2 w-full" />
                        <x-input-error :messages="$errors->get('title')" class="mt-1" />
                    </div>

                    <!-- Location -->
                    <div class="mb-4">
                        <x-input-label for="location" :value="__('Job Vacancy Location')" />
                        <x-text-input id="location" name="location" type="text" :value="old('location' ,$job->location)"
                            class="mt-2 w-full" />
                        <x-input-error :messages="$errors->get('location')" class="mt-1" />
                    </div>

                    <!-- Salary -->
                    <div class="mb-4">
                        <x-input-label for="salary" :value="__('Job Vacancy Salary')" />
                        <x-text-input id="salary" name="salary" type="number" :value="old('salary',$job->salary)"
                            class="mt-2 w-full" />
                        <x-input-error :messages="$errors->get('salary')" class="mt-1" />
                    </div>

                    <!-- Job Type -->
                    <div class="mb-4">
                        <x-input-label for="type" :value="__('Job Type')" />
                        <select name="type" id="type" class="mt-2 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500">
                            <option value="Full-time" {{ old('type', $job->type) == 'Full-time' ? 'selected' : '' }}>Full-time</option>
                            <option value="Contract" {{ old('type', $job->type) == 'Contract' ? 'selected' : '' }}>Contract</option>
                            <option value="Remote" {{ old('type', $job->type) == 'Remote' ? 'selected' : '' }}>Remote</option>
                            <option value="Hybrid" {{ old('type', $job->type) == 'Hybrid' ? 'selected' : '' }}>Hybrid</option>
                        </select>
                        <x-input-error :messages="$errors->get('type')" class="mt-1" />
                    </div>

                    <!-- Company -->
                    <div class="mb-4">
                        <x-input-label for="company_id" :value="__('Company')" />
                        <select name="companyId" id="company_id" class="mt-2 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500">
                            @foreach ($companies as $company)
                            <option value="{{ $company->id }}" {{ old('companyId', $job->companyId == $company->id ? 'selected' : '') }}>{{ $company->name }}</option>
                            @endforeach
                        </select>
                    <x-input-error :messages="$errors->get('companyId')" class="mt-1" />
                    </div>

                    <!-- Job Category -->
                    <div class="mb-4">
                        <x-input-label for="jobcategory_id" :value="__('Job Category')" />
                        <select name="jobcategoryId" id="jobcategory_id" class="mt-2 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500">
                            @foreach ($jobCategories as $jobCategory)
                            <option value="{{ $jobCategory->id }}" {{ old('jobcategoryId', $job->jobcategoryId == $jobCategory->id ? 'selected' : '') }}>{{ $jobCategory->name }}</option>
                            @endforeach
                        </select>
                    <x-input-error :messages="$errors->get('jobcategoryId')" class="mt-1" />
                    </div>

                    <!-- Description -->
                    <div class="mb-4">
                        <x-input-label for="description" :value="__('Job Vacancy Description')" />
                        <textarea id="description" name="description" rows="4"
                            class="mt-2 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500">{{ old('description', $job->description) }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-1" />
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex justify-end space-x-4">
                    <a href="{{ route('job-vacancies.index') }}"
                        class="px-4 py-2 text-gray-500 hover:text-gray-700 rounded-md border border-gray-300 hover:border-gray-400">
                        Cancel
                    </a>
                    <x-primary-button>{{ __('Update Job Vacancy') }}</x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>