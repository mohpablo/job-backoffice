<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __($job->title . (request()->boolean('archived') ? ' (Archived)' : '')) }}
            </h2>

            <!-- Back Button -->
            <a href="{{ route('job-vacancies.index') }}"
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
                            {{ $job->title }}
                        </h3>
                        <p class="text-2xl font-semibold text-gray-800">
                            Company : {{ $job->company->name }}
                        </p>
                        <p class="text-2xl font-semibold text-gray-800">
                            job Category : {{ $job->jobCategory->name }}
                        </p>

                        <p class="text-2xl font-semibold text-gray-800">
                            Salary : ${{ number_format($job->salary,2) }}
                        </p>
                        <p class="text-sm text-gray-500">
                            {{ $job->location }} • {{ $job->type }}
                        </p>
                        <p class="text-sm text-gray-500">
                            {{ $job->description }}
                        </p>

                    </div>

                    <!-- Actions -->
                    <div class="flex gap-3">
                        <a href="{{ route('job-vacancies.edit', ['job_vacancy' => $job,'redirecttolist' => 'false']) }}"
                            class="inline-flex items-center gap-2 px-4 py-2 rounded-lg
                                  bg-blue-50 text-blue-700 hover:bg-blue-100 transition">
                            Edit
                        </a>

                        <form action="{{ route('job-vacancies.destroy', $job) }}" method="POST">
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
            <table class="min-w-full divide-y rounded-lg shadow mt-4 bg-white divide-gray-200">
                <thead>
                    <tr>
                        <th class="px-4 py-3 text-left text-md  font-semibold text-gray-600 uppercase tracking-wider">user</th>
                        <th class="px-4 py-3 text-left text-md  font-semibold text-gray-600 uppercase tracking-wider">status</th>
                        <th class="px-4 py-3 text-left text-md  font-semibold text-gray-600 uppercase tracking-wider">aiGeneratedScore</th>
                        <th class="px-4 py-3 text-left text-md  font-semibold text-gray-600 uppercase tracking-wider">aiGeneratedFeedback</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse ($jobapplications as $jobapplication)
                    <tr class="hover:bg-gray-50">
                        <td class="p-4 font-medium">{{ $jobapplication->user->name }}</td>
                        <td class="p-4">{{ $jobapplication->status }}</td>
                        <td class="p-4">{{ $jobapplication->aiGeneratedScore }}</td>
                        <td class="p-4">{{ $jobapplication->aiGeneratedFeedback }}</td>
                        <td class="p-4 text-left">
                            <a href="{{ route('job-vacancies.show', $job->id) }}"
                                class="text-blue-600 hover:underline">View</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="p-6 text-center text-gray-500">
                            No jobs posted yet.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-4">
                {{ $jobapplications->links() }}
            </div>
        </div>
</x-app-layout>