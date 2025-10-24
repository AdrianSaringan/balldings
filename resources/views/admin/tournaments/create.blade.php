@extends('layouts.app')

@section('title', 'Add Tournament')

@section('content')
<div class="py-10">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-md rounded-xl p-8">
            <h2 class="text-2xl font-bold mb-6 text-gray-800">Add Tournament</h2>

            <form action="{{ route('admin.tournaments.store') }}" method="POST">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block font-semibold text-gray-700 mb-2">Tournament Name</label>
                        <input type="text" name="name" class="w-full border-gray-300 rounded-lg" required>
                    </div>

                    <div>
                        <label class="block font-semibold text-gray-700 mb-2">Sport</label>
                        <select name="sport" class="w-full border-gray-300 rounded-lg" required>
                            <option value="">-- Select Sport --</option>
                            <option value="basketball">Basketball</option>
                            <option value="volleyball">Volleyball</option>
                        </select>
                    </div>

                    <div>
                        <label class="block font-semibold text-gray-700 mb-2">Start Date</label>
                        <input type="date" name="start_date" class="w-full border-gray-300 rounded-lg">
                    </div>

                    <div>
                        <label class="block font-semibold text-gray-700 mb-2">End Date</label>
                        <input type="date" name="end_date" class="w-full border-gray-300 rounded-lg">
                    </div>

                    <div>
                        <label class="block font-semibold text-gray-700 mb-2">Venue</label>
                        <input type="text" name="venue" class="w-full border-gray-300 rounded-lg">
                    </div>

                    <div>
                        <label class="block font-semibold text-gray-700 mb-2">Status</label>
                        <select name="status" class="w-full border-gray-300 rounded-lg">
                            <option value="upcoming">Upcoming</option>
                            <option value="ongoing">Ongoing</option>
                            <option value="completed">Completed</option>
                        </select>
                    </div>
                </div>

                <div class="mt-8 flex justify-end">
                    <a href="{{ route('admin.tournaments.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg mr-2">Cancel</a>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
