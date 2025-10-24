<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Volleyball;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use App\Notifications\TeamChanged;
use Illuminate\Support\Facades\Schema;

class VolleyballTeamController extends Controller
{
    // Show all teams
    public function index()
    {
        $teams = Volleyball::all();
        return view('admin.volleyball.teams.index', compact('teams'));
    }

    // Show a specific volleyball team with its players
    public function show(Volleyball $team)
    {
        $query = User::where('role','player')
            ->where('sport','volleyball');
        if (Schema::hasColumn('users','volleyball_team_id')) {
            $query->where('volleyball_team_id', $team->id);
        } else {
            // Fallback: show none until migration is applied
            $query->whereRaw('1=0');
        }
        $players = $query->orderBy('name')->get();

        $availablePlayers = collect();
        if (Schema::hasColumn('users','volleyball_team_id')) {
            $availablePlayers = User::where('role','player')
                ->where('sport','volleyball')
                ->whereNull('volleyball_team_id')
                ->orderBy('name')
                ->get(['id','name','email']);
        }

        return view('admin.volleyball.teams.show', compact('team','players','availablePlayers'));
    }

    // Show create form
    public function create()
    {
        return view('admin.volleyball.teams.create');
    }

    // Store new team
    public function store(Request $request)
    {
        $request->validate([
            'team_name'      => 'required|string|max:255',
            'coach_name'     => 'required|string|max:255',
            'num_of_players' => 'required|integer|min:1',
        ]);

        $team = Volleyball::create([
            'team_name'      => $request->team_name,
            'coach_name'     => $request->coach_name,
            'num_of_players' => $request->num_of_players,
        ]);

        // Notify volleyball users
        $recipients = User::where('usertype','!=','admin')->where('sport','volleyball')->get();
        if ($recipients->isNotEmpty()) {
            Notification::send($recipients, new TeamChanged('volleyball', 'created', $team->toArray()));
        }

        return redirect()
            ->route('admin.volleyball.teams.index')
            ->with('success', 'Volleyball team added successfully!');
    }


    // Edit form
    public function edit(Volleyball $team)
    {
        return view('admin.volleyball.teams.edit', compact('team'));
    }

    // Update existing team
    public function update(Request $request, Volleyball $team)
    {
        $request->validate([
            'team_name'       => 'required|string|max:255',
            'coach_name'      => 'required|string|max:255',
            'num_of_players'  => 'required|integer|min:1',
        ]);

        $team->update([
            'team_name'      => $request->team_name,
            'coach_name'     => $request->coach_name,
            'num_of_players' => $request->num_of_players,
        ]);

        // Notify volleyball users
        $recipients = User::where('usertype','!=','admin')->where('sport','volleyball')->get();
        if ($recipients->isNotEmpty()) {
            Notification::send($recipients, new TeamChanged('volleyball', 'updated', $team->toArray()));
        }

        return redirect()
            ->route('admin.volleyball.teams.index')
            ->with('success', 'Volleyball team updated successfully!');
    }

    // Delete team
    public function destroy(Volleyball $team)
    {
        $payload = $team->toArray();
        $team->delete();

        // Notify volleyball users
        $recipients = User::where('usertype','!=','admin')->where('sport','volleyball')->get();
        if ($recipients->isNotEmpty()) {
            Notification::send($recipients, new TeamChanged('volleyball', 'deleted', $payload));
        }

        return redirect()
            ->route('admin.volleyball.teams.index')
            ->with('success', 'Team deleted successfully!');
    }

    /**
     * ➕ Add a player to the volleyball team roster.
     */
    public function addPlayer(Request $request, Volleyball $team)
    {
        if (!Schema::hasColumn('users','volleyball_team_id')) {
            return back()->with('error', 'Cannot add players until migrations are run (missing users.volleyball_team_id).');
        }
        $request->validate([
            'user_id' => ['required','exists:users,id'],
        ]);

        $user = User::findOrFail($request->input('user_id'));
        if ($user->role !== 'player' || $user->sport !== 'volleyball') {
            return back()->with('error', 'Selected user is not a volleyball player.');
        }

        $previousTeamId = $user->volleyball_team_id;
        if ($previousTeamId === $team->id) {
            return back()->with('info', 'Player is already in this team.');
        }

        if ($previousTeamId) {
            $oldTeam = Volleyball::find($previousTeamId);
            if ($oldTeam && Schema::hasColumn('volleyballs','num_of_players')) {
                $oldTeam->decrement('num_of_players');
            }
        }

        $user->volleyball_team_id = $team->id;
        $user->save();

        if (Schema::hasColumn('volleyballs','num_of_players')) {
            $team->increment('num_of_players');
        }

        return back()->with('success', 'Player added to team.');
    }

    /**
     * ➖ Remove a player from the volleyball team roster.
     */
    public function removePlayer(Volleyball $team, User $user)
    {
        if (!Schema::hasColumn('users','volleyball_team_id')) {
            return back()->with('error', 'Cannot remove players until migrations are run (missing users.volleyball_team_id).');
        }
        if ($user->role !== 'player' || $user->sport !== 'volleyball') {
            return back()->with('error', 'Selected user is not a volleyball player.');
        }

        if ($user->volleyball_team_id !== $team->id) {
            return back()->with('info', 'Player is not in this team.');
        }

        $user->volleyball_team_id = null;
        $user->save();

        if (Schema::hasColumn('volleyballs','num_of_players')) {
            $team->decrement('num_of_players');
        }

        return back()->with('success', 'Player removed from team.');
    }
}
