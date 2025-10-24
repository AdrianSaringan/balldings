@extends('layouts.app')

@section('title', 'Create Game')

@section('content')
<div class="py-8 bg-gray-50 min-h-screen">
  <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
    <div class="mb-6 flex items-center justify-between">
      <h1 class="text-2xl font-bold text-gray-800">Create Game</h1>
      <a href="{{ route('admin.games.index') }}" class="px-4 py-2 bg-gray-700 text-white rounded-md text-sm hover:bg-gray-800">← Back</a>
    </div>

    @if($errors->any())
      <div class="mb-4 bg-red-50 text-red-700 px-4 py-2 rounded">
        <ul class="list-disc pl-5">
          @foreach($errors->all() as $e)
            <li>{{ $e }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form action="{{ route('admin.games.store') }}" method="POST" class="bg-white shadow-xl rounded-2xl p-6 space-y-5">
      @csrf
      <div>
        <label class="block text-sm font-medium text-gray-700">Sport</label>
        <select name="sport" x-data x-on:change="$dispatch('sport-change', { value: $event.target.value })" class="mt-1 w-full border-gray-300 rounded-md">
          <option value="basketball">Basketball</option>
          <option value="volleyball">Volleyball</option>
        </select>
      </div>

      <div x-data="{ sport: 'basketball' }" x-on:sport-change.window="sport = $event.detail.value">
        <div x-show="sport==='basketball'" class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700">Team 1 (Basketball)</label>
            <select name="team1_id_basketball" class="mt-1 w-full border-gray-300 rounded-md">
              @foreach($basketballTeams as $t)
                <option value="{{ $t->id }}">{{ $t->team_name }}</option>
              @endforeach
            </select>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700">Team 2 (Basketball)</label>
            <select name="team2_id_basketball" class="mt-1 w-full border-gray-300 rounded-md">
              @foreach($basketballTeams as $t)
                <option value="{{ $t->id }}">{{ $t->team_name }}</option>
              @endforeach
            </select>
          </div>
        </div>

        <div x-show="sport==='volleyball'" class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700">Team 1 (Volleyball)</label>
            <select name="team1_id_volleyball" class="mt-1 w-full border-gray-300 rounded-md">
              @foreach($volleyballTeams as $t)
                <option value="{{ $t->id }}">{{ $t->team_name }}</option>
              @endforeach
            </select>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700">Team 2 (Volleyball)</label>
            <select name="team2_id_volleyball" class="mt-1 w-full border-gray-300 rounded-md">
              @foreach($volleyballTeams as $t)
                <option value="{{ $t->id }}">{{ $t->team_name }}</option>
              @endforeach
            </select>
          </div>
        </div>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label class="block text-sm font-medium text-gray-700">Date & Time</label>
          <input type="datetime-local" name="played_at" class="mt-1 w-full border-gray-300 rounded-md" />
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700">Venue</label>
          <input type="text" name="venue" class="mt-1 w-full border-gray-300 rounded-md" placeholder="e.g. Main Gym" />
        </div>
      </div>

      <div class="pt-4">
        <button type="submit" class="px-5 py-2.5 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Create</button>
      </div>
    </form>
  </div>
</div>
@endsection
