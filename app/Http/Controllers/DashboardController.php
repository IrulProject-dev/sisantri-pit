<?php
namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\Division;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
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
}
