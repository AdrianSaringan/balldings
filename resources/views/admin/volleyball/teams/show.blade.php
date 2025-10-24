@extends('layouts.app')

@section('title', $team->team_name . ' Players')

@section('content')
<div class="py-8 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="mb-6 flex items-center justify-between">
            <h1 class="text-2xl font-bold text-gray-800">Volleyball Team: {{ $team->team_name }}</h1>
            <a href="{{ route('admin.volleyball.teams.index') }}" class="px-4 py-2 bg-gray-700 text-white rounded-md text-sm hover:bg-gray-800">← Back to Teams</a>
        </div>

        <div class="bg-white shadow-xl rounded-2xl p-6">
            <div class="mb-4">
                <div class="text-sm text-gray-600"><strong>Coach:</strong> {{ $team->coach_name }}</div>
                <div class="text-sm text-gray-600"><strong>Registered Players:</strong> {{ $players->count() }}</div>
            </div>

            @if(session('success'))
                <div class="mb-4 bg-green-100 text-green-800 px-4 py-2 rounded">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="mb-4 bg-red-100 text-red-800 px-4 py-2 rounded">{{ session('error') }}</div>
            @endif
            @if(session('info'))
                <div class="mb-4 bg-blue-100 text-blue-800 px-4 py-2 rounded">{{ session('info') }}</div>
            @endif

            <div class="mb-6">
                <form action="{{ route('admin.volleyball.teams.players.add', $team->id) }}" method="POST" class="flex items-end gap-3">
                    @csrf
                    <div class="flex-1">
                        <label class="block text-sm font-medium text-gray-700">Add Player</label>
                        <select name="user_id" class="mt-1 w-full border-gray-300 rounded-md">
                            @forelse($availablePlayers as $ap)
                                <option value="{{ $ap->id }}">{{ $ap->name }} ({{ $ap->email }})</option>
                            @empty
                                <option value="">No available players</option>
                            @endforelse
                        </select>
                    </div>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md text-sm hover:bg-indigo-700">Add</button>
                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-sm text-left">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3 uppercase font-semibold text-gray-500">#</th>
                            <th class="px-6 py-3 uppercase font-semibold text-gray-500">Player</th>
                            <th class="px-6 py-3 uppercase font-semibold text-gray-500">Contact</th>
                            <th class="px-6 py-3 uppercase font-semibold text-gray-500">Position</th>
                            <th class="px-6 py-3 uppercase font-semibold text-gray-500">Jersey</th>
                            <th class="px-6 py-3 uppercase font-semibold text-gray-500">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse($players as $p)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-3">{{ $loop->iteration }}</td>
                                <td class="px-6 py-3 flex items-center gap-3">
                                    @php($pp = $p->profile_photo_path ? asset('storage/'.$p->profile_photo_path) : asset('images/default-avatar.png'))
                                    <img src="{{ $pp }}" class="w-8 h-8 rounded-full object-cover border" alt="avatar">
                                    <div>
                                        <div class="font-medium text-gray-900">{{ $p->name }}</div>
                                        <div class="text-xs text-gray-500">Joined {{ $p->created_at?->diffForHumans() }}</div>
                                    </div>
                                </td>
                                <td class="px-6 py-3">
                                    <div>{{ $p->email }}</div>
                                    <div class="text-xs text-gray-500">{{ $p->phone ?? '—' }}</div>
                                </td>
                                <td class="px-6 py-3">{{ $p->position ?? '—' }}</td>
                                <td class="px-6 py-3">{{ $p->jersey_number ?? '—' }}</td>
                                <td class="px-6 py-3">
                                    <form action="{{ route('admin.volleyball.teams.players.remove', [$team->id, $p->id]) }}" method="POST" onsubmit="return confirm('Remove this player from the team?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1 bg-red-600 text-white rounded text-xs hover:bg-red-700">Remove</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-6 text-center text-gray-500">No players registered in this team.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
