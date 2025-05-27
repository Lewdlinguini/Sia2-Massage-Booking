@extends('layouts.app')

@section('content')
<div class="container">
    <h2>{{ isset($service) ? 'Edit Service' : 'Add a New Service' }}</h2>
    
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form 
        action="{{ isset($service) ? route('services.update', $service->id) : route('services.store') }}" 
        method="POST" 
        enctype="multipart/form-data"
    >
        @csrf
        @if(isset($service))
            @method('PUT')
        @endif

        {{-- Service Name --}}
        <div class="mb-3">
            <label for="name" class="form-label">Service Name</label>
            <input 
                type="text" 
                class="form-control" 
                name="name" 
                id="name" 
                placeholder="e.g., Hot Stone Massage" 
                value="{{ old('name', $service->name ?? '') }}" 
                required
            >
        </div>

        {{-- Service Description --}}
        <div class="mb-3">
            <label for="description" class="form-label">Service Description</label>
            <textarea 
                class="form-control" 
                name="description" 
                id="description" 
                rows="3" 
                placeholder="Describe the service..."
            >{{ old('description', $service->description ?? '') }}</textarea>
        </div>

        {{-- Profile Info (Static Display) --}}
        <div class="mb-3 d-flex align-items-center">
            <label class="form-label me-3 mb-0">You (Service Provider):</label>
            @if(auth()->user()->profile_picture)
                <img src="{{ asset('storage/' . auth()->user()->profile_picture) }}" alt="Profile Picture" style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%; margin-right: 10px;">
            @endif
            <strong>{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</strong>
        </div>

        {{-- Optional Service Image --}}
        <div class="mb-3">
            <label for="image" class="form-label">Service Image (Optional)</label>
            <input type="file" class="form-control" name="image" id="image">
        </div>

        {{-- Submit --}}
        <button 
            type="submit" 
            class="btn" 
            style="background: rgba(212, 163, 115, 0.9); color: white; padding: 0.5rem 1.5rem; border-radius: 5px;"
        >
            {{ isset($service) ? 'Update Service' : 'Add Service' }}
        </button>
    </form>
</div>
@endsection