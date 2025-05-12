<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Customer;
use App\Models\Job;
use App\Models\User;
use Carbon\Carbon;
use Faker\Factory as Faker;

class DemoDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Set up faker
        $faker = Faker::create();
        
        // Preserve users but clear all other data
        $this->command->info('Clearing existing data...');
        
        // Check database connection type
        $connection = config('database.default');
        $isSQLite = $connection === 'sqlite';
        
        if ($isSQLite) {
            // SQLite doesn't support FOREIGN_KEY_CHECKS
            DB::table('service_jobs')->delete();
            DB::table('job_status_histories')->delete();
            DB::table('sms_logs')->delete();
            DB::table('customers')->delete();
        } else {
            // MySQL/MariaDB approach
            // Disable foreign key checks to allow truncating
            DB::statement('SET FOREIGN_KEY_CHECKS=0');
            
            // Clear existing data - add all tables except users
            DB::table('service_jobs')->truncate();
            DB::table('customers')->truncate();
            DB::table('job_status_histories')->truncate();
            
            // Check if sms_logs exists before trying to truncate
            try {
                DB::table('sms_logs')->truncate();
            } catch (\Exception $e) {
                $this->command->info('SMS logs table not found. Skipping...');
            }
            
            // Re-enable foreign key checks
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
        }
        
        $this->command->info('Existing data cleared successfully!');
        
        // Get available users for job assignment
        $users = User::all();
        
        if ($users->isEmpty()) {
            $this->command->error('No users found in the system. Please create users first.');
            return;
        }
        
        // Create 50 customers
        $this->command->info('Creating 50 sample customers...');
        
        $customers = [];
        for ($i = 0; $i < 50; $i++) {
            $customers[] = [
                'name' => $faker->name,
                'phone_number_1' => $faker->numerify('07########'),
                'phone_number_2' => $faker->optional(0.7)->numerify('07########'),
                'home_phone_number' => $faker->optional(0.5)->numerify('0#########'),
                'whatsapp_number' => $faker->optional(0.8)->numerify('07########'),
                'email' => $faker->optional(0.6)->safeEmail,
                'address' => $faker->optional(0.8)->address,
                'notes' => $faker->optional(0.3)->sentence(10),
                'created_at' => $faker->dateTimeBetween('-1 year', 'now'),
                'updated_at' => now(),
            ];
        }
        
        // Insert customers in chunks to avoid memory issues
        foreach (array_chunk($customers, 10) as $chunk) {
            Customer::insert($chunk);
        }
        
        // Get inserted customers
        $customerIds = Customer::pluck('id')->toArray();
        
        // Create 120 jobs with random distribution across statuses
        $this->command->info('Creating 120 sample jobs...');
        
        $statuses = [
            'pending' => 25,
            'in_progress' => 30,
            'waiting_for_parts' => 15,
            'completed' => 35,
            'delivered' => 10,
            'cancelled' => 5
        ];
        
        $deviceTypes = [
            'Laptop' => 60,
            'Desktop' => 20,
            'Tablet' => 10,
            'Phone' => 20,
            'Printer' => 5,
            'Monitor' => 5
        ];
        
        $brands = [
            'Apple', 'Dell', 'HP', 'Lenovo', 'Asus', 'Acer', 'Samsung', 'Microsoft', 
            'Sony', 'LG', 'Toshiba', 'MSI', 'Huawei', 'Xiaomi', 'Canon', 'Epson'
        ];
        
        $jobNumber = 10000;
        $jobsCreated = 0;
        
        foreach ($statuses as $status => $count) {
            for ($i = 0; $i < $count; $i++) {
                $jobsCreated++;
                
                // Random dates based on status
                $receivedDate = $faker->dateTimeBetween('-6 months', '-1 day');
                $estimatedCompletionDate = $faker->optional(0.9)->dateTimeBetween($receivedDate, '+2 weeks');
                
                $completedDate = null;
                $deliveredDate = null;
                
                if (in_array($status, ['completed', 'delivered'])) {
                    $completedDate = $faker->dateTimeBetween($receivedDate, 'now');
                    
                    if ($status === 'delivered') {
                        $deliveredDate = $faker->dateTimeBetween($completedDate, 'now');
                    }
                }
                
                // Random device type with weighted distribution
                $deviceType = $this->getRandomWeightedElement($deviceTypes);
                $brand = $faker->randomElement($brands);
                
                // Create job
                $job = new Job();
                $job->job_number = 'LPXTS' . str_pad($jobNumber++, 5, '0', STR_PAD_LEFT);
                $job->customer_id = $faker->randomElement($customerIds);
                $job->device_type = $deviceType;
                $job->brand = $brand;
                $job->model = $faker->bothify('?###?') . ' ' . $faker->word;
                $job->serial_number = $faker->optional(0.7)->bothify('??####?####??');
                $job->issue_description = $faker->paragraph(2);
                $job->diagnosis = $faker->optional(0.8)->paragraph(2);
                $job->resolution = ($status === 'completed' || $status === 'delivered') ? $faker->paragraph(2) : $faker->optional(0.3)->paragraph(1);
                
                // Ensure cost is never null but use different ranges based on status
                if ($status === 'completed' || $status === 'delivered') {
                    $job->cost = $faker->numberBetween(1500, 25000);
                } else if ($status === 'in_progress' || $status === 'waiting_for_parts') {
                    $job->cost = $faker->optional(0.7, 0)->numberBetween(1000, 30000);
                } else {
                    $job->cost = 0; // Default for pending/cancelled
                }
                
                $job->status = $status;
                $job->received_date = $receivedDate;
                $job->estimated_completion_date = $estimatedCompletionDate;
                $job->completed_date = $completedDate;
                $job->delivered_date = $deliveredDate;
                $job->assigned_to = $faker->optional(0.8)->randomElement($users->pluck('id')->toArray());
                $job->notes = $faker->optional(0.4)->paragraph(1);
                $job->created_at = $receivedDate;
                $job->updated_at = $deliveredDate ?? $completedDate ?? now();
                $job->save();
                
                // Create status history
                $job->recordStatusChange($status, $users->random()->id ?? null, 'Initial job status');
                
                // Add more status history for older jobs
                if ($faker->boolean(70) && $receivedDate < Carbon::now()->subDays(7)) {
                    $statuses = ['pending', 'in_progress', 'waiting_for_parts', 'completed', 'delivered'];
                    $currentStatusIndex = array_search($status, $statuses);
                    
                    if ($currentStatusIndex !== false && $currentStatusIndex > 0) {
                        $statusDate = clone $receivedDate;
                        
                        for ($j = 0; $j < $currentStatusIndex; $j++) {
                            $statusDate = $faker->dateTimeBetween($statusDate, $completedDate ?? $deliveredDate ?? now());
                            $job->statusHistory()->create([
                                'status' => $statuses[$j],
                                'user_id' => $users->random()->id ?? null,
                                'notes' => $faker->optional(0.6)->sentence(),
                                'created_at' => $statusDate,
                                'updated_at' => $statusDate
                            ]);
                        }
                    }
                }
            }
        }
        
        $this->command->info("Demo data created successfully! Created {$jobsCreated} jobs for 50 customers.");
    }
    
    /**
     * Get a random element with weighted probability.
     */
    private function getRandomWeightedElement(array $weightedValues)
    {
        $rand = mt_rand(1, array_sum($weightedValues));
        
        foreach ($weightedValues as $key => $value) {
            $rand -= $value;
            if ($rand <= 0) {
                return $key;
            }
        }
    }
} 