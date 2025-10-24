@extends('layouts.app')

@section('title', 'Edit Basketball Team')

@section('content')
<div class="py-10">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-lg rounded-2xl p-8">

            <!-- Header -->
            <div class="mb-6 border-b pb-4 flex items-center justify-between">
                <h2 class="text-2xl font-bold text-gray-800">
                    🏀 Edit Basketball Team
                </h2>
                <a href="{{ route('admin.basketball.teams.index') }}" 
                   class="text-sm text-gray-600 hover:text-blue-600 transition">
                    ← Back
                </a>
            </div>

            <!-- Form -->
            <form method="POST" action="{{ route('admin.basketball.teams.update', $team->id) }}" class="space-y-6">
                @csrf
                @method('PUT')

                {{-- Team Name --}}
                <div>
                    <label for="team_name" class="block text-sm font-medium text-gray-700 mb-1">
                        Team Name
                    </label>
                    <input 
                        type="text" 
                        id="team_name" 
                        name="team_name" 
                        value="{{ old('team_name', $team->team_name) }}" 
                        class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        placeholder="Enter team name"
                        required
                    >
                    @error('team_name')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Coach Name --}}
                <div>
                    <label for="coach_name" class="block text-sm font-medium text-gray-700 mb-1">
                        Coach Name
                    </label>
                    <input 
                        type="text" 
                        id="coach_name" 
                        name="coach_name" 
                        value="{{ old('coach_name', $team->coach_name) }}" 
                        class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        placeholder="Enter coach name"
                        required
                    >
                    @error('coach_name')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Number of Players --}}
                <div>
                    <label for="num_of_players" class="block text-sm font-medium text-gray-700 mb-1">
                        Number of Players
                    </label>
                    <input 
                        type="number" 
                        id="num_of_players" 
                        name="num_of_players" 
                        value="{{ old('num_of_players', $team->num_of_players ?? $team->num_players) }}" 
                        class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        placeholder="Enter number of players"
                        min="1"
                        required
                    >
                    @error('num_of_players')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Actions -->
                <div class="flex justify-end space-x-3 pt-4 border-t">
                    <a href="{{ route('admin.basketball.teams.index') }}" 
                       class="px-5 py-2 rounded-lg bg-gray-500 text-white hover:bg-gray-600 transition">
                        Cancel
                    </a>
                    <button 
                        type="submit" 
                        class="px-5 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition">
                        Update Team
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
