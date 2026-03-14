<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Log;

class TwilioService
{
    protected $client = null;
    protected string $from;

    public function __construct()
    {
        $sid   = config('services.twilio.sid');
        $token = config('services.twilio.token');
        $this->from = config('services.twilio.from', '+10000000000');

        // Only load Twilio if real credentials are provided
        if ($sid && $token && $sid !== 'test' && str_starts_with($sid, 'AC')) {
            try {
                $this->client = new \Twilio\Rest\Client($sid, $token);
            } catch (Exception $e) {
                Log::error('Twilio init failed: ' . $e->getMessage());
                $this->client = null;
            }
        }
    }

    public function sendOtp(string $phone, string $otp): bool
    {
        // No real client — just log the OTP
        if (!$this->client) {
            Log::info("DEV OTP for {$phone}: {$otp}");
            return false;
        }

        try {
            $phone = $this->formatPhone($phone);
            $this->client->messages->create($phone, [
                'from' => $this->from,
                'body' => "Your Stitch & Bloom OTP is: {$otp}. Valid for 10 minutes. Do not share.",
            ]);
            Log::info("OTP sent to {$phone}");
            return true;
        } catch (Exception $e) {
            Log::error('Twilio send error: ' . $e->getMessage());
            return false;
        }
    }

    private function formatPhone(string $phone): string
    {
        $phone = preg_replace('/\D/', '', $phone);
        if (strlen($phone) === 10) {
            return '+91' . $phone;
        }
        return '+' . $phone;
    }
}