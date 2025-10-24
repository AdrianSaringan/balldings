@extends('layouts.app')

@section('title', 'Edit Bracket')

@section('content')
<div class="py-8">
    <div class="max-w-2xl mx-auto bg-white p-8 rounded-2xl shadow">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">Edit Bracket</h2>
        <form method="POST" action="{{ route('admin.brackets.update', $bracket->id) }}">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block mb-1 font-medium text-gray-700">Sport</label>
                <select name="sport" class="w-full border rounded p-2">
                    <option value="basketball" {{ $bracket->sport == 'basketball' ? 'selected' : '' }}>Basketball</option>
                    <option value="volleyball" {{ $bracket->sport == 'volleyball' ? 'selected' : '' }}>Volleyball</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="block mb-1 font-medium text-gray-700">Team 1</label>
                <select name="team1_id" class="w-full border rounded p-2">
                    @foreach($players as $player)
                        <option value="{{ $player->id }}" {{ $bracket->team1_id == $player->id ? 'selected' : '' }}>
                            {{ $player->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="block mb-1 font-medium text-gray-700">Team 2</label>
                <select name="team2_id" class="w-full border rounded p-2">
                    @foreach($players as $player)
                        <option value="{{ $player->id }}" {{ $bracket->team2_id == $player->id ? 'selected' : '' }}>
                            {{ $player->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="block mb-1 font-medium text-gray-700">Round</label>
                <input type="number" name="round" value="{{ $bracket->round }}" class="w-full border rounded p-2" required>
            </div>

            <div class="mb-4">
                <label class="block mb-1 font-medium text-gray-700">Status</label>
                <input type="text" name="status" value="{{ $bracket->status }}" class="w-full border rounded p-2">
            </div>

            <div class="mb-4">
                <label class="block mb-1 font-medium text-gray-700">Winner</label>
                <input type="text" name="winner" value="{{ $bracket->winner }}" class="w-full border rounded p-2">
            </div>

            <div class="flex justify-end space-x-2">
                <a href="{{ route('admin.brackets.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">Cancel</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Update</button>
            </div>
        </form>
    </div>
</div>
@endsection
