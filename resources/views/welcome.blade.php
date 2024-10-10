<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>GitHub OAuth App</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="font-sans antialiased dark:bg-black dark:text-white">
<div class="min-h-screen bg-gray-50 dark:bg-gray-900">
    <!-- Container -->
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
            @if (Auth::check())
                <!-- GitHub User Profile with Dashboard Link -->
                <div class="flex flex-col sm:flex-row items-center justify-between mb-6">
                    <!-- Left: Profile Info -->
                    <div class="flex items-center space-x-4 mb-4 sm:mb-0">
                        <img src="{{ $userProfile->avatar_url }}" alt="Profile Picture"
                             class="w-16 h-16 rounded-full">
                        <div>
                            <h3 class="text-xl font-semibold dark:text-white">{{ $userProfile->name }}</h3>
                            <p class="text-gray-600 dark:text-gray-400">{{ $userProfile->bio }}</p>
                            <p class="text-gray-600 dark:text-gray-400">{{ $userProfile->public_repos }} Public
                                Repositories</p>
                        </div>
                    </div>

                    <!-- Right: Dashboard Link -->
                    <div class="sm:mt-0 mt-2 w-full sm:w-auto text-center sm:text-right">
                        <a href="{{ route('dashboard') }}" class="text-blue-500 hover:text-blue-600 font-normal">
                            Dashboard (Backend)
                        </a>
                    </div>
                </div>

                <!-- Search Bar -->
                <form method="GET" action="{{ url()->current() }}">
                    <div class="flex items-center space-x-2">
                        <input type="text" name="search" value="{{ $search ?? '' }}"
                               placeholder="Search repositories by name"
                               class="border focus:outline-none border-gray-300 dark:border-gray-600 p-2 rounded-lg w-full dark:bg-gray-900 dark:text-white">
                        <button type="submit"
                                class="bg-violet-700 hover:bg-violet-800 text-white px-4 py-2 rounded-lg">
                            Search
                        </button>
                    </div>
                </form>

                <!-- Repository List -->
                <div class="mt-6">
                    <h3 class="text-xl mb-4 dark:text-white">GitHub Repositories (New to Old)</h3>
                    <ul class="space-y-4">
                        @forelse ($paginatedRepositories as $repo)
                            <li class="p-4 mb-4 bg-gray-100 dark:bg-gray-700 rounded-lg shadow-md">
                                <h4 class="text-lg font-semibold dark:text-white">{{ $repo->name }}</h4>
                                <p class="dark:text-gray-400">{{ $repo->description ?? 'No description available' }}</p>
                                <p class="dark:text-gray-400"><strong>Stars:</strong> {{ $repo->stargazers_count }}
                                </p>
                                <p class="dark:text-gray-400"><strong>Forks:</strong> {{ $repo->forks_count }}</p>
                                <p class="dark:text-gray-400">
                                    <strong>Language:</strong> {{ $repo->language ?? 'N/A' }}
                                </p>
                                <a href="{{ $repo->html_url }}" target="_blank"
                                   class="underline dark:text-blue-400">View Repository on GitHub</a>
                            </li>
                        @empty
                            <li class="p-4 bg-gray-100 dark:bg-gray-700 rounded-lg shadow-md">
                                <p class="dark:text-gray-400">No repositories found for the search term
                                    "{{ $search }}
                                    ".</p>
                            </li>
                        @endforelse
                    </ul>
                </div>

                <!-- Pagination Links -->
                <div class="mt-6">
                    {{ $paginatedRepositories->links() }}
                </div>
            @else
                <div class="flex items-center justify-center min-h-96">
                    <div class="text-center">
                        <!-- Heading -->
                        <h1 class="text-4xl font-bold text-white-800 mb-4">GitHub Authorization and Repository
                            Information Display</h1>

                        <!-- Hello message -->
                        <p class="text-base text-slate-400 mb-8">Hello! Please log in using your GitHub account to view
                            your profile and repositories.</p>

                        <!-- Login Link -->
                        <a href="{{ route('login') }}"
                           class="inline-block bg-blue-500 text-white px-6 py-2 rounded-full font-semibold hover:bg-blue-600">
                            Login with GitHub
                        </a>
                    </div>
                </div>
            @endif

        </div>
    </div>

    <!--Footer Section-->
    <footer class="py-6 sm:px-6 lg:px-8">
        <div class="container mx-auto text-center">
            <p class="text-sm">
                © {{ now()->year }} <a href="https://sagorislam.com/" target="_blank"
                                       class="text-blue-500 hover:text-blue-600">Md Alamin Islam</a>.
                All Rights Reserved.
            </p>
        </div>
    </footer>
</div>
</body>
</html>

