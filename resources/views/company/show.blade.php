<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __($company->name . (request()->boolean('archived') ? ' (Archived)' : '')) }}
            </h2>
            @if (auth()->user()->role === 'admin')
            <!-- Back Button -->
            <a href="{{ route('companies.index') }}"
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
            @endif
        </div>
    </x-slot>

    <div class="">
        <div class="max-w-7xl mx-auto px-6 py-3 space-y-2">

            <x-toast-notification />

            <div class="bg-white rounded-2xl border shadow-sm p-6">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">

                    <div class="space-y-1">
                        <h3 class="text-2xl font-semibold text-gray-800">
                            {{ $company->name }}
                        </h3>
                        <p class="text-2xl font-semibold text-gray-800">
                            Owner : {{ $company->owner->name }}
                        </p>
                        <p class="text-2xl font-semibold text-gray-800">
                            Email : {{ $company->owner->email }}
                        </p>
                        <p class="text-sm text-gray-500">
                            {{ $company->industry }} • {{ $company->address }}
                        </p>

                        @if($company->website)
                        <a href="{{ $company->website }}" target="_blank"
                            class="inline-block text-sm text-blue-600 hover:underline">
                            {{ $company->website }}
                        </a>
                        @endif
                    </div>

                    <!-- Actions -->
                    <div class="flex gap-3">
                        @if (auth()->user()->role === 'admin')
                        <a href="{{ route('companies.edit', ['company' => $company->id,'redirecttolist' => 'false']) }}"
                            class="inline-flex items-center gap-2 px-4 py-2 rounded-lg
                                  bg-blue-50 text-blue-700 hover:bg-blue-100 transition">
                            Edit
                        </a>
                        @else
                        <a href="{{ route('my-company.edit', ['id' => $company->id,'redirecttolist' => 'false']) }}"
                            class="inline-flex items-center gap-2 px-4 py-2 rounded-lg
                                  bg-blue-50 text-blue-700 hover:bg-blue-100 transition">
                            Edit
                        </a>
                        @endif

                        @if (auth()->user()->role === 'admin' )
                        <form action="{{ route('companies.destroy', $company->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="px-5 py-2 rounded-lg bg-red-100 text-red-700
                                       hover:bg-red-200 transition">
                                Archive
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>

            @if (auth()->user()->role === 'admin')

            <div class="bg-white rounded-2xl border shadow-sm">
                <!-- Tabs -->
                <div class="border-b px-6">
                    <nav class="flex gap-8">
                        <a href="{{ route('companies.show', [$company->id, 'tab' => 'jobs']) }}"
                            class="py-4 text-sm font-medium border-b-2
                           {{ request('tab', 'jobs') === 'jobs'
                               ? 'border-blue-600 text-blue-600'
                               : 'border-transparent text-gray-500 hover:text-gray-700' }}">
                            Jobs
                        </a>

                        <a href="{{ route('companies.show', [$company->id, 'tab' => 'applicants']) }}"
                            class="py-4 text-sm font-medium border-b-2
                           {{ request('tab') === 'applicants'
                               ? 'border-blue-600 text-blue-600'
                               : 'border-transparent text-gray-500 hover:text-gray-700' }}">
                            Applications
                        </a>
                    </nav>
                </div>

                <!-- Content -->
                <div class="p-6 ">

                    <!-- Jobs -->
                    @if(request('tab', 'jobs') === 'jobs')
                    <table class="min-w-full divide-y rounded-lg shadow mt-4 bg-white divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-4 py-3 text-left text-md  font-semibold text-gray-600 uppercase tracking-wider">Title</th>
                                <th class="px-4 py-3 text-left text-md  font-semibold text-gray-600 uppercase tracking-wider">Type</th>
                                <th class="px-4 py-3 text-left text-md  font-semibold text-gray-600 uppercase tracking-wider">Location</th>
                                <th class="px-4 py-3 text-left text-md  font-semibold text-gray-600 uppercase tracking-wider">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            @forelse ($jobs as $job)
                            <tr class="hover:bg-gray-50">
                                <td class="p-4 font-medium">{{ $job->title }}</td>
                                <td class="p-4">{{ $job->type }}</td>
                                <td class="p-4">{{ $job->location }}</td>
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
                        {{ $jobs->links() }}
                    </div>
                    @endif

                    <!-- Applications -->
                    @if(request('tab') === 'applicants')
                    <table class="min-w-full divide-y rounded-lg shadow mt-4 bg-white divide-gray-200">
                        <thead>
                            <tr>
                                <th class="p-4 text-left">Applicant</th>
                                <th class="p-4 text-left">Job</th>
                                <th class="p-4 text-left">Status</th>
                                <th class="p-4 text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            @forelse ($applications as $application)
                            <tr class="hover:bg-gray-50">
                                <td class="p-4">{{ $application->user->name }}</td>
                                <td class="p-4">{{ $application->jobVacancy->title }}</td>
                                <td class="p-4">
                                    <span class="px-3 py-1 rounded-full text-xs bg-gray-100">
                                        {{ $application->status }}
                                    </span>
                                </td>
                                <td class="p-4 text-right">
                                    <a href="{{ route('job-applications.show', $application->id) }}"
                                        class="text-blue-600 hover:underline">
                                        View
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="p-6 text-center text-gray-500">
                                    No applications yet.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $applications->links() }}
                    </div>
                    @endif

                </div>
            </div>
            @endif

        </div>
    </div>
</x-app-layout>