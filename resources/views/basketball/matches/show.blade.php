@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-6 flex items-center justify-between">
        <h2 class="text-2xl font-semibold">Basketball Match</h2>
        <a href="{{ url('/') }}" class="text-sm text-indigo-600 hover:underline">Home</a>
    </div>

    <div class="bg-white rounded-xl shadow p-6 space-y-6">
        <div class="text-center">
            <div class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($match->match_date)->format('M d, Y h:ia') }} • {{ $match->venue }}</div>
            <div class="mt-2 text-xl font-semibold">{{ $match->team_a }} vs {{ $match->team_b }}</div>
        </div>

        <div class="grid grid-cols-2 gap-6 items-center">
            <div class="text-center">
                <div class="text-gray-500 text-sm mb-1">{{ $match->team_a }}</div>
                <div class="text-5xl font-bold">{{ $match->score_team_a }}</div>
            </div>
            <div class="text-center">
                <div class="text-gray-500 text-sm mb-1">{{ $match->team_b }}</div>
                <div class="text-5xl font-bold">{{ $match->score_team_b }}</div>
            </div>
        </div>

        <div class="text-center">
            <span class="px-3 py-1 text-xs rounded-full {{ $match->status === 'Ongoing' ? 'bg-green-100 text-green-700' : ($match->status === 'Finished' ? 'bg-gray-200 text-gray-700' : 'bg-yellow-100 text-yellow-700') }}">{{ $match->status }}</span>
        </div>
    </div>
</div>
@endsection
