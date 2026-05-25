<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\GameController;
use App\Http\Controllers\Admin\MatchesController;
use App\Http\Controllers\Admin\OrganizationController;
use App\Http\Controllers\Admin\PlayerController;
use App\Http\Controllers\Admin\ResultController as AdminResultController;
use App\Http\Controllers\Admin\TeamController;
use App\Http\Controllers\EventsController;
use App\Http\Controllers\GamesController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MatchesPublicController;
use App\Http\Controllers\OrganizationsController;
use App\Http\Controllers\PlayersController;
use App\Http\Controllers\TeamsController;
use App\Http\Controllers\User\EventController as UserEventController;
use App\Http\Controllers\User\MatchController as UserMatchController;
use App\Http\Controllers\User\PlayerController as UserPlayerController;
use App\Http\Controllers\User\ResultController as UserResultController;
use App\Http\Controllers\User\TeamController as UserTeamController;
use Illuminate\Support\Facades\Route;

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
    Route::resource('events', UserEventController::class);
    Route::resource('teams', UserTeamController::class);
    Route::resource('teams.players', UserPlayerController::class);
    Route::resource('events.matches', UserMatchController::class);
    Route::resource('matches.results', UserResultController::class);
});

// Admin routes
Route::prefix('admin')
    ->middleware(['auth', 'admin'])
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('events', EventController::class);
        Route::resource('teams', TeamController::class);
        Route::resource('players', PlayerController::class);
        Route::resource('matches', MatchesController::class);
        Route::resource('results', AdminResultController::class);
        Route::resource('organizations', OrganizationController::class);
        Route::resource('games', GameController::class);

        Route::post('events/{event}/approve', [EventController::class, 'approve'])->name('events.approve');
        Route::post('events/{event}/reject', [EventController::class, 'reject'])->name('events.reject');
    });

require __DIR__ . '/auth.php';
