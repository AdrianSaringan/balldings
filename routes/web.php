<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BasketballTeamController;
use App\Http\Controllers\VolleyballTeamController;
use App\Http\Controllers\BasketballMatchController;
use App\Http\Controllers\VolleyballMatchController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\TournamentController;
use App\Http\Controllers\BracketController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\UserSportController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 🏠 Public welcome page
Route::get('/', function () {
    return view('welcome');
});

// 🧭 User Dashboard (for authenticated + verified users)
Route::get('/dashboard', function () {
    $user = auth()->user();
    if ($user && $user->usertype === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// 👤 Profile Routes (accessible to logged-in users)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 🔔 User Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'read'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'readAll'])->name('notifications.readAll');
    Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])->name('notifications.destroy');

    // 🧑‍🤝‍🧑 User-facing: My Teams and My Matches (filtered by user's sport)
    Route::get('/teams', [UserSportController::class, 'teams'])->name('user.teams');
    Route::get('/matches', [UserSportController::class, 'matches'])->name('user.matches');
    Route::get('/brackets', [UserSportController::class, 'brackets'])->name('user.brackets');
});

// 🛡️ Admin Routes (Protected by auth + admin middleware)
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // 🧭 Admin Dashboard
        Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

        // 👥 User Management
        Route::resource('users', UserController::class);

        // 👤 Admin view of a user's profile
        Route::get('users/{user}/profile', [UserController::class, 'show'])
            ->name('users.profile');

        // 🏀 Basketball
        Route::prefix('basketball')->name('basketball.')->group(function () {
            Route::resource('teams', BasketballTeamController::class);
            Route::resource('matches', BasketballMatchController::class);
            // Team roster management
            Route::post('teams/{team}/players', [BasketballTeamController::class, 'addPlayer'])->name('teams.players.add');
            Route::delete('teams/{team}/players/{user}', [BasketballTeamController::class, 'removePlayer'])->name('teams.players.remove');
            // Scoring monitor
            Route::get('matches/{match}/scorer', [BasketballMatchController::class, 'scorer'])->name('matches.scorer');
            // GET safeguard: redirect GET /score to scorer page to avoid 405s
            Route::get('matches/{match}/score', function ($match) {
                return redirect(url("/admin/basketball/matches/{$match}/scorer"));
            });
            Route::post('matches/{match}/score', [BasketballMatchController::class, 'score'])->name('matches.score');
            Route::post('matches/{match}/status', [BasketballMatchController::class, 'setStatus'])->name('matches.setStatus');
        });

        // 🏐 Volleyball
        Route::prefix('volleyball')->name('volleyball.')->group(function () {
            Route::resource('teams', VolleyballTeamController::class);
            Route::resource('matches', VolleyballMatchController::class);
            // Team roster management
            Route::post('teams/{team}/players', [VolleyballTeamController::class, 'addPlayer'])->name('teams.players.add');
            Route::delete('teams/{team}/players/{user}', [VolleyballTeamController::class, 'removePlayer'])->name('teams.players.remove');
            // Scoring monitor
            Route::get('matches/{match}/scorer', [VolleyballMatchController::class, 'scorer'])->name('matches.scorer');
            // GET safeguard: redirect GET /score to scorer page to avoid 405s
            Route::get('matches/{match}/score', function ($match) {
                return redirect(url("/admin/volleyball/matches/{$match}/scorer"));
            });
            Route::post('matches/{match}/score', [VolleyballMatchController::class, 'score'])->name('matches.score');
            Route::post('matches/{match}/status', [VolleyballMatchController::class, 'setStatus'])->name('matches.setStatus');
        });

        // 🏆 Tournament Management
        Route::resource('tournaments', TournamentController::class);
        Route::resource('brackets', BracketController::class);

        // 🧩 Games (cross-sport)
        Route::resource('games', GameController::class);
        Route::post('games/{game}/scores', [GameController::class, 'updateScores'])->name('games.scores');
        Route::post('games/{game}/stats', [GameController::class, 'saveStats'])->name('games.stats');
    });

require __DIR__ . '/auth.php';

// 📺 Public read-only match viewers
Route::get('/basketball/matches', [BasketballMatchController::class, 'listPublic'])
    ->name('basketball.public.index');
Route::get('/basketball/matches/{match}', [BasketballMatchController::class, 'showPublic'])
    ->name('basketball.public.show');
Route::get('/volleyball/matches', [VolleyballMatchController::class, 'listPublic'])
    ->name('volleyball.public.index');
Route::get('/volleyball/matches/{match}', [VolleyballMatchController::class, 'showPublic'])
    ->name('volleyball.public.show');

// 🎮 Public read-only games
Route::get('/games', [GameController::class, 'listPublic'])->name('games.public.index');
Route::get('/games/{game}', [GameController::class, 'showPublic'])->name('games.public.show');
