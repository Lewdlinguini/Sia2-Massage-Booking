<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use App\Models\Service;

class ServiceController extends Controller
{
    public function index()
    {
    $services = Service::with('user')->get();
    return view('services.index', compact('services'));
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
    ]);

    $data = $request->only('name', 'description');

    if ($request->hasFile('image')) {
        $data['image'] = $request->file('image')->store('services', 'public');
    }

    // Assign the authenticated user's id here:
    $data['user_id'] = Auth::id();

    Service::create($data);

    return redirect()->route('services.index')->with('success', 'Service added successfully!');
    }
}