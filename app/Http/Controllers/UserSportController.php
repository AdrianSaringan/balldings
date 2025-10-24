<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Basketball;
use App\Models\Volleyball;
use App\Models\BasketballMatch;
use App\Models\VolleyballMatch;
use App\Models\Bracket;

class UserSportController extends Controller
{
    public function teams(Request $request)
    {
        $sport = $request->user()->sport; // 'basketball' or 'volleyball'
        if ($sport === 'basketball') {
            $teams = Basketball::orderBy('team_name')->paginate(12);
        } elseif ($sport === 'volleyball') {
            $teams = Volleyball::orderBy('team_name')->paginate(12);
        } else {
            $teams = collect();
        }

        return view('user.teams', [
            'sport' => $sport,
            'teams' => $teams,
        ]);
    }

    public function matches(Request $request)
    {
        $sport = $request->user()->sport; // 'basketball' or 'volleyball'
        if ($sport === 'basketball') {
            $matches = BasketballMatch::orderByDesc('match_date')->paginate(12);
        } elseif ($sport === 'volleyball') {
            $matches = VolleyballMatch::orderByDesc('match_date')->paginate(12);
        } else {
            $matches = collect();
        }

        return view('user.matches', [
            'sport' => $sport,
            'matches' => $matches,
        ]);
    }

    public function brackets(Request $request)
    {
        $sport = $request->user()->sport; // 'basketball' or 'volleyball'
        $brackets = collect();
        if (in_array($sport, ['basketball','volleyball'])) {
            $brackets = Bracket::where('sport', $sport)
                ->orderBy('round')
                ->get();
        }

        return view('user.brackets', [
            'sport' => $sport,
            'brackets' => $brackets,
        ]);
    }
}
