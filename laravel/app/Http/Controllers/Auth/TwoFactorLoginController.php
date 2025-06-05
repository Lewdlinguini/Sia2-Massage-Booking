<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use App\Models\User;

class TwoFactorLoginController extends Controller
{
    /**
     * Show the 2FA verification form.
     */
    public function show2faForm(Request $request)
    {
        if (!$request->session()->has('2fa:user:id')) {
            return redirect()->route('login');
        }

        return view('auth.2fa');
    }

    /**
     * Verify the 2FA code.
     */
    public function verify2faCode(Request $request)
    {
        $request->validate([
            'code' => 'required|digits:6',
        ]);

        if (!$request->session()->has('2fa:user:id')) {
            return redirect()->route('login')->withErrors(['code' => 'Session expired, please login again.']);
        }

        $userId = $request->session()->get('2fa:user:id');
        $user = User::find($userId);

        if (!$user) {
            return redirect()->route('login')->withErrors(['code' => 'User not found.']);
        }

        if (
            $user->two_factor_code === $request->code &&
            $user->two_factor_expires_at &&
            Carbon::parse($user->two_factor_expires_at)->isFuture()
        ) {
            // Valid 2FA code, complete login
            Auth::login($user);

            // Clear 2FA values
            $user->forceFill([
                'two_factor_code'       => null,
                'two_factor_expires_at' => null,
            ])->save();

            $request->session()->forget('2fa:user:id');

            // Redirect based on user role
            if ($user->role === 'Admin') {
            return redirect()->intended(route('admin.dashboard'));
            }

            return redirect()->intended('/home');
        }

        return back()->withErrors(['code' => 'Invalid or expired 2FA code.']);
    }
}
