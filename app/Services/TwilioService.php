<?php
// app/Services/TwilioService.php

namespace App\Services;

use Twilio\Rest\Client;
use Exception;
use Illuminate\Support\Facades\Log;

class TwilioService
{
    protected ?Client $client = null;
    protected string $from;

    public function __construct()
    {
        $sid   = config('services.twilio.sid');
        $token = config('services.twilio.token');
        $this->from = config('services.twilio.from', '+10000000000');

        if ($sid && $token && $sid !== 'test') {
            $this->client = new Client($sid, $token);
        }
    }

    /**
     * Send OTP SMS via Twilio
     */
    public function sendOtp(string $phone, string $otp): bool
    {
        if (!$this->client) {
            Log::info("DEV OTP for {$phone}: {$otp}");
            return false;
        }

        try {
            $phone = $this->formatPhone($phone);
            $this->client->messages->create($phone, [
                'from' => $this->from,
                'body' => "Your Stitch & Bloom OTP is: {$otp}. Valid for 10 minutes.",
            ]);
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
