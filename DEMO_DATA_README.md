# Demo Data Seeder

This file documents how to use the demo data seeder to populate the Laptop Expert Service Center application with sample data.

## Overview

The demo data seeder creates:
- 50 sample customers with various contact details
- 120 service jobs distributed across different statuses:
  - 25 pending jobs
  - 30 in-progress jobs
  - 15 waiting for parts jobs
  - 35 completed jobs
  - 10 delivered jobs
  - 5 cancelled jobs

Jobs are created with realistic data including device types, brands, models, and appropriate costs based on their status.

## Running the Seeder

To run the seeder and populate your database with sample data:

```bash
php artisan db:seed --class=DemoDataSeeder
```

This will:
1. Clear existing data from the customers, service_jobs, job_status_histories, and SMS logs tables
2. Create 50 new sample customers
3. Create 120 service jobs distributed across various statuses
4. Create appropriate job status history records

**Important:** The seeder preserves existing user data but removes all other data.

## Verifying the Data

You can verify the seeded data using the custom verification command:

```bash
php artisan demo:verify
```

This command will display:
- Total number of customers and jobs
- Breakdown of jobs by status
- Breakdown of jobs by device type

## Customizing the Seeder

To modify the number or distribution of sample data:

1. Edit `database/seeders/DemoDataSeeder.php`
2. Adjust the number of customers by changing the loop counter in the customer creation section
3. Modify the job status distribution by changing the count values in the `$statuses` array
4. Adjust device type distribution by changing values in the `$deviceTypes` array

## Troubleshooting

If you encounter issues:

1. Make sure your database migrations are up to date: `php artisan migrate:status`
2. Check that the table names in the seeder match your actual database tables
3. Try running with verbose output: `php artisan db:seed --class=DemoDataSeeder -v` 