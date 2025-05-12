<?php

namespace App\Services;

use App\Models\Job;
use App\Models\SmsLog;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class NotifySmsService
{
    protected $userId;
    protected $apiKey;
    protected $senderId;
    protected $apiUrl;

    public function __construct()
    {
        // Use direct credentials instead of config
        $this->userId = '12507'; // Direct credential
        $this->apiKey = 'AB9581mSmfGHNU4TcM0t'; // Direct credential
        $this->senderId = 'NotifyDEMO';
        $this->apiUrl = 'https://app.notify.lk/api/v1/send';
        
        // Log the credentials being used
        Log::info('NotifySmsService initialized with credentials', [
            'user_id' => $this->userId,
            'sender_id' => $this->senderId
        ]);
    }

    /**
     * Send SMS to a phone number
     * 
     * @param string $phoneNumber The recipient's phone number (format: 9471XXXXXXX)
     * @param string $message The SMS message to send
     * @param string $type The type of SMS (job_created, status_update, etc.)
     * @param int|null $customerId The customer ID if available
     * @param int|null $jobId The job ID if available
     * @return bool Success status
     */
    public function sendSms($phoneNumber, $message, $type = 'status_update', $customerId = null, $jobId = null)
    {
        try {
            // Format phone number if needed (remove leading zeros or + signs)
            $phoneNumber = $this->formatPhoneNumber($phoneNumber);

            // Make API request
            $response = Http::get($this->apiUrl, [
                'user_id' => $this->userId,
                'api_key' => $this->apiKey,
                'sender_id' => $this->senderId,
                'to' => $phoneNumber,
                'message' => $message,
            ]);

            $result = $response->json();
            $success = ($result['status'] ?? '') === 'success';

            // Log the response
            Log::info('SMS sent via Notify.lk', [
                'to' => $phoneNumber,
                'response' => $result,
                'success' => $success
            ]);

            // Log to database
            SmsLog::create([
                'customer_id' => $customerId,
                'job_id' => $jobId,
                'phone_number' => $phoneNumber,
                'message' => $message,
                'type' => $type,
                'success' => $success,
                'response' => json_encode($result),
                'error' => $success ? null : ($result['message'] ?? 'Unknown error'),
            ]);

            return $success;
        } catch (\Exception $e) {
            Log::error('Failed to send SMS via Notify.lk', [
                'error' => $e->getMessage(),
                'to' => $phoneNumber
            ]);

            // Log failure to database
            SmsLog::create([
                'customer_id' => $customerId,
                'job_id' => $jobId,
                'phone_number' => $phoneNumber,
                'message' => $message,
                'type' => $type,
                'success' => false,
                'error' => $e->getMessage(),
            ]);

            return false;
        }
    }

    /**
     * Format phone number to be compatible with Notify.lk API
     * 
     * @param string $phoneNumber
     * @return string
     */
    protected function formatPhoneNumber($phoneNumber)
    {
        // Remove any non-numeric characters
        $number = preg_replace('/[^0-9]/', '', $phoneNumber);
        
        // If it starts with 0, remove it
        if (substr($number, 0, 1) === '0') {
            $number = substr($number, 1);
        }
        
        // If it starts with 94, keep it as is
        // If not, add 94 (Sri Lanka country code) at the beginning
        if (substr($number, 0, 2) !== '94') {
            $number = '94' . $number;
        }
        
        return $number;
    }

    /**
     * Send job created notification to customer
     * 
     * @param \App\Models\Job $job
     * @return bool
     */
    public function sendJobCreatedNotification($job)
    {
        // Check if customer has disabled SMS notifications
        if ($job->customer->disable_sms) {
            Log::info('SMS notification skipped: customer has disabled SMS', [
                'customer_id' => $job->customer_id,
                'job_id' => $job->id
            ]);
            return false;
        }
        
        $message = "Dear {$job->customer->name}, your service job #{$job->job_number} has been created. We will keep you updated on its progress. Thank you for choosing our service. - Laptop Expert Service Center";
        
        return $this->sendSms(
            $job->customer->phone_number_1,
            $message,
            'job_created',
            $job->customer_id,
            $job->id
        );
    }

    /**
     * Send job status update notification to customer
     * 
     * @param \App\Models\Job $job
     * @param string $oldStatus
     * @param string $newStatus
     * @return bool
     */
    public function sendJobStatusUpdateNotification($job, $oldStatus, $newStatus)
    {
        // Check if customer has disabled SMS notifications
        if ($job->customer->disable_sms) {
            Log::info('SMS notification skipped: customer has disabled SMS', [
                'customer_id' => $job->customer_id,
                'job_id' => $job->id,
                'status_change' => "$oldStatus -> $newStatus"
            ]);
            return false;
        }
        
        $statusLabels = [
            'pending' => 'Pending',
            'in_progress' => 'In Progress',
            'waiting_for_parts' => 'Waiting for Parts',
            'completed' => 'Completed',
            'delivered' => 'Delivered',
            'cancelled' => 'Cancelled'
        ];
        
        $newStatusLabel = $statusLabels[$newStatus] ?? $newStatus;
        
        $message = "Dear {$job->customer->name}, your service job #{$job->job_number} status has been updated to {$newStatusLabel}. ";
        
        // Add specific messages based on the new status
        if ($newStatus === 'completed') {
            $message .= "Your device is ready for pickup. Thank you for your patience. ";
        } elseif ($newStatus === 'waiting_for_parts') {
            $message .= "We are waiting for parts to arrive. We'll update you once they're in. ";
        } elseif ($newStatus === 'delivered') {
            $message .= "Your device has been delivered. Thank you for choosing our service. ";
        }
        
        $message .= "- Laptop Expert Service Center";
        
        return $this->sendSms(
            $job->customer->phone_number_1,
            $message,
            'status_update',
            $job->customer_id,
            $job->id
        );
    }
} 