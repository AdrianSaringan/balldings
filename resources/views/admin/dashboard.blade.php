@extends('layouts.app')

@section('content')
@php($header = 'Admin Dashboard')

@php(
    $totalUsers = \App\Models\User::count()
)
@php(
    $players = \App\Models\User::where('role','player')->count()
)
@php(
    $coaches = \App\Models\User::where('role','coach')->count()
)
@php(
    $referees = \App\Models\User::where('role','referee')->count()
)
@php(
    $upcomingTourneys = \App\Models\Tournament::where('status','upcoming')->count()
)
@php(
    $ongoingTourneys = \App\Models\Tournament::where('status','ongoing')->count()
)
@php(
    $recentUsers = \App\Models\User::orderByDesc('created_at')->limit(5)->get()
)
@php(
    $nextTourneys = \App\Models\Tournament::orderBy('start_date')->limit(5)->get()
)

<div class="space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-gray-100 rounded-xl p-4 border border-gray-500">
            <div class="text-sm text-gray-500">Total Users</div>
            <div class="text-2xl font-semibold">{{ $totalUsers }}</div>
        </div>
        <div class="bg-yellow-100 rounded-xl p-4 border border-yellow-400">
        <div class="text-sm text-gray-500">Players</div>
            <div class="text-2xl font-semibold">{{ $players }}</div>
        </div>
        <div class="bg-green-100 rounded-xl p-4 border border-green-400">
            <div class="text-sm text-gray-500">Coaches</div>
            <div class="text-2xl font-semibold">{{ $coaches }}</div>
        </div>
        <div class="bg-purple-100 rounded-xl p-4 border border-purple-400">
            <div class="text-sm text-gray-500">Referees</div>
            <div class="text-2xl font-semibold">{{ $referees }}</div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 bg-white rounded-lg shadow">
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-800">Upcoming Tournaments</h3>
                    <div class="text-sm text-gray-500">Upcoming: {{ $upcomingTourneys }} | Ongoing: {{ $ongoingTourneys }}</div>
                </div>
                <div class="mt-4 divide-y">
                    @forelse($nextTourneys as $t)
                        <div class="py-3 flex items-center justify-between">
                            <div>
                                <div class="font-medium text-gray-900">{{ $t->name }}</div>
                                <div class="text-sm text-gray-600">{{ ucfirst($t->sport) }} • {{ $t->venue ?: 'TBA' }}</div>
                            </div>
                            <div class="text-xs text-gray-500">{{ $t->start_date ? \Carbon\Carbon::parse($t->start_date)->toFormattedDateString() : 'Start TBA' }}</div>
                        </div>
                    @empty
                        <div class="py-6 text-sm text-gray-600">No tournaments yet.</div>
                    @endforelse
                </div>
                <div class="mt-4">
                    <a href="{{ route('admin.tournaments.index') }}" class="text-sm text-green-700 hover:underline">Manage Tournaments</a>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-800">Quick Links</h3>
                <div class="mt-4 grid grid-cols-1 gap-2 text-sm">
                    <a class="px-3 py-2 bg-gray-800 text-white rounded text-center" href="{{ route('admin.users.index') }}">User Management</a>
                    <a class="px-3 py-2 bg-green-600 text-white rounded text-center" href="{{ route('admin.tournaments.index') }}">Tournaments</a>
                    <a class="px-3 py-2 bg-indigo-600 text-white rounded text-center" href="{{ route('admin.brackets.index') }}">Brackets</a>
                    <a class="px-3 py-2 bg-blue-600 text-white rounded text-center" href="{{ route('admin.basketball.teams.index') }}">Basketball Teams</a>
                    <a class="px-3 py-2 bg-purple-600 text-white rounded text-center" href="{{ route('admin.volleyball.teams.index') }}">Volleyball Teams</a>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow">
        <div class="p-6">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-800">Recent Users</h3>
                <a href="{{ route('admin.users.index') }}" class="text-sm text-green-700 hover:underline">View all</a>
            </div>
            <div class="mt-4 divide-y">
                @forelse($recentUsers as $ru)
                    <div class="py-3 flex items-center justify-between">
                        <div>
                            <div class="font-medium text-gray-900">{{ $ru->name }}</div>
                            <div class="text-sm text-gray-600">{{ $ru->email }} • {{ ucfirst($ru->role ?? 'user') }}</div>
                        </div>
                        <div class="text-xs text-gray-500">Joined {{ $ru->created_at->diffForHumans() }}</div>
                    </div>
                @empty
                    <div class="py-6 text-sm text-gray-600">No users found.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>

@endsection
