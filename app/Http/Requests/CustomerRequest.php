<?php

namespace App\Http\Requests;

use App\Helpers\PhoneNumberFormatter;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CustomerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone_number_1' => [
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    if (!PhoneNumberFormatter::isValid($value)) {
                        $fail('The ' . $attribute . ' must be a valid Sri Lankan phone number (9 digits).');
                    }
                },
            ],
            'phone_number_2' => [
                'nullable',
                'string',
                function ($attribute, $value, $fail) {
                    if (!empty($value) && !PhoneNumberFormatter::isValid($value)) {
                        $fail('The ' . $attribute . ' must be a valid Sri Lankan phone number (9 digits).');
                    }
                },
            ],
            'home_phone_number' => [
                'nullable',
                'string',
                function ($attribute, $value, $fail) {
                    if (!empty($value) && !PhoneNumberFormatter::isValid($value)) {
                        $fail('The ' . $attribute . ' must be a valid Sri Lankan phone number (9 digits).');
                    }
                },
            ],
            'whatsapp_number' => [
                'nullable',
                'string',
                function ($attribute, $value, $fail) {
                    if (!empty($value) && !PhoneNumberFormatter::isValid($value)) {
                        $fail('The ' . $attribute . ' must be a valid Sri Lankan phone number (9 digits).');
                    }
                },
            ],
            'address' => 'nullable|string|max:500',
            'notes' => 'nullable|string',
            'disable_sms' => 'boolean',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // No need to modify the input data before validation
    }

    /**
     * Get the validated data from the request.
     *
     * @return array
     */
    public function validated($key = null, $default = null)
    {
        $validated = parent::validated($key, $default);

        // Format phone numbers for storage
        if (is_array($validated)) {
            if (isset($validated['phone_number_1'])) {
                $validated['phone_number_1'] = PhoneNumberFormatter::clean($validated['phone_number_1']);
            }
            
            if (isset($validated['phone_number_2'])) {
                $validated['phone_number_2'] = PhoneNumberFormatter::clean($validated['phone_number_2']);
            }
            
            if (isset($validated['home_phone_number'])) {
                $validated['home_phone_number'] = PhoneNumberFormatter::clean($validated['home_phone_number']);
            }
            
            if (isset($validated['whatsapp_number'])) {
                $validated['whatsapp_number'] = PhoneNumberFormatter::clean($validated['whatsapp_number']);
            }
        }

        return $validated;
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'phone_number_1' => 'primary phone number',
            'phone_number_2' => 'secondary phone number',
            'home_phone_number' => 'home phone number',
            'whatsapp_number' => 'WhatsApp number',
        ];
    }
}
