<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\TwoFactorCodeMail;

class LoginController extends Controller
{
    /**
     * Show the login form.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle an authentication attempt.
     */
    public function login(Request $request)
    {
        // Basic credential validation
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Attempt to sign the user in
        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();  // Session fixation protection
            $user = Auth::user();

            // 1️⃣ Check if email is verified
            if (is_null($user->email_verified_at)) {
                Auth::logout();
                $this->invalidate($request);

                return back()->withErrors([
                    'email' => 'Please verify your email before logging in.',
                ])->onlyInput('email');
            }

            // 2️⃣ If 2FA is enabled, generate & send code
            if ($user->two_factor_enabled) {
                // Generate 2FA code
                $code = random_int(100000, 999999);

                $user->forceFill([
                    'two_factor_code'       => $code,
                    'two_factor_expires_at' => now()->addMinutes(10),
                ])->save();

                // Store user ID in session
                $request->session()->put('2fa:user:id', $user->id);

                // Log the user out to treat them as a guest until 2FA is verified
                Auth::logout();
                $request->session()->regenerate(); // Keep session, just regenerate ID

                // Send 2FA code via email
                Mail::to($user->email)->send(new TwoFactorCodeMail($code));

                return redirect()->route('2fa.form');
            }

            // 3️⃣ No 2FA, go directly to home
            return redirect()->intended('/home');
        }

        // Invalid credentials
        return back()->withErrors([
            'email' => 'Invalid credentials.',
        ])->onlyInput('email');
    }

    /**
     * Log the user out.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $this->invalidate($request);

        return redirect()->route('login');
    }

    /**
     * Helper to invalidate the session cleanly.
     */
    protected function invalidate(Request $request, bool $regenerateToken = true): void
    {
        $request->session()->invalidate();
        if ($regenerateToken) {
            $request->session()->regenerateToken();
        }
    }
}