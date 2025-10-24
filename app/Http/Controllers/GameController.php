<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\GamePlayerStat;
use App\Models\Basketball;
use App\Models\Volleyball;
use App\Models\User;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function index(Request $request)
    {
        $sport = $request->query('sport'); // null|basketball|volleyball
        $query = Game::query()->latest('played_at')->latest('id');
        if ($sport) {
            $query->where('sport', $sport);
        }
        $games = $query->paginate(15);
        return view('admin.games.index', compact('games', 'sport'));
    }

    public function create()
    {
        $basketballTeams = Basketball::all();
        $volleyballTeams = Volleyball::all();
        return view('admin.games.create', compact('basketballTeams', 'volleyballTeams'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'sport' => 'required|in:basketball,volleyball',
            'team1_id_basketball' => 'required_if:sport,basketball|nullable|integer|exists:basketballs,id',
            'team2_id_basketball' => 'required_if:sport,basketball|nullable|integer|exists:basketballs,id',
            'team1_id_volleyball' => 'required_if:sport,volleyball|nullable|integer|exists:volleyballs,id',
            'team2_id_volleyball' => 'required_if:sport,volleyball|nullable|integer|exists:volleyballs,id',
            'played_at' => 'nullable|date',
            'venue' => 'nullable|string|max:255',
            'status' => 'nullable|in:scheduled,ongoing,completed',
        ]);

        $payload = [
            'sport' => $validated['sport'],
            'team1_id' => $validated['sport'] === 'basketball' ? ($validated['team1_id_basketball'] ?? null) : ($validated['team1_id_volleyball'] ?? null),
            'team2_id' => $validated['sport'] === 'basketball' ? ($validated['team2_id_basketball'] ?? null) : ($validated['team2_id_volleyball'] ?? null),
            'played_at' => $validated['played_at'] ?? null,
            'venue' => $validated['venue'] ?? null,
            'status' => $validated['status'] ?? 'scheduled',
        ];

        $game = Game::create($payload);
        return redirect()->route('admin.games.show', $game)->with('success', 'Game created.');
    }

    public function show(Game $game)
    {
        if ($game->sport === 'basketball') {
            $team1 = Basketball::find($game->team1_id);
            $team2 = Basketball::find($game->team2_id);
            $team1Players = User::where('basketball_team_id', $game->team1_id)->get();
            $team2Players = User::where('basketball_team_id', $game->team2_id)->get();
        } else {
            $team1 = Volleyball::find($game->team1_id);
            $team2 = Volleyball::find($game->team2_id);
            $team1Players = User::where('volleyball_team_id', $game->team1_id)->get();
            $team2Players = User::where('volleyball_team_id', $game->team2_id)->get();
        }
        $stats = $game->stats()->get()->keyBy('user_id');
        return view('admin.games.show', compact('game', 'team1', 'team2', 'team1Players', 'team2Players', 'stats'));
    }

    public function updateScores(Request $request, Game $game)
    {
        $data = $request->validate([
            'team1_score' => 'required|integer|min:0',
            'team2_score' => 'required|integer|min:0',
            'status' => 'nullable|in:scheduled,ongoing,completed',
        ]);
        $game->update([
            'team1_score' => $data['team1_score'],
            'team2_score' => $data['team2_score'],
            'status' => $data['status'] ?? $game->status,
        ]);
        return back()->with('success', 'Scores updated.');
    }

    public function saveStats(Request $request, Game $game)
    {
        $rules = [
            'stats' => 'array',
        ];
        // Define per-sport stat fields
        if ($game->sport === 'basketball') {
            $statFields = ['points','rebounds','assists','steals','blocks','fouls','minutes'];
        } else {
            $statFields = ['kills','aces','digs','vb_blocks','vb_assists','receptions','errors','sets_played'];
        }
        foreach ($statFields as $field) {
            $rules["stats.*.$field"] = 'nullable|integer|min:0';
        }
        $rules['stats.*.user_id'] = 'required|exists:users,id';
        $rules['stats.*.team_id'] = 'required|integer';
        $validated = $request->validate($rules);

        foreach (($validated['stats'] ?? []) as $row) {
            $stat = GamePlayerStat::firstOrNew([
                'game_id' => $game->id,
                'user_id' => $row['user_id'],
            ]);
            $stat->sport = $game->sport;
            $stat->team_id = $row['team_id'] ?? null;
            foreach ($statFields as $f) {
                $stat->$f = $row[$f] ?? null;
            }
            $stat->save();
        }

        return back()->with('success', 'Player stats saved.');
    }

    // =====================
    // User-facing (read-only)
    // =====================
    public function listPublic(Request $request)
    {
        $sport = $request->query('sport');
        $user = $request->user();
        $query = Game::query()->latest('played_at')->latest('id');

        if ($user && ($user->usertype !== 'admin')) {
            // Force filter to the user's sport
            if (!empty($user->sport)) {
                $sport = $user->sport;
                $query->where('sport', $user->sport);
            }
        } else {
            // Guest or admin: allow optional filter
            if ($sport) {
                $query->where('sport', $sport);
            }
        }

        $games = $query->paginate(12);
        return view('user.games.index', compact('games', 'sport'));
    }

    public function showPublic(Game $game)
    {
        $user = request()->user();
        if ($user && ($user->usertype !== 'admin')) {
            if (!empty($user->sport) && $user->sport !== $game->sport) {
                abort(403, 'You are not allowed to view games from another sport.');
            }
        }
        if ($game->sport === 'basketball') {
            $team1 = Basketball::find($game->team1_id);
            $team2 = Basketball::find($game->team2_id);
            $team1Players = User::where('basketball_team_id', $game->team1_id)->get();
            $team2Players = User::where('basketball_team_id', $game->team2_id)->get();
            $statFields = ['points','rebounds','assists','steals','blocks','fouls','minutes'];
        } else {
            $team1 = Volleyball::find($game->team1_id);
            $team2 = Volleyball::find($game->team2_id);
            $team1Players = User::where('volleyball_team_id', $game->team1_id)->get();
            $team2Players = User::where('volleyball_team_id', $game->team2_id)->get();
            $statFields = ['kills','aces','digs','vb_blocks','vb_assists','receptions','errors','sets_played'];
        }
        $stats = $game->stats()->get()->keyBy('user_id');
        return view('user.games.show', compact('game','team1','team2','team1Players','team2Players','stats','statFields'));
    }
}
