<x-guest-layout>
    <div class="bg-[#212844] text-white rounded-lg shadow-md px-6 py-6">

        <h1 class="text-lg font-semibold mb-3">
            Verify Your Email
        </h1>

        <p class="text-gray-300 mb-4">
            Thanks for signing up! Before getting started, please verify your email by clicking the link we sent to your inbox.
        </p>

        @if (session('status') == 'verification-link-sent')
            <p class="mb-4 text-green-400">
                A new verification link has been sent to your email!
            </p>
        @endif

        <div class="flex flex-col gap-4 mt-4">

            <!-- Resend Email -->
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button
                    type="submit"
                    class="w-full bg-white text-[#212844] rounded-md py-2 font-semibold hover:bg-gray-200 transition">
                    Resend Verification Email
                </button>
            </form>

            <!-- Logout -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button
                    type="submit"
                    class="text-sm text-gray-300 hover:text-white underline text-center block w-full">
                    Log Out
                </button>
            </form>
        </div>

    </div>
</x-guest-layout>
