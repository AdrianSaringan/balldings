<?php

namespace App\Http\Controllers;

use App\Models\Tournament;
use App\Models\User;
use App\Notifications\TournamentCreated;
use Illuminate\Support\Facades\Notification;
use Illuminate\Http\Request;

class TournamentController extends Controller
{
    // 🏁 Show all tournaments
    public function index()
    {
        $tournaments = Tournament::all();
        return view('admin.tournaments.index', compact('tournaments'));
    }

    // ➕ Show create form
    public function create()
    {
        return view('admin.tournaments.create');
    }

    // 💾 Store new tournament
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'sport' => 'required|in:basketball,volleyball',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'venue' => 'nullable|string|max:255',
            'status' => 'nullable|in:upcoming,ongoing,completed',
        ]);

        $tournament = Tournament::create($request->all());

        // Notify all non-admin users about the newly created tournament
        $recipients = User::where('usertype', '!=', 'admin')->get();
        if ($recipients->isNotEmpty()) {
            Notification::send($recipients, new TournamentCreated($tournament));
        }

        return redirect()->route('admin.tournaments.index')->with('success', 'Tournament created successfully!');

    }

    // ✏️ Edit form
    public function edit(Tournament $tournament)
    {
        return view('admin.tournaments.edit', compact('tournament'));
    }

    // 🔄 Update tournament
    public function update(Request $request, Tournament $tournament)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'sport' => 'required|in:basketball,volleyball',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'venue' => 'nullable|string|max:255',
            'status' => 'nullable|in:upcoming,ongoing,completed',
        ]);

        $tournament->update($request->all());

        return redirect()->route('admin.tournaments.index')->with('success', 'Tournament updated successfully!');
    }

    // ❌ Delete tournament
    public function destroy(Tournament $tournament)
    {
        $tournament->delete();
        return redirect()->route('admin.tournaments.index')->with('success', 'Tournament deleted successfully!');
    }
}
