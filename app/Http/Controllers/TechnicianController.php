<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class TechnicianController extends Controller
{
    /**
     * Display a listing of the technicians.
     */
    public function index()
    {
        $technicians = User::technicians()->latest()->paginate(10);
        return view('technicians.index', compact('technicians'));
    }

    /**
     * Show the form for creating a new technician.
     */
    public function create()
    {
        return view('technicians.create');
    }

    /**
     * Store a newly created technician in storage.
     */
    public function store(Request $request)
    {
        // Log request data for debugging
        \Log::info('Creating technician', $request->all());
        
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'phone_number' => ['nullable', 'string', 'max:20'],
            'skills' => ['nullable', 'string'],
        ]);

        try {
            // Create technician with role set to 'technician'
            User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => 'technician',
                'phone_number' => $validated['phone_number'] ?? null,
                'skills' => $validated['skills'] ?? null,
                'is_active' => $request->has('is_active'),
            ]);

            return redirect()->route('technicians.index')
                ->with('success', 'Technician created successfully.');
        } catch (\Exception $e) {
            \Log::error('Error creating technician: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error creating technician: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified technician.
     */
    public function show(User $technician)
    {
        // Make sure the user is a technician
        if (!$technician->isTechnician()) {
            return redirect()->route('technicians.index')
                ->with('error', 'The specified user is not a technician.');
        }

        // Get assigned jobs
        $assignedJobs = $technician->assignedJobs()->latest()->take(5)->get();
        $activeJobsCount = $technician->assignedJobs()
            ->whereIn('status', ['pending', 'in_progress', 'waiting_for_parts'])
            ->count();

        return view('technicians.show', compact('technician', 'assignedJobs', 'activeJobsCount'));
    }

    /**
     * Show the form for editing the specified technician.
     */
    public function edit(User $technician)
    {
        // Make sure the user is a technician
        if (!$technician->isTechnician()) {
            return redirect()->route('technicians.index')
                ->with('error', 'The specified user is not a technician.');
        }

        return view('technicians.edit', compact('technician'));
    }

    /**
     * Update the specified technician in storage.
     */
    public function update(Request $request, User $technician)
    {
        // Make sure the user is a technician
        if (!$technician->isTechnician()) {
            return redirect()->route('technicians.index')
                ->with('error', 'The specified user is not a technician.');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required', 
                'string', 
                'email', 
                'max:255', 
                Rule::unique('users')->ignore($technician->id),
            ],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'phone_number' => ['nullable', 'string', 'max:20'],
            'skills' => ['nullable', 'string'],
            'is_active' => ['boolean'],
        ]);

        $technicianData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone_number' => $validated['phone_number'] ?? null,
            'skills' => $validated['skills'] ?? null,
            'is_active' => $request->has('is_active'),
        ];

        if (!empty($validated['password'])) {
            $technicianData['password'] = Hash::make($validated['password']);
        }

        $technician->update($technicianData);

        return redirect()->route('technicians.index')
            ->with('success', 'Technician updated successfully.');
    }

    /**
     * Remove the specified technician from storage.
     */
    public function destroy(User $technician)
    {
        // Make sure the user is a technician
        if (!$technician->isTechnician()) {
            return redirect()->route('technicians.index')
                ->with('error', 'The specified user is not a technician.');
        }

        // Check if technician has assigned jobs
        $hasJobs = $technician->assignedJobs()->exists();
        if ($hasJobs) {
            return redirect()->route('technicians.index')
                ->with('error', 'Cannot delete a technician who has assigned jobs. Reassign their jobs first.');
        }

        $technician->delete();

        return redirect()->route('technicians.index')
            ->with('success', 'Technician deleted successfully.');
    }

    /**
     * Display the jobs assigned to the specified technician.
     */
    public function jobs(User $technician)
    {
        // Make sure the user is a technician
        if (!$technician->isTechnician()) {
            return redirect()->route('technicians.index')
                ->with('error', 'The specified user is not a technician.');
        }

        $jobs = $technician->assignedJobs()->with('customer')->latest()->paginate(10);

        return view('technicians.jobs', compact('technician', 'jobs'));
    }
}
