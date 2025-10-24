@extends('layouts.app')

@section('content')
@php($header = 'Brackets - '.ucfirst($sport ?? 'N/A'))
<div class="max-w-7xl mx-auto">
    @if(!$sport)
        <div class="bg-yellow-50 border border-yellow-200 text-yellow-800 p-4 rounded">Please set your sport in your profile to view brackets.</div>
    @elseif($brackets->count() === 0)
        <div class="bg-white p-6 rounded shadow">No brackets found for {{ ucfirst($sport) }}.</div>
    @else
        @php($rounds = $brackets->groupBy('round'))
        <div class="overflow-x-auto">
            <div class="flex space-x-12 min-w-[800px]">
                @foreach($rounds as $round => $matches)
                    <div class="flex flex-col space-y-6">
                        <div class="text-center text-sm font-semibold text-gray-700">Round {{ $round }}</div>
                        @foreach($matches as $match)
                            <div class="bg-white border rounded-lg shadow p-4 w-56">
                                <div class="text-sm font-medium text-gray-900">{{ $match->team1_name ?? 'TBD' }}</div>
                                <div class="text-sm font-medium text-gray-900">{{ $match->team2_name ?? 'TBD' }}</div>
                                <div class="text-xs text-gray-500 mt-1 capitalize">{{ $match->status }}</div>
                                @if($match->winner)
                                    <div class="text-xs text-green-700 font-semibold mt-1">Winner: {{ $match->winner }}</div>
                                @endif
                                @if($match->tournament_name)
                                    <div class="mt-2 inline-block text-[10px] px-2 py-0.5 rounded-full bg-gray-100 text-gray-700 border">{{ $match->tournament_name }}</div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection
