<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">Edit User</h2>
    </x-slot>

    <div class="py-12" style="background-color: #F0E8D5; min-height: 100vh;">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-[#212844] text-white shadow-2xl sm:rounded-lg p-6 space-y-6">

                <form action="{{ route('superadmin.users.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Name -->
                    <div class="mb-4">
                        <label for="name" class="block font-semibold">Name</label>
                        <input type="text" name="name" id="name"
                               value="{{ old('name', $user->name) }}"
                               class="w-full px-4 py-2 rounded-lg border border-gray-600 bg-[#2a3155] focus:outline-none focus:ring-2 focus:ring-blue-500"
                               required>
                        @error('name') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Username -->
                    <div class="mb-4">
                        <label for="username" class="block font-semibold">Username</label>
                        <input type="text" name="username" id="username"
                               value="{{ old('username', $user->username) }}"
                               class="w-full px-4 py-2 rounded-lg border border-gray-600 bg-[#2a3155] focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('username') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Email -->
                    <div class="mb-4">
                        <label for="email" class="block font-semibold">Email</label>
                        <input type="email" name="email" id="email"
                               value="{{ old('email', $user->email) }}"
                               class="w-full px-4 py-2 rounded-lg border border-gray-600 bg-[#2a3155] focus:outline-none focus:ring-2 focus:ring-blue-500"
                               required>
                        @error('email') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Role (SUPERADMIN REMOVED) -->
                    <div class="mb-4">
                        <label for="role" class="block font-semibold">Role</label>
                        <select name="role" id="role"
                                class="w-full px-4 py-2 rounded-lg border border-gray-600 bg-[#2a3155] focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
                            <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                        @error('role') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Password (optional) -->
                    <div class="relative mb-4">
                        <label for="password" class="block font-semibold">Password (optional)</label>
                        <input type="password" name="password" id="password"
                               class="w-full px-4 py-2 rounded-lg border border-gray-600 bg-[#2a3155] focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="Enter new password if you want to change it">

                        <button type="button" id="toggle-password"
                                class="absolute right-3 top-9 text-gray-400 hover:text-gray-200">
                            <svg id="eye-closed" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M13.875 18.825A10.05 10.05 0 0112 19c-5.523 0-10-5-10-5s1.5-2.5 5-4.5m0 0a3 3 0 114 4M3 3l18 18"/>
                            </svg>
                            <svg id="eye-open" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>

                        <div id="password-rules-wrapper" class="hidden">
                            <div class="flex gap-2 mt-3">
                                <div class="bar h-3 w-1/5 bg-gray-600 rounded" id="bar-length"></div>
                                <div class="bar h-3 w-1/5 bg-gray-600 rounded" id="bar-uppercase"></div>
                                <div class="bar h-3 w-1/5 bg-gray-600 rounded" id="bar-lowercase"></div>
                                <div class="bar h-3 w-1/5 bg-gray-600 rounded" id="bar-number"></div>
                                <div class="bar h-3 w-1/5 bg-gray-600 rounded" id="bar-symbol"></div>
                            </div>

                            <ul class="mt-2 text-xs space-y-1 text-gray-400">
                                <li id="rule-length">• Minimal 8 karakter</li>
                                <li id="rule-uppercase">• Huruf besar</li>
                                <li id="rule-lowercase">• Huruf kecil</li>
                                <li id="rule-number">• Angka</li>
                                <li id="rule-symbol">• Simbol</li>
                            </ul>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-4">
                        <button type="submit"
                                class="flex-1 px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg transition">
                            Update User
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
const toggle = document.getElementById('toggle-password');
const eyeOpen = document.getElementById('eye-open');
const eyeClosed = document.getElementById('eye-closed');
const wrapper = document.getElementById('password-rules-wrapper');

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

toggle.addEventListener('click', () => {
    const isHidden = password.type === 'password';
    password.type = isHidden ? 'text' : 'password';
    eyeOpen.classList.toggle('hidden', !isHidden);
    eyeClosed.classList.toggle('hidden', isHidden);
});

password.addEventListener('focus', () => {
    wrapper.classList.remove('hidden');
});

password.addEventListener('blur', () => {
    if (password.value.trim() === '') {
        wrapper.classList.add('hidden');
    }
});

password.addEventListener('input', () => {
    const v = password.value;
    const checks = {
        length: v.length >= 8,
        uppercase: /[A-Z]/.test(v),
        lowercase: /[a-z]/.test(v),
        number: /[0-9]/.test(v),
        symbol: /[\W_]/.test(v)
    };

    Object.keys(checks).forEach(key => {
        bars[key].classList.toggle('bg-green-500', checks[key]);
        bars[key].classList.toggle('bg-gray-600', !checks[key]);
        rules[key].classList.toggle('text-green-500', checks[key]);
        rules[key].classList.toggle('text-gray-400', !checks[key]);
    });
});
</script>
</x-app-layout>
