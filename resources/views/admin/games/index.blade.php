@extends('layouts.app')

@section('title', 'Games')

@section('content')
<div class="py-8 bg-gray-50 min-h-screen">
  <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="mb-6 flex items-center justify-between">
      <h1 class="text-2xl font-bold text-gray-800">Games</h1>
      <a href="{{ route('admin.games.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md text-sm hover:bg-indigo-700">+ New Game</a>
    </div>

    <div class="mb-4">
      <a href="{{ route('admin.games.index') }}" class="mr-3 text-sm {{ !$sport ? 'font-semibold text-gray-900' : 'text-gray-600' }}">All</a>
      <a href="{{ route('admin.games.index', ['sport' => 'basketball']) }}" class="mr-3 text-sm {{ $sport==='basketball' ? 'font-semibold text-gray-900' : 'text-gray-600' }}">🏀 Basketball</a>
      <a href="{{ route('admin.games.index', ['sport' => 'volleyball']) }}" class="text-sm {{ $sport==='volleyball' ? 'font-semibold text-gray-900' : 'text-gray-600' }}">🏐 Volleyball</a>
    </div>

    @if(session('success'))
      <div class="mb-4 bg-green-100 text-green-800 px-4 py-2 rounded">{{ session('success') }}</div>
    @endif

    <div class="bg-white shadow-xl rounded-2xl overflow-hidden">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Sport</th>
            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Teams</th>
            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Score</th>
            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
            <th class="px-4 py-3"></th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
          @forelse($games as $game)
            @php
              if ($game->sport==='basketball') {
                $t1 = optional(\App\Models\Basketball::find($game->team1_id))->team_name;
                $t2 = optional(\App\Models\Basketball::find($game->team2_id))->team_name;
              } else {
                $t1 = optional(\App\Models\Volleyball::find($game->team1_id))->team_name;
                $t2 = optional(\App\Models\Volleyball::find($game->team2_id))->team_name;
              }
            @endphp
            <tr>
              <td class="px-4 py-3 text-sm">{{ ucfirst($game->sport) }}</td>
              <td class="px-4 py-3 text-sm">{{ $t1 }} vs {{ $t2 }}</td>
              <td class="px-4 py-3 text-sm">{{ $game->team1_score }} - {{ $game->team2_score }}</td>
              <td class="px-4 py-3 text-xs"><span class="px-2 py-1 rounded bg-gray-100 text-gray-700">{{ $game->status }}</span></td>
              <td class="px-4 py-3 text-sm">{{ optional($game->played_at)->format('Y-m-d H:i') }}</td>
              <td class="px-4 py-3 text-right"><a class="text-indigo-600 hover:text-indigo-800" href="{{ route('admin.games.show', $game) }}">View</a></td>
            </tr>
          @empty
            <tr><td colspan="6" class="px-4 py-6 text-center text-gray-500">No games found.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <div class="mt-4">{{ $games->withQueryString()->links() }}</div>
  </div>
</div>
@endsection
