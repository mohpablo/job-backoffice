<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __("Application for " . $application->jobVacancy->title . (request()->boolean('archived') ? ' (Archived)' : '')) }}
            </h2>

            <!-- Back Button -->
            <a href="{{ route('job-applications.index') }}"
                class="inline-flex items-center gap-2 px-4 py-2 rounded-lg
                      border border-gray-300 bg-white text-gray-700
                      hover:bg-gray-50 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 19l-7-7 7-7" />
                </svg>
                <span class="text-sm font-medium">Back</span>
            </a>
        </div>
    </x-slot>

    <div class="">
        <div class="max-w-7xl mx-auto px-6 py-3 space-y-2">

            <x-toast-notification />

            <div class="bg-white rounded-2xl border shadow-sm p-6">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">

                    <div class="space-y-1">
                        <h3 class="text-2xl font-semibold text-gray-800">
                            {{ $application->user->name }}
                        </h3>
                        <h3 class="text-2xl font-semibold text-gray-800">
                            {{ $application->jobVacancy->title }}
                        </h3>
                        <p class="text-2xl font-semibold text-gray-800">
                            Job Vacany : {{ $application->jobVacancy->title }}
                        </p>
                        <p class="text-2xl font-semibold text-gray-800">
                            Company : {{ $application->jobVacancy->company->name }}</p>
                        <p class="text-2xl font-semibold  @if($application->status == 'Pending') text-yellow-500
                                                         @elseif($application->status == 'Accepted') text-green-500
                                                         @elseif($application->status == 'Rejected') text-red-500
                            @else text-gray-800
                            @endif
                            ">
                            status : {{ $application->status }}
                        </p>
                        <p class="text-sm text-gray-500">
                            Resume {{ $application->resume->fileUrl }}
                        </p>

                    </div>

                    <!-- Actions -->
                    <div class="flex gap-3">
                        <a href="{{ route('job-applications.edit', ['job_application' => $application->id,'redirecttolist' => 'false']) }}"
                            class="inline-flex items-center gap-2 px-4 py-2 rounded-lg
                                  bg-blue-50 text-blue-700 hover:bg-blue-100 transition">
                            Edit
                        </a>

                        <form action="{{ route('job-applications.destroy', $application->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="px-5 py-2 rounded-lg bg-red-100 text-red-700
                                       hover:bg-red-200 transition">
                                Archive
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-2xl border shadow-sm">
                <!-- Tabs -->
                <div class="border-b px-6">
                    <nav class="flex gap-8">
                        <a href="{{ route('job-applications.show', [$application->id, 'tab' => 'resume']) }}"
                            class="py-4 text-sm font-medium border-b-2
                           {{ request('tab', 'resume') === 'resume'
                               ? 'border-blue-600 text-blue-600'
                               : 'border-transparent text-gray-500 hover:text-gray-700' }}">
                            Resume
                        </a>

                        <a href="{{ route('job-applications.show', [$application->id, 'tab' => 'ai-feedback']) }}"
                            class="py-4 text-sm font-medium border-b-2
                           {{ request('tab') === 'ai-feedback'
                               ? 'border-blue-600 text-blue-600'
                               : 'border-transparent text-gray-500 hover:text-gray-700' }}">
                            AI Feedback
                        </a>
                    </nav>
                </div>

                <!-- Content -->
                <div class="p-6 ">

                    <!-- Resume -->
                    @if(request('tab', 'resume') === 'resume')
                    <table class="min-w-full divide-y rounded-lg shadow mt-4 bg-white divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-4 py-3 text-left text-md  font-semibold text-gray-600 uppercase tracking-wider">Summary</th>
                                <th class="px-4 py-3 text-left text-md  font-semibold text-gray-600 uppercase tracking-wider">Skills</th>
                                <th class="px-4 py-3 text-left text-md  font-semibold text-gray-600 uppercase tracking-wider">Experience</th>
                                <th class="px-4 py-3 text-left text-md  font-semibold text-gray-600 uppercase tracking-wider">Education</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">

                            <tr class="hover:bg-gray-50">
                                <td class="p-4 font-medium">{{ $application->resume->summary }}</td>
                                <td class="p-4">{{ $application->resume->skills }}</td>
                                <td class="p-4">{{ $application->resume->experience }}</td>
                                <td class="p-4">{{ $application->resume->education }}</td>
                            </tr>
                        </tbody>
                    </table>
                    @endif

                    <!-- ai-feedback -->
                    @if(request('tab') === 'ai-feedback')
                    <table class="min-w-full divide-y rounded-lg shadow mt-4 bg-white divide-gray-200">
                        <thead>
                            <tr>
                                <th class="p-4 text-left">AI Score</th>
                                <th class="p-4 text-left">AI Feedback</th>

                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            <tr class="hover:bg-gray-50">
                                <td class="p-4">{{ $application->aiGeneratedScore }}</td>
                                <td class="p-4">{{ $application->aiGeneratedFeedback }}</td>

                            </tr>

                        </tbody>
                    </table>


                    @endif

                </div>
            </div>
        </div>
</x-app-layout>