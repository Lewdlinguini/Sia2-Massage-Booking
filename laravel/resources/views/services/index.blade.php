@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="fw-bold text-center">Available Services</h2>
    <p class="text-muted text-center">Select a service and schedule your appointment.</p>

    <div class="row mt-4">
        @forelse ($services as $service)
        <div class="col-md-4">
            <div class="card shadow-sm mb-4">
                @if($service->image)
                <img src="{{ asset('storage/' . $service->image) }}" class="card-img-top" style="height: 200px; object-fit: cover;" alt="Service Image">
                @endif
                <div class="card-body text-center">
                    <h5 class="card-title">{{ $service->name }}</h5>
                    <p class="card-text">{{ $service->description }}</p>
                    @if($service->user)
                    <p class="text-muted">By: {{ $service->user->first_name }} {{ $service->user->last_name }}</p>
                    @endif
                    <a href="#" class="btn" style="background: rgba(212, 163, 115, 0.9); color: white; width: 100%;">
                    Book This Service
                    </a>
                </div>
            </div>
        </div>
        @empty
        <p class="text-center">No services available at the moment.</p>
        @endforelse
    </div>
</div>
@endsection