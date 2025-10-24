@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
<div class="py-10 bg-gray-50 min-h-screen">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-xl rounded-2xl border border-gray-100 p-8">

            <!-- Header -->
            <div class="mb-8 border-b border-gray-200 pb-4 flex justify-between items-center">
                <div>
                    <h2 class="text-3xl font-extrabold text-gray-800 tracking-tight">Edit User</h2>
                    <p class="text-sm text-gray-500">Update user information and details below.</p>
                </div>
                <a href="{{ route('admin.users.index') }}"
                   class="text-gray-600 hover:text-gray-800 text-sm font-medium flex items-center space-x-1 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                    <span>Back to Users</span>
                </a>
            </div>

            <!-- Form -->
            <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- User Info Section -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Full Name</label>
                        <input type="text" name="name" id="name"
                            value="{{ old('name', $user->name) }}"
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500">
                        @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
                        <input type="email" name="email" id="email"
                            value="{{ old('email', $user->email) }}"
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500">
                        @error('email') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">Phone Number</label>
                        <input type="text" name="phone" id="phone"
                            value="{{ old('phone', $user->phone) }}"
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500">
                        @error('phone') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="usertype" class="block text-sm font-semibold text-gray-700 mb-2">User Type</label>
                        <select name="usertype" id="usertype"
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500">
                            <option value="user" {{ old('usertype', $user->usertype) == 'user' ? 'selected' : '' }}>User</option>
                            <option value="admin" {{ old('usertype', $user->usertype) == 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                        @error('usertype') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label for="role" class="block text-sm font-semibold text-gray-700 mb-2">Role</label>
                    <select name="role" id="role"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500">
                        <option value="">Select role</option>
                        <option value="player" {{ old('role', $user->role) == 'player' ? 'selected' : '' }}>Player</option>
                        <option value="coach" {{ old('role', $user->role) == 'coach' ? 'selected' : '' }}>Coach</option>
                        <option value="referee" {{ old('role', $user->role) == 'referee' ? 'selected' : '' }}>Referee</option>
                    </select>
                    @error('role') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Player Details -->
                <div class="border-t border-gray-200 pt-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Player Details</h3>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label for="sport" class="block text-sm font-semibold text-gray-700 mb-2">Sport</label>
                            <select name="sport" id="sport"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500">
                                <option value="">Select sport</option>
                                <option value="basketball" {{ old('sport', $user->sport) == 'basketball' ? 'selected' : '' }}>Basketball</option>
                                <option value="volleyball" {{ old('sport', $user->sport) == 'volleyball' ? 'selected' : '' }}>Volleyball</option>
                            </select>
                            @error('sport') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="position" class="block text-sm font-semibold text-gray-700 mb-2">Position</label>
                            <input type="text" name="position" id="position"
                                value="{{ old('position', $user->position) }}"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500">
                            @error('position') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="dob" class="block text-sm font-semibold text-gray-700 mb-2">Date of Birth</label>
                            <input type="date" name="dob" id="dob"
                                value="{{ old('dob', $user->dob) }}"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500">
                            @error('dob') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="experience" class="block text-sm font-semibold text-gray-700 mb-2">Experience (years)</label>
                            <input type="number" name="experience" id="experience"
                                value="{{ old('experience', $user->experience) }}"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500">
                            @error('experience') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="height" class="block text-sm font-semibold text-gray-700 mb-2">Height (cm)</label>
                            <input type="number" name="height" id="height"
                                value="{{ old('height', $user->height) }}"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500">
                            @error('height') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="weight" class="block text-sm font-semibold text-gray-700 mb-2">Weight (kg)</label>
                            <input type="number" name="weight" id="weight"
                                value="{{ old('weight', $user->weight) }}"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500">
                            @error('weight') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="sm:col-span-2">
                            <label for="emergency_contact" class="block text-sm font-semibold text-gray-700 mb-2">Emergency Contact</label>
                            <input type="text" name="emergency_contact" id="emergency_contact"
                                value="{{ old('emergency_contact', $user->emergency_contact) }}"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500">
                            @error('emergency_contact') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="pt-6 flex justify-end gap-3 border-t border-gray-200">
                    <a href="{{ route('admin.users.index') }}" 
                       class="px-4 py-2.5 bg-gray-200 text-gray-700 font-medium rounded-lg hover:bg-gray-300 transition duration-150 ease-in-out">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="px-6 py-2.5 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 focus:ring-2 focus:ring-green-500 transition duration-150 ease-in-out">
                        Update User
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
