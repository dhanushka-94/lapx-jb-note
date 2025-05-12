<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\NotifySmsService;
use Illuminate\Support\Facades\Config;

class TestSmsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:sms {phone} {message?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test SMS sending with the provided credentials';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Set the credentials directly in the configuration
        Config::set('services.notify.user_id', '12507');
        Config::set('services.notify.api_key', 'AB9581mSmfGHNU4TcM0t');
        Config::set('services.notify.sender_id', 'NotifyDEMO');
        
        $phoneNumber = $this->argument('phone');
        $message = $this->argument('message') ?? 'This is a test message from the Computer Service Center';
        
        $this->info("Sending SMS to: {$phoneNumber}");
        $this->info("Message: {$message}");
        
        try {
            $smsService = new NotifySmsService();
            
            // Check if credentials are loaded
            $this->info('User ID: ' . Config::get('services.notify.user_id'));
            $this->info('API Key: ' . Config::get('services.notify.api_key'));
            $this->info('Sender ID: ' . Config::get('services.notify.sender_id'));
            
            $success = $smsService->sendSms(
                $phoneNumber,
                $message,
                'test_message',
                null,
                null
            );
            
            if ($success) {
                $this->info('SMS sent successfully!');
            } else {
                $this->error('Failed to send SMS. Check logs for more details.');
            }
        } catch (\Exception $e) {
            $this->error('Error: ' . $e->getMessage());
        }
    }
} 