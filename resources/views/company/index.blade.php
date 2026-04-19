<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __("Companies" . (request()->has('archived') && request()->boolean('archived') ? ' (Archived)' : '')) }}
        </h2>
    </x-slot>

    <div class="overflow-x-auto p-6 ">
        <x-toast-notification />
        <div class="flex justify-between items-center mb-4">
            @if ( request()->has('archived') && request()->boolean('archived'))
            <!-- Active -->
            <a href="{{ route('companies.index') }}"
                class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-800 px-3 py-2 rounded-md transition-colors duration-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="font-medium">View Active Companies</span>
            </a>
            @else
            <!-- Archived -->
            <a href="{{ route('companies.index', ['archived' => true]) }}"
                class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-800 px-3 py-2 rounded-md transition-colors duration-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                </svg>
                <span class="font-medium">View Archived Companies</span>
            </a>
            @endif
            <!-- Add Company Button -->
            <a href="{{ route('companies.create') }}"
                class="bg-gray-800 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded transition-colors duration-200">
                Add Company
            </a>
        </div>
        <!-- Company Table -->
        <table class="min-w-full divide-y rounded-lg shadow mt-4 bg-white divide-gray-200">
            <thead>
                <tr>
                    <th class="px-4 py-3 text-left text-md  font-semibold text-gray-600 uppercase tracking-wider">
                        Company
                    </th>
                    <th class="px-4 py-3 text-left text-md font-semibold text-gray-600 uppercase tracking-wider">
                        Address
                    </th>
                    <th class="px-4 py-3 text-left text-md  font-semibold text-gray-600 uppercase tracking-wider">
                        Industry
                    </th>
                    <th class="px-4 py-3 text-left text-md  font-semibold text-gray-600 uppercase tracking-wider">
                        Website
                    </th>
                    <th class="px-4 py-3 text-left text-md  font-semibold text-gray-600 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($companies as $company)
                <tr class="hover:bg-gray-100">
                    <td class="px-4 py-3 text-md font-medium ">
                        @if (request()->input('archived') == false)
                        <a href="{{ route('companies.show', $company->id) }}"> {{ $company->name }}</a>
                        @else
                        {{ $company->name }}
                        @endif
                    </td>
                    <td class="px-4 py-3 text-md text-gray-800  s">
                        {{ $company->address }}
                    </td>
                    <td class="px-4 py-3 text-md text-gray-800  ">
                        {{ $company->industry }}
                    </td>
                    <td class="px-4 py-3 text-md text-gray-800  ">
                        <a href="#" class="text-blue-600 hover:text-blue-800 hover:underline truncate block max-w-[150px]">
                            {{ $company->website }}
                        </a>
                    </td>
                    <td class=" py-3">
                        <div class="flex items-center space-x-2">
                            @if (request()->has('archived') && request()->boolean('archived'))
                            <!-- Restore Button -->
                            <form action="{{ route('companies.restore', $company->id) }}" method="POST" class="inline">
                                @csrf
                                @method('PUT')
                                <button type="submit"
                                    class="inline-flex items-center gap-1 text-gray-600 hover:text-gray-900 hover:bg-gray-100 px-2 py-1.5 rounded transition-colors duration-200"
                                    title="Restore">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                                    </svg>
                                    <span class=" font-medium text-md">Restore</span>
                                </button>
                            </form>
                            @else
                            <!-- Edit Button -->
                            <a href="{{ route('companies.edit', $company->id) }}"
                                class="inline-flex items-center gap-1 text-blue-600 hover:text-blue-800 hover:bg-blue-50 px-2 py-1.5 rounded transition-colors duration-200"
                                title="Edit">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                <span class="font-medium text-md">Edit</span>
                            </a>
                            <!-- Delete Button -->
                            <form action="{{ route('companies.destroy', $company->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="inline-flex items-center gap-1 text-red-600 hover:text-red-800 hover:bg-red-50 px-2 py-1.5 rounded transition-colors duration-200"
                                    title="Archive">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    <span class="font-medium text-md">Archive</span>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-4 py-8 text-center">
                        <div class="text-gray-500">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <p class="mt-2 text-sm font-medium">No Companies found.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>


        <div class="mt-4">
            {{ $companies->links() }}
        </div>
    </div>
</x-app-layout>