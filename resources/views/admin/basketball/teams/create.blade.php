@extends('layouts.app')

@section('title', 'Add Basketball Team')

@section('content')
<div class="py-8">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Create Basketball Teams</h1>
        <div class="bg-white shadow-lg rounded-lg p-6">
            <div class="flex justify-between items-center mb-4"></div>
            <form action="{{ route('admin.basketball.teams.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Team Name</label>
                    <input type="text" name="team_name" 
                           class="w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500" 
                           required>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Coach Name</label>
                    <input type="text" name="coach_name" 
                           class="w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500" 
                           required>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Number of Players</label>
                    <input type="number" name="number_of_players" min="1"
                           class="w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500" 
                           required>
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
