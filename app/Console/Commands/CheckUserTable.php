<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CheckUserTable extends Command
{
    protected $signature = 'check:users-table';
    protected $description = 'Check the users table structure';

    public function handle()
    {
        $this->info('Checking users table structure...');
        
        if (Schema::hasTable('users')) {
            $this->info('Users table exists');
            
            $columns = Schema::getColumnListing('users');
            $this->info('Columns in users table:');
            $this->table(['Column Name'], array_map(function($column) {
                return [$column];
            }, $columns));
            
            // Check for specific columns
            $requiredColumns = ['role', 'phone_number', 'skills', 'is_active'];
            foreach ($requiredColumns as $column) {
                if (in_array($column, $columns)) {
                    $this->info("Column '{$column}' exists ✓");
                } else {
                    $this->error("Column '{$column}' does not exist ✗");
                }
            }
        } else {
            $this->error('Users table does not exist');
        }
        
        return Command::SUCCESS;
    }
} 