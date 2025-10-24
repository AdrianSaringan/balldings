<x-guest-layout>
    <div class="min-h-screen flex flex-col items-center justify-center px-6 py-12 bg-gradient-to-br from-[#2d412f] via-[#272c34] to-[#414040]">
        
        <!-- Header -->
        <div class="text-center mb-10">
            <img src="{{ asset('images/playon-logo.png') }}" 
                alt="PlayOn Logo" 
                class="h-24 w-24 mx-auto rounded-full object-cover shadow-xl ring-4 ring-gray-300/20">
            <h1 class="text-3xl font-extrabold text-white mt-4 tracking-tight">Join <span class="text-green-400">PlayOn</span></h1>
            <p class="text-gray-300 text-sm">Register as a Player, Coach, or Referee to participate</p>
        </div>

        <!-- Container -->
        <div class="w-full max-w-5xl bg-gray-900/60 backdrop-blur-xl rounded-2xl shadow-2xl p-10 border border-gray-700/40">
            
            <!-- Tabs -->
            <div class="flex space-x-2 mb-8 bg-gray-800 rounded-full p-1">
                <button id="tab-player" class="flex-1 py-2 font-semibold text-gray-300 hover:text-white hover:bg-gray-700 rounded-full transition-all duration-200">Player</button>
                <button id="tab-coach" class="flex-1 py-2 font-semibold text-gray-300 hover:text-white hover:bg-gray-700 rounded-full transition-all duration-200">Coach</button>
                <button id="tab-referee" class="flex-1 py-2 font-semibold text-gray-300 hover:text-white hover:bg-gray-700 rounded-full transition-all duration-200">Referee</button>
            </div>

            <!-- PLAYER FORM -->
            <div id="form-player" class="bg-white/10 backdrop-blur-sm rounded-2xl p-8 shadow-md">
                <h2 class="text-lg font-bold text-green-300 mb-2">Player Registration</h2>
                <p class="text-gray-300 text-sm mb-6">Join as a player to compete in basketball or volleyball tournaments.</p>

                <form action="{{ route('register') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                    @csrf
                    <input type="hidden" name="role" value="player">

                    <!-- Verification Upload -->
                    <div>
                        <label class="block text-sm font-medium text-gray-200">Full Name</label>
                        <input type="text" name="name" class="mt-1 w-full rounded-lg border-gray-600 bg-gray-800 text-white focus:ring-green-400 focus:border-green-400" placeholder="Enter full name" required>
                    </div>

                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-200">Email</label>
                            <input type="email" name="email" class="mt-1 w-full rounded-lg border-gray-600 bg-gray-800 text-white focus:ring-green-400 focus:border-green-400" placeholder="Enter email" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-200">Phone</label>
                            <input type="text" name="phone" class="mt-1 w-full rounded-lg border-gray-600 bg-gray-800 text-white" placeholder="Enter phone number">
                        </div>
                    </div>

                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-200">Password</label>
                            <input type="password" name="password" class="mt-1 w-full rounded-lg border-gray-600 bg-gray-800 text-white" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-200">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="mt-1 w-full rounded-lg border-gray-600 bg-gray-800 text-white" required>
                        </div>
                    </div>

                    <div class="grid md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-200">Sport</label>
                            <select id="sport" name="sport" class="mt-1 w-full rounded-lg border-gray-600 bg-gray-800 text-white" required>
                                <option value="">Select sport</option>
                                <option value="basketball">Basketball</option>
                                <option value="volleyball">Volleyball</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-200">Position</label>
                            <select id="position" name="position" class="mt-1 w-full rounded-lg border-gray-600 bg-gray-800 text-white" required>
                                <option value="">Select position</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-200">Coach</label>
                            <select id="coach_user_id" name="coach_user_id" class="mt-1 w-full rounded-lg border-gray-600 bg-gray-800 text-white" required>
                                <option value="">Select coach</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-200">Jersey Number</label>
                            <input type="number" name="jersey_number" class="mt-1 w-full rounded-lg border-gray-600 bg-gray-800 text-white" placeholder="Enter number">
                        </div>
                    </div>

                    <div class="grid md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-200">Date of Birth</label>
                            <input type="date" name="dob" max="{{ date('Y-m-d') }}" class="w-full border-gray-600 bg-gray-800 text-white rounded-lg" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-200">Height (cm)</label>
                            <input type="number" name="height" class="mt-1 w-full rounded-lg border-gray-600 bg-gray-800 text-white" placeholder="Height">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-200">Weight (kg)</label>
                            <input type="number" name="weight" class="mt-1 w-full rounded-lg border-gray-600 bg-gray-800 text-white" placeholder="Weight">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-200">Playing Experience (Years)</label>
                        <input type="number" name="experience" class="mt-1 w-full rounded-lg border-gray-600 bg-gray-800 text-white" placeholder="Years of experience">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-200">Emergency Contact</label>
                        <input type="text" name="emergency_contact" class="mt-1 w-full rounded-lg border-gray-600 bg-gray-800 text-white" placeholder="Contact name & number">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-200">Upload Verification Image <span class="text-red-500">*</span></label>
                        <input type="file" name="verification_image" accept="image/*" required 
                        class="mt-1 w-full rounded-lg border-gray-600 bg-gray-800 text-white file:mr-3 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-green-600 file:text-white hover:file:bg-green-500">
                    </div>
                    <button type="submit" class="w-full bg-green-600 hover:bg-green-500 text-white py-3 rounded-lg font-semibold shadow-md transition duration-150">
                        Register as Player
                    </button>
                </form>
            </div>

            <!-- COACH FORM -->
            <div id="form-coach" class="hidden bg-white/10 backdrop-blur-sm rounded-2xl p-8 shadow-md">
                <h2 class="text-lg font-bold text-green-300 mb-2">Coach Registration</h2>
                <p class="text-gray-300 text-sm mb-6">Register as a coach to manage your team and guide players.</p>

                <form action="{{ route('register') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                    @csrf
                    <input type="hidden" name="role" value="coach">

                    <!-- Verification Upload -->
                    <div>
                        <label class="block text-sm font-medium text-gray-200">Full Name</label>
                        <input type="text" name="name" class="mt-1 w-full rounded-lg border-gray-600 bg-gray-800 text-white" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-200">Email</label>
                        <input type="email" name="email" class="mt-1 w-full rounded-lg border-gray-600 bg-gray-800 text-white" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-200">Date of Birth</label>
                        <input type="date" name="dob" max="{{ date('Y-m-d') }}" class="w-full border-gray-600 bg-gray-800 text-white rounded-lg" required>
                    </div>
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-200">Password</label>
                            <input type="password" name="password" class="mt-1 w-full rounded-lg border-gray-600 bg-gray-800 text-white" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-200">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="mt-1 w-full rounded-lg border-gray-600 bg-gray-800 text-white" required>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-200">Team Name</label>
                        <input type="text" name="team_name" class="mt-1 w-full rounded-lg border-gray-600 bg-gray-800 text-white">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-200">Sport</label>
                        <select name="sport" class="mt-1 w-full rounded-lg border-gray-600 bg-gray-800 text-white" required>
                            <option value="">Select sport</option>
                            <option value="basketball">Basketball</option>
                            <option value="volleyball">Volleyball</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-200">Upload Verification Image <span class="text-red-500">*</span></label>
                        <input type="file" name="verification_image" accept="image/*" required 
                        class="mt-1 w-full rounded-lg border-gray-600 bg-gray-800 text-white file:mr-3 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-green-600 file:text-white hover:file:bg-green-500">
                    </div>
                    <button type="submit" class="w-full bg-green-600 hover:bg-green-500 text-white py-3 rounded-lg font-semibold shadow-md transition duration-150">
                        Register as Coach
                    </button>
                </form>
            </div>

            <!-- REFEREE FORM -->
            <div id="form-referee" class="hidden bg-white/10 backdrop-blur-sm rounded-2xl p-8 shadow-md">
                <h2 class="text-lg font-bold text-green-300 mb-2">Referee Registration</h2>
                <p class="text-gray-300 text-sm mb-6">Sign up as a referee to officiate matches fairly.</p>

                <form action="{{ route('register') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                    @csrf
                    <input type="hidden" name="role" value="referee">

                    <!-- Verification Upload -->
                    <div>
                        <label class="block text-sm font-medium text-gray-200">Full Name</label>
                        <input type="text" name="name" class="mt-1 w-full rounded-lg border-gray-600 bg-gray-800 text-white" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-200">Email</label>
                        <input type="email" name="email" class="mt-1 w-full rounded-lg border-gray-600 bg-gray-800 text-white" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-200">Date of Birth</label>
                        <input type="date" name="dob" max="{{ date('Y-m-d') }}" class="w-full border-gray-600 bg-gray-800 text-white rounded-lg" required>
                    </div>
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-200">Password</label>
                            <input type="password" name="password" class="mt-1 w-full rounded-lg border-gray-600 bg-gray-800 text-white" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-200">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="mt-1 w-full rounded-lg border-gray-600 bg-gray-800 text-white" required>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-200">Sport</label>
                        <select name="sport" class="mt-1 w-full rounded-lg border-gray-600 bg-gray-800 text-white" required>
                            <option value="">Select sport</option>
                            <option value="basketball">Basketball</option>
                            <option value="volleyball">Volleyball</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-200">Upload Verification Image <span class="text-red-500">*</span></label>
                        <input type="file" name="verification_image" accept="image/*" required 
                        class="mt-1 w-full rounded-lg border-gray-600 bg-gray-800 text-white file:mr-3 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-green-600 file:text-white hover:file:bg-green-500">
                    </div>
                    <button type="submit" class="w-full bg-green-600 hover:bg-green-500 text-white py-3 rounded-lg font-semibold shadow-md transition duration-150">
                        Register as Referee
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        const tabs = {
            player: document.getElementById('tab-player'),
            coach: document.getElementById('tab-coach'),
            referee: document.getElementById('tab-referee'),
        };
        const forms = {
            player: document.getElementById('form-player'),
            coach: document.getElementById('form-coach'),
            referee: document.getElementById('form-referee'),
        };

        Object.keys(tabs).forEach(role => {
            tabs[role].addEventListener('click', () => {
                Object.values(tabs).forEach(tab => tab.classList.remove('bg-green-500', 'text-white'));
                Object.values(forms).forEach(form => form.classList.add('hidden'));

                tabs[role].classList.add('bg-green-500', 'text-white');
                forms[role].classList.remove('hidden');
            });
        });

        document.addEventListener('DOMContentLoaded', () => {
            const sportSelect = document.getElementById('sport');
            const positionSelect = document.getElementById('position');
            const coachSelect = document.getElementById('coach_user_id');
            const positions = {
                basketball: ['Forward', 'Guard', 'Center'],
                volleyball: ['Setter', 'Libero', 'Spiker', 'Blocker']
            };
            const coachData = {
                basketball: @json($basketballCoaches ?? []),
                volleyball: @json($volleyballCoaches ?? []),
            };

            function populatePositions(sport){
                positionSelect.innerHTML = '<option value="">Select position</option>';
                if (positions[sport]) {
                    positions[sport].forEach(pos => {
                        const option = document.createElement('option');
                        option.value = pos.toLowerCase();
                        option.textContent = pos;
                        positionSelect.appendChild(option);
                    });
                }
            }

            function populateCoaches(sport){
                coachSelect.innerHTML = '<option value="">Select coach</option>';
                (coachData[sport] || []).forEach(c => {
                    const opt = document.createElement('option');
                    opt.value = c.id;
                    opt.textContent = c.name;
                    coachSelect.appendChild(opt);
                });
                coachSelect.disabled = !(coachData[sport] && coachData[sport].length);
            }

            sportSelect.addEventListener('change', function () {
                const sport = this.value;
                populatePositions(sport);
                populateCoaches(sport);
            });

            // Initial state
            populateCoaches(sportSelect.value);
        });
    </script>
</x-guest-layout>
