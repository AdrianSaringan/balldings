@extends('layouts.app')

@section('title', 'Game Details')

@section('content')
<div class="py-8 bg-gray-50 min-h-screen">
  <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="mb-6 flex items-center justify-between">
      <h1 class="text-2xl font-bold text-gray-800">{{ ucfirst($game->sport) }} Game</h1>
      <a href="{{ route('admin.games.index') }}" class="px-4 py-2 bg-gray-700 text-white rounded-md text-sm hover:bg-gray-800">← Back to Games</a>
    </div>

    @if(session('success'))
      <div class="mb-4 bg-green-100 text-green-800 px-4 py-2 rounded">{{ session('success') }}</div>
    @endif
    @if($errors->any())
      <div class="mb-4 bg-red-50 text-red-700 px-4 py-2 rounded">
        <ul class="list-disc pl-5">
          @foreach($errors->all() as $e)
            <li>{{ $e }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <div class="bg-white shadow-xl rounded-2xl p-6 mb-6">
      <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-center">
        <div class="md:col-span-2">
          <div class="text-sm text-gray-600 mb-1">Teams</div>
          <div class="text-lg font-semibold">{{ $team1->team_name ?? 'TBD' }} vs {{ $team2->team_name ?? 'TBD' }}</div>
          <div class="text-sm text-gray-500 mt-1">Venue: {{ $game->venue ?? '—' }}</div>
          <div class="text-sm text-gray-500">Date: {{ optional($game->played_at)->format('Y-m-d H:i') ?? '—' }}</div>
        </div>
        <div>
          <div class="text-sm text-gray-600 mb-1">Status</div>
          <span class="px-2 py-1 rounded bg-gray-100 text-gray-700 text-sm">{{ $game->status }}</span>
        </div>
        <div class="flex md:justify-end">
          <form method="POST" action="{{ route('admin.games.scores', $game) }}" class="flex flex-wrap items-end gap-2">
            @csrf
            <div>
              <label class="block text-xs text-gray-600">{{ $team1->team_name ?? 'Team 1' }} Score</label>
              <input type="number" min="0" name="team1_score" value="{{ $game->team1_score }}" class="mt-1 w-24 border-gray-300 rounded-md" />
            </div>
            <div>
              <label class="block text-xs text-gray-600">{{ $team2->team_name ?? 'Team 2' }} Score</label>
              <input type="number" min="0" name="team2_score" value="{{ $game->team2_score }}" class="mt-1 w-24 border-gray-300 rounded-md" />
            </div>
            <div>
              <label class="block text-xs text-gray-600">Status</label>
              <select name="status" class="mt-1 w-36 border-gray-300 rounded-md">
                <option value="scheduled" {{ $game->status==='scheduled' ? 'selected' : '' }}>scheduled</option>
                <option value="ongoing" {{ $game->status==='ongoing' ? 'selected' : '' }}>ongoing</option>
                <option value="completed" {{ $game->status==='completed' ? 'selected' : '' }}>completed</option>
              </select>
            </div>
            <button class="h-10 px-4 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Save</button>
          </form>
        </div>
      </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <div class="bg-white shadow-xl rounded-2xl p-6">
        <h2 class="font-semibold text-gray-800 mb-4">{{ $team1->team_name ?? 'Team 1' }} Players</h2>
        <form method="POST" action="{{ route('admin.games.stats', $game) }}" class="space-y-3">
          @csrf
          @foreach($team1Players as $p)
            @php $s = $stats[$p->id] ?? null; @endphp
            <div class="border rounded-md p-3">
              <div class="flex items-center justify-between">
                <div class="font-medium">{{ $p->name }}</div>
                <input type="hidden" name="stats[{{ $p->id }}][user_id]" value="{{ $p->id }}" />
                <input type="hidden" name="stats[{{ $p->id }}][team_id]" value="{{ $team1->id ?? '' }}" />
              </div>
              <div class="grid grid-cols-2 gap-3 mt-3">
                @if($game->sport==='basketball')
                  <x-stat-input label="PTS" name="stats[{{ $p->id }}][points]" :value="$s->points ?? null" />
                  <x-stat-input label="REB" name="stats[{{ $p->id }}][rebounds]" :value="$s->rebounds ?? null" />
                  <x-stat-input label="AST" name="stats[{{ $p->id }}][assists]" :value="$s->assists ?? null" />
                  <x-stat-input label="STL" name="stats[{{ $p->id }}][steals]" :value="$s->steals ?? null" />
                  <x-stat-input label="BLK" name="stats[{{ $p->id }}][blocks]" :value="$s->blocks ?? null" />
                  <x-stat-input label="Fouls" name="stats[{{ $p->id }}][fouls]" :value="$s->fouls ?? null" />
                  <x-stat-input label="Min" name="stats[{{ $p->id }}][minutes]" :value="$s->minutes ?? null" />
                @else
                  <x-stat-input label="Kills" name="stats[{{ $p->id }}][kills]" :value="$s->kills ?? null" />
                  <x-stat-input label="Aces" name="stats[{{ $p->id }}][aces]" :value="$s->aces ?? null" />
                  <x-stat-input label="Digs" name="stats[{{ $p->id }}][digs]" :value="$s->digs ?? null" />
                  <x-stat-input label="Blocks" name="stats[{{ $p->id }}][vb_blocks]" :value="$s->vb_blocks ?? null" />
                  <x-stat-input label="Assists" name="stats[{{ $p->id }}][vb_assists]" :value="$s->vb_assists ?? null" />
                  <x-stat-input label="Receptions" name="stats[{{ $p->id }}][receptions]" :value="$s->receptions ?? null" />
                  <x-stat-input label="Errors" name="stats[{{ $p->id }}][errors]" :value="$s->errors ?? null" />
                  <x-stat-input label="Sets" name="stats[{{ $p->id }}][sets_played]" :value="$s->sets_played ?? null" />
                @endif
              </div>
            </div>
          @endforeach
          <div class="pt-2">
            <button class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Save Stats</button>
          </div>
        </form>
      </div>

      <div class="bg-white shadow-xl rounded-2xl p-6">
        <h2 class="font-semibold text-gray-800 mb-4">{{ $team2->team_name ?? 'Team 2' }} Players</h2>
        <form method="POST" action="{{ route('admin.games.stats', $game) }}" class="space-y-3">
          @csrf
          @foreach($team2Players as $p)
            @php $s = $stats[$p->id] ?? null; @endphp
            <div class="border rounded-md p-3">
              <div class="flex items-center justify-between">
                <div class="font-medium">{{ $p->name }}</div>
                <input type="hidden" name="stats[{{ $p->id }}][user_id]" value="{{ $p->id }}" />
                <input type="hidden" name="stats[{{ $p->id }}][team_id]" value="{{ $team2->id ?? '' }}" />
              </div>
              <div class="grid grid-cols-2 gap-3 mt-3">
                @if($game->sport==='basketball')
                  <x-stat-input label="PTS" name="stats[{{ $p->id }}][points]" :value="$s->points ?? null" />
                  <x-stat-input label="REB" name="stats[{{ $p->id }}][rebounds]" :value="$s->rebounds ?? null" />
                  <x-stat-input label="AST" name="stats[{{ $p->id }}][assists]" :value="$s->assists ?? null" />
                  <x-stat-input label="STL" name="stats[{{ $p->id }}][steals]" :value="$s->steals ?? null" />
                  <x-stat-input label="BLK" name="stats[{{ $p->id }}][blocks]" :value="$s->blocks ?? null" />
                  <x-stat-input label="Fouls" name="stats[{{ $p->id }}][fouls]" :value="$s->fouls ?? null" />
                  <x-stat-input label="Min" name="stats[{{ $p->id }}][minutes]" :value="$s->minutes ?? null" />
                @else
                  <x-stat-input label="Kills" name="stats[{{ $p->id }}][kills]" :value="$s->kills ?? null" />
                  <x-stat-input label="Aces" name="stats[{{ $p->id }}][aces]" :value="$s->aces ?? null" />
                  <x-stat-input label="Digs" name="stats[{{ $p->id }}][digs]" :value="$s->digs ?? null" />
                  <x-stat-input label="Blocks" name="stats[{{ $p->id }}][vb_blocks]" :value="$s->vb_blocks ?? null" />
                  <x-stat-input label="Assists" name="stats[{{ $p->id }}][vb_assists]" :value="$s->vb_assists ?? null" />
                  <x-stat-input label="Receptions" name="stats[{{ $p->id }}][receptions]" :value="$s->receptions ?? null" />
                  <x-stat-input label="Errors" name="stats[{{ $p->id }}][errors]" :value="$s->errors ?? null" />
                  <x-stat-input label="Sets" name="stats[{{ $p->id }}][sets_played]" :value="$s->sets_played ?? null" />
                @endif
              </div>
            </div>
          @endforeach
          <div class="pt-2">
            <button class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Save Stats</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
