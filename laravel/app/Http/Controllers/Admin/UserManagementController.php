<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserManagementController extends Controller
{
    public function index()
{
    $users = User::paginate(15);
    return view('admin.users.index', compact('users'));
}

public function edit(User $user)
{
    $roles = ['admin', 'masseuse', 'user'];
    return view('admin.users.edit', compact('user', 'roles'));
}

public function update(Request $request, User $user)
{
    $request->validate([
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'date_of_birth' => 'required|date',
        'role' => 'required|in:admin,masseuse,user',
        'password' => 'nullable|string|min:6|confirmed',
        'is_active' => 'sometimes|boolean',
    ]);

    $input = $request->only('first_name', 'last_name', 'date_of_birth', 'role');
    $input['is_active'] = $request->has('is_active') ? true : false;

    if ($request->filled('password')) {
        $input['password'] = Hash::make($request->password);
    }

    $user->update($input);
    
    return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
}

public function destroy(User $user)
{
    $user->delete();
    return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
}
}