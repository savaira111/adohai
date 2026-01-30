<section>
    

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            <x-input-label for="update_password_current_password" :value="__('Current Password')" class="!text-white" />

            <x-text-input
                id="update_password_current_password"
                name="current_password"
                type="password"
                autocomplete="current-password"
                class="mt-1 block w-full bg-[#2a3155] border-[#3a4270] !text-white placeholder-gray-300 focus:border-white focus:ring-white"
            />

            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2 text-red-300" />
        </div>

        <div>
            <x-input-label for="update_password_password" :value="__('New Password')" class="!text-white" />

            <x-text-input
                id="update_password_password"
                name="password"
                type="password"
                autocomplete="new-password"
                class="mt-1 block w-full bg-[#2a3155] border-[#3a4270] !text-white placeholder-gray-300 focus:border-white focus:ring-white"
            />

            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2 text-red-300" />
        </div>

        <div>
            <x-input-label for="update_password_password_confirmation" :value="__('Confirm Password')" class="!text-white" />

            <x-text-input
                id="update_password_password_confirmation"
                name="password_confirmation"
                type="password"
                autocomplete="new-password"
                class="mt-1 block w-full bg-[#2a3155] border-[#3a4270] !text-white placeholder-gray-300 focus:border-white focus:ring-white"
            />

            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2 text-red-300" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button class="bg-gray text-[#212844] hover:bg-white/90">
                {{ __('Save') }}
            </x-primary-button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-green-300"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
