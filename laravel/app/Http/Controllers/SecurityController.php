<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class SecurityController extends Controller
{
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $user = $request->user();

        // Check if current password is correct
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect'])->withInput();
        }

        // Update password
        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success', 'Password updated successfully!');
    }

    public function enable2FA(Request $request)
    {
        $request->validate(['current_password' => 'required']);

        $user = $request->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json(['success' => false, 'message' => 'Incorrect current password.']);
        }

        // Generate 6-digit code
        $code = rand(100000, 999999);

        // Save code and expiry (e.g., 10 mins)
        $user->two_factor_code = $code;
        $user->two_factor_expires_at = Carbon::now()->addMinutes(10);
        $user->two_factor_enabled = true;
        $user->save();

        // Send email with code via SMTP
        Mail::send('emails.twofactor', ['code' => $code, 'user' => $user], function ($message) use ($user) {
            $message->to($user->email)
                ->subject('Your Two-Factor Authentication Code');
        });

        return response()->json(['success' => true]);
    }

    // Disable 2FA
    public function disable2FA(Request $request)
    {
        $request->validate(['current_password' => 'required']);

        $user = $request->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json(['success' => false, 'message' => 'Incorrect current password.']);
        }

        $user->two_factor_enabled = false;
        $user->two_factor_code = null;
        $user->two_factor_expires_at = null;
        $user->save();

        return response()->json(['success' => true]);
    }

    public function show2faForm()
    {
    if (auth()->user()->role === 'Admin') {
        return view('admin.profile.security');
    } else {
        return view('profile.security');
    }
    }
}