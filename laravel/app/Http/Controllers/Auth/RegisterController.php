<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;          
use Illuminate\Support\Facades\Auth;          
use App\Mail\VerifyEmailCodeMail;  
           
class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');

    
}

public function register(Request $request)
    {
        $request->validate([
            'first_name'   => ['required', 'string', 'max:255'],
            'last_name'    => ['required', 'string', 'max:255'],
            'email'        => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password'     => ['required', 'string', 'min:8', 'confirmed'],
            'date_of_birth'=> ['required', 'date', 'before:today'],
            'role'         => ['required', 'in:User,Masseuse'],
        ]);

        
        $age = Carbon::parse($request->date_of_birth)->age;

        
        $user = User::create([
            'first_name'    => $request->first_name,
            'last_name'     => $request->last_name,
            'email'         => $request->email,
            'password'      => Hash::make($request->password),
            'age'           => $age,
            'date_of_birth' => $request->date_of_birth,
            'role'          => $request->role,
        ]);

        $code = random_int(100000, 999999);

        $user->forceFill([
            'email_verify_code'     => Hash::make($code),
            'email_code_expires_at' => now()->addMinutes(15),
        ])->save();

        Mail::to($user->email)->send(new VerifyEmailCodeMail($code));
       
        Auth::login($user);

        return redirect()->route('verification.code.form');
    }
}