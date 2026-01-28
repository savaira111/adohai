<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            User Management
        </h2>
    </x-slot>

    <div class="py-12 bg-gradient-to-br from-[#F0E8D5] to-[#E0D8C0] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- SweetAlert Success -->
            @if(session('success'))
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: "{{ session('success') }}",
                            timer: 1500,
                            showConfirmButton: false
                        });
                    });
                </script>
            @endif

            <!-- Search + Filter -->
            <form method="GET" class="flex flex-col sm:flex-row gap-3 mb-2">
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Search username or role..."
                       class="px-3 py-2 rounded border border-gray-500 bg-[#2a3155] text-white focus:outline-none flex-1">

                <select name="role"
                        class="px-3 py-2 rounded border border-gray-500 bg-[#2a3155] text-white focus:outline-none">
                    <option value="all" {{ request('role')=='all' ? 'selected' : '' }}>All Roles</option>
                    <option value="user" {{ request('role')=='user' ? 'selected' : '' }}>User</option>
                    <option value="admin" {{ request('role')=='admin' ? 'selected' : '' }}>Admin</option>
                    <option value="superadmin" {{ request('role')=='superadmin' ? 'selected' : '' }}>Superadmin</option>
                </select>

                <button type="submit"
                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded transition">
                    Apply
                </button>
            </form>

            <!-- Add User Button -->
            <div class="flex justify-end mb-4">
                <a href="{{ route('superadmin.users.create') }}" 
                   title="Add a new user"
                   class="flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition shadow">
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
                                    <a href="{{ route('superadmin.users.edit', $user->id) }}"
                                        class="flex items-center gap-1 px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600 transition shadow">
                                        Edit
                                    </a>

                                    <button onclick="deleteUser({{ $user->id }})"
                                        class="flex items-center gap-1 px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 transition shadow">
                                        Delete
                                    </button>
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

    <!-- Delete SweetAlert -->
    <script>
        function deleteUser(id) {
            Swal.fire({
                title: 'Move to Trash?',
                text: "This user will be moved to trash and can be restored later.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Move to Trash',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    let form = document.createElement('form');
                    form.action = `/superadmin/users/${id}`;
                    form.method = 'POST';

                    form.innerHTML = `
                        @csrf
                        @method('DELETE')
                    `;

                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }
    </script>

    <!-- SweetAlert CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</x-app-layout>
