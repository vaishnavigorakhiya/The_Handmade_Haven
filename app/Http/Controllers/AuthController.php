<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\TwilioService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    protected TwilioService $twilio;

    public function __construct(TwilioService $twilio)
    {
        $this->twilio = $twilio;
    }

    public function showLogin(Request $request)
    {
        
        return redirect()->route('home')->with('open_login_modal', true);
    }

    public function submitIdentifier(Request $request)
    {
        $request->validate(['identifier' => 'required|string']);

        $identifier = trim($request->identifier);
        $isEmail    = filter_var($identifier, FILTER_VALIDATE_EMAIL);
        $isPhone    = preg_match('/^[0-9]{10,15}$/', preg_replace('/\D/', '', $identifier));

        if (!$isEmail && !$isPhone) {
            return response()->json(['error' => 'Please enter a valid email address or 10-digit phone number.']);
        }

        
        if ($isEmail) {
            $user = User::where('email', $identifier)->first();

            if (!$user) {
                
                session(['auth_register_email' => $identifier]);
                return response()->json(['step' => 'register']);
            }

            session(['auth_identifier' => $identifier]);
            return response()->json(['step' => 'password']);
        }

        $phone = preg_replace('/\D/', '', $identifier);

        $user = User::firstOrCreate(
            ['phone' => $phone],
            ['name' => 'Customer', 'role' => 'customer', 'is_verified' => false]
        );

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

    public function verifyPassword(Request $request)
    {
        $request->validate(['password' => 'required|string']);

        $identifier = session('auth_identifier');
        if (!$identifier) {
            return response()->json(['error' => 'Session expired. Please start again.']);
        }

        $user = User::where('email', $identifier)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['error' => 'Incorrect password. Please try again.']);
        }

        Auth::login($user, $request->boolean('remember'));
        session()->forget('auth_identifier');
        session()->regenerate();

        $intended = session()->pull('url.intended');
        $default  = $user->isAdmin()
            ? route('admin.dashboard')
            : route('user.dashboard');

        return response()->json(['redirect' => $intended ?: $default]);
    }

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
        session()->regenerate();

        $intended = session()->pull('url.intended');
        return response()->json(['redirect' => $intended ?: route('user.dashboard')]);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'                  => 'required|string|min:2|max:100',
            'email'                 => 'required|email|unique:users,email',
            'password'              => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required|string',
        ], [
            'name.required'              => 'Please enter your full name.',
            'name.min'                   => 'Name must be at least 2 characters.',
            'email.required'             => 'Email address is required.',
            'email.email'                => 'Please enter a valid email address.',
            'email.unique'               => 'This email is already registered. Please login instead.',
            'password.required'          => 'Please create a password.',
            'password.min'               => 'Password must be at least 8 characters.',
            'password.confirmed'         => 'Passwords do not match.',
            'password_confirmation.required' => 'Please confirm your password.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()->toArray(),
                'error'  => $validator->errors()->first(),
            ], 422);
        }

        $user = User::create([
            'name'        => $request->name,
            'email'       => strtolower(trim($request->email)),
            'password'    => Hash::make($request->password),
            'role'        => 'customer',
            'is_verified' => true,
        ]);

        session()->forget('auth_register_email');
        Auth::login($user, true);
        session()->regenerate();

        $intended = session()->pull('url.intended');
        return response()->json(['redirect' => $intended ?: route('user.dashboard')]);
    }

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

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home')->with('success', 'You have been logged out.');
    }
}
