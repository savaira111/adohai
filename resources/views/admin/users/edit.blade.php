<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-white leading-tight">Edit User</h2>
    </x-slot>

    <div class="py-12" style="background-color: #F0E8D5; min-height: 100vh;">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-[#212844] text-white shadow-2xl rounded-2xl p-8 transition transform hover:scale-105">

                <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Name -->
                    <div>
                        <label for="name" class="block font-semibold mb-1">Name</label>
                        <input type="text" name="name" id="name" 
                               value="{{ old('name', $user->name) }}"
                               class="w-full px-4 py-2 rounded-lg text-black focus:outline-none focus:ring-2 focus:ring-white"
                               placeholder="Enter full name" required>
                        @error('name') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Username -->
                    <div>
                        <label for="username" class="block font-semibold mb-1">Username</label>
                        <input type="text" name="username" id="username" 
                               value="{{ old('username', $user->username) }}"
                               class="w-full px-4 py-2 rounded-lg text-black focus:outline-none focus:ring-2 focus:ring-white"
                               placeholder="Enter username">
                        @error('username') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block font-semibold mb-1">Email</label>
                        <input type="email" name="email" id="email" 
                               value="{{ old('email', $user->email) }}"
                               class="w-full px-4 py-2 rounded-lg text-black focus:outline-none focus:ring-2 focus:ring-white"
                               placeholder="Enter email" required>
                        @error('email') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Password -->
                    <div class="relative">
                        <label for="password" class="block font-semibold mb-1">
                            Password <span class="text-gray-300 text-sm">(Kosongkan jika tidak ingin mengubah)</span>
                        </label>

                        <input type="password" name="password" id="password"
                            class="w-full px-4 py-2 rounded-lg text-black focus:outline-none focus:ring-2 focus:ring-white"
                            placeholder="Enter new password">

                        <!-- Toggle -->
                        <button type="button" id="toggle-password"
                            class="absolute right-3 top-9 text-gray-400 hover:text-gray-200 select-none">👁</button>

                        <!-- Validation bars -->
                        <div id="strength-bars" class="flex gap-2 mt-3 opacity-0 transition duration-200">
                            <div class="h-2 w-1/5 bg-gray-600 rounded" id="bar-length"></div>
                            <div class="h-2 w-1/5 bg-gray-600 rounded" id="bar-uppercase"></div>
                            <div class="h-2 w-1/5 bg-gray-600 rounded" id="bar-lowercase"></div>
                            <div class="h-2 w-1/5 bg-gray-600 rounded" id="bar-number"></div>
                            <div class="h-2 w-1/5 bg-gray-600 rounded" id="bar-symbol"></div>
                        </div>

                        <!-- Rules -->
                        <ul id="rules-list" class="mt-2 text-xs space-y-1 opacity-0 transition duration-200">
                            <li id="rule-length" class="text-red-400 hidden">• Minimal 8 karakter</li>
                            <li id="rule-uppercase" class="text-red-400 hidden">• Huruf besar</li>
                            <li id="rule-lowercase" class="text-red-400 hidden">• Huruf kecil</li>
                            <li id="rule-number" class="text-red-400 hidden">• Angka</li>
                            <li id="rule-symbol" class="text-red-400 hidden">• Simbol</li>
                        </ul>
                    </div>

                    <!-- Buttons -->
                    <div class="flex gap-4 justify-center">
                        <button type="submit"
                                class="px-6 py-2 bg-green-600 rounded-xl text-white font-semibold hover:bg-green-700 transition shadow-md">
                            Update User
                        </button>
                        <a href="{{ route('admin.users.index') }}"
                           class="px-6 py-2 bg-gray-500 rounded-xl text-white font-semibold hover:bg-gray-600 transition shadow-md">
                            Cancel
                        </a>
                    </div>

                </form>

            </div>

        </div>
    </div>

    <script>
        const password = document.getElementById('password');
        const bars = {
            length: document.getElementById('bar-length'),
            uppercase: document.getElementById('bar-uppercase'),
            lowercase: document.getElementById('bar-lowercase'),
            number: document.getElementById('bar-number'),
            symbol: document.getElementById('bar-symbol')
        };
        const rules = {
            length: document.getElementById('rule-length'),
            uppercase: document.getElementById('rule-uppercase'),
            lowercase: document.getElementById('rule-lowercase'),
            number: document.getElementById('rule-number'),
            symbol: document.getElementById('rule-symbol')
        };

        const barsContainer = document.getElementById('strength-bars');
        const rulesList = document.getElementById('rules-list');

        password.addEventListener('input', () => {
            const val = password.value;

            if (val.length === 0) {
                barsContainer.style.opacity = 0;
                rulesList.style.opacity = 0;
                Object.values(rules).forEach(r => r.classList.add('hidden'));
                return;
            }

            barsContainer.style.opacity = 1;
            rulesList.style.opacity = 1;

            function updateRule(cond, bar, rule) {
                bar.classList.toggle('bg-green-500', cond);
                bar.classList.toggle('bg-gray-600', !cond);

                rule.classList.remove('hidden');
                rule.classList.toggle('text-green-400', cond);
                rule.classList.toggle('text-red-400', !cond);
            }

            updateRule(val.length >= 8, bars.length, rules.length);
            updateRule(/[A-Z]/.test(val), bars.uppercase, rules.uppercase);
            updateRule(/[a-z]/.test(val), bars.lowercase, rules.lowercase);
            updateRule(/[0-9]/.test(val), bars.number, rules.number);
            updateRule(/[\W_]/.test(val), bars.symbol, rules.symbol);
        });

        document.getElementById('toggle-password').addEventListener('click', () => {
            password.type = password.type === 'password' ? 'text' : 'password';
        });
    </script>
</x-app-layout>
