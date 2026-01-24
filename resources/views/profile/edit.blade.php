<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-white text-center leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12" style="background-color: #F0E8D5; min-height: 100vh;">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <!-- Avatar Card -->
            <div class="p-6 bg-[#212844] text-white shadow-2xl rounded-2xl transition transform hover:scale-105">
                <div class="flex flex-col items-center space-y-4">
                    <img src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : asset('default-avatar.png') }}"
                         alt="Avatar" class="w-28 h-28 rounded-full border-2 border-white object-cover">

                    <form method="POST" action="{{ route('profile.avatar.update') }}" enctype="multipart/form-data" class="flex flex-col items-center w-full">
                        @csrf
                        @method('PATCH')
                        <input type="file" name="avatar" accept="image/*" class="mb-2 w-3/4 text-center rounded bg-[#3a4270] py-1" required>
                        <button type="submit" class="px-4 py-2 bg-green-600 rounded hover:bg-green-700 transition w-3/4">
                            Update Avatar
                        </button>
                    </form>
                </div>
            </div>

            <!-- Profile Information Card -->
            <div class="p-6 bg-[#212844] text-white shadow-2xl rounded-2xl transition transform hover:scale-105">
                <div class="max-w-xl mx-auto text-center space-y-4">
                    <h3 class="text-xl font-semibold mb-2">Update Profile Information</h3>
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <!-- Update Password Card -->
            <div class="p-6 bg-[#212844] text-white shadow-2xl rounded-2xl">
                <div class="max-w-xl mx-auto space-y-4">

                    <h3 class="text-xl font-semibold text-center">Update Password</h3>

                    <form method="post" action="{{ route('password.update') }}">
                        @csrf
                        @method('put')

                        <!-- Current Password -->
                        <div class="mb-4">
                            <x-input-label for="current_password" value="Current Password" />
                            <x-text-input id="current_password" name="current_password" type="password"
                                class="mt-1 block w-full bg-[#2a3155] border-[#3a4270] !text-white" />
                            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2 text-red-300" />
                        </div>

                        <!-- New Password -->
                        <div class="relative mb-4">
                            <x-input-label for="password" value="New Password" />
                            <x-text-input id="password" name="password" type="password"
                                class="mt-1 block w-full bg-[#2a3155] border-[#3a4270] !text-white"
                                autocomplete="new-password" />

                            <!-- Toggle Eye -->
                            <button type="button" id="toggle-password" class="absolute right-3 top-9 text-gray-400 hover:text-gray-200">
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

                            @error('password')
                                <span class="text-red-300 text-sm">{{ $message }}</span>
                            @enderror

                            <!-- Strength Bars -->
                            <div class="flex gap-2 mt-3">
                                <div class="h-3 w-1/5 bg-gray-600 rounded" id="bar-length"></div>
                                <div class="h-3 w-1/5 bg-gray-600 rounded" id="bar-uppercase"></div>
                                <div class="h-3 w-1/5 bg-gray-600 rounded" id="bar-lowercase"></div>
                                <div class="h-3 w-1/5 bg-gray-600 rounded" id="bar-number"></div>
                                <div class="h-3 w-1/5 bg-gray-600 rounded" id="bar-symbol"></div>
                            </div>

                            <!-- Rules -->
                            <ul class="mt-2 text-xs space-y-1">
                                <li id="rule-length" class="text-red-400">• Minimal 8 karakter</li>
                                <li id="rule-uppercase" class="text-red-400">• Huruf besar</li>
                                <li id="rule-lowercase" class="text-red-400">• Huruf kecil</li>
                                <li id="rule-number" class="text-red-400">• Angka</li>
                                <li id="rule-symbol" class="text-red-400">• Simbol</li>
                            </ul>
                        </div>

                        <!-- Confirm Password -->
                        <div class="relative mb-4">
                            <x-input-label for="password_confirmation" value="Confirm Password" />
                            
                            <x-text-input id="password_confirmation" name="password_confirmation" type="password"
                                class="mt-1 block w-full bg-[#2a3155] border-[#3a4270] !text-white"
                                autocomplete="new-password" />

                            <!-- Toggle Eye -->
                            <button type="button" id="toggle-password-confirm" class="absolute right-3 top-9 text-gray-400 hover:text-gray-200">
                                <svg id="confirm-eye-closed" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13.875 18.825A10.05 10.05 0 0112 19c-5.523 0-10-5-10-5s1.5-2.5 5-4.5m0 0a3 3 0 114 4M3 3l18 18"/>
                                </svg>
                                <svg id="confirm-eye-open" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>

                            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2 text-red-300" />
                        </div>

                        <!-- BUTTON SAVE -->
                        <div class="flex justify-center pt-2">
                            <button type="submit" class="px-4 py-2 bg-green-600 hover:bg-green-700 rounded transition">
                                Update Password
                            </button>
                        </div>

                    </form>
                </div>
            </div>

            <!-- Delete Account Card (Superadmin only) -->
            @if(auth()->user()->role === 'superadmin')
                <div class="p-6 bg-[#212844] text-white shadow-2xl rounded-2xl transition transform hover:scale-105">
                    <div class="max-w-xl mx-auto text-center space-y-4">
                        <h3 class="text-xl font-semibold mb-4">Delete Account</h3>
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            @endif

        </div>
    </div>

    <style>
        input, textarea, select {
            background-color: #212844 !important;
            color: white !important;
            border: 1px solid #3a4270 !important;
            border-radius: 0.5rem !important;
            padding: 0.5rem 1rem !important;
            width: 100% !important;
            text-align: center;
        }
        input::placeholder, textarea::placeholder {
            color: rgba(255, 255, 255, 0.6) !important;
        }
        label { color: white !important; }
    </style>

    <script>
        const password = document.getElementById('password');
        const toggle = document.getElementById('toggle-password');
        const eyeOpen = document.getElementById('eye-open');
        const eyeClosed = document.getElementById('eye-closed');

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
            if(password.type === 'password') {
                password.type = 'text';
                eyeOpen.classList.remove('hidden');
                eyeClosed.classList.add('hidden');
            } else {
                password.type = 'password';
                eyeOpen.classList.add('hidden');
                eyeClosed.classList.remove('hidden');
            }
        });

        password.addEventListener('input', () => {
            const val = password.value;
            function check(cond, bar, rule) {
                cond 
                    ? (bar.classList.replace('bg-gray-600', 'bg-green-500'),
                       rule.classList.replace('text-red-400', 'text-green-400'))
                    : (bar.classList.replace('bg-green-500', 'bg-gray-600'),
                       rule.classList.replace('text-green-400', 'text-red-400'));
            }

            check(val.length >= 8, bars.length, rules.length);
            check(/[A-Z]/.test(val), bars.uppercase, rules.uppercase);
            check(/[a-z]/.test(val), bars.lowercase, rules.lowercase);
            check(/[0-9]/.test(val), bars.number, rules.number);
            check(/[^A-Za-z0-9]/.test(val), bars.symbol, rules.symbol);
        });
    </script>
</x-app-layout>
