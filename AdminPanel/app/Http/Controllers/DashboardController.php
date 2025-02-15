<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Formateur;
use App\Models\Stagiaire;
use App\Models\User;
use App\Models\Groupe;
use Illuminate\Support\Facades\DB;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class DashboardController extends Controller
{
    public function index()
    {
        try {
            // Get counts using Eloquent
            $totalFormateurs = Formateur::count();
            $totalStagiaires = Stagiaire::count();
            $totalUsers = User::count();
            $totalGroups = Groupe::count();

            // Get groups with their stagiaire counts
            $groupes = Groupe::withCount('stagiaires')->get();

            // Log the counts and relationship data for debugging
            \Log::info('Dashboard counts:', [
                'formateurs' => $totalFormateurs,
                'stagiaires' => $totalStagiaires,
                'users' => $totalUsers,
                'groups' => $totalGroups,
                'groupe_counts' => $groupes->pluck('stagiaires_count', 'name')
            ]);

            return view('Admin.dashboard', compact(
                'totalFormateurs',
                'totalStagiaires',
                'totalUsers',
                'totalGroups',
                'groupes'
            ));

        } catch (\Exception $e) {
            \Log::error('Dashboard Error: ' . $e->getMessage());
            return back()->with('error', 'Error loading dashboard data');
        }
    }

    public function charts()
    {
        // Check if user is logged in
        if (!session()->has('LoggedAdminInfo')) {
            return redirect()->route('admin.login');
        }

        try {
            // Get the counts
            $totalFormateurs = Formateur::count();
            $totalStagiaires = Stagiaire::count();
            $totalUsers = User::count();
            $totalGroups = Groupe::count();

            // Create the chart using dependency injection
            $chart = new LarapexChart();
            
            $chart = $chart->barChart()
                ->setTitle('Statistics')
                ->setSubtitle('Total counts of users in the system')
                ->addData('Counts', [$totalFormateurs, $totalStagiaires, $totalUsers, $totalGroups])
                ->setXAxis(['Formateurs', 'Stagiaires', 'Users', 'Groups']);

            return view('charts.charts', [
                'chart' => $chart,
                'LoggedAdminInfo' => session('LoggedAdminInfo'),
                'totalFormateurs' => $totalFormateurs,
                'totalStagiaires' => $totalStagiaires,
                'totalUsers' => $totalUsers,
                'totalGroups' => $totalGroups
            ]);

        } catch (\Exception $e) {
            \Log::error('Chart Error: ' . $e->getMessage());
            return back()->with('error', 'Error loading chart data');
        }
    }
}
