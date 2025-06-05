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

        // Fetch top 3 highest-rated services with at least one rating and an image
        $featuredServices = Service::withCount('bookings')
            ->withAvg('ratings', 'stars')
            ->whereHas('ratings')
            ->whereNotNull('image')
            ->orderByDesc('ratings_avg_stars')
            ->orderByDesc('bookings_count')
            ->take(3)
            ->get();

        return view('home', compact('featuredServices'));
    }
}