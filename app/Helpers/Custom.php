<?php

use App\Models\Country;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\UploadedFile;
use Intervention\Image\Facades\Image;

/**
 * Check if the application is running in a production environment.
 *
 * This function checks the application's RELEASE_STATUS configuration setting to determine if it's in a production environment.
 *
 * @return bool True if the application is in production; false if it's not.
 */
if (!function_exists('onProduction')) {
    function onProduction()
    {
        return config('ws_config.RELEASE_STATUS') == 'staging' ? false : true;
    }
}
/**
 * Generate a 4-digit One-Time Password (OTP).
 *
 * This function generates a random 4-digit OTP and returns it as a string.
 *
 * @return string The generated OTP.
 */
if (!function_exists('generateOTP')) {
    function generateOTP()
    {
        return str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);
    }
}
