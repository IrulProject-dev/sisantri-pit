<?php
namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\Division;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'admin' || $user->role === 'superadmin') {
        // Get real counts from database
        $santriCount   = User::where('role', 'santri')->count();
        $divisionCount = Division::count();
        $batchCount    = Batch::count();

        // Get recent santris for activity feed
        $recentSantris = User::where('role', 'santri')
            ->latest()
            ->take(5)
            ->get();

        return view('pages.dashboard', compact('santriCount', 'divisionCount', 'batchCount', 'recentSantris'));
        }
        if ($user->role === 'santri') {
        // Tampilkan halaman dashboard khusus santri
        return view('pages.dashboardSantri');
        }
        if ($user->role === 'mentor') {
            return view('pages.dashboardMentor');
        }

        // Kalau ada role lain atau error, redirect atau abort
        abort(403, 'Unauthorized');
    }
}
