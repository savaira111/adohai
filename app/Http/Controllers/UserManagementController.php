<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserManagementController extends Controller
{
    public function index()
    {
        $users = User::latest()->get();
        return view('superadmin.users.index', compact('users'));
    }

    public function create()
    {
        return view('superadmin.users.create');
        }
        
        public function store(Request $request)
        {
        $request->validate([
            'name'      => 'required|string|max:255',
            'username'  => 'required|string|max:255|unique:users',
            'email'     => 'required|email|unique:users',
            'password'  => 'required|string|min:8',
            'password_confirmation' => 'required|same:password',
            'role'      => 'required|in:admin,user',
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
        return view('superadmin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'username'  => 'required|string|max:255|unique:users,username,' . $user->id,
            'email'     => 'required|email|unique:users,email,' . $user->id,
            'role'      => 'required|in:admin,user,superadmin',
        ]);

        $user->update([
            'name'     => $request->name,
            'username' => $request->username,
            'email'    => $request->email,
            'role'     => $request->role,
        ]);

        return redirect()
            ->route('superadmin.users.index')
            ->with('success', 'User berhasil diupdate');
    }

    public function destroy(User $user)
    {
        return view('components.confirm-delete', [
            'deleteUrl' => route('superadmin.users.destroy.confirm', $user->id)
        ]);
    }

    public function destroyConfirm($id)
    {
        User::findOrFail($id)->delete();

        return redirect()
            ->route('superadmin.users.index')
            ->with('success', 'User dipindahkan ke trash');
    }

    public function trashed()
    {
        $users = User::onlyTrashed()->get();
        return view('superadmin.users.trashed', compact('users'));
    }

    public function restore($id)
    {
        User::onlyTrashed()->findOrFail($id)->restore();

        return redirect()
            ->route('superadmin.users.trashed')
            ->with('success', 'User berhasil direstore');
    }

    public function forceDelete($id)
    {
        User::onlyTrashed()->findOrFail($id)->forceDelete();

        return redirect()
            ->route('superadmin.users.trashed')
            ->with('success', 'User dihapus permanen');
    }
}
