@extends('layouts.app')

@section('content')
<div class="container-fluid px-4 py-5" style="background-color: #f8f9fa;">
    <!-- Hero Section -->
    <div class="container text-center mb-5">
        <h1 class="fw-bold display-4" style="color: #d4a373;">Book Your Appointment Today</h1>
        <p class="lead text-muted mb-4">Step into a world of tranquility and relaxation.</p>
        <a href="{{ route('services.index') }}" class="btn btn-lg px-4 fw-semibold" style="background: #d4a373; color: white;">
            Schedule Now
        </a>
    </div>

    <!-- Services Grid -->
    <div class="container">
        <div class="row g-4 justify-content-center mb-5">
            <div class="col-md-6 col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <img src="{{ asset('images/feet1.jpg') }}" class="card-img-top rounded-top-4" alt="Feet Massage" style="height: 240px; object-fit: cover;">
                    <div class="card-body text-center">
                        <h5 class="fw-bold" style="color: #4a3b2b;">Feet Massage</h5>
                        <p class="text-muted">Unwinding massage techniques that relieve tension and stress from your foot.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <img src="{{ asset('images/body1.jpg') }}" class="card-img-top rounded-top-4" alt="Body Massage" style="height: 240px; object-fit: cover;">
                    <div class="card-body text-center">
                        <h5 class="fw-bold" style="color: #4a3b2b;">Body Massage</h5>
                        <p class="text-muted">Revitalize your strength with a soothing oiled-up full body massage.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <img src="{{ asset('images/facial1.jpeg') }}" class="card-img-top rounded-top-4" alt="Facial Massage" style="height: 240px; object-fit: cover;">
                    <div class="card-body text-center">
                        <h5 class="fw-bold" style="color: #4a3b2b;">Facial Massage</h5>
                        <p class="text-muted">Relax the mind with facial massages and indulge in ultimate relaxation.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Highlight Section -->
        <div class="text-center mt-5">
            <h2 class="fw-bold" style="color: #d4a373;">Highlighted Services</h2>
            <p class="text-muted">Indulge in a variety of luxurious treatments designed for your well-being.</p>
        </div>
    </div>
</div>
@endsection
