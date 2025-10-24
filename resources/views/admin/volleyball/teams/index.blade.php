@extends('layouts.app')

@section('title', 'Volleyball Teams')

@section('content')
<div class="py-8 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Volleyball Teams</h1>

        <div class="bg-white shadow-xl rounded-2xl p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold text-gray-700">Team List</h3>
                <a href="{{ route('admin.volleyball.teams.create') }}" 
                   class="px-4 py-2 bg-green-600 text-white rounded-full text-sm font-medium hover:bg-green-700 transition">
                    + Add Team
                </a>
            </div>

            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-sm text-left">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3 uppercase font-semibold text-gray-500">No.</th>
                            <th class="px-6 py-3 uppercase font-semibold text-gray-500">Team Name</th>
                            <th class="px-6 py-3 uppercase font-semibold text-gray-500">Coach Name</th>
                            <th class="px-6 py-3 uppercase font-semibold text-gray-500">Number of Players</th>
                            <th class="px-6 py-3 uppercase font-semibold text-gray-500">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse($teams as $team)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-3">{{ $loop->iteration }}</td>
                                <td class="px-6 py-3 font-medium text-gray-900">{{ $team->team_name }}</td>
                                <td class="px-6 py-3 text-gray-700">{{ $team->coach_name }}</td>
                                <td class="px-6 py-3 text-gray-700">{{ $team->num_of_players }}</td>
                                <td class="px-6 py-3 flex gap-2">
                                    <a href="{{ route('admin.volleyball.teams.show', $team->id) }}" 
                                       class="px-3 py-1 bg-indigo-600 text-white rounded-full text-xs hover:bg-indigo-700 transition">
                                        View
                                    </a>
                                    <a href="{{ route('admin.volleyball.teams.edit', $team->id) }}" 
                                       class="px-3 py-1 bg-blue-600 text-white rounded-full text-xs hover:bg-blue-700 transition">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.volleyball.teams.destroy', $team->id) }}" method="POST" 
                                          onsubmit="return confirm('Are you sure you want to delete this team?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="px-3 py-1 bg-red-600 text-white rounded-full text-xs hover:bg-red-700 transition">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-6 text-center text-gray-500">No teams found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
