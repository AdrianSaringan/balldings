@extends('layouts.app')

@section('content')
@php($header = 'Welcome, '.auth()->user()->name)

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @php(
                $u = auth()->user()
            )
            @php(
                $unreadItems = \Illuminate\Support\Facades\Schema::hasTable('notifications') ? $u->unreadNotifications()->limit(3)->get() : collect()
            )
            @php(
                $unreadCount = \Illuminate\Support\Facades\Schema::hasTable('notifications') ? $u->unreadNotifications()->count() : 0
            )
            @php(
                $tournaments = \App\Models\Tournament::query()
                    ->when($u->sport, fn($q, $s) => $q->where('sport', $s))
                    ->where('status', 'upcoming')
                    ->orderBy('start_date')
                    ->limit(3)
                    ->get()
            )
            @php($sport = $u->sport)
            @php(
                $teamsCount = match($sport) {
                    'basketball' => \App\Models\Basketball::count(),
                    'volleyball' => \App\Models\Volleyball::count(),
                    default => 0,
                }
            )
            @php(
                $matchesCount = match($sport) {
                    'basketball' => \App\Models\BasketballMatch::count(),
                    'volleyball' => \App\Models\VolleyballMatch::count(),
                    default => 0,
                }
            )
            @php(
                $bracketsCount = $sport ? \App\Models\Bracket::where('sport',$sport)->count() : 0
            )

            <!-- Sport-aware quick stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-white border rounded-lg p-4">
                    <div class="text-xs text-gray-500">Your Sport</div>
                    <div class="text-2xl font-semibold text-gray-800">{{ ucfirst($sport ?? 'Not set') }}</div>
                </div>
                <div class="bg-white border rounded-lg p-4">
                    <div class="text-xs text-gray-500">Teams</div>
                    <div class="text-2xl font-semibold text-gray-800">{{ $teamsCount }}</div>
                </div>
                <div class="bg-white border rounded-lg p-4">
                    <div class="text-xs text-gray-500">Matches</div>
                    <div class="text-2xl font-semibold text-gray-800">{{ $matchesCount }}</div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-semibold text-gray-800">Notifications</h3>
                            <a href="{{ route('notifications.index') }}" class="text-sm text-green-700 hover:underline">View all @if($unreadCount) ({{ $unreadCount }}) @endif</a>
                        </div>
                        <div class="mt-4 space-y-3">
                            @forelse($unreadItems as $n)
                                <div class="border rounded-lg p-3 bg-green-50 border-green-200 text-sm text-gray-800">
                                    <div class="font-medium">{{ data_get($n->data, 'title', 'Notification') }}</div>
                                    <div class="text-gray-700">{{ data_get($n->data, 'message', json_encode($n->data)) }}</div>
                                    <div class="text-xs text-gray-500 mt-1">{{ $n->created_at->diffForHumans() }}</div>
                                </div>
                            @empty
                                <div class="border rounded-lg p-4 bg-gray-50 border-gray-200 text-sm text-gray-600">No unread notifications.</div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-800">Quick Actions</h3>
                        @php($role = $u->role)
                        <div class="mt-4 grid grid-cols-1 gap-2 text-sm">
                            <a href="{{ route('profile.edit') }}" class="px-3 py-2 rounded-md bg-green-600 text-white text-center">Update Profile</a>
                            <a href="{{ route('notifications.index') }}" class="px-3 py-2 rounded-md bg-gray-800 text-white text-center">Notifications</a>
                            @if($sport)
                                <a href="{{ route('user.teams') }}" class="px-3 py-2 rounded-md bg-blue-600 text-white text-center">View Teams</a>
                                <a href="{{ route('user.matches') }}" class="px-3 py-2 rounded-md bg-indigo-600 text-white text-center">View Matches</a>
                                <a href="{{ route('user.brackets') }}" class="px-3 py-2 rounded-md bg-purple-600 text-white text-center">View Brackets</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-800">Upcoming Tournaments</h3>
                        <div class="text-sm text-gray-500">{{ ucfirst($u->sport ?? 'All') }}</div>
                    </div>
                    <div class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-4">
                        @forelse($tournaments as $t)
                            <div class="border rounded-lg p-4">
                                <div class="font-semibold text-gray-900">{{ $t->name }}</div>
                                <div class="text-sm text-gray-600">{{ ucfirst($t->sport) }}</div>
                                <div class="text-sm text-gray-600">{{ $t->venue ?: 'TBA' }}</div>
                                <div class="text-xs text-gray-500 mt-1">{{ $t->start_date ? \Carbon\Carbon::parse($t->start_date)->toFormattedDateString() : 'Start TBA' }}</div>
                                <div class="text-xs text-gray-500">Status: {{ ucfirst($t->status ?? 'upcoming') }}</div>
                            </div>
                        @empty
                            <div class="text-sm text-gray-600">No upcoming tournaments.</div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Recent Matches for user's sport -->
            @if($sport)
                @php(
                    $recentMatches = $sport === 'basketball'
                        ? \App\Models\BasketballMatch::orderByDesc('match_date')->limit(5)->get()
                        : \App\Models\VolleyballMatch::orderByDesc('match_date')->limit(5)->get()
                )
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-semibold text-gray-800">Recent Matches</h3>
                            <a href="{{ route('user.matches') }}" class="text-sm text-green-700 hover:underline">View Matches</a>
                        </div>
                        <div class="mt-4 space-y-2 text-sm">
                            @forelse($recentMatches as $m)
                                <div class="flex items-center justify-between border rounded-lg p-3">
                                    <div>
                                        <div class="font-medium text-gray-900">{{ $m->team_a }} vs {{ $m->team_b }}</div>
                                        <div class="text-xs text-gray-500">{{ $m->venue ?: 'TBA' }} • {{ $m->match_date }}</div>
                                    </div>
                                    @if(isset($m->score_team_a) || isset($m->score_team_b))
                                        <div class="text-gray-900 font-semibold">{{ $m->score_team_a ?? '-' }} - {{ $m->score_team_b ?? '-' }}</div>
                                    @endif
                                </div>
                            @empty
                                <div class="text-sm text-gray-600">No recent matches.</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
