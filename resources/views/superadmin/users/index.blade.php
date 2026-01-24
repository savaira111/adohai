<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            User Management
        </h2>
    </x-slot>

    <div class="py-12 bg-gradient-to-br from-[#F0E8D5] to-[#E0D8C0] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Flash Messages -->
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <!-- Add User Button -->
            <div class="flex justify-end mb-4">
                <a href="{{ route('superadmin.users.create') }}" 
                   title="Add a new user"
                   class="flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition shadow">

                   <!-- Icon plus -->
                   <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                       <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                   </svg>

                   <span class="text-sm font-medium">Add User</span>
                </a>
            </div>

            <!-- Users Table -->
            <div class="bg-[#212844] shadow-lg sm:rounded-lg p-4 overflow-x-auto mt-4">
               <table class="min-w-full divide-y divide-gray-600 text-sm">
                <thead class="bg-[#2a3155]">
                    <tr>
                        <th class="px-3 py-2 text-left font-medium text-gray-200 uppercase">ID</th>
                        <th class="px-3 py-2 text-left font-medium text-gray-200 uppercase">Username</th>
                        <th class="px-3 py-2 text-left font-medium text-gray-200 uppercase">Name</th>
                        <th class="px-3 py-2 text-left font-medium text-gray-200 uppercase">Email</th>
                        <th class="px-3 py-2 text-left font-medium text-gray-200 uppercase">Role</th>
                        <th class="px-3 py-2 text-left font-medium text-gray-200 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-600">
                    @forelse($users as $user)
                        <tr class="hover:bg-[#1a1f33] transition duration-200">
                            <td class="px-3 py-2 whitespace-nowrap text-white">{{ $user->id }}</td>
                            <td class="px-3 py-2 whitespace-nowrap text-white">{{ $user->username ?? '-' }}</td>
                            <td class="px-3 py-2 whitespace-nowrap text-white">{{ $user->name }}</td>
                            <td class="px-3 py-2 whitespace-nowrap text-white">{{ $user->email }}</td>
                            <td class="px-3 py-2 whitespace-nowrap">
                                <span class="px-2 py-1 rounded-full text-xs font-semibold
                                    {{ $user->role == 'superadmin' ? 'bg-red-600 text-white' : ($user->role == 'admin' ? 'bg-yellow-500 text-black' : 'bg-green-500 text-white') }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td class="px-3 py-2 whitespace-nowrap flex gap-2">

                                <!-- Edit -->
                                <a href="{{ route('superadmin.users.edit', $user->id) }}"
                                title="Edit this user"
                                class="flex items-center gap-1 px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600 transition shadow">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M17.414 2.586a2 2 0 010 2.828l-1 1-2.828-2.828 1-1a2 2 0 012.828 0z" />
                                        <path fill-rule="evenodd" d="M4 13V16h3l9-9-3-3-9 9z" clip-rule="evenodd"/>
                                    </svg>
                                    Edit
                                </a>

                                <!-- Delete -->
                                <form method="POST" action="{{ route('superadmin.users.destroy', $user->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            title="Delete this user"
                                            class="flex items-center gap-1 px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 transition shadow"
                                            onclick="return confirm('Are you sure to delete this user?')">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M8 9a1 1 0 011-1h2a1 1 0 110 2H9a1 1 0 01-1-1z" clip-rule="evenodd" />
                                            <path d="M4 5h12v2H4V5z" />
                                        </svg>
                                        Delete
                                    </button>
                                </form>

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
