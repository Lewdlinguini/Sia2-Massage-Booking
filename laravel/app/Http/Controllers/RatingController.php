<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rating;

class RatingController extends Controller
{
   public function store(Request $request)
   {
    $request->validate([
        'service_id' => 'required|exists:services,id',
        'stars' => 'required|integer|min:1|max:5',
    ]);

    $rating = Rating::updateOrCreate(
        ['user_id' => auth()->id(), 'service_id' => $request->service_id],
        ['stars' => $request->stars]
    );

    $rating->service->updateRatingStats();

    return back()->with('success', 'Thank you for rating!');
}

}