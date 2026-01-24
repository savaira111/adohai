<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Admin hanya bisa lihat active users (role='user' yang sudah verified)
        $totalUsers = User::where('role','user')
                          ->whereNotNull('email_verified_at')
                          ->count();

        // 5 user terakhir yang terdaftar dan aktif
        $recentUsers = User::where('role','user')
                           ->whereNotNull('email_verified_at')
                           ->latest()
                           ->take(5)
                           ->count();

        // User aktif (role=user yang sudah verified)
        $activeUsers = User::where('role','user')
                          ->whereNotNull('email_verified_at')
                          ->count();

        return view('admin.dashboard', compact('totalUsers','recentUsers','activeUsers'));
    }
}
