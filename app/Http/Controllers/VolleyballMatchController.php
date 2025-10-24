<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VolleyballMatch;
use App\Models\Volleyball;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use App\Notifications\MatchAssigned;

class VolleyballMatchController extends Controller
{
    public function index()
    {
        $matches = VolleyballMatch::all();
        return view('admin.volleyball.matches.index', compact('matches'));
    }

    public function create()
    {
        $referees = User::where('role', 'referee')->orderBy('name')->get();
        $teams = Volleyball::orderBy('team_name')->get(['id','team_name']);
        return view('admin.volleyball.matches.create', compact('referees','teams'));
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
            'set_scores' => 'nullable',
        ]);

        $payload = $request->all();
        if (isset($payload['set_scores']) && is_string($payload['set_scores'])) {
            $decoded = json_decode($payload['set_scores'], true);
            if ($decoded !== null) {
                $payload['set_scores'] = $decoded;
            }
        }

        $match = VolleyballMatch::create($payload);

        if ($match->referee_id) {
            $ref = User::find($match->referee_id);
            if ($ref) {
                Notification::send($ref, new MatchAssigned('volleyball', $match->toArray()));
            }
        }
        return redirect()->route('admin.volleyball.matches.index')
            ->with('success', 'Volleyball match created successfully!');
    }

    public function edit(VolleyballMatch $match)
    {
        $referees = User::where('role', 'referee')->orderBy('name')->get();
        $teams = Volleyball::orderBy('team_name')->get(['id','team_name']);
        return view('admin.volleyball.matches.edit', compact('match','referees','teams'));
    }

    public function update(Request $request, VolleyballMatch $match)
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
            'set_scores' => 'nullable',
        ]);

        $payload = $request->all();
        if (isset($payload['set_scores']) && is_string($payload['set_scores'])) {
            $decoded = json_decode($payload['set_scores'], true);
            if ($decoded !== null) {
                $payload['set_scores'] = $decoded;
            }
        }

        $match->update($payload);

        if ($match->referee_id) {
            $ref = User::find($match->referee_id);
            if ($ref) {
                Notification::send($ref, new MatchAssigned('volleyball', $match->toArray()));
            }
        }
        return redirect()->route('admin.volleyball.matches.index')
            ->with('success', 'Volleyball match updated successfully!');
    }

    public function destroy(VolleyballMatch $match)
    {
        $match->delete();
        return redirect()->route('admin.volleyball.matches.index')
            ->with('success', 'Match deleted successfully!');
    }

    public function scorer(VolleyballMatch $match)
    {
        return view('admin.volleyball.matches.scorer', compact('match'));
    }

    public function score(Request $request, VolleyballMatch $match)
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

    public function setStatus(Request $request, VolleyballMatch $match)
    {
        $data = $request->validate([
            'status' => 'required|in:Upcoming,Ongoing,Finished',
        ]);
        $match->update(['status' => $data['status']]);
        return back()->with('success', 'Status updated');
    }

    public function showPublic(VolleyballMatch $match)
    {
        return view('volleyball.matches.show', compact('match'));
    }

    public function listPublic()
    {
        $matches = VolleyballMatch::orderByDesc('match_date')->get();
        return view('volleyball.matches.index', compact('matches'));
    }
}
