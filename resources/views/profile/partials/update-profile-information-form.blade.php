<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="md:col-span-2">
                <x-input-label for="profile_photo" :value="__('Profile Photo')" />
                <div class="flex items-center gap-4 mt-1">
                    <img id="profile_photo_preview" src="{{ $user->profile_photo_path ? asset('storage/'.$user->profile_photo_path) : '' }}" alt="Profile Photo" class="w-16 h-16 rounded-full object-cover border {{ $user->profile_photo_path ? '' : 'hidden' }}" />
                    <div id="profile_photo_placeholder" class="w-16 h-16 rounded-full bg-gray-200 flex items-center justify-center text-gray-500 {{ $user->profile_photo_path ? 'hidden' : '' }}">--</div>
                    <input id="profile_photo" name="profile_photo" type="file" accept="image/*" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50" />
                </div>
                <x-input-error class="mt-2" :messages="$errors->get('profile_photo')" />
            </div>
            <div>
                <x-input-label for="phone" :value="__('Phone')" />
                <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" :value="old('phone', $user->phone)" autocomplete="tel" />
                <x-input-error class="mt-2" :messages="$errors->get('phone')" />
            </div>
            <div>
                <x-input-label for="dob" :value="__('Date of Birth')" />
                <x-text-input id="dob" name="dob" type="date" class="mt-1 block w-full" :value="old('dob', $user->dob)" />
                <x-input-error class="mt-2" :messages="$errors->get('dob')" />
            </div>
            <div>
                <x-input-label for="sport" :value="__('Sport')" />
                <select id="sport" name="sport" class="mt-1 block w-full border-gray-300 rounded-md">
                    <option value="">-- {{ __('Select sport') }} --</option>
                    <option value="basketball" @selected(old('sport', $user->sport) === 'basketball')>{{ __('Basketball') }}</option>
                    <option value="volleyball" @selected(old('sport', $user->sport) === 'volleyball')>{{ __('Volleyball') }}</option>
                </select>
                <x-input-error class="mt-2" :messages="$errors->get('sport')" />
            </div>
            <div>
                <x-input-label for="position" :value="__('Position')" />
                <x-text-input id="position" name="position" type="text" class="mt-1 block w-full" :value="old('position', $user->position)" />
                <x-input-error class="mt-2" :messages="$errors->get('position')" />
            </div>
            <div>
                <x-input-label for="height" :value="__('Height (cm)')" />
                <x-text-input id="height" name="height" type="number" step="0.01" class="mt-1 block w-full" :value="old('height', $user->height)" />
                <x-input-error class="mt-2" :messages="$errors->get('height')" />
            </div>
            <div>
                <x-input-label for="weight" :value="__('Weight (kg)')" />
                <x-text-input id="weight" name="weight" type="number" step="0.01" class="mt-1 block w-full" :value="old('weight', $user->weight)" />
                <x-input-error class="mt-2" :messages="$errors->get('weight')" />
            </div>
            <div>
                <x-input-label for="experience" :value="__('Experience (years)')" />
                <x-text-input id="experience" name="experience" type="number" class="mt-1 block w-full" :value="old('experience', $user->experience)" />
                <x-input-error class="mt-2" :messages="$errors->get('experience')" />
            </div>
            <div>
                <x-input-label for="jersey_number" :value="__('Jersey Number')" />
                <x-text-input id="jersey_number" name="jersey_number" type="number" class="mt-1 block w-full" :value="old('jersey_number', $user->jersey_number)" />
                <x-input-error class="mt-2" :messages="$errors->get('jersey_number')" />
            </div>
            <div class="md:col-span-2">
                <x-input-label for="emergency_contact" :value="__('Emergency Contact')" />
                <x-text-input id="emergency_contact" name="emergency_contact" type="text" class="mt-1 block w-full" :value="old('emergency_contact', $user->emergency_contact)" />
                <x-input-error class="mt-2" :messages="$errors->get('emergency_contact')" />
            </div>
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
    <script>
        (function(){
            const input = document.getElementById('profile_photo');
            const img = document.getElementById('profile_photo_preview');
            const ph = document.getElementById('profile_photo_placeholder');
            if (input) {
                input.addEventListener('change', function(){
                    const file = this.files && this.files[0];
                    if (!file) return;
                    const url = URL.createObjectURL(file);
                    if (img) {
                        img.src = url;
                        img.classList.remove('hidden');
                    }
                    if (ph) ph.classList.add('hidden');
                });
            }
        })();
    </script>
</section>
