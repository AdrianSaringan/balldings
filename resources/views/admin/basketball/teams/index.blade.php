@extends('layouts.app')

@section('title', 'Basketball Teams')

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Basketball Teams</h1>

        <div class="bg-white shadow-lg rounded-lg p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold">Team List</h3>
                <a href="{{ route('admin.basketball.teams.create') }}" 
                   class="px-4 py-2 bg-green-600 text-white rounded-full text-sm font-medium hover:bg-green-700 transition">
                    + Add Team
                </a>
            </div>

            @if(session('success'))
                <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">#</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Team Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Coach</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Number of Players</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-200">
                    @forelse($basketballs as $team)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $team->team_name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $team->coach_name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $team->number_of_players }}</td>
                            <td class="px-6 py-4 text-sm space-x-2">
                                <a href="{{ route('admin.basketball.teams.show', $team->id) }}" 
                                   class="px-4 py-1 bg-indigo-600 text-white rounded-full text-xs hover:bg-indigo-700 transition">
                                    View
                                </a>
                                <a href="{{ route('admin.basketball.teams.edit', $team->id) }}" 
                                   class="px-4 py-1 bg-blue-600 text-white rounded-full text-xs hover:bg-blue-700 transition">
                                    Edit
                                </a>
                                <form action="{{ route('admin.basketball.teams.destroy', $team->id) }}" 
                                      method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            onclick="return confirm('Are you sure you want to delete this team?')"
                                            class="px-4 py-1 bg-red-600 text-white rounded-full text-xs hover:bg-red-700 transition">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-gray-500">
                                No teams found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
