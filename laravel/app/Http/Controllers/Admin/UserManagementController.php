<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserManagementController extends Controller
{
    public function create()
    {
        
        $roles = ['Admin', 'Masseuse', 'User'];

        return view('admin.users.create', compact('roles'));
    }

    public function store(Request $request)
{
    $request->validate([
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'date_of_birth' => 'required|date',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:6|confirmed', // password confirmation check
        'role' => 'required|in:User,Masseuse',
    ]);

    $user = User::create([
        'first_name' => $request->first_name,
        'last_name' => $request->last_name,
        'date_of_birth' => $request->date_of_birth,
        'email' => $request->email,
        'password' => bcrypt($request->password),
        'role' => $request->role,
    ]);

    return redirect()->back()->with('success', 'User created successfully!');
}

}
