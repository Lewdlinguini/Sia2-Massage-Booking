@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="fw-bold text-center">Available Services</h2>
    <p class="text-muted text-center">Select a service and schedule your appointment.</p>

    <div class="row mt-4">
        @forelse ($services as $service)
        <div class="col-md-4">
            <div class="card shadow-sm mb-4">
                {{-- Service Image --}}
                @if($service->image)
                <img src="{{ asset('storage/' . $service->image) }}" class="card-img-top" style="height: 200px; object-fit: cover;" alt="Service Image">
                @endif

                <div class="card-body text-center">
                    {{-- Service Title & Description --}}
                    <h5 class="card-title">{{ $service->name }}</h5>
                    <p class="card-text">{{ $service->description }}</p>

                    {{-- Provider Profile Info --}}
                    @if($service->user)
                    <div class="d-flex align-items-center justify-content-center mb-3">
                        <img 
                            src="{{ $service->user->profile_picture ? asset('storage/' . $service->user->profile_picture) : asset('default-profile.png') }}" 
                            alt="Profile" 
                            style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover; margin-right: 10px;">
                        <span class="text-muted">{{ $service->user->first_name }} {{ $service->user->last_name }}</span>
                    </div>
                    @endif

                    {{-- Book Button --}}
                    <a href="#" class="btn" style="background: rgba(212, 163, 115, 0.9); color: white; width: 100%;">
                        Book This Service
                    </a>

                    {{-- Delete Button for Owner --}}
                    @if(auth()->check() && auth()->id() === $service->user_id)
                    <form action="{{ route('services.destroy', $service->id) }}" method="POST" class="mt-2">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100" onclick="return confirm('Are you sure you want to delete this service?')">
                            Delete
                        </button>
                    </form>

                    {{-- Edit Button for Owner --}}
                    <a href="{{ route('services.edit', $service->id) }}" class="btn btn-secondary w-100 mt-2">
                        Edit
                    </a>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <p class="text-center">No services available at the moment.</p>
        @endforelse
    </div>
</div>
@endsection
