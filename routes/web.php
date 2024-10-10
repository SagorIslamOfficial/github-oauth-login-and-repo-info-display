<?php

use App\Http\Controllers\GitHubController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Display GitHub user profile and repositories
Route::get('/', [GitHubController::class, 'profile'])->name('github.profile');


require __DIR__.'/auth.php';

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/dashboard', [GitHubController::class, 'getRepositories'])->name('dashboard');
});

Route::get('/auth/redirect', [GitHubController::class, 'redirectToProvider'])->name('github.login');
Route::get('/auth/github/callback', [GitHubController::class, 'callback']);
