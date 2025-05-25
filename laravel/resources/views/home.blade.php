@extends('layouts.app')

@section('content')

<div class="container-fluid px-4 py-4">
    <!-- Hero Section -->
    <div class="container mb-5">
        <div class="text-center mt-4">
            <h2 class="fw-bold">Book Your Appointment Today</h2>
            <p class="text-muted">Step into a world of tranquility and relaxation.</p>
            <a href="{{ route('services.index') }}" class="btn custom-btn btn-sm">Schedule Now</a>
        </div>
    </div>

    <div class="row justify-content-center mb-5">
        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-lg service-card h-100">
                <img src="{{ asset('images/feet1.jpg') }}" class="card-img-top w-100" alt="Feet Massage" style="height: 200px; object-fit: cover;">
                <div class="card-body text-center">
                    <h5 class="card-title">Feet Massage</h5>
                    <p class="card-text">Unwinding massage techniques that relieve tension and stress from your foot.</p>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-lg service-card h-100">
                <img src="{{ asset('images/body1.jpg') }}" class="card-img-top w-100" alt="Body Massage" style="height: 200px; object-fit: cover;">
                <div class="card-body text-center">
                    <h5 class="card-title">Body Massage</h5>
                    <p class="card-text">Revitalize your strength with a soothing oiled up full body massage.</p>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-lg service-card h-100">
                <img src="{{ asset('images/facial1.jpeg') }}" class="card-img-top w-100" alt="Facial Massage" style="height: 200px; object-fit: cover;">
                <div class="card-body text-center">
                    <h5 class="card-title">Facial Massage</h5>
                    <p class="card-text">Relax the mind with facial massages, and indulge in ultimate relaxation.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="text-center">
        <h2 class="fw-bold">Highlighted Services</h2>
        <p class="text-muted">Indulge in a variety of luxurious treatments designed for ultimate relaxation.</p>
    </div>
</div>

@endsection
