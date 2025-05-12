<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Job;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the dashboard page.
     */
    public function index()
    {
        // Count totals
        $userCount = User::count();
        $customerCount = Customer::count();
        $jobCount = Job::count();
        
        // Get recent jobs
        $recentJobs = Job::with('customer')
                        ->latest()
                        ->take(5)
                        ->get();
        
        // Get recent customers
        $recentCustomers = Customer::latest()
                            ->take(5)
                            ->get();
        
        // Get jobs requiring attention
        $pendingJobs = Job::where('status', 'pending')
                        ->with('customer', 'assignedUser')
                        ->latest()
                        ->take(5)
                        ->get();
        
        $inProgressJobs = Job::where('status', 'in_progress')
                        ->with('customer', 'assignedUser')
                        ->latest()
                        ->take(5)
                        ->get();
        
        $waitingForPartsJobs = Job::where('status', 'waiting_for_parts')
                        ->with('customer', 'assignedUser')
                        ->latest()
                        ->take(5)
                        ->get();
        
        // Get counts for highlights
        $pendingCount = Job::where('status', 'pending')->count();
        $inProgressCount = Job::where('status', 'in_progress')->count();
        $waitingForPartsCount = Job::where('status', 'waiting_for_parts')->count();
        
        return view('dashboard', compact(
            'userCount',
            'customerCount',
            'jobCount',
            'recentJobs',
            'recentCustomers',
            'pendingJobs',
            'inProgressJobs',
            'waitingForPartsJobs',
            'pendingCount',
            'inProgressCount',
            'waitingForPartsCount'
        ));
    }
} 