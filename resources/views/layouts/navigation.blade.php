<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Left Section -->
            <div class="flex items-center">
                <!-- Logo -->
                <div class="shrink-0">
                    <a href="{{ route('dashboard') }}">
                        <img src="{{ asset('images/playon-logo.png') }}" 
                             alt="PlayOn Logo" 
                             class="h-9 w-10 rounded-full object-cover border border-gray-300 shadow-sm transition-transform duration-200 hover:scale-110">
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden sm:flex sm:items-center sm:ml-10 space-x-7">
                    @auth
                        @if(Auth::user()->usertype !== 'admin')
                            <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                                {{ __('Dashboard') }}
                            </x-nav-link>
                        @else
                            <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                                {{ __('Admin Dashboard') }}
                            </x-nav-link>

                            <x-nav-link :href="route('admin.users.index')" 
                                        :active="request()->routeIs('admin.users.*')" 
                                        class="ml-4">
                                {{ __('Users') }}
                            </x-nav-link>

                            <!-- Teams Dropdown -->
                            <div x-data="{ openTeams: false }" class="relative">
                                <button @click="openTeams = !openTeams"
                                    class="inline-flex items-center py-2 text-sm font-medium text-gray-600 hover:text-gray-900 focus:outline-none">
                                    Teams
                                    <svg class="ml-2 h-4 w-4 transition-transform duration-200" 
                                         :class="{ 'rotate-180': openTeams }" xmlns="http://www.w3.org/2000/svg" fill="none" 
                                         viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>

                                <div x-show="openTeams" 
                                     @click.away="openTeams = false"
                                     x-transition
                                     class="absolute mt-1 w-48 bg-white rounded-md shadow-lg z-50">
                                    <a href="{{ route('admin.basketball.teams.index') }}"
                                       class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        🏀 Basketball Teams
                                    </a>
                                    <a href="{{ route('admin.volleyball.teams.index') }}"
                                       class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        🏐 Volleyball Teams
                                    </a>
                                </div>
                            </div>

                            <!-- Matches Dropdown -->
                            <div x-data="{ openMatches: false }" class="relative">
                                <button @click="openMatches = !openMatches"
                                    class="inline-flex items-centers py-2 text-sm font-medium text-gray-600 hover:text-gray-900 focus:outline-none">
                                    Matches
                                    <svg class="ml-2 h-4 w-4 transition-transform duration-200" 
                                         :class="{ 'rotate-180': openMatches }" xmlns="http://www.w3.org/2000/svg" fill="none" 
                                         viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>

                                <div x-show="openMatches"
                                     @click.away="openMatches = false"
                                     x-transition
                                     class="absolute mt-1 w-48 bg-white rounded-md shadow-lg z-50">
                                    <a href="{{ route('admin.basketball.matches.index') }}" 
                                       class="block px-3 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                       🏀 Basketball Matches
                                    </a>
                                    <a href="{{ route('admin.volleyball.matches.index') }}" 
                                       class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                       🏐 Volleyball Matches
                                    </a>
                                </div>
                            </div>

                            <x-nav-link :href="route('admin.games.index')" 
                                        :active="request()->routeIs('admin.games.*')" 
                                        class="ml-2">
                                🎮 Games
                            </x-nav-link>
                        @endif
                    @endauth
                </div>
            </div>

            <!-- Right Section (User Settings) -->
            <div class="hidden sm:flex sm:items-center">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="flex items-center text-sm font-medium text-gray-600 hover:text-gray-900 focus:outline-none">
                            <span>{{ Auth::user()->name }}</span>
                            <svg class="ml-1 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                      d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 
                                         111.414 1.414l-4 4a1 1 0 01-1.414 
                                         0l-4-4a1 1 0-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger (Mobile Menu Button) -->
            <div class="flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-500 hover:text-gray-700 hover:bg-gray-100 focus:outline-none">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': !open}" class="inline-flex"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': !open, 'inline-flex': open}" class="hidden"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation (Mobile) -->
    <div :class="{'block': open, 'hidden': !open}" class="hidden sm:hidden bg-white border-t border-gray-200">
        <div class="pt-2 pb-3 space-y-1">
            @auth
                @if(Auth::user()->usertype !== 'admin')
                    <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-responsive-nav-link>
                @else
                    <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                        {{ __('Admin Dashboard') }}
                    </x-responsive-nav-link>

                    <x-responsive-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')">
                        {{ __('Users') }}
                    </x-responsive-nav-link>

                    <x-responsive-nav-link :href="route('admin.basketball.teams.index')" :active="request()->routeIs('admin.basketball.*')">
                        🏀 Basketball Teams
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.volleyball.teams.index')" :active="request()->routeIs('admin.volleyball.*')">
                        🏐 Volleyball Teams
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.basketball.matches.index')" :active="request()->routeIs('admin.basketball.matches.*')">
                        🏀 Basketball Matches
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.volleyball.matches.index')" :active="request()->routeIs('admin.volleyball.matches.*')">
                        🏐 Volleyball Matches
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.games.index')" :active="request()->routeIs('admin.games.*')">
                        🎮 Games
                    </x-responsive-nav-link>
                @endif
            @endauth
        </div>

        <!-- Profile & Logout (Mobile) -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
