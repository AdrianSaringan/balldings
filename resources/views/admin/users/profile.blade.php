@extends('layouts.app')

@section('title', $user->name . ' Profile')

@section('content')
<div class="py-10 bg-gray-50 min-h-screen">
    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8">

            <!-- Header -->
            <div class="flex flex-col sm:flex-row items-center sm:items-start sm:space-x-6 mb-6">
                <img src="{{ $user->profile_photo_path ? asset('storage/'.$user->profile_photo_path) : asset('images/default-avatar.png') }}" 
                     alt="User Avatar" 
                     class="w-32 h-32 rounded-full border-4 border-indigo-500 shadow-md object-cover">
                
                <div class="mt-4 sm:mt-0 text-center sm:text-left">
                    <h2 class="text-3xl font-extrabold text-gray-800">{{ $user->name }}</h2>
                    <p class="text-gray-500 text-sm capitalize">{{ $user->role ?? 'User' }}</p>

                    <span class="mt-2 inline-block px-3 py-1 bg-indigo-100 text-indigo-700 text-xs font-semibold rounded-full">
                        {{ ucfirst($user->usertype ?? 'N/A') }}
                    </span>
                </div>
            </div>

            <hr class="my-6">

            <!-- Profile Information -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-700 mb-2">Personal Information</h3>
                    <ul class="text-gray-600 space-y-2 text-sm">
                        <li><strong>Email:</strong> {{ $user->email }}</li>
                        <li><strong>Phone:</strong> {{ $user->phone ?? '—' }}</li>
                        <li><strong>Date of Birth:</strong> {{ $user->dob ?? '—' }}</li>
                        <li><strong>Emergency Contact:</strong> {{ $user->emergency_contact ?? '—' }}</li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-lg font-semibold text-gray-700 mb-2">Role Details</h3>
                    <ul class="text-gray-600 space-y-2 text-sm">
                        <li><strong>Role:</strong> {{ ucfirst($user->role ?? 'N/A') }}</li>
                        <li><strong>Sport:</strong> {{ ucfirst($user->sport ?? '—') }}</li>
                        <li><strong>Team / Position:</strong> {{ $user->position ?? '—' }}</li>
                        @php(
                            $coachName = null
                        )
                        @if(($user->role === 'player') && $user->sport === 'basketball')
                            @php(
                                $team = $user->basketball_team_id ? \App\Models\Basketball::find($user->basketball_team_id) : null
                            )
                            @if($team)
                                @php(
                                    $coachName = $team->coach_user_id ? optional(\App\Models\User::find($team->coach_user_id))->name : ($team->coach_name ?? null)
                                )
                            @endif
                        @elseif(($user->role === 'player') && $user->sport === 'volleyball')
                            @php(
                                $team = $user->volleyball_team_id ? \App\Models\Volleyball::find($user->volleyball_team_id) : null
                            )
                            @if($team)
                                @php(
                                    $coachName = $team->coach_user_id ? optional(\App\Models\User::find($team->coach_user_id))->name : ($team->coach_name ?? null)
                                )
                            @endif
                        @endif
                        @if($coachName)
                            <li><strong>Coach:</strong> {{ $coachName }}</li>
                        @endif
                        <li><strong>Joined:</strong> {{ $user->created_at->format('F d, Y') }}</li>
                    </ul>
                </div>
            </div>

            <!-- Verification Image -->
            <div class="mt-8">
                <h3 class="text-lg font-semibold text-gray-700 mb-2">Verification Image</h3>
                <div class="bg-gray-50 rounded-xl border border-gray-200 p-6">
                    @if(!empty($user->verification_image_path))
                        <div class="flex items-center gap-4">
                            <img src="{{ asset('storage/'.$user->verification_image_path) }}" alt="Verification Image" class="w-40 h-40 object-cover rounded-lg border" />
                            <a href="{{ asset('storage/'.$user->verification_image_path) }}" target="_blank" class="px-3 py-1.5 bg-indigo-600 text-white rounded-md text-xs hover:bg-indigo-700">Open Full Image</a>
                        </div>
                    @else
                        <div class="text-sm text-gray-500">No verification image uploaded.</div>
                    @endif
                </div>
            </div>

            <!-- Conditional Section for Players -->
            @if($user->role === 'player')
            <div class="mt-8">
                <h3 class="text-lg font-semibold text-gray-700 mb-2">Player Stats</h3>
                <div class="bg-gray-50 rounded-xl border border-gray-200 p-6">
                    <ul class="text-sm text-gray-600 space-y-2">
                        <li><strong>Height:</strong> {{ $user->height ? $user->height . ' cm' : '—' }}</li>
                        <li><strong>Weight:</strong> {{ $user->weight ? $user->weight . ' kg' : '—' }}</li>
                        <li><strong>Jersey Number:</strong> {{ $user->jersey_number ?? '—' }}</li>
                    </ul>
                </div>
            </div>
            @endif

            <!-- Conditional Section for Coach -->
            @if($user->role === 'coach')
            <div class="mt-8">
                <h3 class="text-lg font-semibold text-gray-700 mb-2">Coach Information</h3>
                <div class="bg-gray-50 rounded-xl border border-gray-200 p-6">
                    <p class="text-sm text-gray-600">Responsible for managing and training players in the {{ ucfirst($user->sport ?? 'unknown') }} team.</p>
                </div>
            </div>
            @endif

            <!-- Conditional Section for Referee -->
            @if($user->role === 'referee')
            <div class="mt-8">
                <h3 class="text-lg font-semibold text-gray-700 mb-2">Referee Profile</h3>
                <div class="bg-gray-50 rounded-xl border border-gray-200 p-6">
                    <p class="text-sm text-gray-600">Certified referee for {{ ucfirst($user->sport ?? '—') }} matches.</p>
                </div>
            </div>
            @endif

            <!-- Back & Edit Buttons -->
            <div class="mt-10 flex justify-between items-center">
                <a href="{{ route('admin.users.index') }}" 
                   class="px-5 py-2 bg-gray-700 text-white rounded-lg text-sm hover:bg-gray-800 transition">
                    ← Back to Users
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
