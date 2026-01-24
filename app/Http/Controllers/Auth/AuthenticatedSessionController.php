<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = Auth::user();

        // --- OTOMATIS AKTIFKAN USER BIASA ---
        if (!in_array($user->role, ['admin','superadmin'])) {
            $user->is_active = 1; // aktif saat login
            $user->save();
        }

        switch ($user->role) {
            case 'superadmin':
                return redirect()->route('dashboard.superadmin');
            case 'admin':
                return redirect()->route('dashboard.admin');
            default:
                return redirect()->route('dashboard.user');
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $user = Auth::user();

        // --- OTOMATIS NONAKTIFKAN USER BIASA SAAT LOGOUT ---
        if ($user && !in_array($user->role, ['admin','superadmin'])) {
            $user->is_active = 0; // nonaktif saat logout
            $user->save();
        }

        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
