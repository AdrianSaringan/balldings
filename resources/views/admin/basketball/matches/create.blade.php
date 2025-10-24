@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-lg rounded-lg p-6">
            <form action="{{ route('admin.basketball.matches.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label>Team A</label>
                    <select name="team_a" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500" required>
                        <option value="">-- Select Team A --</option>
                        @foreach($teams as $t)
                            <option value="{{ $t->team_name }}">{{ $t->team_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label>Team B</label>
                    <select name="team_b" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500" required>
                        <option value="">-- Select Team B --</option>
                        @foreach($teams as $t)
                            <option value="{{ $t->team_name }}">{{ $t->team_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label>Match Date</label>
                    <input type="date" name="match_date" 
                    class="w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500" 
                    required>
                </div>

                <div class="mb-4">
                    <label>Venue</label>
                    <input type="text" name="venue"
                    class="w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500" 
                    required>
                </div>

                <div class="mb-4">
                    <label>Status</label>
                    <select name="status" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500" >
                        <option>Upcoming</option>
                        <option>Ongoing</option>
                        <option>Finished</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label>Referee</label>
                    <select name="referee_id" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500">
                        <option value="">-- None --</option>
                        @foreach($referees as $ref)
                            <option value="{{ $ref->id }}">{{ $ref->name }} ({{ $ref->email }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label>Score Team A</label>
                    <input type="number" name="score_team_a" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500" 
        >
                </div>

                <div class="mb-4">
                    <label>Score Team B</label>
                    <input type="number" name="score_team_b" 
                    class="w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500" >
                </div>

                <div class="mb-4">
                    <label>Winner</label>
                    <input type="text" name="winner" 
                    class="w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500" >
                </div>

                <div class="flex justify-end space-x-2">
                    <a href="{{ route('admin.basketball.teams.index') }}" 
                    class="px-4 py-2 bg-gray-300 rounded-full text-sm hover:bg-gray-400 transition">Cancel</a>
                    <button type="submit" 
                            class="px-4 py-2 bg-green-600 text-white rounded-full text-sm hover:bg-green-700 transition">
                        Save Team
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
