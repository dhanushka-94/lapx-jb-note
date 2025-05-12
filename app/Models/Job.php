<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
     * Get the status history for the job.
     */
    public function statusHistory(): HasMany
    {
        return $this->hasMany(JobStatusHistory::class)->orderBy('created_at', 'desc');
    }

    /**
     * Record a status change in history.
     */
    public function recordStatusChange(string $status, ?int $userId = null, ?string $notes = null): void
    {
        $this->statusHistory()->create([
            'status' => $status,
            'user_id' => $userId,
            'notes' => $notes,
        ]);
    }

    /**
     * Generate a unique job number.
     */
    public static function generateJobNumber(): string
    {
        $prefix = 'LPXTS';
        
        $lastJob = self::latest()->first();
        
        // Get the sequence number from the last job or start with 1
        if ($lastJob && preg_match('/^LPXTS(\d+)$/', $lastJob->job_number, $matches)) {
            $sequence = intval($matches[1]) + 1;
        } else {
            $sequence = 1;
        }
        
        // Format: LPXTS + XXXXX (5-digit incremental number padded with zeros)
        return $prefix . str_pad($sequence, 5, '0', STR_PAD_LEFT);
    }
}
