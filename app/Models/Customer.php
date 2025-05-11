<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone_number_1',
        'phone_number_2',
        'home_phone_number',
        'whatsapp_number',
        'address',
        'notes',
    ];

    /**
     * Get the jobs for the customer.
     */
    public function jobs(): HasMany
    {
        return $this->hasMany(Job::class);
    }
}
