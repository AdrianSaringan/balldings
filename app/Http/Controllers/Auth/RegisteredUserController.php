<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Basketball;
use App\Models\Volleyball;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $basketballCoaches = User::where('role','coach')->where('sport','basketball')->orderBy('name')->get(['id','name']);
        $volleyballCoaches = User::where('role','coach')->where('sport','volleyball')->orderBy('name')->get(['id','name']);
        return view('auth.register', compact('basketballCoaches','volleyballCoaches'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
    'name' => ['required', 'string', 'max:255'],
    'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
    'password' => ['required', 'confirmed', Rules\Password::defaults()],
    'phone' => ['nullable', 'string', 'max:20'],
    'sport' => ['required', 'string'],
    'position' => ['nullable', 'string'],
    'dob' => ['required', 'date', 'before:today'], // 👈 ensures valid date before today
    'height' => ['nullable', 'numeric', 'min:0'],
    'weight' => ['nullable', 'numeric', 'min:0'],
    'experience' => ['nullable', 'integer', 'min:0'],
    'emergency_contact' => ['nullable', 'string', 'max:255'],
    'jersey_number' => ['nullable', 'integer'],
    'role' => ['required', 'in:player,coach,referee'],
    'verification_image' => ['required','image','mimes:jpg,jpeg,png,webp','max:4096'],
]); 

        if ($request->role === 'player') {
            $request->validate([
                'coach_user_id' => ['required','exists:users,id'],
            ]);
        }

        $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'phone' => $request->phone,
        'sport' => $request->sport,
        'position' => $request->position,
        'dob' => $request->dob,
        'height' => $request->height,
        'weight' => $request->weight,
        'experience' => $request->experience,
        'emergency_contact' => $request->emergency_contact,
        'jersey_number' => $request->jersey_number,
        'usertype' => 'user',
        'role' => $request->role,
    ]);

        // Post-create linkage for coach/player to teams
        if ($user->role === 'coach') {
            if ($user->sport === 'basketball') {
                $payload = [
                    'team_name' => $request->input('team_name') ?: ($user->name . " Team"),
                    'coach_name' => $user->name,
                    'number_of_players' => 0,
                ];
                if (Schema::hasColumn('basketballs','coach_user_id')) {
                    $payload['coach_user_id'] = $user->id;
                }
                $team = Basketball::create($payload);
                if (Schema::hasColumn('users','basketball_team_id')) {
                    $user->basketball_team_id = $team->id;
                    $user->save();
                }
            } elseif ($user->sport === 'volleyball') {
                $payload = [
                    'team_name' => $request->input('team_name') ?: ($user->name . " Team"),
                    'coach_name' => $user->name,
                    'num_of_players' => 0,
                ];
                if (Schema::hasColumn('volleyballs','coach_user_id')) {
                    $payload['coach_user_id'] = $user->id;
                }
                $team = Volleyball::create($payload);
                if (Schema::hasColumn('users','volleyball_team_id')) {
                    $user->volleyball_team_id = $team->id;
                    $user->save();
                }
            }
        } elseif ($user->role === 'player') {
            $coachId = $request->input('coach_user_id');
            if ($user->sport === 'basketball') {
                $coach = User::where('id',$coachId)->where('role','coach')->where('sport','basketball')->first();
                if ($coach) {
                    $team = Schema::hasColumn('basketballs','coach_user_id')
                        ? Basketball::where('coach_user_id',$coach->id)->first()
                        : null;
                    if (!$team) {
                        // fallback: attempt to find a team by coach name match
                        $team = Basketball::where('coach_name', $coach->name)->first();
                    }
                    if ($team && Schema::hasColumn('users','basketball_team_id')) {
                        $user->basketball_team_id = $team->id;
                        $user->save();
                        // increment number_of_players if column exists
                        if (Schema::hasColumn('basketballs','number_of_players')) {
                            $team->increment('number_of_players');
                        }
                    }
                }
            } elseif ($user->sport === 'volleyball') {
                $coach = User::where('id',$coachId)->where('role','coach')->where('sport','volleyball')->first();
                if ($coach) {
                    $team = Schema::hasColumn('volleyballs','coach_user_id')
                        ? Volleyball::where('coach_user_id',$coach->id)->first()
                        : null;
                    if (!$team) {
                        $team = Volleyball::where('coach_name', $coach->name)->first();
                    }
                    if ($team && Schema::hasColumn('users','volleyball_team_id')) {
                        $user->volleyball_team_id = $team->id;
                        $user->save();
                        // increment num_of_players if column exists
                        if (Schema::hasColumn('volleyballs','num_of_players')) {
                            $team->increment('num_of_players');
                        }
                    }
                }
            }
        }

        // Store verification image
        if ($request->hasFile('verification_image')) {
            $vpath = $request->file('verification_image')->store('verification', 'public');
            if (Schema::hasColumn('users','verification_image_path')) {
                $user->verification_image_path = $vpath;
                $user->save();
            }
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
