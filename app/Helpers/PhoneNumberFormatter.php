<?php

namespace App\Helpers;

class PhoneNumberFormatter
{
    /**
     * Format a phone number to Sri Lankan standard
     * Format: +94 xx xx xx xxx
     *
     * @param string|null $phoneNumber
     * @return string|null
     */
    public static function format(?string $phoneNumber): ?string
    {
        if (empty($phoneNumber)) {
            return null;
        }

        // Remove all non-numeric characters
        $digits = preg_replace('/[^0-9]/', '', $phoneNumber);

        // If number starts with 0, remove it
        if (substr($digits, 0, 1) === '0') {
            $digits = substr($digits, 1);
        }

        // If number doesn't start with 94, add it
        if (substr($digits, 0, 2) !== '94') {
            $digits = '94' . $digits;
        }

        // Ensure we have exactly 11 digits (94 + 9 digits)
        if (strlen($digits) > 11) {
            $digits = substr($digits, 0, 11);
        } elseif (strlen($digits) < 11) {
            // If less than 11 digits, return original with +94 prefix
            return '+94 ' . substr($digits, 2);
        }

        // Format as +94 xx xx xx xxx
        return '+' . substr($digits, 0, 2) . ' ' 
                   . substr($digits, 2, 2) . ' ' 
                   . substr($digits, 4, 2) . ' ' 
                   . substr($digits, 6, 2) . ' ' 
                   . substr($digits, 8, 3);
    }

    /**
     * Clean phone number for storage
     * Store as: +94xxxxxxxxx
     *
     * @param string|null $phoneNumber
     * @return string|null
     */
    public static function clean(?string $phoneNumber): ?string
    {
        if (empty($phoneNumber)) {
            return null;
        }

        // Remove all non-numeric characters
        $digits = preg_replace('/[^0-9]/', '', $phoneNumber);

        // If number starts with 0, remove it
        if (substr($digits, 0, 1) === '0') {
            $digits = substr($digits, 1);
        }

        // If number doesn't start with 94, add it
        if (substr($digits, 0, 2) !== '94') {
            $digits = '94' . $digits;
        }

        // Ensure we have exactly 11 digits (94 + 9 digits)
        if (strlen($digits) > 11) {
            $digits = substr($digits, 0, 11);
        }

        return '+' . $digits;
    }

    /**
     * Validate if the phone number is a valid Sri Lankan number
     *
     * @param string|null $phoneNumber
     * @return bool
     */
    public static function isValid(?string $phoneNumber): bool
    {
        if (empty($phoneNumber)) {
            return false;
        }

        $digits = preg_replace('/[^0-9]/', '', $phoneNumber);
        
        // Remove the leading 0 if present
        if (substr($digits, 0, 1) === '0') {
            $digits = substr($digits, 1);
        }
        
        // Remove 94 if present at the beginning
        if (substr($digits, 0, 2) === '94') {
            $digits = substr($digits, 2);
        }
        
        // Check that we have 9 digits for a Sri Lankan number
        return strlen($digits) === 9;
    }
} 