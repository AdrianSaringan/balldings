@extends('layouts.app')

@section('title', 'Tournament Management')

@section('content')
<div class="py-10">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-lg rounded-2xl p-8">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Tournaments</h2>
                <a href="{{ route('admin.tournaments.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow">
                    + Add Tournament
                </a>
            </div>

            @if(session('success'))
                <div class="mb-4 text-green-600 font-semibold">
                    {{ session('success') }}
                </div>
            @endif

            <div class="overflow-x-auto">
                <table class="w-full border border-gray-200 rounded-lg">
                    <thead class="bg-gray-100 text-gray-700">
                        <tr>
                            <th class="px-4 py-3 text-left">Name</th>
                            <th class="px-4 py-3 text-left">Sport</th>
                            <th class="px-4 py-3 text-left">Start Date</th>
                            <th class="px-4 py-3 text-left">End Date</th>
                            <th class="px-4 py-3 text-left">Venue</th>
                            <th class="px-4 py-3 text-left">Status</th>
                            <th class="px-4 py-3 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse($tournaments as $tournament)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 font-medium">{{ $tournament->name }}</td>
                                <td class="px-4 py-3 capitalize">{{ $tournament->sport }}</td>
                                <td class="px-4 py-3">{{ $tournament->start_date ?? '—' }}</td>
                                <td class="px-4 py-3">{{ $tournament->end_date ?? '—' }}</td>
                                <td class="px-4 py-3">{{ $tournament->venue ?? '—' }}</td>
                                <td class="px-4 py-3">
                                    <span class="px-2 py-1 text-sm rounded-full 
                                        @if($tournament->status == 'upcoming') bg-yellow-100 text-yellow-700 
                                        @elseif($tournament->status == 'ongoing') bg-green-100 text-green-700
                                        @else bg-gray-200 text-gray-700 @endif">
                                        {{ ucfirst($tournament->status) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-center space-x-2">
                                    <a href="{{ route('admin.tournaments.edit', $tournament) }}" class="text-blue-600 hover:underline">Edit</a>
                                    <form action="{{ route('admin.tournaments.destroy', $tournament) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Are you sure?')" class="text-red-600 hover:underline">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-6 text-center text-gray-500">No tournaments available.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
