<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-white leading-tight">
            Trashed Users
        </h2>
    </x-slot>

    <div class="py-12" style="background-color:#F0E8D5; min-height:100vh;">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Back Button -->
            <a href="{{ route('superadmin.users.index') }}"
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
                            <th class="text-left py-2">No</th>
                            <th class="text-left py-2">Username</th>
                            <th class="text-left py-2">Email</th>
                            <th class="text-left py-2">Role</th>
                            <th class="text-left py-2">Deleted At</th>
                            <th class="text-left py-2">Auto Delete In</th>
                            <th class="text-left py-2">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($users as $user)

                            {{-- Superadmin tetap tidak ditampilkan --}}
                            @if($user->role === 'superadmin')
                                @continue
                            @endif

                            @php
                                $expiresAt = $user->deleted_at->copy()->addDays(7);

                                $remaining = now()->lt($expiresAt)
                                    ? $expiresAt->diff(now())
                                    : null;
                            @endphp

                            <tr class="border-b border-gray-700 hover:bg-[#2a3155] transition">
                                <!-- ✅ ID BERURUT -->
                                <td class="py-2">
                                    {{ $loop->iteration }}
                                </td>

                                <td class="py-2">{{ $user->username }}</td>
                                <td class="py-2">{{ $user->email }}</td>

                                <!-- ✅ ROLE DENGAN WARNA (PASTI MUNCUL) -->
                                <td class="py-2">
                                    @if($user->role === 'admin')
                                        <span style="background:#facc15;color:#000;padding:4px 12px;border-radius:9999px;font-size:12px;font-weight:600;">
                                            Admin
                                        </span>
                                    @elseif($user->role === 'user')
                                        <span style="background:#22c55e;color:#fff;padding:4px 12px;border-radius:9999px;font-size:12px;font-weight:600;">
                                            User
                                        </span>
                                    @endif
                                </td>

                                <!-- ✅ JAM WIB -->
                                <td class="py-2">
                                    {{ $user->deleted_at->timezone('Asia/Jakarta')->format('d M Y, H:i') }}
                                </td>

                                <!-- ✅ AUTO DELETE (HARI + JAM + MENIT) -->
                                <td class="py-2 text-sm">
                                    @if($remaining)
                                        <span class="text-green-400 font-semibold">
                                            {{ $remaining->d }} days
                                            {{ $remaining->h }} hours
                                            {{ $remaining->i }} minute
                                        </span>
                                        <div class="text-xs text-gray-400">
                                            Auto delete:
                                            {{ $expiresAt->timezone('Asia/Jakarta')->format('d M Y, H:i') }}
                                        </div>
                                    @else
                                        <span class="text-red-400 font-semibold">Expired</span>
                                    @endif
                                </td>

                                <td class="py-2 flex gap-2">
                                    <!-- Restore -->
                                    <form method="POST" action="{{ route('superadmin.users.restore', $user->id) }}">
                                        @csrf
                                        <button class="px-3 py-1 bg-yellow-500 text-black rounded-lg hover:bg-yellow-600 transition">
                                            Restore
                                        </button>
                                    </form>
                                </td>
                            </tr>

                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-gray-300">
                                    Trash is empty.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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

                    form.innerHTML = `
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="_method" value="DELETE">
                    `;

                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }
    </script>
</x-app-layout>
