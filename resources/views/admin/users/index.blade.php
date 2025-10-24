@extends('layouts.app')

@section('title', 'User Management')

@section('content')
<div class="py-10 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-xl rounded-2xl p-8 border border-gray-100">

            <!-- Header -->
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4 gap-4">
                <div>
                    <h2 class="text-3xl font-extrabold text-gray-800 tracking-tight">User List</h2>
                    <p class="text-gray-500 text-sm mt-1">Manage registered users and their information</p>
                </div>
            </div>

            <!-- Quick Stats -->
            @php(
                $totalUsers = \App\Models\User::count()
            )
            @php(
                $playerCount = \App\Models\User::where('role','player')->count()
            )
            @php(
                $coachCount = \App\Models\User::where('role','coach')->count()
            )
            @php(
                $refereeCount = \App\Models\User::where('role','referee')->count()
            )

            <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-6">
                <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                    <div class="text-xs text-gray-500">Total Users</div>
                    <div class="text-2xl font-semibold text-gray-800">{{ $totalUsers }}</div>
                </div>
                <div class="bg-yellow-50 rounded-xl p-4 border border-yellow-100">
                    <div class="text-xs text-yellow-700">Players</div>
                    <div class="text-2xl font-semibold text-yellow-800">{{ $playerCount }}</div>
                </div>
                <div class="bg-green-50 rounded-xl p-4 border border-green-100">
                    <div class="text-xs text-green-700">Coaches</div>
                    <div class="text-2xl font-semibold text-green-800">{{ $coachCount }}</div>
                </div>
                <div class="bg-purple-50 rounded-xl p-4 border border-purple-100">
                    <div class="text-xs text-purple-700">Referees</div>
                    <div class="text-2xl font-semibold text-purple-800">{{ $refereeCount }}</div>
                </div>
            </div>

            <!-- Filters & Search -->
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
                <!-- Filter Buttons -->
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('admin.users.index', ['filter' => 'basketball']) }}" 
                       class="px-4 py-1 rounded-lg text-sm font-medium {{ request('filter') === 'basketball' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">Basketball</a>
                    <a href="{{ route('admin.users.index', ['filter' => 'volleyball']) }}" 
                       class="px-4 py-1 rounded-lg text-sm font-medium {{ request('filter') === 'volleyball' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">Volleyball</a>
                    <a href="{{ route('admin.users.index', ['filter' => 'coach']) }}" 
                       class="px-4 py-1 rounded-lg text-sm font-medium {{ request('filter') === 'coach' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">Coach</a>
                    <a href="{{ route('admin.users.index', ['filter' => 'referee']) }}" 
                       class="px-4 py-1 rounded-lg text-sm font-medium {{ request('filter') === 'referee' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">Referee</a>
                    <a href="{{ route('admin.users.index') }}" 
                       class="px-4 py-1 rounded-lg text-sm font-medium bg-gray-100 text-gray-700 hover:bg-gray-200">All</a>
                </div>

                <!-- Search -->
                <form method="GET" action="{{ route('admin.users.index') }}" class="flex">
                    <input type="text" name="search" placeholder="Search users..." value="{{ request('search') }}"
                        class="rounded-l-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    <button type="submit"
                        class="px-4 py-2 bg-indigo-600 text-white rounded-r-lg hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500 transition">Search</button>
                </form>
            </div>

            <!-- Table Container -->
            <div class="overflow-hidden border border-gray-200 rounded-xl">
                <div class="overflow-x-auto max-h-[70vh] scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100">
                    <table class="min-w-full text-sm text-left text-gray-700">
                        <thead class="bg-gray-100 text-gray-700 uppercase font-semibold sticky top-0 z-10 shadow-sm">
                            <tr>
                                <th class="px-6 py-3">#</th>
                                <th class="px-6 py-3">User</th>
                                <th class="px-6 py-3">Verification</th>
                                <th class="px-6 py-3">Contact</th>
                                <th class="px-6 py-3">Sport/Pos</th>
                                <th class="px-6 py-3 hidden lg:table-cell">DOB</th>
                                <th class="px-6 py-3 hidden xl:table-cell">Height</th>
                                <th class="px-6 py-3 hidden xl:table-cell">Weight</th>
                                <th class="px-6 py-3 hidden 2xl:table-cell">Jersey</th>
                                <th class="px-6 py-3 hidden 2xl:table-cell">Emergency</th>
                                <th class="px-6 py-3">Type</th>
                                <th class="px-6 py-3">Role</th>
                                <th class="px-6 py-3 text-center">Actions</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100 bg-white">
                            @forelse ($users as $user)
                                <tr class="hover:bg-gray-50 transition duration-150 ease-in-out">
                                    <td class="px-6 py-4">{{ $loop->iteration }}</td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <a href="{{ route('admin.users.profile', $user->id) }}" class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center text-sm font-semibold text-gray-700 hover:ring-2 hover:ring-indigo-300 transition overflow-hidden aspect-square">
                                                @if(!empty($user->profile_photo_path))
                                                    <img src="{{ asset('storage/'.$user->profile_photo_path) }}" alt="{{ $user->name }}" class="w-full h-full object-cover rounded-full" />
                                                @else
                                                    <span class="leading-none">{{ strtoupper(mb_substr($user->name,0,1)) }}</span>
                                                @endif
                                            </a>
                                            <div>
                                                <div class="font-medium text-gray-900">
                                                    <a href="{{ route('admin.users.profile', $user->id) }}" class="hover:text-indigo-700 underline-offset-2 hover:underline">
                                                        {{ $user->name }}
                                                    </a>
                                                </div>
                                                <div class="text-xs text-gray-500">Joined {{ $user->created_at?->diffForHumans() }}</div>
                                                <div class="mt-1 text-xs">
                                                    <a href="{{ route('admin.users.profile', $user->id) }}" class="text-indigo-600 hover:text-indigo-800">View Profile</a>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if(!empty($user->verification_image_path))
                                            <a href="{{ asset('storage/'.$user->verification_image_path) }}" target="_blank" class="inline-block">
                                                <img src="{{ asset('storage/'.$user->verification_image_path) }}" alt="Verification" class="w-10 h-10 rounded-full object-cover border" />
                                            </a>
                                        @else
                                            <span class="text-xs text-gray-400">None</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm">{{ $user->email }}</div>
                                        <div class="text-xs text-gray-500">{{ $user->phone ?? '—' }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm">{{ ucfirst($user->sport ?? '—') }}</div>
                                        <div class="text-xs text-gray-500">{{ $user->position ?? '—' }}</div>
                                    </td>
                                    <td class="px-6 py-4 hidden lg:table-cell">{{ $user->dob ?? '—' }}</td>
                                    <td class="px-6 py-4 hidden xl:table-cell">{{ $user->height ?? '—' }}</td>
                                    <td class="px-6 py-4 hidden xl:table-cell">{{ $user->weight ?? '—' }}</td>
                                    <td class="px-6 py-4 hidden 2xl:table-cell">{{ $user->jersey_number ?? '—' }}</td>
                                    <td class="px-6 py-4 hidden 2xl:table-cell">{{ $user->emergency_contact ?? '—' }}</td>

                                    <!-- User Type -->
                                    <td class="px-6 py-4">
                                        @if($user->usertype === 'admin')
                                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-700">Admin</span>
                                        @else
                                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-700">User</span>
                                        @endif
                                    </td>

                                    <!-- Role -->
                                    <td class="px-6 py-4">
                                        @if($user->role === 'coach')
                                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">Coach</span>
                                        @elseif($user->role === 'referee')
                                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-700">Referee</span>
                                        @elseif($user->role === 'player')
                                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-700">Player</span>
                                        @else
                                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-700">—</span>
                                        @endif
                                    </td>

                                    <!-- Actions -->
                                    <td class="px-6 py-4 text-center">
                                        <div class="inline-flex gap-2">
                                            <a href="{{ route('admin.users.edit', $user->id) }}" 
                                               class="inline-flex items-center px-3 py-1.5 bg-blue-600 text-white text-xs font-medium rounded-md shadow-sm hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 transition">
                                                Edit
                                            </a>
                                            <a href="{{ route('admin.users.profile', $user->id) }}" 
                                               class="inline-flex items-center px-3 py-1.5 bg-indigo-600 text-white text-xs font-medium rounded-md shadow-sm hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500 transition">
                                                View
                                            </a>
                                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" 
                                                  class="inline" 
                                                  onsubmit="return confirm('Are you sure you want to delete this user?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="inline-flex items-center px-3 py-1.5 bg-red-600 text-white text-xs font-medium rounded-md shadow-sm hover:bg-red-700 focus:ring-2 focus:ring-red-500 transition">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="14" class="px-6 py-6 text-center text-gray-500 text-sm">
                                        No users found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Footer -->
            <div class="mt-6 text-sm text-gray-500 text-center">
                Showing <span class="font-semibold">{{ $users->count() }}</span> user(s)
            </div>
        </div>
    </div>
</div>
@endsection
