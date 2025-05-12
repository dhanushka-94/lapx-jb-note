<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Job;
use App\Models\User;
use App\Services\NotifySmsService;
use Illuminate\Http\Request;

class JobController extends Controller
{
    /**
     * Display a listing of the jobs.
     */
    public function index(Request $request)
    {
        $query = Job::with(['customer', 'assignedUser']);
        
        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                // Search in job fields
                $q->where('job_number', 'like', "%{$searchTerm}%")
                  ->orWhere('device_type', 'like', "%{$searchTerm}%")
                  ->orWhere('brand', 'like', "%{$searchTerm}%")
                  ->orWhere('model', 'like', "%{$searchTerm}%")
                  ->orWhere('serial_number', 'like', "%{$searchTerm}%")
                  ->orWhere('issue_description', 'like', "%{$searchTerm}%");
                
                // Search in customer fields
                $q->orWhereHas('customer', function($query) use ($searchTerm) {
                    $query->where('name', 'like', "%{$searchTerm}%")
                          ->orWhere('phone_number_1', 'like', "%{$searchTerm}%");
                });
            });
        }
        
        // Filter by status if provided
        if ($request->has('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }
        
        // Filter by assigned_to if provided
        if ($request->has('assigned_to') && $request->assigned_to != 'all') {
            $query->where('assigned_to', $request->assigned_to);
        }
        
        // Filter by customer if provided
        if ($request->has('customer_id') && $request->customer_id != 'all') {
            $query->where('customer_id', $request->customer_id);
        }
        
        // Filter by date range - received date
        if ($request->has('received_date_from') && $request->received_date_from) {
            $query->whereDate('received_date', '>=', $request->received_date_from);
        }
        
        if ($request->has('received_date_to') && $request->received_date_to) {
            $query->whereDate('received_date', '<=', $request->received_date_to);
        }
        
        $jobs = $query->latest()->paginate(10);
        
        // Get users for filter dropdown
        $users = User::all();
        
        // Get customers for filter dropdown
        $customers = Customer::orderBy('name')->get();
        
        // Get statuses for filter dropdown
        $statuses = [
            'pending' => 'Pending',
            'in_progress' => 'In Progress',
            'waiting_for_parts' => 'Waiting for Parts',
            'completed' => 'Completed',
            'delivered' => 'Delivered',
            'cancelled' => 'Cancelled'
        ];
        
        return view('jobs.index', compact('jobs', 'users', 'customers', 'statuses'));
    }

    /**
     * Show the form for creating a new job.
     */
    public function create()
    {
        $customers = Customer::all();
        $users = User::where('role', 'technician')->where('is_active', true)->get();
        $jobNumber = Job::generateJobNumber();
        
        return view('jobs.create', compact('customers', 'users', 'jobNumber'));
    }

    /**
     * Store a newly created job in storage.
     */
    public function store(Request $request)
    {
        // Clean cost value to remove any commas from the formatted value
        if ($request->has('cost')) {
            $request->merge(['cost' => str_replace(',', '', $request->cost)]);
        }
        
        $validated = $request->validate([
            'job_number' => 'required|string|unique:service_jobs',
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

        // Create the job
        $job = Job::create($validated);
        
        // Record the initial status
        $job->recordStatusChange($validated['status'], auth()->id(), 'Initial job status');
        
        // Send SMS notification
        try {
            $smsService = new NotifySmsService();
            $job->load('customer'); // Make sure customer relation is loaded
            
            if ($job->customer && $job->customer->phone_number_1) {
                $smsService->sendJobCreatedNotification($job);
            }
        } catch (\Exception $e) {
            // Log error but don't interrupt the flow
            \Log::error('Failed to send job creation SMS: ' . $e->getMessage());
        }

        return redirect()->route('jobs.index')
            ->with('success', 'Job created successfully.');
    }

    /**
     * Display the specified job.
     */
    public function show(Job $job)
    {
        $job->load(['customer', 'assignedUser', 'statusHistory.user']);
        
        return view('jobs.show', compact('job'));
    }

    /**
     * Show the form for editing the specified job.
     */
    public function edit(Job $job)
    {
        $customers = Customer::all();
        $users = User::where('role', 'technician')->where('is_active', true)->get();
        
        return view('jobs.edit', compact('job', 'customers', 'users'));
    }

    /**
     * Update the specified job in storage.
     */
    public function update(Request $request, Job $job)
    {
        // Clean cost value to remove any commas from the formatted value
        if ($request->has('cost')) {
            $request->merge(['cost' => str_replace(',', '', $request->cost)]);
        }
        
        $validated = $request->validate([
            'job_number' => 'required|string|unique:service_jobs,job_number,' . $job->id,
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

        // Check if status has changed
        $oldStatus = $job->status;
        if ($oldStatus !== $validated['status']) {
            // Record the status change
            $job->recordStatusChange($validated['status'], auth()->id());
            
            // Send SMS notification
            try {
                $smsService = new NotifySmsService();
                $job->load('customer'); // Make sure customer relation is loaded
                
                if ($job->customer && $job->customer->phone_number_1) {
                    $smsService->sendJobStatusUpdateNotification($job, $oldStatus, $validated['status']);
                }
            } catch (\Exception $e) {
                // Log error but don't interrupt the flow
                \Log::error('Failed to send status update SMS: ' . $e->getMessage());
            }
        }

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

    /**
     * Update the status of a job.
     */
    public function updateStatus(Request $request, Job $job)
    {
        // Log the incoming request for debugging
        \Log::info('Status update request', [
            'job_id' => $job->id,
            'status' => $request->status,
            'content_type' => $request->header('Content-Type'),
            'all_data' => $request->all()
        ]);
        
        $validated = $request->validate([
            'status' => 'required|in:pending,in_progress,waiting_for_parts,completed,delivered,cancelled',
        ]);

        // Only update if status actually changed
        if ($job->status !== $validated['status']) {
            $oldStatus = $job->status;
            
            // Record the status change with the current user ID
            $job->recordStatusChange($validated['status'], auth()->id());
            
            // Update the job status
            $job->update(['status' => $validated['status']]);
            
            // Send SMS notification
            try {
                $smsService = new NotifySmsService();
                $job->load('customer'); // Make sure customer relation is loaded
                
                if ($job->customer && $job->customer->phone_number_1) {
                    $smsService->sendJobStatusUpdateNotification($job, $oldStatus, $validated['status']);
                }
            } catch (\Exception $e) {
                // Log error but don't interrupt the flow
                \Log::error('Failed to send status update SMS: ' . $e->getMessage());
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Job status updated successfully.',
            'new_status' => $validated['status'],
            'new_status_label' => ucfirst(str_replace('_', ' ', $validated['status']))
        ]);
    }
    
    /**
     * Generate a PDF receipt for the job.
     */
    public function generateReceipt(Job $job)
    {
        $job->load(['customer', 'assignedUser']);
        
        $statusLabels = [
            'pending' => 'Pending',
            'in_progress' => 'In Progress',
            'waiting_for_parts' => 'Waiting for Parts',
            'completed' => 'Completed',
            'delivered' => 'Delivered',
            'cancelled' => 'Cancelled',
        ];
        
        $pdf = \PDF::loadView('jobs.receipt', [
            'job' => $job,
            'statusLabel' => $statusLabels[$job->status] ?? $job->status,
            'date' => now()->format('Y-m-d'),
        ]);
        
        return $pdf->stream("receipt-{$job->job_number}.pdf");
    }

    /**
     * Display jobs requiring attention (highlights)
     */
    public function highlights()
    {
        // Get jobs requiring attention with full details
        $pendingJobs = Job::where('status', 'pending')
                        ->with('customer', 'assignedUser')
                        ->latest()
                        ->get();
        
        $inProgressJobs = Job::where('status', 'in_progress')
                        ->with('customer', 'assignedUser')
                        ->latest()
                        ->get();
        
        $waitingForPartsJobs = Job::where('status', 'waiting_for_parts')
                        ->with('customer', 'assignedUser')
                        ->latest()
                        ->get();
        
        // Get counts for highlights
        $pendingCount = $pendingJobs->count();
        $inProgressCount = $inProgressJobs->count();
        $waitingForPartsCount = $waitingForPartsJobs->count();
        
        return view('jobs.highlights', compact(
            'pendingJobs',
            'inProgressJobs',
            'waitingForPartsJobs',
            'pendingCount',
            'inProgressCount',
            'waitingForPartsCount'
        ));
    }
}
