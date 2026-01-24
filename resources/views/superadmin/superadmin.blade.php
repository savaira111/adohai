<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            Superadmin Dashboard
        </h2>
    </x-slot>

    <div class="py-12" style="background-color: #F0E8D5; min-height: 100vh;">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Greeting -->
            <div class="mb-8 text-center">
                <h1 class="text-3xl font-bold text-gray-800 mb-2">Hello, {{ Auth::user()->name }}! 👋</h1>
                <p class="text-gray-700 text-lg">Berikut statistik terbaru sistem Anda</p>
            </div>

            <!-- Statistik Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                <div class="shadow rounded-lg p-6 text-center text-white transition transform hover:scale-105 hover:shadow-xl"
                     style="background-color: #212844;">
                    <div class="text-4xl mb-2">👥</div>
                    <h3 class="text-lg font-semibold mb-1">Total Users</h3>
                    <p class="text-2xl font-bold">{{ $totalUsers }}</p>
                    <p class="text-sm mt-2 text-gray-300">Semua user aktif di sistem</p>
                </div>

                <div class="shadow rounded-lg p-6 text-center text-white transition transform hover:scale-105 hover:shadow-xl"
                     style="background-color: #212844;">
                    <div class="text-4xl mb-2">🛠️</div>
                    <h3 class="text-lg font-semibold mb-1">Admins</h3>
                    <p class="text-2xl font-bold">{{ $totalAdmins }}</p>
                    <p class="text-sm mt-2 text-gray-300">Jumlah admin yang dapat mengelola user</p>
                </div>

                <div class="shadow rounded-lg p-6 text-center text-white transition transform hover:scale-105 hover:shadow-xl"
                     style="background-color: #212844;">
                    <div class="text-4xl mb-2">⭐</div>
                    <h3 class="text-lg font-semibold mb-1">Superadmins</h3>
                    <p class="text-2xl font-bold">{{ $totalSuperadmins }}</p>
                    <p class="text-sm mt-2 text-gray-300">Jumlah superadmin dengan akses penuh</p>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>
