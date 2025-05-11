<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Job extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'service_jobs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'job_number',
        'customer_id',
        'device_type',
        'brand',
        'model',
        'serial_number',
        'issue_description',
        'diagnosis',
        'resolution',
        'cost',
        'status',
        'received_date',
        'estimated_completion_date',
        'completed_date',
        'delivered_date',
        'assigned_to',
        'notes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'received_date' => 'date',
        'estimated_completion_date' => 'date',
        'completed_date' => 'date',
        'delivered_date' => 'date',
        'cost' => 'decimal:2',
    ];

    /**
     * Get the customer that owns the job.
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get the user that the job is assigned to.
     */
    public function assignedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    /**
     * Generate a unique job number.
     */
    public static function generateJobNumber(): string
    {
        $prefix = 'JOB';
        $year = date('Y');
        $month = date('m');
        
        $lastJob = self::latest()->first();
        $number = $lastJob ? (intval(substr($lastJob->job_number, -5)) + 1) : 1;
        
        return $prefix . $year . $month . str_pad($number, 5, '0', STR_PAD_LEFT);
    }
}
