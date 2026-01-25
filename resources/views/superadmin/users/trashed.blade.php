<x-app-layout>
    <div class="p-6">

        <h2 class="text-2xl font-semibold text-white mb-4">Trash</h2>

        @if($users->count() === 0)
        <p class="text-gray-300">Tidak ada data di trash.</p>
        @else
        <table class="min-w-full bg-[#212844] text-white rounded-lg overflow-hidden border border-[#1a1f33]">
            <thead>
                <tr class="bg-[#1a1f3b]">
                    <th class="px-4 py-2 text-left">Nama</th>
                    <th class="px-4 py-2 text-left">Email</th>
                    <th class="px-4 py-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr class="border-t border-[#1a1f33]">
                    <td class="px-4 py-2">{{ $user->name }}</td>
                    <td class="px-4 py-2">{{ $user->email }}</td>
                    <td class="px-4 py-2 flex gap-2">

                        <!-- RESTORE -->
                        <form action="{{ route('superadmin.users.restore', $user->id) }}" method="POST">
                            @csrf
                            <button class="px-3 py-1 bg-green-600 rounded hover:bg-green-500">
                                Restore
                            </button>
                        </form>

                        <!-- FORCE DELETE -->
                        <form action="{{ route('superadmin.users.forceDelete', $user->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="px-3 py-1 bg-red-600 rounded hover:bg-red-500">
                                Delete Permanently
                            </button>
                        </form>

                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</x-app-layout>