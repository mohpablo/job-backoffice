<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl  text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 px-6 flex flex-col gap-6">
        <!-- over view cards -->
        <div class="grid grid-cols-3 gap-6">
            <!-- active users -->
            <div class="bg-white overflow-hidden shadow-md rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900">{{ __('Active Users') }}</h3>
                    <p class="text-3xl font-bold text-indigo-600">{{ $analytics['activeUser'] }}</p>
                <p class="text-sm text-gray-500">last 30 days</p>
            </div>
            <!-- totals jobs -->
            <div class="bg-white overflow-hidden shadow-md rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900">{{ __('Total Jobs') }}</h3>
                <p class="text-3xl font-bold text-indigo-600">{{ $analytics['totalJobs'] }}</p>
                <p class="text-sm text-gray-500">all time</p>
            </div>
            <!-- totals applications jobs -->
            <div class="bg-white overflow-hidden shadow-md rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900">{{ __('Total Applications') }}</h3>
                <p class="text-3xl font-bold text-indigo-600">{{ $analytics['totalApplications'] }}</p>
                <p class="text-sm text-gray-500">all time</p>
            </div>
        </div>
        <!-- most appliyed jobs -->
        <div class="bg-white overflow-hidden shadow-md rounded-lg p-6 ">
            <h3 class="text-lg font-medium text-gray-900">{{ __('Most Applied Jobs') }}</h3>
            <div class="w-full mt-4 overflow-x-auto">
                <table class="w-full divide-y divide-gray-200">
                    <thead>
                        <tr class="text-left">
                            <th class="py-2 uppercase text-gray-500">{{ __('Job Title') }}</th>
                            <th class="py-2 uppercase text-gray-500">{{ __('Company') }}</th>
                            <th class="py-2 uppercase text-gray-500">{{ __('total Applications') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($analytics['mostAppliedJobs'] as $job)
                        <tr>
                            <td class="py-4">{{ $job->title }}</td>
                            <td class="py-4">{{ $job->company->name }}</td>
                            <td class="py-4">{{ $job->TotalCount }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Conversation rate -->
        <div class="bg-white overflow-hidden shadow-md rounded-lg p-6 ">
            <h3 class="text-lg font-medium text-gray-900">{{ __('Conversation Rate') }}</h3>
            <div class="w-full mt-4 overflow-x-auto">
                <table class="w-full divide-y divide-gray-200">
                    <thead>
                        <tr class="text-left">
                            <th class="py-2 uppercase text-gray-500">{{ __('Job Title') }}</th>
                            <th class="py-2 uppercase text-gray-500">{{ __('view') }}</th>
                            <th class="py-2 uppercase text-gray-500">{{ __('total Applications') }}</th>
                            <th class="py-2 uppercase text-gray-500">{{ __('Conversation Rate') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($analytics['conversationRates'] as $job)
                        <tr>
                            <td class="py-4">{{ $job->title }}</td>
                            <td class="py-4">{{ $job->viewCount }}</td>
                            <td class="py-4">{{ $job->TotalCount }}</td>
                            <td class="py-4">
                                {{ $job->conversationRate }}%
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>