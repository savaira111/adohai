<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class SuperAdminDashboardController extends Controller
{
    // Middleware sudah didefinisikan di routes/web.php

    public function index()
    {
        // Statistik untuk superadmin
        $totalUsers = User::where('role','user')->count();
        $totalAdmins = User::where('role','admin')->count();
        $totalSuperadmins = User::where('role','superadmin')->count();

        return view('superadmin.superadmin', compact('totalUsers', 'totalAdmins', 'totalSuperadmins'));
    }
}
