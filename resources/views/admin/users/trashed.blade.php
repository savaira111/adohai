<x-app-layout>

<x-slot name="header">
    <h2 class="font-bold text-2xl text-white leading-tight">
        Trashed Users
    </h2>
</x-slot>

<div class="py-12" style="background-color:#F0E8D5; min-height:100vh;">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

        <!-- Back Button -->
        <a href="{{ route('admin.users.index') }}"
           class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
            Back
        </a>

        <!-- Search Form -->
        <form method="GET" class="flex gap-2 mt-4 mb-2">
            <input type="text"
                   name="search"
                   value="{{ request('search') }}"
                   placeholder="Search username or email..."
                   class="flex-1 px-3 py-2 rounded-lg bg-[#2a3155] text-white placeholder-gray-300 border border-transparent focus:border-[#3b4470] outline-none">
            <button type="submit"
                    class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition">
                Search
            </button>
        </form>

        <div class="bg-[#212844] text-white rounded-xl p-4 overflow-x-auto">

            <table class="min-w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-600">
                        <th class="text-left py-2">ID</th>
                        <th class="text-left py-2">Username</th>
                        <th class="text-left py-2">Email</th>
                        <th class="text-left py-2">Role</th>
                        <th class="text-left py-2">Auto Delete In</th>
                        <th class="text-left py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)

                        @php
                            $expiresAt = $user->deleted_at->addDays(7);
                            $remaining = now()->lt($expiresAt)
                                ? $expiresAt->diffForHumans(now(), ['parts' => 2, 'short' => true])
                                : 'Expired';
                        @endphp

                        <tr class="border-b border-gray-700">
                            <td class="py-2">{{ $user->id }}</td>
                            <td class="py-2">{{ $user->username }}</td>
                            <td class="py-2">{{ $user->email }}</td>
                            <td class="py-2">{{ $user->role }}</td>
                            <td class="py-2">{{ $remaining }}</td>

                            <td class="py-2 flex gap-2">
                                <!-- Restore -->
                                <form method="POST" action="{{ route('admin.users.restore', $user->id) }}">
                                    @csrf
                                    <button class="px-3 py-1 bg-yellow-500 text-black rounded-lg hover:bg-yellow-600 transition">
                                        Restore
                                    </button>
                                </form>

                                <!-- Delete -->
                                <button type="button"
                                        data-route="{{ route('admin.users.forceDelete', $user->id) }}"
                                        onclick="confirmDelete(this)"
                                        class="px-3 py-1 bg-red-600 rounded-lg hover:bg-red-700 transition">
                                    Delete Permanently
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-gray-300">
                                Trash is empty.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        </div>
    </div>
</div>

<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Delete Confirmation Script -->
<script>
    function confirmDelete(button) {
        let route = button.dataset.route;

        Swal.fire({
            title: 'Are you sure?',
            text: "This user will be permanently deleted!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                let form = document.createElement('form');
                form.action = route;
                form.method = 'POST';

                let csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = '{{ csrf_token() }}';
                form.appendChild(csrfInput);

                let methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'DELETE';
                form.appendChild(methodInput);

                document.body.appendChild(form);
                form.submit();
            }
        });
    }
</script>

</x-app-layout>
