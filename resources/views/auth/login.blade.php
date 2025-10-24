<x-guest-layout>
    <div class="min-h-screen flex flex-col justify-center items-center px-4 bg-gradient-to-br from-[#2d412f] via-[#272c34] to-[#414040] text-gray-100">

        <!-- Logo + Title -->
        <div class="mb-8 text-center">
            <img src="{{ asset('images/playon-logo.png') }}" 
                 alt="PlayOn Logo" 
                 class="h-24 w-24 mx-auto rounded-full object-cover shadow-xl ring-4 ring-green-500/30">
            <h1 class="text-3xl font-extrabold text-white mt-4 tracking-tight">Welcome to <span class="text-green-400">PlayOn</span></h1>
            <p class="text-gray-300 text-sm mt-1">Sign in to access your account</p>
        </div>

        <!-- Login Card -->
        <div class="w-full max-w-lg bg-gray-900/60 backdrop-blur-lg shadow-2xl rounded-2xl p-10 border border-gray-700/40">
            
            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div class="mb-5">
                    <x-input-label for="email" :value="__('Email')" class="text-green-300" />
                    <x-text-input id="email"
                                  type="email"
                                  name="email"
                                  :value="old('email')"
                                  required
                                  autofocus
                                  autocomplete="username"
                                  class="block mt-2 w-full bg-gray-800 text-gray-100 border border-gray-600 focus:border-green-400 focus:ring-green-400 rounded-lg px-4 py-2" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-400" />
                </div>

                <!-- Password -->
                <div class="mb-5">
                    <x-input-label for="password" :value="__('Password')" class="text-green-300" />
                    <x-text-input id="password"
                                  type="password"
                                  name="password"
                                  required
                                  autocomplete="current-password"
                                  class="block mt-2 w-full bg-gray-800 text-gray-100 border border-gray-600 focus:border-green-400 focus:ring-green-400 rounded-lg px-4 py-2" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-400" />
                </div>

                <!-- Remember Me + Forgot Password -->
                <div class="flex items-center justify-between mb-6">
                    <label for="remember_me" class="flex items-center text-sm text-gray-300">
                        <input id="remember_me"
                               type="checkbox"
                               class="rounded border-gray-500 bg-gray-700 text-green-500 focus:ring-green-400"
                               name="remember">
                        <span class="ml-2">{{ __('Remember me') }}</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}"
                           class="text-sm font-medium text-green-400 hover:text-green-300 transition">
                            {{ __('Forgot password?') }}
                        </a>
                    @endif
                </div>

                <!-- Submit Button -->
                <div>
                    <button type="submit"
                            class="w-full flex justify-center items-center px-4 py-3 bg-green-600 hover:bg-green-500 rounded-lg font-semibold text-white shadow-md focus:outline-none focus:ring-4 focus:ring-green-400/50 transition duration-150 ease-in-out">
                        {{ __('Log In') }}
                    </button>
                </div>
            </form>

            <!-- Register Link -->
            <div class="mt-6 text-center">
                <p class="text-sm text-gray-300">
                    Don’t have an account?
                    <a href="{{ route('register') }}"
                       class="text-green-400 hover:text-green-300 font-medium transition">
                        Register here
                    </a>
                </p>
            </div>
        </div>

        <!-- Footer Note -->
        <p class="text-gray-400 text-xs mt-8">© {{ date('Y') }} PlayOn. All rights reserved.</p>
    </div>
</x-guest-layout>
