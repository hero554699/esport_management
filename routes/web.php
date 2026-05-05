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
Route::get('/matches', [MatchesPublicController::class, 'index'])->name('matches.index');

// User dashboard routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\UserDashboardController::class, 'index'])->name('dashboard');
});

// User CRUD routes
Route::middleware(['auth'])->prefix('user')->name('user.')->group(function () {
    Route::resource('events', App\Http\Controllers\User\EventController::class);
    Route::resource('teams', App\Http\Controllers\User\TeamController::class);
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
        Route::resource('organizations', OrganizationController::class);
        Route::resource('games', GameController::class);
    });

require __DIR__ . '/auth.php';
