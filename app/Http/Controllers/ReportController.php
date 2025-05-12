<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Customer;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /**
     * Display the reports dashboard.
     */
    public function index()
    {
        // Get date ranges
        $today = Carbon::today();
        $thisWeekStart = Carbon::now()->startOfWeek();
        $thisMonthStart = Carbon::now()->startOfMonth();
        $thisYearStart = Carbon::now()->startOfYear();

        // Get overall statistics
        $totalJobs = Job::count();
        $totalCustomers = Customer::count();
        $totalRevenue = Job::sum('cost');

        // Get jobs by status
        $jobsByStatus = Job::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status')
            ->toArray();

        // Get job counts by time period
        $jobsToday = Job::whereDate('created_at', $today)->count();
        $jobsThisWeek = Job::where('created_at', '>=', $thisWeekStart)->count();
        $jobsThisMonth = Job::where('created_at', '>=', $thisMonthStart)->count();
        $jobsThisYear = Job::where('created_at', '>=', $thisYearStart)->count();
        
        // Get revenue by time period
        $revenueToday = Job::whereDate('created_at', $today)->sum('cost');
        $revenueThisWeek = Job::where('created_at', '>=', $thisWeekStart)->sum('cost');
        $revenueThisMonth = Job::where('created_at', '>=', $thisMonthStart)->sum('cost');
        $revenueThisYear = Job::where('created_at', '>=', $thisYearStart)->sum('cost');

        // Get jobs by device type
        $jobsByDeviceType = Job::select('device_type', DB::raw('count(*) as count'))
            ->groupBy('device_type')
            ->get()
            ->pluck('count', 'device_type')
            ->toArray();

        // Get technician statistics
        $technicianStats = Job::select('assigned_to', DB::raw('count(*) as total_jobs'), DB::raw('sum(cost) as total_revenue'))
            ->whereNotNull('assigned_to')
            ->groupBy('assigned_to')
            ->with('assignedUser')
            ->get();

        // Get monthly reports for the last 6 months
        $last6Months = collect([]);
        for ($i = 0; $i < 6; $i++) {
            $month = Carbon::now()->subMonths($i);
            $last6Months->push([
                'month' => $month->format('M Y'),
                'jobs' => Job::whereYear('created_at', $month->year)
                    ->whereMonth('created_at', $month->month)
                    ->count(),
                'revenue' => Job::whereYear('created_at', $month->year)
                    ->whereMonth('created_at', $month->month)
                    ->sum('cost'),
            ]);
        }
        
        // Recent activity - last 10 jobs
        $recentJobs = Job::with(['customer', 'assignedUser'])
            ->latest()
            ->take(10)
            ->get();

        return view('reports.index', compact(
            'totalJobs', 
            'totalCustomers', 
            'totalRevenue',
            'jobsByStatus',
            'jobsToday',
            'jobsThisWeek',
            'jobsThisMonth',
            'jobsThisYear',
            'revenueToday',
            'revenueThisWeek',
            'revenueThisMonth',
            'revenueThisYear',
            'jobsByDeviceType',
            'technicianStats',
            'last6Months',
            'recentJobs'
        ));
    }

    /**
     * Export a specific report
     */
    public function export(Request $request)
    {
        // For future implementation
        return redirect()->back()->with('info', 'Export feature coming soon.');
    }
}
