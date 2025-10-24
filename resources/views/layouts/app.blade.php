<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'PlayOn') }}</title>

    <!-- ✅ Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

    <!-- ✅ Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- ✅ Tailwind & Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gray-100 text-gray-800">
    <div class="min-h-screen flex">

        <!-- ✅ SIDEBAR -->
        <aside 
            x-data="{ 
                openTeams: {{ request()->routeIs('admin.basketball.teams.*') || request()->routeIs('admin.volleyball.teams.*') ? 'true' : 'false' }},
                openMatches: {{ request()->routeIs('admin.basketball.matches.*') || request()->routeIs('admin.volleyball.matches.*') ? 'true' : 'false' }},
                openTournament: {{ request()->routeIs('admin.tournaments.*') ? 'true' : 'false' }}
            }" 
            class="hidden md:flex flex-col w-64 bg-gradient-to-b from-green-700 to-gray-900 text-white shadow-lg fixed inset-y-0"
        >
            <!-- Logo -->
            <div class="flex items-center justify-center py-6 border-b border-green-800">
                <img src="{{ asset('images/playon-logo.png') }}" alt="PlayOn" class="h-12 w-12 rounded-full mr-2">
                <h1 class="text-xl font-bold">PlayOn</h1>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 p-4 space-y-1 text-sm overflow-y-auto">
                @auth
                    @if(Auth::user()->usertype === 'admin')
                        <!-- ✅ Admin Links -->
                        <a href="{{ route('dashboard') }}" 
                           class="flex items-center px-4 py-2 rounded-lg transition {{ request()->routeIs('dashboard') ? 'bg-green-600' : 'hover:bg-green-600' }}">
                            Dashboard
                        </a>

                        <a href="{{ route('admin.users.index') }}" 
                           class="flex items-center px-4 py-2 rounded-lg transition {{ request()->routeIs('admin.users.*') ? 'bg-green-600' : 'hover:bg-green-600' }}">
                            User Management
                        </a>

                        <!-- ✅ Teams Dropdown -->
                        <div class="relative">
                            <button @click="openTeams = !openTeams" 
                                    class="w-full flex justify-between items-center px-4 py-2 rounded-lg hover:bg-green-600 transition">
                                Teams
                                <svg class="w-4 h-4 transform transition-transform duration-200" 
                                    :class="{ 'rotate-180': openTeams }" xmlns="http://www.w3.org/2000/svg" fill="none" 
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div x-show="openTeams" x-transition class="mt-1 ml-6 space-y-1">
                                <a href="{{ route('admin.basketball.teams.index') }}" 
                                   class="block px-3 py-2 rounded-lg transition {{ request()->routeIs('admin.basketball.teams.*') ? 'bg-green-600' : 'hover:bg-green-600' }}">
                                    Basketball
                                </a>
                                <a href="{{ route('admin.volleyball.teams.index') }}" 
                                   class="block px-3 py-2 rounded-lg transition {{ request()->routeIs('admin.volleyball.teams.*') ? 'bg-green-600' : 'hover:bg-green-600' }}">
                                    Volleyball
                                </a>
                            </div>
                        </div>

                        <!-- ✅ Matches Dropdown -->
                        <div class="relative">
                            <button @click="openMatches = !openMatches" 
                                    class="w-full flex justify-between items-center px-4 py-2 rounded-lg hover:bg-green-600 transition">
                                Matches
                                <svg class="w-4 h-4 transform transition-transform duration-200" 
                                    :class="{ 'rotate-180': openMatches }" xmlns="http://www.w3.org/2000/svg" fill="none" 
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div x-show="openMatches" x-transition class="mt-1 ml-6 space-y-1">
                                <a href="{{ route('admin.basketball.matches.index') }}" 
                                   class="block px-3 py-2 rounded-lg transition {{ request()->routeIs('admin.basketball.matches.*') ? 'bg-green-600' : 'hover:bg-green-600' }}">
                                    Basketball
                                </a>
                                <a href="{{ route('admin.volleyball.matches.index') }}" 
                                   class="block px-3 py-2 rounded-lg transition {{ request()->routeIs('admin.volleyball.matches.*') ? 'bg-green-600' : 'hover:bg-green-600' }}">
                                    Volleyball
                                </a>
                            </div>
                        </div>

                        <!-- ✅ Games -->
                        <a href="{{ route('admin.games.index') }}" 
                           class="flex items-center px-4 py-2 rounded-lg transition {{ request()->routeIs('admin.games.*') ? 'bg-green-600' : 'hover:bg-green-600' }}">
                            Games
                        </a>

                        <!-- ✅ Tournament -->
                        <a href="{{ route('admin.tournaments.index') }}" 
                           class="flex items-center px-4 py-2 rounded-lg transition {{ request()->routeIs('admin.tournaments.*') ? 'bg-green-600' : 'hover:bg-green-600' }}">
                            Tournament
                        </a>

                        <a href="{{ route('admin.brackets.index') }}" 
                           class="flex items-center px-4 py-2 rounded-lg transition {{ request()->routeIs('admin.brackets.*') ? 'bg-green-600' : 'hover:bg-green-600' }}">
                            Bracket
                        </a>
                    @else
                        <!-- ✅ Regular User Links -->
                        <a href="{{ route('dashboard') }}" 
                           class="flex items-center px-4 py-2 rounded-lg transition {{ request()->routeIs('dashboard') ? 'bg-green-600' : 'hover:bg-green-600' }}">
                            Dashboard
                        </a>

                        <a href="{{ route('user.teams') }}"
                           class="flex items-center px-4 py-2 rounded-lg transition {{ request()->routeIs('user.teams') ? 'bg-green-600' : 'hover:bg-green-600' }}">
                            View Teams
                        </a>

                        <a href="{{ route('user.matches') }}"
                           class="flex items-center px-4 py-2 rounded-lg transition {{ request()->routeIs('user.matches') ? 'bg-green-600' : 'hover:bg-green-600' }}">
                            View Matches
                        </a>

                        <a href="{{ route('user.brackets') }}"
                           class="flex items-center px-4 py-2 rounded-lg transition {{ request()->routeIs('user.brackets') ? 'bg-green-600' : 'hover:bg-green-600' }}">
                            View Brackets
                        </a>

                        <a href="{{ route('games.public.index') }}"
                           class="flex items-center px-4 py-2 rounded-lg transition {{ request()->routeIs('games.public.*') ? 'bg-green-600' : 'hover:bg-green-600' }}">
                            View Games
                        </a>

                        <!-- 🔔 Notifications -->
                        <a href="{{ route('notifications.index') }}"
                           class="flex items-center justify-between px-4 py-2 rounded-lg transition {{ request()->routeIs('notifications.index') ? 'bg-green-600' : 'hover:bg-green-600' }}">
                            <span>Notifications</span>
                            @php($unread = \Illuminate\Support\Facades\Schema::hasTable('notifications') ? auth()->user()->unreadNotifications()->count() : 0)
                            @if($unread > 0)
                                <span class="ml-3 inline-flex items-center justify-center text-xs font-semibold bg-red-500 text-white rounded-full h-5 min-w-[1.25rem] px-2">
                                    {{ $unread }}
                                </span>
                            @endif
                        </a>
                    @endif

                    <!-- ✅ Shared Links (both) -->
                    <a href="{{ route('profile.edit') }}" 
                       class="flex items-center px-4 py-2 rounded-lg transition {{ request()->routeIs('profile.edit') ? 'bg-green-600' : 'hover:bg-green-600' }}">
                        Profile
                    </a>
                @endauth
            </nav>
            @auth
            <!-- Logout anchored at bottom -->
            <div class="mt-auto p-4">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" 
                            class="w-full text-left px-4 py-2 rounded-lg bg-gray-600 text-white hover:bg-red-700 transition">
                        Logout
                    </button>
                </form>
            </div>
            @endauth
        </aside>

        <!-- ✅ MAIN CONTENT AREA -->
        <div class="flex-1 md:ml-64 flex flex-col">
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <main class="flex-1 p-6">
                @yield('content')
            </main>

            <footer class="bg-white border-t mt-auto">
                <div class="max-w-7xl mx-auto py-4 px-4 text-sm text-gray-500 text-center">
                    &copy; {{ date('Y') }} PlayOn. All rights reserved.
                </div>
            </footer>
        </div>
    </div>

    <!-- ✅ AlpineJS -->
    <script src="//unpkg.com/alpinejs" defer></script>
</body>
</html>
