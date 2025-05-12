<?php

namespace App\Models;

use App\Helpers\PhoneNumberFormatter;
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
        'disable_sms',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'formatted_phone_number_1',
        'formatted_phone_number_2',
        'formatted_home_phone_number',
        'formatted_whatsapp_number',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'disable_sms' => 'boolean',
    ];

    /**
     * Get the formatted primary phone number.
     *
     * @return string|null
     */
    public function getFormattedPhoneNumber1Attribute()
    {
        return PhoneNumberFormatter::format($this->phone_number_1);
    }

    /**
     * Get the formatted secondary phone number.
     *
     * @return string|null
     */
    public function getFormattedPhoneNumber2Attribute()
    {
        return PhoneNumberFormatter::format($this->phone_number_2);
    }

    /**
     * Get the formatted home phone number.
     *
     * @return string|null
     */
    public function getFormattedHomePhoneNumberAttribute()
    {
        return PhoneNumberFormatter::format($this->home_phone_number);
    }

    /**
     * Get the formatted WhatsApp number.
     *
     * @return string|null
     */
    public function getFormattedWhatsappNumberAttribute()
    {
        return PhoneNumberFormatter::format($this->whatsapp_number);
    }

    /**
     * Get the jobs for the customer.
     */
    public function jobs(): HasMany
    {
        return $this->hasMany(Job::class);
    }
}
