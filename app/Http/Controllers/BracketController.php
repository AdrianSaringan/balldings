<?php

namespace App\Http\Controllers;

use App\Models\Bracket;
use App\Models\User;
use App\Models\Basketball;
use App\Models\Volleyball;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class BracketController extends Controller
{
    /**
     * Display a listing of the brackets.
     */
    public function index(Request $request)
    {
        $sportFilter = $request->query('sport'); // null | basketball | volleyball
        if (Schema::hasColumn('brackets', 'bracket_type')) {
            $basketballUpper = (!$sportFilter || $sportFilter === 'basketball')
                ? Bracket::where('sport', 'basketball')->where('bracket_type', 'upper')->get()
                : collect();
            $basketballLower = (!$sportFilter || $sportFilter === 'basketball')
                ? Bracket::where('sport', 'basketball')->where('bracket_type', 'lower')->get()
                : collect();
            $volleyballUpper = (!$sportFilter || $sportFilter === 'volleyball')
                ? Bracket::where('sport', 'volleyball')->where('bracket_type', 'upper')->get()
                : collect();
            $volleyballLower = (!$sportFilter || $sportFilter === 'volleyball')
                ? Bracket::where('sport', 'volleyball')->where('bracket_type', 'lower')->get()
                : collect();
        } else {
            // Fallback before migration: treat all as upper, keep lower empty so view renders
            $basketballUpper = (!$sportFilter || $sportFilter === 'basketball') ? Bracket::where('sport', 'basketball')->get() : collect();
            $basketballLower = collect();
            $volleyballUpper = (!$sportFilter || $sportFilter === 'volleyball') ? Bracket::where('sport', 'volleyball')->get() : collect();
            $volleyballLower = collect();
        }

        return view('admin.brackets.index', compact('basketballUpper', 'basketballLower', 'volleyballUpper', 'volleyballLower', 'sportFilter'));
    }

    /**
     * Show the form for creating a new bracket.
     */
    public function create()
    {
        $basketballTeams = Basketball::all();
        $volleyballTeams = Volleyball::all();

        return view('admin.brackets.create', compact('basketballTeams', 'volleyballTeams'));
    }

    /**
     * Store a newly created bracket in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'sport' => 'required|in:basketball,volleyball',
            'team1_id_basketball' => 'required_if:sport,basketball|nullable|integer|exists:basketballs,id',
            'team2_id_basketball' => 'required_if:sport,basketball|nullable|integer|exists:basketballs,id',
            'team1_id_volleyball' => 'required_if:sport,volleyball|nullable|integer|exists:volleyballs,id',
            'team2_id_volleyball' => 'required_if:sport,volleyball|nullable|integer|exists:volleyballs,id',
            'round' => 'required|integer|min:1',
            'status' => 'nullable|string',
            'winner' => 'nullable|string',
            'tournament_name' => 'nullable|string|max:255',
            'bracket_type' => 'required|in:upper,lower',
        ]);

        $payload = [
            'sport' => $validated['sport'],
            'team1_id' => $validated['sport'] === 'basketball' ? ($validated['team1_id_basketball'] ?? null) : ($validated['team1_id_volleyball'] ?? null),
            'team2_id' => $validated['sport'] === 'basketball' ? ($validated['team2_id_basketball'] ?? null) : ($validated['team2_id_volleyball'] ?? null),
            'round' => $validated['round'],
            'status' => $validated['status'] ?? 'pending',
            'winner' => $validated['winner'] ?? null,
            'tournament_name' => $validated['tournament_name'] ?? 'Untitled Tournament',
            'bracket_type' => $validated['bracket_type'],
        ];

        Bracket::create($payload);

        return redirect()->route('admin.brackets.index')->with('success', 'Bracket created successfully!');
    }

    /**
     * Show the form for editing the specified bracket.
     */
    public function edit(Bracket $bracket)
    {
        $basketballTeams = Basketball::all();
        $volleyballTeams = Volleyball::all();

        return view('admin.brackets.edit', compact('bracket', 'basketballTeams', 'volleyballTeams'));
    }

    /**
     * Update the specified bracket in storage.
     */
    public function update(Request $request, Bracket $bracket)
    {
        $validated = $request->validate([
            'sport' => 'required|in:basketball,volleyball',
            'team1_id' => 'nullable|integer',
            'team2_id' => 'nullable|integer',
            'team1_id_basketball' => 'required_if:sport,basketball|nullable|integer|exists:basketballs,id',
            'team2_id_basketball' => 'required_if:sport,basketball|nullable|integer|exists:basketballs,id',
            'team1_id_volleyball' => 'required_if:sport,volleyball|nullable|integer|exists:volleyballs,id',
            'team2_id_volleyball' => 'required_if:sport,volleyball|nullable|integer|exists:volleyballs,id',
            'round' => 'required|integer|min:1',
            'status' => 'nullable|string',
            'winner' => 'nullable|string',
            'tournament_name' => 'nullable|string|max:255',
            'bracket_type' => 'required|in:upper,lower',
        ]);

        $payload = [
            'sport' => $validated['sport'],
            'team1_id' => $validated['team1_id']
                ?? ($validated['sport'] === 'basketball' ? ($validated['team1_id_basketball'] ?? null) : ($validated['team1_id_volleyball'] ?? null)),
            'team2_id' => $validated['team2_id']
                ?? ($validated['sport'] === 'basketball' ? ($validated['team2_id_basketball'] ?? null) : ($validated['team2_id_volleyball'] ?? null)),
            'round' => $validated['round'],
            'status' => $validated['status'] ?? $bracket->status,
            'winner' => $validated['winner'] ?? $bracket->winner,
            'tournament_name' => $validated['tournament_name'] ?? $bracket->tournament_name,
            'bracket_type' => $validated['bracket_type'],
        ];

        $bracket->update($payload);

        return redirect()->route('admin.brackets.index')->with('success', 'Bracket updated successfully!');
    }

    /**
     * Remove the specified bracket from storage.
     */
    public function destroy(Bracket $bracket)
    {
        $bracket->delete();

        return redirect()->route('admin.brackets.index')->with('success', 'Bracket deleted successfully!');
    }
}
