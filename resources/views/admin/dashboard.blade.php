<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-[#212844] leading-tight">
            Admin Dashboard
        </h2>
    </x-slot>

    <div class="py-12" style="background-color: #F0E8D5; min-height: 100vh;">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Welcome / Intro -->
            <div class="mb-6 p-6 bg-[#212844] text-white rounded-2xl shadow-lg text-center transition transform hover:scale-105">
                <h3 class="text-2xl font-bold">Welcome, {{ Auth::user()->name }}!</h3>
                <p class="text-gray-300 mt-2">This is your admin dashboard. You can view and manage all regular users here.</p>
            </div>

            <!-- Statistik Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <div class="bg-[#212844] text-white shadow-xl rounded-2xl p-6 text-center transition transform hover:scale-105">
                    <div class="text-4xl mb-2">👥</div>
                    <h3 class="text-lg font-semibold mb-2">Total Users</h3>
                    <p class="text-2xl font-bold">{{ $totalUsers }}</p>
                </div>

                <div class="bg-[#212844] text-white shadow-xl rounded-2xl p-6 text-center transition transform hover:scale-105">
                    <div class="text-4xl mb-2">🆕</div>
                    <h3 class="text-lg font-semibold mb-2">Recent Registrations</h3>
                    <p class="text-2xl font-bold">{{ $recentUsers }}</p>
                </div>

                <div class="bg-[#212844] text-white shadow-xl rounded-2xl p-6 text-center transition transform hover:scale-105">
                    <div class="text-4xl mb-2">✅</div>
                    <h3 class="text-lg font-semibold mb-2">Active Users</h3>
                    <p class="text-2xl font-bold">{{ $activeUsers }}</p>
                </div>

            </div>


        </div>
    </div>
</x-app-layout>
