<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('GitHub Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{-- Display GitHub user profile --}}
                    <div class="flex items-center space-x-4 mb-6">
                        <img src="{{ $userProfile->avatar_url }}" alt="Profile Picture" class="w-16 h-16 rounded-full">
                        <div style="padding-left: 20px;">
                            <h3 class="text-xl font-semibold">{{ $userProfile->name }}</h3>
                            <p class="text-gray-600">{{ $userProfile->bio }}</p>
                            <p class="text-gray-600">{{ $userProfile->public_repos }} Public Repositories</p>
                        </div>
                    </div>

                    <!-- Search Bar -->
                    <form method="GET" action="{{ url()->current() }}">
                        <div class="flex items-center space-x-2 mb-4">
                            <input type="text" name="search" value="{{ $search ?? '' }}"
                                   placeholder="Search repositories by name"
                                   class="border focus:outline-none border-gray-300 dark:border-gray-600 p-2 rounded-lg w-full  dark:text-black ">
                            <button type="submit"
                                    class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg">
                                Search
                            </button>
                        </div>
                    </form>

                    {{-- Display list of repositories --}}
                    <div>
                        <h3 class="text-xl mb-4">GitHub Repositories (New to Old)</h3>
                        <ul class="space-y-4">
                            @forelse ($paginatedRepositories as $repo)
                                <li class="p-4 mb-4 bg-gray-100 rounded-lg shadow-md">
                                    <h4 class="text-lg font-semibold">{{ $repo->name }}</h4>
                                    <p>{{ $repo->description ?? 'No description available' }}</p>
                                    <p><strong>Stars:</strong> {{ $repo->stargazers_count }}</p>
                                    <p><strong>Forks:</strong> {{ $repo->forks_count }}</p>
                                    <p><strong>Language:</strong> {{ $repo->language ?? 'N/A' }}</p>
                                    <a href="{{ $repo->html_url }}" target="_blank"
                                       class="underline">View Repository on GitHub</a>
                                </li>
                            @empty
                                <li class="p-4 bg-gray-100 rounded-lg shadow-md">
                                    <p>No repositories found for the search term "{{ $search }}".</p>
                                </li>
                            @endforelse
                        </ul>
                    </div>

                    <!-- Pagination Links -->
                    <div class="mt-6">
                        {{ $paginatedRepositories->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
