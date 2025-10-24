@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="mb-6 flex items-center justify-between">
        <h2 class="text-2xl font-semibold">Basketball Matches</h2>
        <a href="{{ url('/') }}" class="text-sm text-indigo-600 hover:underline">Home</a>
    </div>

    <div class="bg-white rounded-xl shadow">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Match</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Venue</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Score</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">View</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($matches as $m)
                    <tr>
                        <td class="px-4 py-2 text-sm text-gray-600">{{ \Carbon\Carbon::parse($m->match_date)->format('M d, Y h:ia') }}</td>
                        <td class="px-4 py-2 text-sm">{{ $m->team_a }} vs {{ $m->team_b }}</td>
                        <td class="px-4 py-2 text-sm text-gray-600">{{ $m->venue }}</td>
                        <td class="px-4 py-2 text-sm font-semibold">{{ $m->score_team_a }} - {{ $m->score_team_b }}</td>
                        <td class="px-4 py-2 text-xs">
                            <span class="px-2 py-1 rounded {{ $m->status==='Ongoing'?'bg-green-100 text-green-700':($m->status==='Finished'?'bg-gray-200 text-gray-700':'bg-yellow-100 text-yellow-700') }}">{{ $m->status }}</span>
                        </td>
                        <td class="px-4 py-2 text-right">
                            <a href="{{ route('basketball.public.show', $m) }}" class="text-indigo-600 hover:underline text-sm">Open</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-6 text-center text-gray-500">No matches found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
