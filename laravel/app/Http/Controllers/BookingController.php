<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Notifications\BookingCancelled;
use App\Notifications\BookingCreated;
use App\Notifications\BookingRescheduled;
use Illuminate\Http\Request;
use App\Services\ActivityLogger;

class BookingController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'booking_date' => 'required|date|after_or_equal:today',
            'booking_time' => 'required|date_format:H:i',
            'payment_method' => 'required|string',
            'duration' => 'required|numeric|min:0.5',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        $service = \App\Models\Service::findOrFail($request->service_id);

        $booking = new Booking();
        $booking->user_id = auth()->id();
        $booking->service_id = $request->service_id;
        $booking->booking_date = $request->booking_date;
        $booking->booking_time = $request->booking_time;
        $booking->payment_method = $request->payment_method;
        $booking->duration = $request->duration;
        $booking->price = $service->price_per_hour * $request->duration;
        $booking->latitude = $request->latitude ?? null;
        $booking->longitude = $request->longitude ?? null;
        $booking->save();

        ActivityLogger::log(auth()->id(), 'Created a booking (ID: ' . $booking->id . ')');

        $masseuse = $booking->service->user;
        if ($masseuse) {
            $masseuse->notify(new BookingCreated($booking));
        }

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
        if ($booking->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'booking_date' => 'required|date|after_or_equal:today',
            'booking_time' => 'required|date_format:H:i',
        ]);

        $booking->booking_date = $request->booking_date;
        $booking->booking_time = $request->booking_time;
        $booking->save();

        ActivityLogger::log(auth()->id(), 'Updated booking (ID: ' . $booking->id . ')');

        // Notify the masseuse (not the user) about the reschedule
        $masseuse = $booking->service->user;
        if ($masseuse) {
            $masseuse->notify(new BookingRescheduled($booking));
        }

        return redirect()->route('bookings.my')->with('success', 'Booking updated successfully.');
    }

    public function destroy(Booking $booking)
    {
        if ($booking->user_id !== auth()->id()) {
            abort(403);
        }

        // Notify the masseuse before deletion
        $masseuse = $booking->service->user;
        if ($masseuse) {
            $masseuse->notify(new BookingCancelled($booking));
        }

        $booking->delete();

        ActivityLogger::log(auth()->id(), 'Cancelled booking (ID: ' . $booking->id . ')');

        return redirect()->route('bookings.my')->with('success', 'Booking cancelled successfully.');
    }

    public function masseuseBookings()
    {
        $user = auth()->user();

        $bookings = Booking::whereHas('service', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->with(['service', 'user'])
            ->orderBy('booking_date', 'desc')
            ->get();

        return view('services.masseuse-bookings', compact('bookings'));
    }

    public function showLocation(Booking $booking)
    {
        if (!$booking->latitude || !$booking->longitude) {
            abort(404, 'Location not available');
        }

        return view('services.location', compact('booking'));
    }
}
