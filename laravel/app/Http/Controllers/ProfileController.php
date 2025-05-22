<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('profile.edit');
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . auth()->id(),
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = auth()->user();

        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            $image = $request->file('profile_picture');
            $imageName = time() . '_' . $image->getClientOriginalName();

            // Save image to 'public' disk (i.e., storage/app/public/profile_pictures)
            Storage::disk('public')->putFileAs('profile_pictures', $image, $imageName);

            // Delete old profile picture if exists
            if ($user->profile_picture && Storage::disk('public')->exists($user->profile_picture)) {
                Storage::disk('public')->delete($user->profile_picture);
            }

            $validated['profile_picture'] = 'profile_pictures/' . $imageName;
        }

        $user->update($validated);

        return redirect()->route('profile.edit')->with('success', 'Profile updated successfully.');
    }
}
