<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('service_jobs', function (Blueprint $table) {
            $table->id();
            $table->string('job_number')->unique();
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
            $table->string('device_type'); // Desktop, Laptop, Printer, etc.
            $table->string('brand')->nullable();
            $table->string('model')->nullable();
            $table->string('serial_number')->nullable();
            $table->text('issue_description');
            $table->text('diagnosis')->nullable();
            $table->text('resolution')->nullable();
            $table->decimal('cost', 10, 2)->default(0.00);
            $table->enum('status', ['pending', 'in_progress', 'waiting_for_parts', 'completed', 'delivered', 'cancelled'])->default('pending');
            $table->date('received_date');
            $table->date('estimated_completion_date')->nullable();
            $table->date('completed_date')->nullable();
            $table->date('delivered_date')->nullable();
            $table->foreignId('assigned_to')->nullable()->references('id')->on('users');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_jobs');
    }
};
