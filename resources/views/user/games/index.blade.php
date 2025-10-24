@extends('layouts.app')

@section('title', 'Games')

@section('content')
<div class="py-8 bg-gray-50 min-h-screen">
  <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="mb-6 flex items-center justify-between">
      <h1 class="text-2xl font-bold text-gray-800">Games</h1>
      <div>
        @php $u = auth()->user(); @endphp
        @if(!$u || ($u && $u->usertype === 'admin'))
          <a href="{{ route('games.public.index') }}" class="mr-3 text-sm {{ !$sport ? 'font-semibold text-gray-900' : 'text-gray-600' }}">All</a>
          <a href="{{ route('games.public.index', ['sport' => 'basketball']) }}" class="mr-3 text-sm {{ $sport==='basketball' ? 'font-semibold text-gray-900' : 'text-gray-600' }}">🏀 Basketball</a>
          <a href="{{ route('games.public.index', ['sport' => 'volleyball']) }}" class="text-sm {{ $sport==='volleyball' ? 'font-semibold text-gray-900' : 'text-gray-600' }}">🏐 Volleyball</a>
        @elseif($u && $u->sport === 'basketball')
          <span class="text-sm font-semibold text-gray-900">🏀 Basketball</span>
        @elseif($u && $u->sport === 'volleyball')
          <span class="text-sm font-semibold text-gray-900">🏐 Volleyball</span>
        @endif
      </div>
    </div>

    <div class="bg-white shadow-xl rounded-2xl overflow-hidden">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Sport</th>
            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Teams</th>
            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Score</th>
            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
            <th class="px-4 py-3"></th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
          @if($games->count())
          @foreach($games as $game)
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
              <td class="px-4 py-3 text-sm">{{ optional($game->played_at)->format('Y-m-d H:i') }}</td>
              <td class="px-4 py-3 text-right"><a class="text-indigo-600 hover:text-indigo-800" href="{{ route('games.public.show', $game) }}">View</a></td>
            </tr>
          @endforeach
          @else
            <tr><td colspan="5" class="px-4 py-6 text-center text-gray-500">No games found.</td></tr>
          @endif
        </tbody>
      </table>
    </div>

    <div class="mt-4">{{ $games->withQueryString()->links() }}</div>
  </div>
</div>
@endsection
