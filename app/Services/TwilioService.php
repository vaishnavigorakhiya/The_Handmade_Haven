<?php
// app/Services/TwilioService.php

namespace App\Services;

use Twilio\Rest\Client;
use Exception;
use Illuminate\Support\Facades\Log;

class TwilioService
{
    protected Client $client;
    protected string $from;

    public function __construct()
    {
        $this->client = new Client(
            config('services.twilio.sid'),
            config('services.twilio.token')
        );
        $this->from = config('services.twilio.from');
    }

    /**
     * Send OTP SMS via Twilio
     */
    public function sendOtp(string $phone, string $otp): bool
    {
        try {
            // Ensure phone has country code
            $phone = $this->formatPhone($phone);

            $this->client->messages->create($phone, [
                'from' => $this->from,
                'body' => "Your Stitch & Bloom OTP is: {$otp}\nValid for 10 minutes. Do not share this code.",
            ]);

            Log::info("OTP sent to {$phone}");
            return true;

        } catch (Exception $e) {
            Log::error("Twilio error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Format phone to E.164 format (e.g. +919876543210)
     */
    private function formatPhone(string $phone): string
    {
        $phone = preg_replace('/\D/', '', $phone);

        // If 10 digits (Indian number), prepend +91
        if (strlen($phone) === 10) {
            return '+91' . $phone;
        }

        // If already has country code
        if (strlen($phone) > 10) {
            return '+' . $phone;
        }

        return '+' . $phone;
    }
}
