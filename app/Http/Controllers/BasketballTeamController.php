<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Basketball;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use App\Notifications\TeamChanged;

class BasketballTeamController extends Controller
{
    /**
     * 📋 Display all basketball teams.
     */
    public function index()
    {
        // Kunin lahat ng basketball teams
        $basketballs = Basketball::all();

        // I-display sa view na admin/basketball/teams/index.blade.php
        return view('admin.basketball.teams.index', compact('basketballs'));
    }

    /**
     * 👀 Show a specific basketball team with its players.
     */
    public function show($id)
    {
        $team = Basketball::findOrFail($id);
        $players = User::where('role','player')
            ->where('sport','basketball')
            ->where('basketball_team_id', $team->id)
            ->orderBy('name')
            ->get();

        $availablePlayers = collect();
        if (\Illuminate\Support\Facades\Schema::hasColumn('users','basketball_team_id')) {
            $availablePlayers = User::where('role','player')
                ->where('sport','basketball')
                ->whereNull('basketball_team_id')
                ->orderBy('name')
                ->get(['id','name','email']);
        }

        return view('admin.basketball.teams.show', compact('team','players','availablePlayers'));
    }

    /**
     * ➕ Show create form.
     */
    public function create()
    {
        return view('admin.basketball.teams.create');
    }

    /**
     * 💾 Store new basketball team.
     */
    public function store(Request $request)
    {
        $request->validate([
            'team_name' => 'required|string|max:255',
            'coach_name' => 'required|string|max:255',
            'number_of_players' => 'required|integer|min:1',
        ]);

        // Gumamit ng mass assignment
        $team = Basketball::create([
            'team_name' => $request->team_name,
            'coach_name' => $request->coach_name,
            'number_of_players' => $request->number_of_players,
        ]);

        // Notify basketball users
        $recipients = User::where('usertype','!=','admin')->where('sport','basketball')->get();
        if ($recipients->isNotEmpty()) {
            Notification::send($recipients, new TeamChanged('basketball', 'created', $team->toArray()));
        }

        return redirect()->route('admin.basketball.teams.index')
            ->with('success', 'Basketball team added successfully!');
    }

    /**
     * ✏️ Edit an existing basketball team.
     */
    public function edit($id)
    {
        $team = Basketball::findOrFail($id);
        return view('admin.basketball.teams.edit', compact('team'));
    }

    /**
     * 🔄 Update an existing basketball team.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'team_name' => 'required|string|max:255',
            'coach_name' => 'required|string|max:255',
            'number_of_players' => 'required|integer|min:1',
        ]);

        $team = Basketball::findOrFail($id);
        $team->update([
            'team_name' => $request->team_name,
            'coach_name' => $request->coach_name,
            'number_of_players' => $request->number_of_players,
        ]);

        // Notify basketball users
        $recipients = User::where('usertype','!=','admin')->where('sport','basketball')->get();
        if ($recipients->isNotEmpty()) {
            Notification::send($recipients, new TeamChanged('basketball', 'updated', $team->toArray()));
        }

        return redirect()->route('admin.basketball.teams.index')
            ->with('success', 'Basketball team updated successfully!');
    }

    /**
     * ❌ Delete a basketball team.
     */
    public function destroy($id)
    {
        $team = Basketball::findOrFail($id);
        $payload = $team->toArray();
        $team->delete();

        // Notify basketball users
        $recipients = User::where('usertype','!=','admin')->where('sport','basketball')->get();
        if ($recipients->isNotEmpty()) {
            Notification::send($recipients, new TeamChanged('basketball', 'deleted', $payload));
        }

        return redirect()->route('admin.basketball.teams.index')
            ->with('success', 'Basketball team deleted successfully!');
    }

    /**
     * ➕ Add a player to the basketball team roster.
     */
    public function addPlayer(Request $request, Basketball $team)
    {
        $request->validate([
            'user_id' => ['required','exists:users,id'],
        ]);

        $user = User::findOrFail($request->input('user_id'));

        if ($user->role !== 'player' || $user->sport !== 'basketball') {
            return back()->with('error', 'Selected user is not a basketball player.');
        }

        $previousTeamId = $user->basketball_team_id;
        if ($previousTeamId === $team->id) {
            return back()->with('info', 'Player is already in this team.');
        }

        // If previously in another team, decrement that team's count
        if ($previousTeamId) {
            $oldTeam = Basketball::find($previousTeamId);
            if ($oldTeam && \Illuminate\Support\Facades\Schema::hasColumn('basketballs','number_of_players')) {
                $oldTeam->decrement('number_of_players');
            }
        }

        // Assign to this team
        $user->basketball_team_id = $team->id;
        $user->save();

        if (\Illuminate\Support\Facades\Schema::hasColumn('basketballs','number_of_players')) {
            $team->increment('number_of_players');
        }

        return back()->with('success', 'Player added to team.');
    }

    /**
     * ➖ Remove a player from the basketball team roster.
     */
    public function removePlayer(Basketball $team, User $user)
    {
        if ($user->role !== 'player' || $user->sport !== 'basketball') {
            return back()->with('error', 'Selected user is not a basketball player.');
        }

        if ($user->basketball_team_id !== $team->id) {
            return back()->with('info', 'Player is not in this team.');
        }

        $user->basketball_team_id = null;
        $user->save();

        if (\Illuminate\Support\Facades\Schema::hasColumn('basketballs','number_of_players')) {
            $team->decrement('number_of_players');
        }

        return back()->with('success', 'Player removed from team.');
    }
}
