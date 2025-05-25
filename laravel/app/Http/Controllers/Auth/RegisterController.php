<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register'); // your custom register form
    }

    public function register(Request $request)
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'date_of_birth' => ['required', 'date', 'before:today'],
        ]);

        $dateOfBirth = Carbon::parse($request->date_of_birth);
        $age = $dateOfBirth->age;

        User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'age' => $age,
            'date_of_birth' => $request->date_of_birth,  // Make sure you added this column to users table
        ]);

        return redirect()->route('login')->with('success', 'Registration successful! Please login.');
    }
}
