@extends('layouts.app')

@section('title', 'Tournament Brackets')

@section('content')
<div class="p-8 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto bg-white shadow-lg rounded-2xl p-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-8">
            <h2 class="text-3xl font-bold text-gray-800">Tournament Brackets</h2>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.brackets.index') }}" class="px-3 py-1.5 rounded {{ empty($sportFilter) ? 'bg-gray-900 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">All</a>
                <a href="{{ route('admin.brackets.index', ['sport' => 'basketball']) }}" class="px-3 py-1.5 rounded {{ ($sportFilter ?? null) === 'basketball' ? 'bg-blue-600 text-white' : 'bg-blue-50 text-blue-700 hover:bg-blue-100' }}">Basketball</a>
                <a href="{{ route('admin.brackets.index', ['sport' => 'volleyball']) }}" class="px-3 py-1.5 rounded {{ ($sportFilter ?? null) === 'volleyball' ? 'bg-purple-600 text-white' : 'bg-purple-50 text-purple-700 hover:bg-purple-100' }}">Volleyball</a>
            </div>
            <a href="{{ route('admin.brackets.create') }}"
                class="px-5 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                + Create Bracket
            </a>
        </div>

        @if(empty($sportFilter) || $sportFilter === 'basketball')
        <!-- Basketball Bracket -->
        <div class="mb-12">
            <h3 class="text-2xl font-semibold mb-2 text-gray-800">Basketball Bracket</h3>
            @php
                $bbAll = collect([])->merge($basketballUpper ?? collect())->merge($basketballLower ?? collect());
            @endphp
            @if(($bbAll)->count())
                <div class="mb-4 text-sm text-gray-600 flex flex-wrap gap-2">
                    @foreach($bbAll->pluck('tournament_name')->filter()->unique() as $tn)
                        <span class="px-3 py-1 rounded-full bg-blue-50 text-blue-700 border border-blue-200">{{ $tn }}</span>
                    @endforeach
                </div>

                <div class="space-y-10">
                    <!-- Upper Bracket -->
                    <div>
                        <h4 class="text-lg font-bold text-gray-700 mb-3">Upper Bracket</h4>
                        @if(($basketballUpper ?? collect())->count())
                            <div class="overflow-x-auto">
                                <div class="flex space-x-16 min-w-[800px]">
                                    @php $rounds = ($basketballUpper ?? collect())->groupBy('round'); @endphp
                                    @foreach($rounds as $roundNumber => $matches)
                                        <div class="flex flex-col space-y-12">
                                            <div class="text-center font-semibold text-gray-700 mb-2">Round {{ $roundNumber }}</div>
                                            @foreach($matches as $match)
                                                <div class="bg-gray-50 border rounded-xl shadow-sm px-4 py-3 w-48 relative">
                                                    <div class="font-semibold text-gray-800">{{ $match->team1_name ?? 'TBD' }}</div>
                                                    <div class="font-semibold text-gray-800">{{ $match->team2_name ?? 'TBD' }}</div>
                                                    <p class="text-xs text-gray-500 mt-1 capitalize">{{ $match->status }}</p>
                                                    @if($match->winner)
                                                        <p class="text-xs text-green-600 font-medium mt-1">Winner: {{ $match->winner }}</p>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <p class="text-gray-500">No upper bracket matches.</p>
                        @endif
                    </div>

                    <!-- Lower Bracket -->
                    <div>
                        <h4 class="text-lg font-bold text-gray-700 mb-3">Lower Bracket</h4>
                        @if(($basketballLower ?? collect())->count())
                            <div class="overflow-x-auto">
                                <div class="flex space-x-16 min-w-[800px]">
                                    @php $rounds = ($basketballLower ?? collect())->groupBy('round'); @endphp
                                    @foreach($rounds as $roundNumber => $matches)
                                        <div class="flex flex-col space-y-12">
                                            <div class="text-center font-semibold text-gray-700 mb-2">Round {{ $roundNumber }}</div>
                                            @foreach($matches as $match)
                                                <div class="bg-gray-50 border rounded-xl shadow-sm px-4 py-3 w-48 relative">
                                                    <div class="font-semibold text-gray-800">{{ $match->team1_name ?? 'TBD' }}</div>
                                                    <div class="font-semibold text-gray-800">{{ $match->team2_name ?? 'TBD' }}</div>
                                                    <p class="text-xs text-gray-500 mt-1 capitalize">{{ $match->status }}</p>
                                                    @if($match->winner)
                                                        <p class="text-xs text-green-600 font-medium mt-1">Winner: {{ $match->winner }}</p>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <p class="text-gray-500">No lower bracket matches.</p>
                        @endif
                    </div>
                </div>
            @else
                <p class="text-gray-500">No basketball brackets yet.</p>
            @endif
        </div>
        @endif

        @if(empty($sportFilter) || $sportFilter === 'volleyball')
        <!-- Volleyball Bracket -->
        <div>
            <h3 class="text-2xl font-semibold mb-2 text-gray-800">Volleyball Bracket</h3>
            @php
                $vbAll = collect([])->merge($volleyballUpper ?? collect())->merge($volleyballLower ?? collect());
            @endphp
            @if(($vbAll)->count())
                <div class="mb-4 text-sm text-gray-600 flex flex-wrap gap-2">
                    @foreach($vbAll->pluck('tournament_name')->filter()->unique() as $tn)
                        <span class="px-3 py-1 rounded-full bg-purple-50 text-purple-700 border border-purple-200">{{ $tn }}</span>
                    @endforeach
                </div>

                <div class="space-y-10">
                    <!-- Upper Bracket -->
                    <div>
                        <h4 class="text-lg font-bold text-gray-700 mb-3">Upper Bracket</h4>
                        @if(($volleyballUpper ?? collect())->count())
                            <div class="overflow-x-auto">
                                <div class="flex space-x-16 min-w-[800px]">
                                    @php $rounds = ($volleyballUpper ?? collect())->groupBy('round'); @endphp
                                    @foreach($rounds as $roundNumber => $matches)
                                        <div class="flex flex-col space-y-12">
                                            <div class="text-center font-semibold text-gray-700 mb-2">Round {{ $roundNumber }}</div>
                                            @foreach($matches as $match)
                                                <div class="bg-gray-50 border rounded-xl shadow-sm px-4 py-3 w-48 relative">
                                                    <div class="font-semibold text-gray-800">{{ $match->team1_name ?? 'TBD' }}</div>
                                                    <div class="font-semibold text-gray-800">{{ $match->team2_name ?? 'TBD' }}</div>
                                                    <p class="text-xs text-gray-500 mt-1 capitalize">{{ $match->status }}</p>
                                                    @if($match->winner)
                                                        <p class="text-xs text-green-600 font-medium mt-1">Winner: {{ $match->winner }}</p>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <p class="text-gray-500">No upper bracket matches.</p>
                        @endif
                    </div>

                    <!-- Lower Bracket -->
                    <div>
                        <h4 class="text-lg font-bold text-gray-700 mb-3">Lower Bracket</h4>
                        @if(($volleyballLower ?? collect())->count())
                            <div class="overflow-x-auto">
                                <div class="flex space-x-16 min-w-[800px]">
                                    @php $rounds = ($volleyballLower ?? collect())->groupBy('round'); @endphp
                                    @foreach($rounds as $roundNumber => $matches)
                                        <div class="flex flex-col space-y-12">
                                            <div class="text-center font-semibold text-gray-700 mb-2">Round {{ $roundNumber }}</div>
                                            @foreach($matches as $match)
                                                <div class="bg-gray-50 border rounded-xl shadow-sm px-4 py-3 w-48 relative">
                                                    <div class="font-semibold text-gray-800">{{ $match->team1_name ?? 'TBD' }}</div>
                                                    <div class="font-semibold text-gray-800">{{ $match->team2_name ?? 'TBD' }}</div>
                                                    <p class="text-xs text-gray-500 mt-1 capitalize">{{ $match->status }}</p>
                                                    @if($match->winner)
                                                        <p class="text-xs text-green-600 font-medium mt-1">Winner: {{ $match->winner }}</p>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <p class="text-gray-500">No lower bracket matches.</p>
                        @endif
                    </div>
                </div>
            @else
                <p class="text-gray-500">No volleyball brackets yet.</p>
            @endif
        </div>
        @endif
    </div>
</div>
@endsection
