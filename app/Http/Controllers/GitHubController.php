<?php

namespace App\Http\Controllers;

use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class GitHubController extends Controller
{
    public function redirectToProvider()
    {
        return Socialite::driver('github')->redirect();
    }

    public function callback()
    {
        $user = Socialite::driver('github')->user();

        $gitUser = User::updateOrCreate([
            'github_id' => $user->id,
        ], [
            'name' => $user->name,
            'nickname' => $user->nickname,
            'email' => $user->email,
            'github_token' => $user->token,
            'github_refresh_token' => $user->refreshToken,
            'auth_type' => 'github',
            'password' => Hash::make('password'),
        ]);

        Auth::login($gitUser);


        return redirect('/dashboard');
    }

    // For backend only
    public function getRepositories()
    {
        $user = Auth::user();

        // Use the private method
        $githubData = $this->fetchGitHubData($user);

        // Return the dashboard view
        return view('dashboard', [
            'userProfile' => $githubData['userProfile'],
            'paginatedRepositories' => $githubData['paginatedRepositories'],
            'search' => $githubData['search']
        ]);
    }

    // Private method to handle fetching profile and repositories
    private function fetchGitHubData($user)
    {
        $client = new Client();

        // Fetch the user profile from GitHub
        $profileResponse = $client->get('https://api.github.com/user', [
            'headers' => [
                'Authorization' => "Bearer $user->github_token",
            ]
        ]);

        // Fetch the repositories from GitHub
        $reposResponse = $client->get('https://api.github.com/user/repos', [
            'headers' => [
                'Authorization' => "Bearer $user->github_token",
            ]
        ]);

        // Decode the responses
        $userProfile = json_decode($profileResponse->getBody());
        $repositories = collect(json_decode($reposResponse->getBody()));

        // Check if there is a search query
        $search = request('search');
        if ($search) {
            $repositories = $repositories->filter(function ($repo) use ($search) {
                return stripos($repo->name, $search) !== false;
            });
        }

        // Sort repositories -- new to old
        $repositories = $repositories->sortByDesc('created_at');

        // Paginate repositories
        $perPage = 3;
        $currentPage = request('page', 1);
        $paginatedRepositories = new LengthAwarePaginator(
            $repositories->forPage($currentPage, $perPage),
            $repositories->count(),
            $perPage,
            $currentPage,
            ['path' => url()->current()]
        );

        return [
            'userProfile' => $userProfile,
            'paginatedRepositories' => $paginatedRepositories,
            'search' => $search
        ];
    }

    // For frontend only
    public function profile()
    {
        if (Auth::check()) {
            $user = Auth::user();

            // Use the private method
            $githubData = $this->fetchGitHubData($user);

            // Return the profile view
            return view('welcome', [
                'userProfile' => $githubData['userProfile'],
                'paginatedRepositories' => $githubData['paginatedRepositories'],
                'search' => $githubData['search']
            ]);
        } else {
            // If user is not logged in, return the default view
            return view('welcome');
        }
    }
}
