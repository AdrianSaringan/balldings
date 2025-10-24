@extends('layouts.app')

@section('title', 'Add New User')

@section('content')
<div class="py-10">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-xl rounded-2xl p-10">
            <h2 class="text-3xl font-bold text-gray-800 mb-8 border-b pb-4">Add New User</h2>

            {{-- ✅ Success/Error Alert --}}
            @if ($errors->any())
                <div class="bg-red-100 text-red-700 p-4 rounded-xl mb-6">
                    <ul class="list-disc ml-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- FORM --}}
            <form action="{{ route('admin.users.store') }}" method="POST" id="userForm">
                @csrf

                {{-- 🧍 PERSONAL INFO --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
                    <div>
                        <label for="name" class="block font-semibold text-gray-700 mb-2">Full Name <span class="text-red-500">*</span></label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required
                               class="w-full border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="email" class="block font-semibold text-gray-700 mb-2">Email Address <span class="text-red-500">*</span></label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required
                               class="w-full border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="phone" class="block font-semibold text-gray-700 mb-2">Phone Number</label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone') }}"
                               class="w-full border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="dob" class="block font-semibold text-gray-700 mb-2">Date of Birth</label>
                        <input type="date" name="dob" id="dob" value="{{ old('dob') }}"
                               class="w-full border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                {{-- 🏐 SPORT DETAILS (Player Only) --}}
                <div id="sportFields" class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
                    <div>
                        <label for="sport" class="block font-semibold text-gray-700 mb-2">Sport</label>
                        <select name="sport" id="sport"
                                class="w-full border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500">
                            <option value="">Select Sport</option>
                            <option value="basketball" {{ old('sport') == 'basketball' ? 'selected' : '' }}>Basketball</option>
                            <option value="volleyball" {{ old('sport') == 'volleyball' ? 'selected' : '' }}>Volleyball</option>
                        </select>
                    </div>

                    <div>
                        <label for="position" class="block font-semibold text-gray-700 mb-2">Position</label>
                        <input type="text" name="position" id="position" value="{{ old('position') }}"
                               class="w-full border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500" placeholder="e.g. Setter, Point Guard">
                    </div>

                    <div>
                        <label for="height" class="block font-semibold text-gray-700 mb-2">Height (cm)</label>
                        <input type="number" name="height" id="height" step="0.1" value="{{ old('height') }}"
                               class="w-full border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="weight" class="block font-semibold text-gray-700 mb-2">Weight (kg)</label>
                        <input type="number" name="weight" id="weight" step="0.1" value="{{ old('weight') }}"
                               class="w-full border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div class="md:col-span-2">
                        <label for="experience" class="block font-semibold text-gray-700 mb-2">Experience</label>
                        <textarea name="experience" id="experience" rows="3"
                                  class="w-full border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500"
                                  placeholder="Describe your experience...">{{ old('experience') }}</textarea>
                    </div>

                    <div class="md:col-span-2">
                        <label for="emergency_contact" class="block font-semibold text-gray-700 mb-2">Emergency Contact</label>
                        <input type="text" name="emergency_contact" id="emergency_contact" value="{{ old('emergency_contact') }}"
                               class="w-full border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500" placeholder="e.g. Name - 09xxxxxxxxx">
                    </div>

                    <div>
                        <label for="jersey_number" class="block font-semibold text-gray-700 mb-2">Jersey Number</label>
                        <input type="number" name="jersey_number" id="jersey_number" value="{{ old('jersey_number') }}"
                               class="w-full border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                {{-- 👤 ACCOUNT DETAILS --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
                    <div>
                        <label for="usertype" class="block font-semibold text-gray-700 mb-2">Role <span class="text-red-500">*</span></label>
                        <select name="usertype" id="usertype" required
                                class="w-full border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500">
                            <option value="">Select Type</option>
                            <option value="player" {{ old('usertype') == 'player' ? 'selected' : '' }}>Player</option>
                            <option value="coach" {{ old('usertype') == 'coach' ? 'selected' : '' }}>Coach</option>
                            <option value="referee" {{ old('usertype') == 'referee' ? 'selected' : '' }}>Referee</option>
                        </select>
                    </div>

                    <div>
                    <label class="block text-sm font-medium text-gray-700">Sport</label>
                    <select name="sport" class="mt-1 w-full rounded-lg border-gray-300" required>
                        <option value="">Select sport</option>
                        <option value="basketball">Basketball</option>
                        <option value="volleyball">Volleyball</option>
                    </select>
                    </div>

                    <div>
                        <label for="password" class="block font-semibold text-gray-700 mb-2">Password <span class="text-red-500">*</span></label>
                        <input type="password" name="password" id="password" required
                               class="w-full border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500" placeholder="Enter password">
                    </div>

                    <div>
                        <label for="password_confirmation" class="block font-semibold text-gray-700 mb-2">Confirm Password <span class="text-red-500">*</span></label>
                        <input type="password" name="password_confirmation" id="password_confirmation" required
                               class="w-full border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500" placeholder="Confirm password">
                    </div>
                </div>

                {{-- BUTTONS --}}
                <div class="flex justify-end space-x-4 mt-8">
                    <a href="{{ route('admin.users.index') }}"
                       class="bg-gray-200 text-gray-800 px-5 py-2 rounded-xl font-semibold hover:bg-gray-300 transition">
                        Cancel
                    </a>
                    <button type="submit"
                            class="bg-blue-600 text-white px-6 py-2 rounded-xl font-semibold hover:bg-blue-700 transition">
                        Add User
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- SCRIPT: Toggle sport fields based on usertype --}}
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const usertypeSelect = document.getElementById('usertype');
        const sportFields = document.getElementById('sportFields');

        function toggleFields() {
            const type = usertypeSelect.value;
            sportFields.style.display = (type === 'coach' || type === 'referee') ? 'none' : 'grid';
        }

        usertypeSelect.addEventListener('change', toggleFields);
        toggleFields();
    });
</script>
@endsection
