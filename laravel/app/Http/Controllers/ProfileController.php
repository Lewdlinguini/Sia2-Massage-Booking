<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function edit()
    {
        // Return edit profile view
        return view('profile.edit');
    }

    public function update(Request $request)
    {
        // Validate input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . auth()->id(),
        ]);

        // Update user info
        $user = auth()->user();
        $user->update($validated);

        // Redirect back with success message
        return redirect()->route('profile.edit')->with('success', 'Profile updated successfully.');
    }
}