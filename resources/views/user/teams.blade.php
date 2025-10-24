@extends('layouts.app')

@section('content')
@php($header = 'Teams - '.ucfirst($sport ?? 'N/A'))
<div class="max-w-7xl mx-auto">
    @if(!$sport)
        <div class="bg-yellow-50 border border-yellow-200 text-yellow-800 p-4 rounded">Please set your sport in your profile to view teams.</div>
    @elseif($teams instanceof \Illuminate\Pagination\LengthAwarePaginator && $teams->count() === 0)
        <div class="bg-white p-6 rounded shadow">No teams found for {{ ucfirst($sport) }}.</div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($teams as $team)
                <div class="bg-white rounded-lg shadow p-4">
                    <div class="text-lg font-semibold text-gray-800">{{ $team->team_name }}</div>
                    @if(isset($team->coach_name))
                        <div class="text-sm text-gray-600">Coach: {{ $team->coach_name }}</div>
                    @endif
                    @if(isset($team->number_of_players))
                        <div class="text-xs text-gray-500 mt-1">Players: {{ $team->number_of_players }}</div>
                    @endif
                </div>
            @endforeach
        </div>
        @if($teams instanceof \Illuminate\Pagination\LengthAwarePaginator)
            <div class="mt-6">{{ $teams->links() }}</div>
        @endif
    @endif
</div>
@endsection
