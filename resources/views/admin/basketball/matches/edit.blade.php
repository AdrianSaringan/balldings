@extends('layouts.app')

@section('title', 'Edit Basketball Match')

@section('content')
<div class="py-10 bg-gray-50 min-h-screen">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-xl rounded-2xl p-8 border border-gray-100">

            <h2 class="text-2xl font-bold text-gray-800 mb-6">Edit Basketball Match</h2>

            <form action="{{ route('admin.basketball.matches.update', $match->id) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-sm font-medium text-gray-700">Team A</label>
                    <select name="team_a" required class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option value="">-- Select Team A --</option>
                        @foreach($teams as $t)
                            <option value="{{ $t->team_name }}" {{ $match->team_a === $t->team_name ? 'selected' : '' }}>{{ $t->team_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Team B</label>
                    <select name="team_b" required class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option value="">-- Select Team B --</option>
                        @foreach($teams as $t)
                            <option value="{{ $t->team_name }}" {{ $match->team_b === $t->team_name ? 'selected' : '' }}>{{ $t->team_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Match Date</label>
                    <input type="date" name="match_date" value="{{ $match->match_date }}" required
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Venue</label>
                    <input type="text" name="venue" value="{{ $match->venue }}" required
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Status</label>
                    <select name="status"
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option value="Upcoming" {{ $match->status == 'Upcoming' ? 'selected' : '' }}>Upcoming</option>
                        <option value="Ongoing" {{ $match->status == 'Ongoing' ? 'selected' : '' }}>Ongoing</option>
                        <option value="Finished" {{ $match->status == 'Finished' ? 'selected' : '' }}>Finished</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Referee</label>
                    <select name="referee_id" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option value="">-- None --</option>
                        @foreach($referees as $ref)
                            <option value="{{ $ref->id }}" {{ (string)$match->referee_id === (string)$ref->id ? 'selected' : '' }}>
                                {{ $ref->name }} ({{ $ref->email }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Score Team A</label>
                        <input type="number" name="score_team_a" value="{{ $match->score_team_a }}"
                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Score Team B</label>
                        <input type="number" name="score_team_b" value="{{ $match->score_team_b }}"
                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Winner</label>
                    <input type="text" name="winner" value="{{ $match->winner }}"
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                </div>

                <div class="flex justify-end gap-3 mt-6">
                    <a href="{{ route('admin.basketball.matches.index') }}"
                        class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">Cancel</a>
                    <button type="submit"
                        class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">Update Match</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
