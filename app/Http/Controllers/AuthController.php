<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\TwilioService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    protected TwilioService $twilio;

    public function __construct(TwilioService $twilio)
    {
        $this->twilio = $twilio;
    }

    // ── Show Login Page (fallback if JS disabled) ──
    public function showLogin()
    {
        if (Auth::check()) {
            return Auth::user()->isAdmin()
                ? redirect()->route('admin.dashboard')
                : redirect()->route('user.dashboard');
        }
        // Redirect to home and open modal via JS
        return redirect()->route('home')->with('open_login_modal', true);
    }

    // ── STEP 1: Submit email or phone — returns JSON ──
    public function submitIdentifier(Request $request)
    {
        $request->validate(['identifier' => 'required|string']);

        $identifier = trim($request->identifier);
        $isEmail    = filter_var($identifier, FILTER_VALIDATE_EMAIL);
        $isPhone    = preg_match('/^[0-9]{10,15}$/', preg_replace('/\D/', '', $identifier));

        if (!$isEmail && !$isPhone) {
            return response()->json(['error' => 'Please enter a valid email or 10-digit phone number.']);
        }

        // ── EMAIL: Admin or registered user with password ──
        if ($isEmail) {
            $user = User::where('email', $identifier)->first();
            if (!$user) {
                return response()->json(['error' => 'No account found with this email. Contact admin.']);
            }
            session(['auth_identifier' => $identifier]);
            return response()->json(['step' => 'password']);
        }

        // ── PHONE: Customer OTP login ──
        $phone = preg_replace('/\D/', '', $identifier);

        // Create account if new user
        $user = User::firstOrCreate(
            ['phone' => $phone],
            ['name' => 'Customer', 'role' => 'customer', 'is_verified' => false]
        );

        // Generate and send OTP
        $otp  = $user->generateOtp();
        $sent = $this->twilio->sendOtp($phone, $otp);

        if (!$sent) {
            Log::info("DEV OTP for {$phone}: {$otp}");
        }

        session(['auth_phone' => $phone]);

        return response()->json([
            'step'    => 'otp',
            'dev_otp' => config('app.env') === 'local' ? $otp : null,
        ]);
    }

    // ── STEP 2a: Verify password — returns JSON ──
    public function verifyPassword(Request $request)
    {
        $request->validate(['password' => 'required|string']);

        $identifier = session('auth_identifier');
        $user = User::where('email', $identifier)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['error' => 'Incorrect password. Please try again.']);
        }

        Auth::login($user, $request->boolean('remember'));
        session()->forget('auth_identifier');

        $redirect = $user->isAdmin()
            ? route('admin.dashboard')
            : route('user.dashboard');

        return response()->json(['redirect' => $redirect]);
    }

    // ── STEP 2b: Verify OTP — returns JSON ──
    public function verifyOtp(Request $request)
    {
        $request->validate(['otp' => 'required|string']);

        $phone = session('auth_phone');
        if (!$phone) {
            return response()->json(['error' => 'Session expired. Please start again.']);
        }

        $user = User::where('phone', $phone)->first();

        if (!$user || !$user->verifyOtp($request->otp)) {
            return response()->json(['error' => 'Invalid or expired OTP. Please try again.']);
        }

        $user->clearOtp();
        $user->update(['is_verified' => true]);
        Auth::login($user, true);
        session()->forget('auth_phone');

        return response()->json(['redirect' => route('user.dashboard')]);
    }

    // ── Resend OTP — returns JSON ──
    public function resendOtp(Request $request)
    {
        $phone = session('auth_phone');
        if (!$phone) {
            return response()->json(['message' => 'Session expired. Please start again.']);
        }

        $user = User::where('phone', $phone)->firstOrFail();
        $otp  = $user->generateOtp();
        $sent = $this->twilio->sendOtp($phone, $otp);

        return response()->json([
            'message' => $sent ? '✅ OTP resent successfully!' : '⚠️ SMS failed. Dev OTP: ' . $otp,
        ]);
    }

    // ── Logout ──
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home')->with('success', 'You have been logged out.');
    }
}
