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
            // Get counts directly using DB to ensure we're getting data
            $totalFormateurs = DB::table('formateurs')->count();
            $totalStagiaires = DB::table('stagiaires')->count();
            $totalUsers = DB::table('users')->count();
            $totalGroups = DB::table('groupes')->count();

            // Log the counts for debugging
            \Log::info('Dashboard counts:', [
                'formateurs' => $totalFormateurs,
                'stagiaires' => $totalStagiaires,
                'users' => $totalUsers,
                'groups' => $totalGroups
            ]);

            return view('Admin.dashboard', compact(
                'totalFormateurs',
                'totalStagiaires',
                'totalUsers',
                'totalGroups'
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
