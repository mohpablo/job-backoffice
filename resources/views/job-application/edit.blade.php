<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __("Edit Applictation status") }}
        </h2>
    </x-slot>

    <div class="max-w-3xl mx-auto p-6">
        <div class="bg-white shadow-md rounded-lg p-6">
            <form action="{{ route('job-applications.update', ['job_application' => $application->id, 'redirecttolist' => request()->query('redirecttolist')]) }}" method="post">
                @csrf
                @method('Patch')
                <!-- Job appliaction Details Card -->
                <div class="mb-6 p-6 bg-gray-50 border border-gray-200 rounded-lg">
                    <h3 class="text-lg font-semibold mb-2">Job Applicant Details</h3>
                

                    <!-- name -->
                    <div class="mb-4">
                        <x-input-label for="title" :value="__('applicant name')" />
                        <span>{{ $application->user->name }}</span>
                    </div>

                    <!-- job Vacancy -->
                    <div class="mb-4">
                        <x-input-label for="location" :value="__('Job Vacany')" />
                        <span>{{ $application->jobVacancy->title }}</span>
                    </div>

                    <!-- Company -->
                    <div class="mb-4">
                        <x-input-label for="location" :value="__('Job Company')" />
                        <span>{{ $application->jobVacancy->company->name }}</span>
                    </div>

                    <!-- ai feed back -->
                    <div class="mb-4">
                        <x-input-label for="location" :value="__('AI Feedback')" />
                        <span>{{ $application->aiGeneratedFeedback }}</span>
                    </div>

                    <!-- ai score -->
                    <div class="mb-4">
                        <x-input-label for="location" :value="__('AI Feedback')" />
                        <span>{{ $application->aiGeneratedScore }}</span>
                    </div>

                    <!-- Status -->
                    <div class="mb-4">
                        <x-input-label for="status" :value="__('Job Status')" />
                        <select name="status" id="status" class="mt-2 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500">
                            <option value="Pending" {{ old('status', $application->status) == 'Pending' ? 'selected' : '' }}>Pending</option>
                            <option value="Accepted" {{ old('status', $application->status) == 'Accepted' ? 'selected' : '' }}>Accepted</option>
                            <option value="Rejected" {{ old('status', $application->status) == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                        <x-input-error :messages="$errors->get('status')" class="mt-1" />
                    </div>


                </div>

                <!-- Buttons -->
                <div class="flex justify-end space-x-4">
                    <a href="{{ route('job-applications.index') }}"
                        class="px-4 py-2 text-gray-500 hover:text-gray-700 rounded-md border border-gray-300 hover:border-gray-400">
                        Cancel
                    </a>
                    <x-primary-button>{{ __('Update applicant status') }}</x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>