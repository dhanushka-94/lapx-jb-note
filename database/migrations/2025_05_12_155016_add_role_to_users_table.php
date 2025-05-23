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
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'user', 'technician'])->default('user')->after('email');
            $table->string('phone_number')->nullable()->after('role');
            $table->text('skills')->nullable()->after('phone_number');
            $table->boolean('is_active')->default(true)->after('skills');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'phone_number', 'skills', 'is_active']);
        });
    }
};
