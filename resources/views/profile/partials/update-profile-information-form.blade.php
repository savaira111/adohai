<section>
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" onsubmit="return checkEmailVerification()">
        @csrf
        @method('patch')

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input
                id="name"
                name="name"
                type="text"
                class="mt-1 block w-full"
                :value="old('name', $user->name)"
                required
                autofocus
                autocomplete="name"
                style="background-color: #212844; color: white; text-align: center;" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <!-- Username -->
        <div>
            <x-input-label for="username" value="Username" />

            <x-text-input
                id="username"
                name="username"
                type="text"
                class="mt-1 block w-full border-gray-300"
                :value="old('username', $user->username)"
                required
                autocomplete="username"
                style="background-color: #212844; color: white; text-align: center;" />

            <!-- realtime warning -->
            <p id="username-error"
                class="text-sm text-red-600 mt-1 hidden">
                Username tidak boleh mengandung spasi. Gunakan huruf, angka, titik (.), dan underscore (_) saja.
            </p>

            <x-input-error class="mt-2" :messages="$errors->get('username')" />
        </div>

        <!-- Email -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input
                id="email"
                name="email"
                type="email"
                class="mt-1 block w-full"
                :value="old('email', $user->email)"
                required
                autocomplete="email"
                style="background-color: #212844; color: white; text-align: center;" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            {{-- EMAIL VERIFICATION NOTICE --}}
            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
            <div>
                <p class="text-sm mt-2 text-gray-300">
                    {{ __('Email Anda belum diverifikasi. Silakan verifikasi email terlebih dahulu.') }}
                    <button form="send-verification"
                        class="underline text-sm text-gray-400 hover:text-gray-200 rounded-md
                               focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        {{ __('Klik di sini untuk mengirim ulang email verifikasi') }}
                    </button>
                </p>
            </div>
            @endif
        </div>

        <!-- Phone -->
        <div>
            <x-input-label for="phone" :value="__('Phone')" />
            <x-text-input
                id="phone"
                name="phone"
                type="text"
                class="mt-1 block w-full"
                :value="old('phone', $user->phone)"
                autocomplete="tel"
                style="background-color: #212844; color: white; text-align: center;" />
            <x-input-error class="mt-2" :messages="$errors->get('phone')" />
        </div>

        <!-- Address -->
        <div>
            <x-input-label for="address" :value="__('Address')" />
            <textarea
                id="address"
                name="address"
                rows="3"
                class="mt-1 block w-full rounded-md"
                style="background-color: #212844; color: white; text-align: center;">{{ old('address', $user->address) }}</textarea>
            <x-input-error class="mt-2" :messages="$errors->get('address')" />
        </div>

        <!-- Save -->
        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
            <p
                x-data="{ show: true }"
                x-show="show"
                x-transition
                x-init="setTimeout(() => show = false, 2000)"
                class="text-sm text-gray-300">
                {{ __('Saved.') }}
            </p>
            @endif
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const username = document.getElementById('username');
            const errorText = document.getElementById('username-error');

            const regex = /^[a-zA-Z0-9._]+$/;

            username.addEventListener('input', () => {
                const value = username.value;

                if (value.includes(' ') || !regex.test(value)) {
                    username.classList.remove('border-green-500');
                    username.classList.add('border-red-500');
                    errorText.classList.remove('hidden');
                } else {
                    username.classList.remove('border-red-500');
                    username.classList.add('border-green-500');
                    errorText.classList.add('hidden');
                }

                if (value.length === 0) {
                    username.classList.remove('border-red-500', 'border-green-500');
                    errorText.classList.add('hidden');
                }
            });
        });

        // Popup alert jika email belum diverifikasi
        function checkEmailVerification() {
            const emailUnverified = @json($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail());
            if (emailUnverified) {
                alert('Email Anda belum diverifikasi. Silakan verifikasi email terlebih dahulu.');
                return false; // hentikan submit
            }
            return true;
        }
    </script>
</section>
