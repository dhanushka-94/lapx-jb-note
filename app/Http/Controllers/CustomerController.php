<?php

namespace App\Http\Controllers;

use App\Helpers\PhoneNumberFormatter;
use App\Http\Requests\CustomerRequest;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the customers.
     */
    public function index(Request $request)
    {
        $query = Customer::query();
        
        // Apply search filters if provided
        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('email', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('phone_number_1', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('phone_number_2', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('home_phone_number', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('whatsapp_number', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('address', 'LIKE', "%{$searchTerm}%");
            });
        }
        
        $customers = $query->latest()->paginate(10);
        
        // Append search query to pagination links
        if ($request->has('search')) {
            $customers->appends(['search' => $request->search]);
        }
        
        return view('customers.index', compact('customers'));
    }

    /**
     * Show the form for creating a new customer.
     */
    public function create()
    {
        return view('customers.create');
    }

    /**
     * Store a newly created customer in storage.
     */
    public function store(CustomerRequest $request)
    {
        $validated = $request->validated();
        
        Customer::create($validated);

        return redirect()->route('customers.index')
            ->with('success', 'Customer created successfully.');
    }

    /**
     * Display the specified customer.
     */
    public function show(Customer $customer)
    {
        // Format phone numbers for display
        $customer->phone_number_1 = PhoneNumberFormatter::format($customer->phone_number_1);
        $customer->phone_number_2 = PhoneNumberFormatter::format($customer->phone_number_2);
        $customer->home_phone_number = PhoneNumberFormatter::format($customer->home_phone_number);
        $customer->whatsapp_number = PhoneNumberFormatter::format($customer->whatsapp_number);
        
        // Load the customer's jobs
        $customer->load('jobs');
        
        return view('customers.show', compact('customer'));
    }

    /**
     * Show the form for editing the specified customer.
     */
    public function edit(Customer $customer)
    {
        return view('customers.edit', compact('customer'));
    }

    /**
     * Update the specified customer in storage.
     */
    public function update(CustomerRequest $request, Customer $customer)
    {
        $validated = $request->validated();
        
        $customer->update($validated);

        return redirect()->route('customers.index')
            ->with('success', 'Customer updated successfully.');
    }

    /**
     * Remove the specified customer from storage.
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();

        return redirect()->route('customers.index')
            ->with('success', 'Customer deleted successfully.');
    }
}
