<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-white leading-tight">
            Add New User
        </h2>
    </x-slot>

    <div class="py-12" style="background-color: #F0E8D5; min-height: 100vh;">
        <div class="max-w-md mx-auto p-8 rounded-xl shadow-xl" style="background:#212844; color:white;">

            <h2 class="text-2xl font-bold text-center mb-6">
                Create User
            </h2>

            @if(session('success'))
                <div class="mb-3 p-2 bg-green-600 text-white rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-3 p-2 bg-red-600 text-white rounded">
                    <ul class="list-disc ml-4">
                        @foreach ($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.users.store') }}">
                @csrf

                <!-- NAME -->
                <div class="mb-4">
                    <label class="block font-medium mb-1">Name <span class="text-red-300">*</span></label>
                    <input type="text" name="name" required
                        class="w-full border rounded-lg px-3 py-2 focus:outline-blue-500 bg-white text-black"
                        value="{{ old('name') }}">
                </div>

                <!-- USERNAME -->
                <div class="mb-4">
                    <label class="block font-medium mb-1">Username <span class="text-red-300">*</span></label>
                    <input type="text" name="username" required
                        class="w-full border rounded-lg px-3 py-2 focus:outline-blue-500 bg-white text-black"
                        value="{{ old('username') }}">
                </div>

                <!-- EMAIL -->
                <div class="mb-4">
                    <label class="block font-medium mb-1">Email <span class="text-red-300">*</span></label>
                    <input type="email" name="email" required
                        class="w-full border rounded-lg px-3 py-2 focus:outline-blue-500 bg-white text-black"
                        value="{{ old('email') }}">
                </div>

                <!-- PASSWORD -->
                <div class="mb-4 relative">
                    <label class="block font-medium mb-1">Password <span class="text-red-300">*</span></label>
                    <div class="relative">
                        <input id="password" type="password" name="password" required
                            class="w-full border rounded-lg px-3 py-2 pr-10 bg-white text-black">
                        <button type="button" id="togglePassword"
                            class="absolute top-2.5 right-2 text-gray-600">
                            👁️
                        </button>
                    </div>

                    <ul id="rules" class="mt-2 text-xs text-gray-300 space-y-1 hidden">
                        <li data-rule="length">• Min 8 characters</li>
                        <li data-rule="uppercase">• Uppercase letter</li>
                        <li data-rule="lowercase">• Lowercase letter</li>
                        <li data-rule="number">• Number</li>
                        <li data-rule="symbol">• Symbol</li>
                    </ul>

                    <div class="flex gap-1 mt-2">
                        <div class="bar h-1 flex-1 bg-gray-600 rounded"></div>
                        <div class="bar h-1 flex-1 bg-gray-600 rounded"></div>
                        <div class="bar h-1 flex-1 bg-gray-600 rounded"></div>
                        <div class="bar h-1 flex-1 bg-gray-600 rounded"></div>
                        <div class="bar h-1 flex-1 bg-gray-600 rounded"></div>
                    </div>
                </div>

                <!-- CONFIRM PASSWORD -->
                <div class="mb-4">
                    <label class="block font-medium mb-1">Confirm Password <span class="text-red-300">*</span></label>
                    <div class="relative">
                        <input id="confirmPassword" type="password" name="password_confirmation" required
                            class="w-full border rounded-lg px-3 py-2 bg-white text-black">
                        <span id="confirmIcon" class="absolute right-3 top-2.5 text-lg hidden text-green-400">✔️</span>
                    </div>
                    <small id="confirmError" class="text-red-400 hidden">Passwords do not match</small>
                </div>

                <!-- BUTTONS -->
                <div class="flex gap-3 mt-6">
                    <button type="submit"
                        class="flex-1 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition">
                        Create User
                    </button>

                    <a href="{{ route('admin.users.index') }}"
                        class="flex-1 py-2 bg-gray-600 hover:bg-gray-700 text-white text-center rounded-lg transition">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        const pass = document.getElementById('password');
        const confirm = document.getElementById('confirmPassword');
        const confirmIcon = document.getElementById('confirmIcon');
        const confirmError = document.getElementById('confirmError');
        const rules = document.getElementById('rules');
        const bars = document.querySelectorAll('.bar');

        const ruleCheck = {
            length: v => v.length >= 8,
            uppercase: v => /[A-Z]/.test(v),
            lowercase: v => /[a-z]/.test(v),
            number: v => /[0-9]/.test(v),
            symbol: v => /[^A-Za-z0-9]/.test(v),
        };

        pass.addEventListener('input', () => {
            const v = pass.value;

            if (v.length === 0) {
                rules.classList.add('hidden');
                bars.forEach(bar => bar.style.background = '#4B5563');
                return;
            }

            rules.classList.remove('hidden');

            let score = 0;
            for (const r in ruleCheck) {
                const ok = ruleCheck[r](v);
                document.querySelector(`[data-rule="${r}"]`).style.color = ok ? 'lightgreen' : 'gray';
                if (ok) score++;
            }

            bars.forEach((bar, i) => bar.style.background = i < score ? 'lightgreen' : '#4B5563');
        });

        confirm.addEventListener('input', () => {
            if (confirm.value === pass.value && confirm.value.length > 0) {
                confirm.style.borderColor = 'lightgreen';
                confirmIcon.classList.remove('hidden');
                confirmError.classList.add('hidden');
            } else {
                confirm.style.borderColor = 'red';
                confirmIcon.classList.add('hidden');
                confirmError.classList.remove('hidden');
            }
        });

        togglePassword.addEventListener('click', () => {
            pass.type = pass.type === 'password' ? 'text' : 'password';
        });
    </script>
</x-app-layout>
