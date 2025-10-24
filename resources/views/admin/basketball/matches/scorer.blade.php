@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6 flex items-center justify-between">
        <h2 class="text-2xl font-semibold">Basketball Scorer</h2>
        <a href="{{ route('admin.basketball.matches.index') }}" class="text-sm text-indigo-600 hover:underline">Back to Matches</a>
    </div>

    <div class="bg-white rounded-xl shadow p-6 space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <div class="text-sm text-gray-500">Match</div>
                <div class="text-lg font-semibold">{{ $match->team_a }} vs {{ $match->team_b }}</div>
                <div class="text-xs text-gray-500 mt-1">Venue: {{ $match->venue }} • {{ \Carbon\Carbon::parse($match->match_date)->format('M d, Y h:ia') }}</div>
            </div>
            <span class="px-3 py-1 text-xs rounded-full {{ $match->status === 'Ongoing' ? 'bg-green-100 text-green-700' : ($match->status === 'Finished' ? 'bg-gray-200 text-gray-700' : 'bg-yellow-100 text-yellow-700') }}">{{ $match->status }}</span>
        </div>

        @if(session('success'))
            <div class="p-3 rounded-md bg-green-50 text-green-700 text-sm">{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="p-3 rounded-md bg-red-50 text-red-700 text-sm">{{ $errors->first() }}</div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-center">
            <div class="text-center">
                <div class="text-sm text-gray-500 mb-1">{{ $match->team_a }}</div>
                <div class="text-5xl font-bold">{{ $match->score_team_a }}</div>
                <div class="mt-4 flex justify-center gap-2">
                    <form method="POST" action="{{ route('admin.basketball.matches.score', $match) }}">@csrf
                        <input type="hidden" name="team" value="a">
                        <input type="hidden" name="points" value="1">
                        <button class="px-3 py-2 bg-gray-100 hover:bg-gray-200 rounded">+1</button>
                    </form>
                    <form method="POST" action="{{ route('admin.basketball.matches.score', $match) }}">@csrf
                        <input type="hidden" name="team" value="a">
                        <input type="hidden" name="points" value="2">
                        <button class="px-3 py-2 bg-gray-100 hover:bg-gray-200 rounded">+2</button>
                    </form>
                    <form method="POST" action="{{ route('admin.basketball.matches.score', $match) }}">@csrf
                        <input type="hidden" name="team" value="a">
                        <input type="hidden" name="points" value="3">
                        <button class="px-3 py-2 bg-gray-100 hover:bg-gray-200 rounded">+3</button>
                    </form>
                    <form method="POST" action="{{ route('admin.basketball.matches.score', $match) }}">@csrf
                        <input type="hidden" name="team" value="a">
                        <input type="hidden" name="points" value="-1">
                        <button class="px-3 py-2 bg-gray-100 hover:bg-gray-200 rounded">-1</button>
                    </form>
                </div>
            </div>

            <div class="text-center">
                <div class="text-xs text-gray-500 mb-1">Status</div>
                <form method="POST" action="{{ route('admin.basketball.matches.setStatus', $match) }}" class="inline-flex items-center gap-2">@csrf
                    <select name="status" class="border rounded px-2 py-1">
                        <option value="Upcoming" {{ $match->status==='Upcoming'?'selected':'' }}>Upcoming</option>
                        <option value="Ongoing" {{ $match->status==='Ongoing'?'selected':'' }}>Ongoing</option>
                        <option value="Finished" {{ $match->status==='Finished'?'selected':'' }}>Finished</option>
                    </select>
                    <button class="px-3 py-1.5 bg-indigo-600 text-white rounded hover:bg-indigo-700">Update</button>
                </form>
            </div>

            <div class="text-center">
                <div class="text-sm text-gray-500 mb-1">{{ $match->team_b }}</div>
                <div class="text-5xl font-bold">{{ $match->score_team_b }}</div>
                <div class="mt-4 flex justify-center gap-2">
                    <form method="POST" action="{{ route('admin.basketball.matches.score', $match) }}">@csrf
                        <input type="hidden" name="team" value="b">
                        <input type="hidden" name="points" value="1">
                        <button class="px-3 py-2 bg-gray-100 hover:bg-gray-200 rounded">+1</button>
                    </form>
                    <form method="POST" action="{{ route('admin.basketball.matches.score', $match) }}">@csrf
                        <input type="hidden" name="team" value="b">
                        <input type="hidden" name="points" value="2">
                        <button class="px-3 py-2 bg-gray-100 hover:bg-gray-200 rounded">+2</button>
                    </form>
                    <form method="POST" action="{{ route('admin.basketball.matches.score', $match) }}">@csrf
                        <input type="hidden" name="team" value="b">
                        <input type="hidden" name="points" value="3">
                        <button class="px-3 py-2 bg-gray-100 hover:bg-gray-200 rounded">+3</button>
                    </form>
                    <form method="POST" action="{{ route('admin.basketball.matches.score', $match) }}">@csrf
                        <input type="hidden" name="team" value="b">
                        <input type="hidden" name="points" value="-1">
                        <button class="px-3 py-2 bg-gray-100 hover:bg-gray-200 rounded">-1</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
