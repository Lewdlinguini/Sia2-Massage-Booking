<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Service;

class HomeController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if ($user && is_null($user->email_verified_at)) {
            Auth::logout();
            session()->invalidate();
            session()->regenerateToken();
            return redirect()->route('login')->withErrors([
                'email' => 'Please verify your email before accessing the home page.',
            ]);
        }

        // Fetch the highest-rated service with at least 1 rating and image
        $featuredService = Service::withCount('bookings')
            ->withAvg('ratings', 'stars')   // <-- changed here
            ->whereHas('ratings') // must have at least one rating
            ->whereNotNull('image')
            ->orderByDesc('ratings_avg_stars') // <-- and here (withAvg creates this column)
            ->orderByDesc('bookings_count')    // tie-breaker: most bookings
            ->first();

        return view('home', compact('featuredService'));
    }
}