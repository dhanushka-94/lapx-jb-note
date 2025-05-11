<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Job;
use App\Models\User;
use Illuminate\Http\Request;

class JobController extends Controller
{
    /**
     * Display a listing of the jobs.
     */
    public function index(Request $request)
    {
        $query = Job::with(['customer', 'assignedUser']);
        
        // Filter by status if provided
        if ($request->has('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }
        
        // Filter by assigned_to if provided
        if ($request->has('assigned_to') && $request->assigned_to != 'all') {
            $query->where('assigned_to', $request->assigned_to);
        }
        
        $jobs = $query->latest()->paginate(10);
        
        // Get users for filter dropdown
        $users = User::all();
        
        // Get statuses for filter dropdown
        $statuses = [
            'pending' => 'Pending',
            'in_progress' => 'In Progress',
            'waiting_for_parts' => 'Waiting for Parts',
            'completed' => 'Completed',
            'delivered' => 'Delivered',
            'cancelled' => 'Cancelled'
        ];
        
        return view('jobs.index', compact('jobs', 'users', 'statuses'));
    }

    /**
     * Show the form for creating a new job.
     */
    public function create()
    {
        $customers = Customer::all();
        $users = User::all();
        $jobNumber = Job::generateJobNumber();
        
        return view('jobs.create', compact('customers', 'users', 'jobNumber'));
    }

    /**
     * Store a newly created job in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'job_number' => 'required|string|unique:jobs',
            'customer_id' => 'required|exists:customers,id',
            'device_type' => 'required|string|max:255',
            'brand' => 'nullable|string|max:255',
            'model' => 'nullable|string|max:255',
            'serial_number' => 'nullable|string|max:255',
            'issue_description' => 'required|string',
            'diagnosis' => 'nullable|string',
            'resolution' => 'nullable|string',
            'cost' => 'nullable|numeric|min:0',
            'status' => 'required|in:pending,in_progress,waiting_for_parts,completed,delivered,cancelled',
            'received_date' => 'required|date',
            'estimated_completion_date' => 'nullable|date',
            'completed_date' => 'nullable|date',
            'delivered_date' => 'nullable|date',
            'assigned_to' => 'nullable|exists:users,id',
            'notes' => 'nullable|string',
        ]);

        Job::create($validated);

        return redirect()->route('jobs.index')
            ->with('success', 'Job created successfully.');
    }

    /**
     * Display the specified job.
     */
    public function show(Job $job)
    {
        $job->load(['customer', 'assignedUser']);
        
        return view('jobs.show', compact('job'));
    }

    /**
     * Show the form for editing the specified job.
     */
    public function edit(Job $job)
    {
        $customers = Customer::all();
        $users = User::all();
        
        return view('jobs.edit', compact('job', 'customers', 'users'));
    }

    /**
     * Update the specified job in storage.
     */
    public function update(Request $request, Job $job)
    {
        $validated = $request->validate([
            'job_number' => 'required|string|unique:jobs,job_number,' . $job->id,
            'customer_id' => 'required|exists:customers,id',
            'device_type' => 'required|string|max:255',
            'brand' => 'nullable|string|max:255',
            'model' => 'nullable|string|max:255',
            'serial_number' => 'nullable|string|max:255',
            'issue_description' => 'required|string',
            'diagnosis' => 'nullable|string',
            'resolution' => 'nullable|string',
            'cost' => 'nullable|numeric|min:0',
            'status' => 'required|in:pending,in_progress,waiting_for_parts,completed,delivered,cancelled',
            'received_date' => 'required|date',
            'estimated_completion_date' => 'nullable|date',
            'completed_date' => 'nullable|date',
            'delivered_date' => 'nullable|date',
            'assigned_to' => 'nullable|exists:users,id',
            'notes' => 'nullable|string',
        ]);

        $job->update($validated);

        return redirect()->route('jobs.index')
            ->with('success', 'Job updated successfully.');
    }

    /**
     * Remove the specified job from storage.
     */
    public function destroy(Job $job)
    {
        $job->delete();

        return redirect()->route('jobs.index')
            ->with('success', 'Job deleted successfully.');
    }
}
