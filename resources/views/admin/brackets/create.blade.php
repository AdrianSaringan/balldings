@extends('layouts.app')

@section('title', 'Create Bracket')

@section('content')
<div class="py-10">
    <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">Create Bracket</h2>

        <form action="{{ route('admin.brackets.store') }}" method="POST">
            @csrf

            <!-- SPORT -->
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-1">Sport</label>
                <select name="sport" id="sport" class="w-full border p-2 rounded" required>
                    <option value="">Select Sport</option>
                    <option value="basketball">Basketball</option>
                    <option value="volleyball">Volleyball</option>
                </select>
            </div>

            <!-- BRACKET TYPE -->
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-1">Bracket Type</label>
                <select name="bracket_type" class="w-full border p-2 rounded" required>
                    <option value="upper">Upper Bracket</option>
                    <option value="lower">Lower Bracket</option>
                </select>
            </div>

            <!-- TOURNAMENT NAME -->
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-1">Tournament Name (optional)</label>
                <input type="text" name="tournament_name" class="w-full border p-2 rounded" placeholder="e.g. Summer Cup 2025">
            </div>

            <!-- TEAM 1 -->
            <div class="mb-4 basketball-teams hidden">
                <label class="block text-gray-700 font-medium mb-1">Basketball - Team 1</label>
                <select name="team1_id_basketball" class="w-full border p-2 rounded">
                    <option value="">Select Team 1</option>
                    @foreach($basketballTeams as $team)
                        <option value="{{ $team->id }}">{{ $team->team_name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4 volleyball-teams hidden">
                <label class="block text-gray-700 font-medium mb-1">Volleyball - Team 1</label>
                <select name="team1_id_volleyball" class="w-full border p-2 rounded">
                    <option value="">Select Team 1</option>
                    @foreach($volleyballTeams as $team)
                        <option value="{{ $team->id }}">{{ $team->team_name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- TEAM 2 -->
            <div class="mb-4 basketball-teams hidden">
                <label class="block text-gray-700 font-medium mb-1">Basketball - Team 2</label>
                <select name="team2_id_basketball" class="w-full border p-2 rounded">
                    <option value="">Select Team 2</option>
                    @foreach($basketballTeams as $team)
                        <option value="{{ $team->id }}">{{ $team->team_name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4 volleyball-teams hidden">
                <label class="block text-gray-700 font-medium mb-1">Volleyball - Team 2</label>
                <select name="team2_id_volleyball" class="w-full border p-2 rounded">
                    <option value="">Select Team 2</option>
                    @foreach($volleyballTeams as $team)
                        <option value="{{ $team->id }}">{{ $team->team_name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- ROUND -->
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-1">Round</label>
                <input type="number" name="round" class="w-full border p-2 rounded" min="1" required>
            </div>

            <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-lg">
                Save Bracket
            </button>
        </form>
    </div>
</div>

<script>
    const sportSelect = document.getElementById('sport');
    const basketballTeams = document.querySelectorAll('.basketball-teams');
    const volleyballTeams = document.querySelectorAll('.volleyball-teams');

    sportSelect.addEventListener('change', function() {
        if (this.value === 'basketball') {
            basketballTeams.forEach(el => el.classList.remove('hidden'));
            volleyballTeams.forEach(el => el.classList.add('hidden'));
        } else if (this.value === 'volleyball') {
            volleyballTeams.forEach(el => el.classList.remove('hidden'));
            basketballTeams.forEach(el => el.classList.add('hidden'));
        } else {
            basketballTeams.forEach(el => el.classList.add('hidden'));
            volleyballTeams.forEach(el => el.classList.add('hidden'));
        }
    });
</script>
@endsection
