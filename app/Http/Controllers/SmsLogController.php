<?php

namespace App\Http\Controllers;

use App\Models\SmsLog;
use App\Models\Customer;
use Illuminate\Http\Request;

class SmsLogController extends Controller
{
    /**
     * Display a listing of SMS logs.
     */
    public function index(Request $request)
    {
        $query = SmsLog::with(['customer', 'job']);
        
        // Filter by success status if provided
        if ($request->has('status') && $request->status != 'all') {
            $query->where('success', $request->status === 'success');
        }
        
        // Filter by type if provided
        if ($request->has('type') && $request->type != 'all') {
            $query->where('type', $request->type);
        }
        
        // Filter by customer if provided
        if ($request->has('customer_id') && $request->customer_id != 'all') {
            $query->where('customer_id', $request->customer_id);
        }
        
        // Filter by date range if provided
        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        
        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        
        $smsLogs = $query->latest()->paginate(20);
        
        // Get customers for filter dropdown
        $customers = Customer::orderBy('name')->get();
        
        // Get SMS types for filter dropdown
        $types = [
            'job_created' => 'Job Created',
            'status_update' => 'Status Update',
        ];
        
        // Get statuses for filter dropdown
        $statuses = [
            'success' => 'Success',
            'failed' => 'Failed',
        ];
        
        return view('sms_logs.index', compact('smsLogs', 'customers', 'types', 'statuses'));
    }
    
    /**
     * Display the specified SMS log.
     */
    public function show(SmsLog $smsLog)
    {
        $smsLog->load(['customer', 'job']);
        
        return view('sms_logs.show', compact('smsLog'));
    }
    
    /**
     * Show SMS test form
     */
    public function testForm()
    {
        return view('sms_logs.test');
    }
    
    /**
     * Send a test SMS
     */
    public function sendTest(Request $request)
    {
        $request->validate([
            'phone_number' => 'required|string',
            'message' => 'required|string',
        ]);
        
        try {
            $smsService = new \App\Services\NotifySmsService();
            
            $success = $smsService->sendSms(
                $request->phone_number,
                $request->message,
                'test_message',
                null,
                null
            );
            
            if ($success) {
                return redirect()->route('sms-logs.test')
                    ->with('success', 'Test SMS sent successfully to ' . $request->phone_number);
            } else {
                return redirect()->route('sms-logs.test')
                    ->with('error', 'Failed to send test SMS. Check logs for more details.');
            }
        } catch (\Exception $e) {
            return redirect()->route('sms-logs.test')
                ->with('error', 'Error: ' . $e->getMessage());
        }
    }
}
