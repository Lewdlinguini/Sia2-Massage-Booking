<?php

namespace App\Http\Controllers;

use App\Notifications\BookingCreated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Service;
use App\Services\ActivityLogger;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $query = Service::with('user');

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $services = $query->get();

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
            'image' => 'nullable|image|max:2048',
            'price_per_hour' => 'required|numeric|min:0',
        ]);

        $data = $request->only('name', 'description', 'price_per_hour');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('services', 'public');
        }

        $data['user_id'] = Auth::id();

        // Corrected logging call
        ActivityLogger::log(auth()->id(), 'Created service "' . $data['name'] . '"');

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

        // Corrected logging call
        ActivityLogger::log(auth()->id(), 'Deleted service "' . $service->name . '" (ID: ' . $service->id . ')');

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

        // Corrected logging call
        ActivityLogger::log(auth()->id(), 'Updated service "' . $service->name . '" (ID: ' . $service->id . ')');

        return redirect()->route('services.index')->with('success', 'Service updated successfully!');
    }

    public function book($serviceId)
    {
        $service = Service::findOrFail($serviceId);
        return view('services.book', compact('service'));
    }
}
