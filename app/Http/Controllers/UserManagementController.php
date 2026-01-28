<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserManagementController extends Controller
{
    // ================= SUPERADMIN ONLY =================
    public function index(Request $request)
    {
        $query = User::query();

        // Search by username or role
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('username', 'like', "%{$request->search}%")
                  ->orWhere('role', 'like', "%{$request->search}%");
            });
        }

        // Filter by role
        if ($request->role && $request->role !== 'all') {
            $query->where('role', $request->role);
        }

        $users = $query->latest()->get();

        return view('superadmin.users.index', compact('users'));
    }

    public function create()
    {
        return view('superadmin.users.create');
    }

    public function store(Request $request)
    {
        // Jika login sebagai admin, batasi role hanya "user"
        if (auth()->user()->role === 'admin' && $request->role !== 'user') {
            return redirect()->back()->with('error', 'Admins can only create regular users.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => ['required', 'string', 'regex:/^\S+$/u', 'max:255', 'unique:users'],
            'email' => 'required|email|max:255|unique:users',
            'role' => 'required|in:admin,superadmin,user',
            'password' => 'required|min:6|confirmed',
        ], [
            'username.regex' => 'Usernames cannot contain spaces.',
        ]);

        User::create([
            'name'     => $request->name,
            'username' => $request->username,
            'email'    => $request->email,
            'role'     => $request->role,
            'password' => Hash::make($request->password),
        ]);

        return redirect()
            ->route('superadmin.users.index')
            ->with('success', 'User berhasil dibuat');
    }

    public function edit(User $user)
    {
        // Admin hanya bisa edit user biasa
        if (auth()->user()->role === 'admin' && $user->role !== 'user') {
            return redirect()->route('superadmin.users.index')
                             ->with('error', 'Admins can only edit regular users.');
        }

        return view('superadmin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        // Admin hanya bisa update user biasa
        if (auth()->user()->role === 'admin' && $user->role !== 'user') {
            return redirect()->route('superadmin.users.index')
                             ->with('error', 'Admins can only update regular users.');
        }

        $request->validate([
            'name'      => 'required|string|max:255',
            'username'  => ['required','string','regex:/^\S+$/u','max:255','unique:users,username,' . $user->id],
            'email'     => 'required|email|unique:users,email,' . $user->id,
            'role'      => 'required|in:admin,user,superadmin',
        ], [
            'username.regex' => 'Username tidak boleh mengandung spasi.',
        ]);

        // Admin tidak boleh ubah role selain "user"
        if (auth()->user()->role === 'admin') {
            $user->update([
                'name'     => $request->name,
                'username' => $request->username,
                'email'    => $request->email,
                // Tetap role "user"
                'role'     => 'user',
            ]);
        } else {
            $user->update([
                'name'     => $request->name,
                'username' => $request->username,
                'email'    => $request->email,
                'role'     => $request->role,
            ]);
        }

        return redirect()
            ->route('superadmin.users.index')
            ->with('success', 'User berhasil diupdate');
    }

    // DELETE → soft delete
    public function destroy(User $user)
    {
        // Admin tidak bisa hapus admin/superadmin
        if (auth()->user()->role === 'admin' && $user->role !== 'user') {
            return redirect()->route('superadmin.users.index')
                             ->with('error', 'Admins can only delete regular users.');
        }

        $user->delete();

        return redirect()
            ->route('superadmin.users.index')
            ->with('success', 'User moved to trash.');
    }

    // ================== NEW SOFT DELETE FEATURES ==================

    // Show trashed users
    public function trashed()
    {
        $users = User::onlyTrashed()->latest()->get();
        return view('superadmin.users.trashed', compact('users'));
    }

    // Restore user
    public function restore($id)
    {
        User::onlyTrashed()->findOrFail($id)->restore();
        return back()->with('success', 'User berhasil direstore.');
    }

    // Permanently delete user
    public function forceDelete($id)
    {
        User::onlyTrashed()->findOrFail($id)->forceDelete();
        return back()->with('success', 'User berhasil dihapus permanen.');
    }
}
