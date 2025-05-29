<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'booking_date' => 'required|date|after_or_equal:today',
            'payment_method' => 'required|string',
        ]);

        $booking = new Booking();
        $booking->user_id = Auth::id(); 
        $booking->service_id = $request->service_id;
        $booking->booking_date = $request->booking_date;
        $booking->payment_method = $request->payment_method;
        // Assuming you added latitude and longitude to the form (hidden inputs or JS)
        $booking->latitude = $request->latitude ?? null;  
        $booking->longitude = $request->longitude ?? null;
        $booking->save();

        // Redirect to my-bookings route with success flag
        return redirect()->route('bookings.my')->with('booking_success', true);
    }

    public function myBookings()
    {
        $userId = auth()->id();
        
        $bookings = Booking::with('service.user')
            ->where('user_id', $userId)
            ->orderBy('booking_date', 'desc')
            ->get();
            
        return view('services.my-bookings', compact('bookings'));
    }
    
    public function update(Request $request, Booking $booking)
    {
        // Check if the user owns the booking
        if ($booking->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'booking_date' => 'required|date|after_or_equal:today',
        ]);

        $booking->booking_date = $request->booking_date;
        $booking->save();

        return redirect()->route('bookings.my')->with('success', 'Booking updated successfully.');
    }
    
    public function destroy(Booking $booking)
    {
        if ($booking->user_id !== auth()->id()) {
            abort(403);
        }
        $booking->delete();

        return redirect()->route('bookings.my')->with('success', 'Booking cancelled successfully.');
    }

    public function masseuseBookings()
    {
        $user = auth()->user();

        $bookings = Booking::whereHas('service', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->with(['service', 'user'])->orderBy('booking_date', 'desc')->get();

        return view('services.masseuse-bookings', compact('bookings'));
    }
}