<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-white leading-tight">
            Tambah User
        </h2>
    </x-slot>

    <div class="py-12" style="background-color: #F0E8D5; min-height: 100vh;">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="rounded-2xl p-8" style="background-color:#212844; color:white;">

            <h2 class="text-2xl font-bold text-center mb-6">
                            Buat Pengguna
                        </h2>

                @if ($errors->any())
                <div class="mb-4 p-4 bg-red-600 text-white rounded">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form action="{{ route('superadmin.users.store') }}" method="POST">
                    @csrf

                    <!-- Name -->
                    <div class="mb-4">
                        <label class="block font-semibold mb-1">Nama</label>
                        <input type="text" name="name" value="{{ old('name') }}"
                            class="w-full px-4 py-2 rounded-lg border border-white/30 bg-[#2a3155] text-white"
                            placeholder="Masukkan nama lengkap" required>
                    </div>

                    <!-- Username -->
                    <div class="mb-4">
                        <label class="block font-semibold mb-1">Username</label>
                        <input type="text" name="username" value="{{ old('username') }}"
                            class="w-full px-4 py-2 rounded-lg border border-white/30 bg-[#2a3155] text-white"
                            placeholder="Masukkan username">
                    </div>

                    <!-- Email -->
                    <div class="mb-4">
                        <label class="block font-semibold mb-1">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}"
                            class="w-full px-4 py-2 rounded-lg border border-white/30 bg-[#2a3155] text-white"
                            placeholder="Masukkan email" required>
                    </div>

                    <!-- Role -->
                    <div class="mb-4">
                        <label class="block font-semibold mb-1">Peran</label>
                        <select name="role"
                            class="w-full px-4 py-2 rounded-lg border border-white/30 bg-[#2a3155] text-white"
                            required>
                            <option value="user" class="text-black">User</option>
                            <option value="admin" selected class="text-black">Admin</option>
                        </select>
                    </div>

                    <!-- Password -->
                    <div class="relative mb-4">
                        <label class="block font-semibold mb-1">Password</label>
                        <input type="password" id="password" name="password"
                            class="w-full px-4 py-2 rounded-lg border border-white/30 bg-[#2a3155] text-white"
                            placeholder="Masukkan password" required>

                        <button type="button" id="togglePassword"
                            class="absolute right-3 top-9 text-gray-300 hover:text-white">
                            <span id="eyeOpen" class="hidden">👁</span>
                            <span id="eyeClosed">🙈</span>
                        </button>

                        <div id="pwBars" class="flex gap-2 mt-3 hidden">
                            <div class="pwbar h-2 flex-1 bg-gray-600 rounded" data-check="length"></div>
                            <div class="pwbar h-2 flex-1 bg-gray-600 rounded" data-check="upper"></div>
                            <div class="pwbar h-2 flex-1 bg-gray-600 rounded" data-check="lower"></div>
                            <div class="pwbar h-2 flex-1 bg-gray-600 rounded" data-check="number"></div>
                            <div class="pwbar h-2 flex-1 bg-gray-600 rounded" data-check="symbol"></div>
                        </div>

                        <!-- RULES PUTIH (HIDE JIKA SUDAH VALID) -->
                        <ul id="pwRules" class="mt-2 text-xs space-y-1 text-white hidden">
                            <li data-check="length">• Minimal 8 karakter</li>
                            <li data-check="upper">• Mengandung huruf besar</li>
                            <li data-check="lower">• Mengandung huruf kecil</li>
                            <li data-check="number">• Mengandung angka</li>
                            <li data-check="symbol">• Mengandung simbol</li>
                        </ul>
                    </div>

                    <!-- Confirm Password -->
                    <div class="relative mb-6">
                        <label class="block font-semibold mb-1">Konfirmasi Password</label>
                        <input type="password" id="confirmPassword" name="password_confirmation"
                            class="w-full px-4 py-2 rounded-lg border border-white/30 bg-[#2a3155] text-white"
                            placeholder="Ulangi password" required>

                        <button type="button" id="toggleConfirm"
                            class="absolute right-3 top-9 text-gray-300 hover:text-white">
                            <span id="confirmEyeOpen" class="hidden">👁</span>
                            <span id="confirmEyeClosed">🙈</span>
                        </button>
                    </div>

                    <button type="submit" id="submitBtn"
                        class="w-full px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg disabled:opacity-50"
                        disabled>
                        Tambah Admin
                    </button>
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

            pwBars.classList.toggle('hidden', !v);
            pwRules.classList.toggle('hidden', !v);

            document.querySelectorAll('.pwbar').forEach(bar => {
                bar.classList.toggle('bg-green-500', checks[bar.dataset.check](v));
                bar.classList.toggle('bg-gray-600', !checks[bar.dataset.check](v));
            });

            document.querySelectorAll('#pwRules [data-check]').forEach(rule => {
                rule.classList.toggle('hidden', checks[rule.dataset.check](v));
            });

            matchConfirm();
        }

        function matchConfirm() {
            const match = password.value === confirmPassword.value && confirmPassword.value;
            confirmPassword.style.borderColor = match ? 'lime' : confirmPassword.value ? 'red' : '';
            submitBtn.disabled = !(match && Object.values(checks).every(fn => fn(password.value)));
        }

        togglePassword.onclick = () => {
            password.type = password.type === 'password' ? 'text' : 'password';
            eyeOpen.classList.toggle('hidden');
            eyeClosed.classList.toggle('hidden');
        };

        toggleConfirm.onclick = () => {
            confirmPassword.type = confirmPassword.type === 'password' ? 'text' : 'password';
            confirmEyeOpen.classList.toggle('hidden');
            confirmEyeClosed.classList.toggle('hidden');
        };

        password.addEventListener('input', updateStatus);
        confirmPassword.addEventListener('input', matchConfirm);
    </script>
</x-app-layout>
