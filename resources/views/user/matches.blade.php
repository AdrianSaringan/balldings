@extends('layouts.app')

@section('content')
@php($header = 'Matches - '.ucfirst($sport ?? 'N/A'))
<div class="max-w-7xl mx-auto">
    @if(!$sport)
        <div class="bg-yellow-50 border border-yellow-200 text-yellow-800 p-4 rounded">Please set your sport in your profile to view matches.</div>
    @elseif($matches instanceof \Illuminate\Pagination\LengthAwarePaginator && $matches->count() === 0)
        <div class="bg-white p-6 rounded shadow">No matches found for {{ ucfirst($sport) }}.</div>
    @else
        <div class="space-y-3">
            @foreach($matches as $m)
                <div class="bg-white rounded-lg shadow p-4 flex items-center justify-between">
                    <div>
                        <div class="font-semibold text-gray-800">{{ $m->team_a }} vs {{ $m->team_b }}</div>
                        <div class="text-sm text-gray-600">{{ $m->venue }} • {{ $m->match_date }}</div>
                        <div class="text-xs text-gray-500">Status: {{ $m->status }}</div>
                    </div>
                    @if(isset($m->score_team_a) || isset($m->score_team_b))
                        <div class="text-lg font-bold text-gray-900">{{ $m->score_team_a ?? '-' }} - {{ $m->score_team_b ?? '-' }}</div>
                    @endif
                </div>
            @endforeach
        </div>
        @if($matches instanceof \Illuminate\Pagination\LengthAwarePaginator)
            <div class="mt-6">{{ $matches->links() }}</div>
        @endif
    @endif
</div>
@endsection
