<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    // Middleware sudah didefinisikan di routes/web.php

    /**
     * Tampilkan semua users, tapi CRUD hanya untuk user biasa
     */
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->get(); // Semua role
        return view('admin.users.index', compact('users'));
    }

    /**
     * Form tambah user (otomatis role user)
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Simpan user baru (otomatis role user)
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'username' => 'nullable|string|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6'
        ]);

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'role' => 'user',
            'password' => Hash::make($request->password),
            'email_verified_at' => now(),
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User berhasil dibuat!');
    }

    /**
     * Form edit user (hanya user biasa)
     */
    public function edit(User $user)
    {
        if ($user->role !== 'user') {
            return redirect()->route('admin.users.index')->with('error', 'Hanya bisa mengedit user biasa!');
        }
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update user (hanya user biasa)
     */
    public function update(Request $request, User $user)
    {
        if ($user->role !== 'user') {
            return redirect()->route('admin.users.index')->with('error', 'Hanya bisa mengupdate user biasa!');
        }

        $request->validate([
            'name' => 'required|string',
            'username' => 'nullable|string|unique:users,username,' . $user->id,
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6',
        ]);

        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;

        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'User berhasil diupdate!');
    }

    /**
     * Hapus user (hanya user biasa)
     */
    public function destroy(User $user)
    {
        if ($user->role !== 'user') {
            return redirect()->route('admin.users.index')->with('error', 'Hanya bisa menghapus user biasa!');
        }

        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus!');
    }
}
