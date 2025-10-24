<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BasketballMatch;
use App\Models\Basketball;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Schema;
use App\Notifications\MatchAssigned;

class BasketballMatchController extends Controller
{
    public function index()
    {
        $matches = BasketballMatch::all();
        return view('admin.basketball.matches.index', compact('matches'));
    }

    public function create()
    {
        $referees = User::where('role', 'referee')->orderBy('name')->get();
        $teams = Basketball::orderBy('team_name')->get(['id','team_name']);
        return view('admin.basketball.matches.create', compact('referees','teams'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'team_a' => 'required|string|max:255',
            'team_b' => 'required|string|max:255',
            'match_date' => 'required|date',
            'venue' => 'required|string|max:255',
            'status' => 'nullable|in:Upcoming,Ongoing,Finished',
            'score_team_a' => 'nullable|integer',
            'score_team_b' => 'nullable|integer',
            'winner' => 'nullable|string|max:255',
            'referee_id' => 'nullable|exists:users,id',
        ]);

        $payload = $request->all();
        if (!Schema::hasColumn('basketball_matches', 'referee_id')) {
            unset($payload['referee_id']);
        }

        $match = BasketballMatch::create($payload);

        if (Schema::hasColumn('basketball_matches', 'referee_id') && $match->referee_id) {
            $ref = User::find($match->referee_id);
            if ($ref) {
                Notification::send($ref, new MatchAssigned('basketball', $match->toArray()));
            }
        }
        return redirect()->route('admin.basketball.matches.index')
            ->with('success', 'Basketball match created successfully!');
    }

    public function edit(BasketballMatch $match)
    {
        $referees = User::where('role', 'referee')->orderBy('name')->get();
        $teams = Basketball::orderBy('team_name')->get(['id','team_name']);
        return view('admin.basketball.matches.edit', compact('match','referees','teams'));
    }

    public function update(Request $request, BasketballMatch $match)
    {
        $request->validate([
            'team_a' => 'required|string|max:255',
            'team_b' => 'required|string|max:255',
            'match_date' => 'required|date',
            'venue' => 'required|string|max:255',
            'status' => 'nullable|in:Upcoming,Ongoing,Finished',
            'score_team_a' => 'nullable|integer',
            'score_team_b' => 'nullable|integer',
            'winner' => 'nullable|string|max:255',
            'referee_id' => 'nullable|exists:users,id',
        ]);

        $payload = $request->all();
        if (!Schema::hasColumn('basketball_matches', 'referee_id')) {
            unset($payload['referee_id']);
        }

        $match->update($payload);

        if (Schema::hasColumn('basketball_matches', 'referee_id') && $match->referee_id) {
            $ref = User::find($match->referee_id);
            if ($ref) {
                Notification::send($ref, new MatchAssigned('basketball', $match->toArray()));
            }
        }
        return redirect()->route('admin.basketball.matches.index')
            ->with('success', 'Basketball match updated successfully!');
    }

    public function destroy(BasketballMatch $match)
    {
        $match->delete();
        return redirect()->route('admin.basketball.matches.index')
            ->with('success', 'Match deleted successfully!');
    }

    public function scorer(BasketballMatch $match)
    {
        return view('admin.basketball.matches.scorer', compact('match'));
    }

    public function score(Request $request, BasketballMatch $match)
    {
        $data = $request->validate([
            'team' => 'required|in:a,b',
            'points' => 'required|integer',
        ]);

        $field = $data['team'] === 'a' ? 'score_team_a' : 'score_team_b';
        $new = (int) $match->$field + (int) $data['points'];
        if ($new < 0) {
            $new = 0;
        }
        $match->update([$field => $new]);

        return back()->with('success', 'Score updated');
    }

    public function setStatus(Request $request, BasketballMatch $match)
    {
        $data = $request->validate([
            'status' => 'required|in:Upcoming,Ongoing,Finished',
        ]);
        $match->update(['status' => $data['status']]);
        return back()->with('success', 'Status updated');
    }

    public function showPublic(BasketballMatch $match)
    {
        return view('basketball.matches.show', compact('match'));
    }

    public function listPublic()
    {
        $matches = BasketballMatch::orderByDesc('match_date')->get();
        return view('basketball.matches.index', compact('matches'));
    }
}
