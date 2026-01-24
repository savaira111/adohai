<x-guest-layout>
    <!-- Card -->
    <div class="bg-[#212844] text-white rounded-lg shadow-md px-6 py-6">

        <!-- Session Status -->
        <x-auth-session-status class="mb-4 text-green-300" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

           <!-- Login (Email or Username) -->
            <div>
                <x-input-label for="login" value="Email / Username" class="!text-white" />

                <x-text-input
                    id="login"
                    class="block mt-1 w-full bg-[#2a3155] border-[#3a4270] !text-white placeholder-gray-300 focus:border-white focus:ring-white"
                    type="text"
                    name="login"
                    :value="old('login')"
                    placeholder="Enter Email / Username"
                    required
                    autofocus
                    autocomplete="username"
                />

                <x-input-error :messages="$errors->get('login')" class="mt-2 text-red-300" />
            </div>

                <!-- password -->
                <div class="relative">
                    <label for="password" class="block font-semibold mb-1 text-white">Password</label>
                    <input type="password" name="password" id="password"
                        class="w-full px-4 py-2 rounded-lg bg-[#212844] text-white placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-400"
                        placeholder="Enter password" required>

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
                    <span class="text-red-400 text-sm">{{ $message }}</span>
                @enderror

                <!-- Bars + Rules Wrapper -->
                <div id="password-rules" class="mt-3 hidden">
                    <div class="flex gap-2">
                        <div class="h-3 w-1/5 bg-gray-600 rounded" id="bar-length"></div>
                        <div class="h-3 w-1/5 bg-gray-600 rounded" id="bar-uppercase"></div>
                        <div class="h-3 w-1/5 bg-gray-600 rounded" id="bar-lowercase"></div>
                        <div class="h-3 w-1/5 bg-gray-600 rounded" id="bar-number"></div>
                        <div class="h-3 w-1/5 bg-gray-600 rounded" id="bar-symbol"></div>
                    </div>

                    <ul class="mt-2 text-xs space-y-1">
                        <li id="rule-length" class="text-red-400">• Minimal 8 karakter</li>
                        <li id="rule-uppercase" class="text-red-400">• Huruf besar</li>
                        <li id="rule-lowercase" class="text-red-400">• Huruf kecil</li>
                        <li id="rule-number" class="text-red-400">• Angka</li>
                        <li id="rule-symbol" class="text-red-400">• Simbol</li>
                    </ul>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex flex-col gap-4 mt-6">

                @if (Route::has('password.request'))
                    <a
                        href="{{ route('password.request') }}"
                        class="text-sm text-gray-300 hover:text-white underline"
                    >
                        Forgot your password?
                    </a>
                @endif

                <!-- Login Button -->
                <x-primary-button class="w-full justify-center bg-gray text-[#212844] hover:bg-white-200">
                    Log in
                </x-primary-button>

                @if (Route::has('register'))
                    <a
                        href="{{ route('register') }}"
                        class="text-sm text-gray-300 hover:text-white underline text-center block mt-2"
                    >
                        Don't have an account? Register
                    </a>
                @endif

                <div class="relative flex py-5 items-center">
                    <div class="flex-grow border-t border-gray-500"></div>
                    <span class="flex-shrink-0 mx-4 text-gray-300">Or Login With</span>
                    <div class="flex-grow border-t border-gray-500"></div>
                </div>

                <div class="flex justify-center">
                    <a href="{{ route('social.redirect', ['provider' => 'google']) }}"
                       class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition">
                        Google
                    </a>
                </div>

            </div>
        </form>
    </div>

    <script>
        const password = document.getElementById('password');
        const toggle = document.getElementById('toggle-password');
        const eyeOpen = document.getElementById('eye-open');
        const eyeClosed = document.getElementById('eye-closed');
        const container = document.getElementById('password-rules');

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

            // Show/hide rules
            container.classList.toggle('hidden', val.length === 0);

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

</x-guest-layout>
