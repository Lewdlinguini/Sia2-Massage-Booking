<?php

namespace App\Http\Controllers;

use App\Notifications\BookingCreated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Service;

class ServiceController extends Controller
{

    public function index(Request $request)
{
    $query = Service::with('user');

    // Filter by search input
    if ($request->has('search') && !empty($request->search)) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('description', 'like', "%{$search}%");
        });
    }

    $services = $query->get();

    // Get active bookings for authenticated user
    $activeBookings = [];
    if (auth()->check()) {
        $activeBookings = \App\Models\Booking::where('user_id', auth()->id())
            ->whereDate('booking_date', '>=', now()->toDateString())
            ->pluck('service_id')
            ->toArray();
    }

    return view('services.index', compact('services', 'activeBookings'));
    }

    public function create()
    {
        return view('services.create');
    }

    public function store(Request $request)
    {
    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'image' => 'nullable|image|max:2048', // Add validation for the image
    ]);

    $data = $request->only('name', 'description');

    // Check if an image was uploaded
    if ($request->hasFile('image')) {
        $data['image'] = $request->file('image')->store('services', 'public');
    }

    $data['user_id'] = Auth::id();

    Service::create($data);

    return redirect()->route('services.index')->with('success', 'Service added successfully!');
    }

    public function destroy(Service $service)
    {
    if (auth()->id() !== $service->user_id) {
        abort(403);
    }

  
    if ($service->image && \Storage::disk('public')->exists($service->image)) {
        \Storage::disk('public')->delete($service->image);
    }
    $service->delete();

    return redirect()->route('services.index')->with('success', 'Service deleted successfully.');
    }

    public function edit(Service $service)
{
    if (auth()->id() !== $service->user_id) {
        abort(403);
    }

    return view('services.create', compact('service'));
}

public function update(Request $request, Service $service)
{
    if (auth()->id() !== $service->user_id) {
        abort(403);
    }

    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'image' => 'nullable|image|max:2048',
    ]);

    $data = $request->only('name', 'description');

    if ($request->hasFile('image')) {
        if ($service->image && \Storage::disk('public')->exists($service->image)) {
            \Storage::disk('public')->delete($service->image);
        }
        $data['image'] = $request->file('image')->store('services', 'public');
    }

    $service->update($data);

    return redirect()->route('services.index')->with('success', 'Service updated successfully!');
    }

    public function book($serviceId)
    {
    $service = Service::findOrFail($serviceId);
    return view('services.book', compact('service'));
    }
}