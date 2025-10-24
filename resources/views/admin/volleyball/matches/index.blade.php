@extends('layouts.app')

@section('title', 'Volleyball Matches')

@section('content')
<div class="py-8 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Volleyball Matches</h1>

        <div class="bg-white shadow-xl rounded-2xl p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold text-gray-700">Match List</h3>
                <a href="{{ route('admin.volleyball.matches.create') }}" 
                   class="px-4 py-2 bg-green-600 text-white rounded-full text-sm font-medium hover:bg-green-700 transition">
                    + Add Match
                </a>
            </div>

            @if(session('success'))
                <div class="mb-4 p-3 bg-green-100 text-green-700 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-sm text-left">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3 uppercase font-semibold text-gray-500">#</th>
                            <th class="px-6 py-3 uppercase font-semibold text-gray-500">Team A</th>
                            <th class="px-6 py-3 uppercase font-semibold text-gray-500">Score A</th>
                            <th class="px-6 py-3 uppercase font-semibold text-gray-500">Team B</th>
                            <th class="px-6 py-3 uppercase font-semibold text-gray-500">Score B</th>
                            <th class="px-6 py-3 uppercase font-semibold text-gray-500">Date</th>
                            <th class="px-6 py-3 uppercase font-semibold text-gray-500">Venue</th>
                            <th class="px-6 py-3 uppercase font-semibold text-gray-500">Status</th>
                            <th class="px-6 py-3 uppercase font-semibold text-gray-500">Winner</th>
                            <th class="px-6 py-3 uppercase font-semibold text-gray-500">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse($matches as $match)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-3">{{ $loop->iteration }}</td>
                                <td class="px-6 py-3 font-medium text-gray-900">{{ $match->team_a }}</td>
                                <td class="px-6 py-3 text-gray-700">{{ $match->score_team_a ?? 0 }}</td>
                                <td class="px-6 py-3 font-medium text-gray-900">{{ $match->team_b }}</td>
                                <td class="px-6 py-3 text-gray-700">{{ $match->score_team_b ?? 0 }}</td>
                                <td class="px-6 py-3 text-gray-700">{{ \Carbon\Carbon::parse($match->match_date)->format('M d, Y') }}</td>
                                <td class="px-6 py-3 text-gray-700">{{ $match->venue }}</td>
                                <td class="px-6 py-3 text-gray-700">{{ ucfirst($match->status) }}</td>
                                <td class="px-6 py-3 text-gray-700">{{ $match->winner ?? 'N/A' }}</td>
                                <td class="px-6 py-3 flex gap-2">
                                    <a href="{{ route('admin.volleyball.matches.edit', $match->id) }}" 
                                       class="px-3 py-1 bg-blue-600 text-white rounded-full text-xs hover:bg-blue-700 transition">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.volleyball.matches.destroy', $match->id) }}" method="POST"
                                          onsubmit="return confirm('Are you sure you want to delete this match?')">
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
                                <td colspan="10" class="px-6 py-6 text-center text-gray-500">No matches found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
