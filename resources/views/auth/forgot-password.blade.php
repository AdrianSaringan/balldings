<x-guest-layout>
    <div class="min-h-[60vh] flex items-center justify-center px-4">
        <div class="w-full max-w-md bg-white/80 backdrop-blur border border-gray-200 rounded-2xl shadow-xl p-8">
            <div class="flex items-center gap-3 mb-2">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-6 w-6 text-indigo-600">
                    <path fill-rule="evenodd" d="M12 1.5a5.25 5.25 0 00-5.25 5.25v2.25H6A2.25 2.25 0 003.75 11.25v8.25A2.25 2.25 0 006 21.75h12a2.25 2.25 0 002.25-2.25v-8.25A2.25 2.25 0 0018 9H17.25V6.75A5.25 5.25 0 0012 1.5zm-3.75 5.25A3.75 3.75 0 0112 3a3.75 3.75 0 013.75 3.75V9H8.25V6.75z" clip-rule="evenodd" />
                </svg>
                <h1 class="text-xl font-semibold text-gray-900">{{ __('Forgot your password?') }}</h1>
            </div>
            <p class="text-sm text-gray-600 mb-6">
                {{ __('Enter the email associated with your account and we\'ll send you a link to reset your password.') }}
            </p>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
                @csrf

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email address')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus placeholder="you@example.com" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div>
                    <x-primary-button class="w-full justify-center">
                        {{ __('Send reset link') }}
                    </x-primary-button>
                </div>
            </form>

            <div class="mt-6 text-center">
                <a href="{{ route('login') }}" class="text-sm text-gray-600 hover:text-gray-900 transition">
                    {{ __('Back to sign in') }}
                </a>
            </div>
        </div>
    </div>
</x-guest-layout>
