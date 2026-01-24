<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-white leading-tight">
            Add Admin
        </h2>
    </x-slot>

    <div class="py-12" style="background-color: #F0E8D5; min-height: 100vh;">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="rounded-2xl p-8 shadow-2xl" style="background-color:#212844; color:white;">

              <form action="{{ route('superadmin.users.store') }}" method="POST">
                 @csrf

                    <!-- Name -->
                    <div>
                        <label class="block font-semibold mb-1">Name</label>
                        <input type="text" name="name" value="{{ old('name') }}"
                            class="w-full px-4 py-2 rounded-lg border border-white/30 bg-[#2a3155] text-white placeholder-gray-300 focus:outline-none"
                            placeholder="Enter full name" required>
                    </div>

                    <!-- Username -->
                    <div>
                        <label class="block font-semibold mb-1">Username</label>
                        <input type="text" name="username" value="{{ old('username') }}"
                            class="w-full px-4 py-2 rounded-lg border border-white/30 bg-[#2a3155] text-white placeholder-gray-300 focus:outline-none"
                            placeholder="Enter username">
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block font-semibold mb-1">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}"
                            class="w-full px-4 py-2 rounded-lg border border-white/30 bg-[#2a3155] text-white placeholder-gray-300 focus:outline-none"
                            placeholder="Enter email" required>
                    </div>

                    <!-- Role -->
                    <div>
                        <label class="block font-semibold mb-1">Role</label>
                        <select name="role"
                            class="w-full px-4 py-2 rounded-lg border border-white/30 bg-[#2a3155] text-white focus:outline-none"
                            required>
                            <option value="user" class="text-black">User</option>
                            <option value="admin" selected class="text-black">Admin</option>
                        </select>
                    </div>

                    <!-- Password -->
                    <div class="relative">
                        <label class="block font-semibold mb-1">Password</label>
                        <input type="password" id="password"
                            class="w-full px-4 py-2 rounded-lg border border-white/30 bg-[#2a3155] text-white placeholder-gray-300 focus:outline-none"
                            placeholder="Enter password" required>

                        <!-- Toggle -->
                        <button type="button" id="togglePassword" class="absolute right-3 top-9 text-gray-300 hover:text-white">
                            <svg id="eyeOpen" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            <svg id="eyeClosed" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13.875 18.825A10.05 10.05 0 0112 19c-5.523 0-10-5-10-5s1.5-2.5 5-4.5m0 0a3 3 0 114 4M3 3l18 18"/>
                            </svg>
                        </button>

                        <!-- Bars -->
                        <div id="pwBars" class="flex gap-2 mt-3 hidden">
                            <div class="pwbar h-3 w-1/5 bg-gray-600 rounded" data-check="length"></div>
                            <div class="pwbar h-3 w-1/5 bg-gray-600 rounded" data-check="upper"></div>
                            <div class="pwbar h-3 w-1/5 bg-gray-600 rounded" data-check="lower"></div>
                            <div class="pwbar h-3 w-1/5 bg-gray-600 rounded" data-check="number"></div>
                            <div class="pwbar h-3 w-1/5 bg-gray-600 rounded" data-check="symbol"></div>
                        </div>

                        <!-- Rules -->
                        <ul id="pwRules" class="mt-2 text-xs space-y-1 hidden">
                            <li data-check="length" class="text-red-400">• Minimal 8 karakter</li>
                            <li data-check="upper" class="text-red-400">• Huruf besar</li>
                            <li data-check="lower" class="text-red-400">• Huruf kecil</li>
                            <li data-check="number" class="text-red-400">• Angka</li>
                            <li data-check="symbol" class="text-red-400">• Simbol</li>
                        </ul>
                    </div>

                    <!-- Confirm Password -->
                    <div class="relative">
                        <label class="block font-semibold mb-1">Confirm Password</label>
                        <input type="password" id="confirmPassword"
                            class="w-full px-4 py-2 rounded-lg border border-white/30 bg-[#2a3155] text-white placeholder-gray-300 focus:outline-none"
                            placeholder="Confirm password" required>

                        <button type="button" id="toggleConfirm" class="absolute right-3 top-9 text-gray-300 hover:text-white">
                            <svg id="confirmEyeOpen" class="h-5 w-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            <svg id="confirmEyeClosed" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13.875 18.825A10.05 10.05 0 0112 19c-5.523 0-10-5-10-5s1.5-2.5 5-4.5m0 0a3 3 0 114 4M3 3l18 18"/>
                            </svg>
                        </button>
                    </div>

                    <div class="flex gap-4">
                        <button type="submit" id="submitBtn"
                            class="flex-1 px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg transition disabled:opacity-50"
                            disabled>
                            Add Admin
                        </button>
                        <a href="{{ route('superadmin.users.index') }}"
                            class="flex-1 px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white font-semibold rounded-lg text-center transition">
                            Cancel
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script>
        const password = document.getElementById('password');
        const confirmPassword = document.getElementById('confirmPassword');
        const submitBtn = document.getElementById('submitBtn');
        const pwBars = document.getElementById('pwBars');
        const pwRules = document.getElementById('pwRules');

        const checks = {
            length: v => v.length >= 8,
            upper: v => /[A-Z]/.test(v),
            lower: v => /[a-z]/.test(v),
            number: v => /[0-9]/.test(v),
            symbol: v => /[\W_]/.test(v)
        };

        function updateStatus() {
            const v = password.value;

            if (v.length > 0) {
                pwBars.classList.remove('hidden');
                pwRules.classList.remove('hidden');
            } else {
                pwBars.classList.add('hidden');
                pwRules.classList.add('hidden');
            }

            document.querySelectorAll('.pwbar').forEach(bar => {
                const type = bar.dataset.check;
                const ok = checks[type](v);
                bar.classList.toggle('bg-green-500', ok);
                bar.classList.toggle('bg-gray-600', !ok);
            });

            document.querySelectorAll('#pwRules [data-check]').forEach(rule => {
                const type = rule.dataset.check;
                const ok = checks[type](v);
                rule.classList.toggle('text-green-400', ok);
                rule.classList.toggle('text-red-400', !ok);
            });

            matchConfirm();
        }

        function matchConfirm() {
            const p = password.value;
            const c = confirmPassword.value;

            if (!c.length) {
                confirmPassword.style.borderColor = 'rgba(255,255,255,0.3)';
                submitBtn.disabled = true;
                return;
            }

            const allGood = Object.values(checks).every(fn => fn(p)) && p === c;

            if (p === c) {
                confirmPassword.style.borderColor = 'lime';
                confirmPassword.style.animation = 'pop .2s';
            } else {
                confirmPassword.style.borderColor = 'red';
            }

            submitBtn.disabled = !allGood;
        }

        password.addEventListener('input', updateStatus);
        confirmPassword.addEventListener('input', matchConfirm);

        // Toggle Password
        document.getElementById('togglePassword').onclick = () => {
            password.type = password.type === 'password' ? 'text' : 'password';
            eyeOpen.classList.toggle('hidden');
            eyeClosed.classList.toggle('hidden');
        };

        // Toggle Confirm Password
        document.getElementById('toggleConfirm').onclick = () => {
            confirmPassword.type = confirmPassword.type === 'password' ? 'text' : 'password';
            confirmEyeOpen.classList.toggle('hidden');
            confirmEyeClosed.classList.toggle('hidden');
        };

        // Anim
        const style = document.createElement('style');
        style.innerHTML = `@keyframes pop {0%{transform:scale(1);}50%{transform:scale(1.05);}100%{transform:scale(1);}}`;
        document.head.appendChild(style);
    </script>
</x-app-layout>
