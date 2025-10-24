@extends('layouts.app')

@section('title', 'Game')

@section('content')
<div class="py-8 bg-gray-50 min-h-screen">
  <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="mb-6 flex items-center justify-between">
      <h1 class="text-2xl font-bold text-gray-800">{{ ucfirst($game->sport) }} Game</h1>
      <a href="{{ route('games.public.index') }}" class="px-4 py-2 bg-gray-700 text-white rounded-md text-sm hover:bg-gray-800">← Back to Games</a>
    </div>

    <div class="bg-white shadow-xl rounded-2xl p-6 mb-6">
      <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
        <div class="md:col-span-2">
          <div class="text-sm text-gray-600 mb-1">Teams</div>
          <div class="text-lg font-semibold">{{ optional($team1)->team_name ?? 'TBD' }} vs {{ optional($team2)->team_name ?? 'TBD' }}</div>
          <div class="text-sm text-gray-500 mt-1">Venue: {{ $game->venue ?? '—' }}</div>
          <div class="text-sm text-gray-500">Date: {{ optional($game->played_at)->format('Y-m-d H:i') ?? '—' }}</div>
        </div>
        <div>
          <div class="text-sm text-gray-600 mb-1">Status</div>
          <span class="px-2 py-1 rounded bg-gray-100 text-gray-700 text-sm">{{ $game->status }}</span>
        </div>
        <div class="text-right">
          <div class="text-2xl font-bold">{{ $game->team1_score }} - {{ $game->team2_score }}</div>
        </div>
      </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <div class="bg-white shadow-xl rounded-2xl p-6">
        <h2 class="font-semibold text-gray-800 mb-4">{{ optional($team1)->team_name ?? 'Team 1' }} Players</h2>
        <div class="space-y-2">
          @foreach($team1Players as $p)
            @php $s = $stats[$p->id] ?? null; @endphp
            <div class="border rounded-md p-3">
              <div class="font-medium">{{ $p->name }}</div>
              <div class="grid grid-cols-2 gap-3 mt-2 text-sm">
                @foreach($statFields as $f)
                  <div class="flex items-center justify-between">
                    <span class="text-gray-600">{{ strtoupper(str_replace(['_','VB_'], [' ',''], $f)) }}</span>
                    <span class="font-medium">{{ $s->$f ?? 0 }}</span>
                  </div>
                @endforeach
              </div>
            </div>
          @endforeach
        </div>
      </div>

      <div class="bg-white shadow-xl rounded-2xl p-6">
        <h2 class="font-semibold text-gray-800 mb-4">{{ optional($team2)->team_name ?? 'Team 2' }} Players</h2>
        <div class="space-y-2">
          @foreach($team2Players as $p)
            @php $s = $stats[$p->id] ?? null; @endphp
            <div class="border rounded-md p-3">
              <div class="font-medium">{{ $p->name }}</div>
              <div class="grid grid-cols-2 gap-3 mt-2 text-sm">
                @foreach($statFields as $f)
                  <div class="flex items-center justify-between">
                    <span class="text-gray-600">{{ strtoupper(str_replace(['_','VB_'], [' ',''], $f)) }}</span>
                    <span class="font-medium">{{ $s->$f ?? 0 }}</span>
                  </div>
                @endforeach
              </div>
            </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
