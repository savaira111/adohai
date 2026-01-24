<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-[#212844] leading-tight">
            User Management
        </h2>
    </x-slot>

    <div class="py-12" style="background-color: #F0E8D5; min-height: 100vh;">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Flash Messages -->
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded shadow">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-800 px-4 py-3 rounded shadow">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Add User Button -->
            <div class="flex justify-end">
                <a href="{{ route('admin.users.create') }}" 
                   class="flex items-center gap-2 px-4 py-2 bg-[#212844] text-white rounded-xl hover:bg-[#1a1f3b] transition shadow-md">
                   + Add User
                </a>
            </div>

            <!-- Users Table -->
            <div class="bg-[#212844] shadow-xl rounded-2xl overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-700 text-sm">
                    <thead class="bg-[#1a1f3b]">
                        <tr>
                            <th class="px-3 py-2 text-left font-semibold text-gray-300 uppercase">ID</th>
                            <th class="px-3 py-2 text-left font-semibold text-gray-300 uppercase">Username</th>
                            <th class="px-3 py-2 text-left font-semibold text-gray-300 uppercase">Name</th>
                            <th class="px-3 py-2 text-left font-semibold text-gray-300 uppercase">Email</th>
                            <th class="px-3 py-2 text-left font-semibold text-gray-300 uppercase">Role</th>
                            <th class="px-3 py-2 text-left font-semibold text-gray-300 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700">
                        @forelse($users as $user)
                            <tr class="hover:bg-[#2a3155] transition">
                                <td class="px-3 py-2 text-white">{{ $user->id }}</td>
                                <td class="px-3 py-2 text-white">{{ $user->username ?? '-' }}</td>
                                <td class="px-3 py-2 text-white">{{ $user->name }}</td>
                                <td class="px-3 py-2 text-white">{{ $user->email }}</td>

                                <!-- ROLE WITH COLOR -->
                                <td class="px-3 py-2">
                                    <span class="px-2 py-1 rounded-full text-xs font-semibold
                                        {{ $user->role == 'superadmin' ? 'bg-red-600 text-white' : ($user->role == 'admin' ? 'bg-yellow-500 text-black' : 'bg-green-500 text-white') }}">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>

                                <!-- ACTIONS -->
                                <td class="px-3 py-2 flex gap-2">
                                    @if($user->role === 'user')
                                        <!-- Edit -->
                                        <a href="{{ route('admin.users.edit', $user->id) }}"
                                           class="px-3 py-1 bg-yellow-500 text-white rounded-xl hover:bg-yellow-600 transition shadow-sm">
                                            Edit
                                        </a>

                                        <!-- Delete -->
                                        <form method="POST" action="{{ route('admin.users.destroy', $user->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="px-3 py-1 bg-red-600 text-white rounded-xl hover:bg-red-700 transition shadow-sm"
                                                    onclick="return confirm('Are you sure to delete this user?')">
                                                Delete
                                            </button>
                                        </form>
                                    @else
                                        <!-- Admin & Superadmin hanya bisa dilihat -->
                                        <span class="px-3 py-1 bg-gray-600 text-white rounded-xl text-sm">View Only</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-gray-300">
                                    No users found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>
