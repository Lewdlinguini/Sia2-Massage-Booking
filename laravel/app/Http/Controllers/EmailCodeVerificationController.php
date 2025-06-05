<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerifyEmailCodeMail;
use Illuminate\Support\Carbon;

class EmailCodeVerificationController extends Controller
{
    public function showForm()
    {
        return view('auth.verify-code');
    }

    public function verify(Request $request)
    {
        $request->validate(['code' => 'required|digits:6']);
        $user = $request->user();

        $expiresAt = $user->email_code_expires_at
            ? Carbon::parse($user->email_code_expires_at)
            : null;

        if (
            $expiresAt?->isFuture() &&
            Hash::check($request->code, $user->email_verify_code)
        ) {
            $user->forceFill([
                'email_verified_at'     => now(),
                'email_verify_code'     => null,
                'email_code_expires_at' => null,
            ])->save();

            return redirect()->intended('/home')->with('success', 'Email verified!');
        }

        return back()->withErrors(['code' => 'Invalid or expired code.']);
    }

    public function resend(Request $request)
    {
        $user = $request->user();
        $code = random_int(100000, 999999);

        $user->forceFill([
            'email_verify_code'     => Hash::make($code),
            'email_code_expires_at' => now()->addMinutes(15),
        ])->save();

        Mail::to($user->email)->send(new VerifyEmailCodeMail($code));

        return back()->with('message', 'A new code has been sent.');
    }
}