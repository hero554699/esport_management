<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EventsController;
use App\Http\Controllers\TeamsController;
use App\Http\Controllers\PlayersController;
use App\Http\Controllers\GamesController;
use App\Http\Controllers\OrganizationsController;
use App\Http\Controllers\MatchesPublicController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\TeamController;
use App\Http\Controllers\Admin\PlayerController;
use App\Http\Controllers\Admin\MatchesController;
use App\Http\Controllers\Admin\OrganizationController;
use App\Http\Controllers\Admin\GameController;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/events', [EventsController::class, 'index'])->name('events.index');
Route::get('/events/{event:slug}', [EventsController::class, 'show'])->name('events.show');
Route::get('/teams', [TeamsController::class, 'index'])->name('teams.index');
Route::get('/players', [PlayersController::class, 'index'])->name('players.index');
Route::get('/games', [GamesController::class, 'index'])->name('games.index');
Route::get('/organizations', [OrganizationsController::class, 'index'])->name('organizations.index');
Route::get('/organizations/{organization:slug}', [OrganizationsController::class, 'show'])->name('organizations.show');
Route::get('/matches', [MatchesPublicController::class, 'index'])->name('matches.index');

// User dashboard
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\UserDashboardController::class, 'index'])->name('dashboard');
});

// User CRUD routes
Route::middleware(['auth'])->prefix('user')->name('user.')->group(function () {
    Route::resource('events', App\Http\Controllers\User\EventController::class);
    Route::resource('teams', App\Http\Controllers\User\TeamController::class);
    Route::resource('teams.players', App\Http\Controllers\User\PlayerController::class)
        ->only(['store', 'destroy']);
    Route::get('teams/{team}', [App\Http\Controllers\User\TeamController::class, 'show'])
        ->name('teams.show');

    // Match scheduling inside a tournament
    Route::post('events/{event}/matches', [App\Http\Controllers\User\MatchController::class, 'store'])
        ->name('events.matches.store');
    Route::delete('events/{event}/matches/{match}', [App\Http\Controllers\User\MatchController::class, 'destroy'])
        ->name('events.matches.destroy');
});

// Admin routes
Route::prefix('admin')
    ->middleware(['auth', 'admin'])
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('events', EventController::class);
        Route::resource('teams', TeamController::class);
        Route::get('teams/{team}/show', [TeamController::class, 'show'])->name('teams.show');
        Route::resource('players', PlayerController::class);
        Route::resource('matches', MatchesController::class);
        Route::resource('organizations', OrganizationController::class);
        Route::resource('games', GameController::class);

        Route::post('events/{event}/approve', [EventController::class, 'approve'])->name('events.approve');
        Route::post('events/{event}/reject', [EventController::class, 'reject'])->name('events.reject');
    });

require __DIR__ . '/auth.php';
