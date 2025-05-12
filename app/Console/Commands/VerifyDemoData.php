<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Customer;
use App\Models\Job;
use Illuminate\Support\Facades\DB;

class VerifyDemoData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'demo:verify';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verify demo data is properly populated';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $customerCount = Customer::count();
        $jobCount = Job::count();

        $this->info("===== Demo Data Summary =====");
        $this->info("Total Customers: {$customerCount}");
        $this->info("Total Jobs: {$jobCount}");
        
        $this->info("\nJobs by Status:");
        $jobsByStatus = Job::select('status', DB::raw('count(*) as count'))
                        ->groupBy('status')
                        ->get();

        $table = [];
        foreach ($jobsByStatus as $status) {
            $table[] = [$status->status, $status->count];
        }
        
        $this->table(['Status', 'Count'], $table);
        
        $this->info("\nDevice Types:");
        $deviceTypes = Job::select('device_type', DB::raw('count(*) as count'))
                        ->groupBy('device_type')
                        ->get();
                        
        $table = [];
        foreach ($deviceTypes as $type) {
            $table[] = [$type->device_type, $type->count];
        }
        
        $this->table(['Device Type', 'Count'], $table);

        $this->info("\nDemo data verification completed.");
        
        return Command::SUCCESS;
    }
} 