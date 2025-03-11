@extends('layouts.app')

@section('content')

<!-- Hero Section -->
<div class="container mt-5">
    <!-- Call to Action -->
<div class="container text-center mt-5"> 
    <h2 class="fw-bold">Book Your Appointment Today</h2>
    <p class="text-muted">Step into a world of tranquility and relaxation.</p>
    <a href="#" class="btn custom-btn btn-sm">Schedule Now</a>
</div>

    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-lg service-card">
            <img src="{{ asset('images/feet1.jpg') }}" class="card-img-top w-100" alt="Feet Massage" style="height: 200px; object-fit: cover;">
                <div class="card-body text-center">
                    <h5 class="card-title">Feet Massage</h5>
                    <p class="card-text">Unwinding massage techniques that relieve tension and stress from your foot.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-lg service-card">
            <img src="{{ asset('images/body1.jpg') }}" class="card-img-top w-100" alt="Body Massage" style="height: 200px; object-fit: cover;">
                <div class="card-body text-center">
                    <h5 class="card-title">Body Massage</h5>
                    <p class="card-text">Revitalize your strenght with a soothing oiled up full body massage.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-lg service-card">
            <img src="{{ asset('images/facial1.jpeg') }}" class="card-img-top w-100" alt="Facial Massage" style="height: 200px; object-fit: cover;">
                <div class="card-body text-center">
                    <h5 class="card-title">Facial Massage</h5>
                    <p class="card-text">Relax the mind with facial massages, and indulge in ultimate relaxation.</p>
                </div>
            </div>
        </div>
    </div>
</div>

    <h2 class="text-center fw-bold">Highlighted Services</h2>
    <p class="text-center text-muted">Indulge in a variety of luxurious treatments designed for ultimate relaxation.</p>

@endsection