@extends('layouts.app')

@section('content')
<div class="container-fluid px-4 py-5" min-height: 100vh;">

    <!-- Hero Section -->
    <div class="container text-center mb-5">
        <h1 class="display-4 fw-bold mb-3" style="color: #b97f5a; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
            Book Your Appointment Today
        </h1>
        <p class="lead text-secondary mb-4" style="font-weight: 500; max-width: 600px; margin: 0 auto;">
            Step into a world of tranquility and relaxation.
        </p>
        <a href="{{ route('services.index') }}" 
           class="btn btn-lg px-5 py-3 fw-semibold text-white shadow-lg"
           style="
                background: linear-gradient(90deg, #caa974, #d4a373);
                border-radius: 50px;
                box-shadow: 0 6px 15px rgba(212, 163, 115, 0.4);
                transition: all 0.3s ease;
            "
           onmouseover="this.style.background='linear-gradient(90deg, #d4a373, #caa974)'"
           onmouseout="this.style.background='linear-gradient(90deg, #caa974, #d4a373)'"
        >
            Schedule Now
        </a>
    </div>

    <!-- Services Grid -->
    <div class="container">
        <div class="row g-5 justify-content-center mb-5">
            @php
                $services = [
                    ['img' => 'feet1.jpg', 'title' => 'Feet Massage', 'desc' => 'Unwinding massage techniques that relieve tension and stress from your foot.'],
                    ['img' => 'body1.jpg', 'title' => 'Body Massage', 'desc' => 'Revitalize your strength with a soothing oiled-up full body massage.'],
                    ['img' => 'facial1.jpeg', 'title' => 'Facial Massage', 'desc' => 'Relax the mind with facial massages and indulge in ultimate relaxation.'],
                ];
            @endphp

            @foreach($services as $service)
            <div class="col-md-6 col-lg-4">
                <div class="card rounded-5 shadow border-0 h-100 service-card modern-card">
                    <div class="overflow-hidden rounded-top-5" style="height: 260px;">
                        <img src="{{ asset('images/' . $service['img']) }}" 
                             alt="{{ $service['title'] }}" 
                             class="w-100 h-100 object-fit-cover"
                             style="transition: transform 0.5s ease;"
                             />
                    </div>
                    <div class="card-body text-center px-4 py-4">
                        <h5 class="fw-bold mb-3" style="color: #4a3b2b; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
                            {{ $service['title'] }}
                        </h5>
                        <p class="text-muted" style="font-size: 0.95rem; line-height: 1.5;">
                            {{ $service['desc'] }}
                        </p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Highlight Section -->
        <div class="text-center mt-5">
            <h2 class="fw-bold mb-3" style="color: #b97f5a; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
                Highlighted Services
            </h2>
            <p class="text-secondary fs-5 mx-auto" style="max-width: 700px;">
                Indulge in a variety of luxurious treatments designed for your well-being.
            </p>
        </div>
    </div>
</div>

@push('styles')
<style>
    .modern-card {
        background: #fff;
        box-shadow:
            8px 8px 16px #d1b58e,
            -8px -8px 16px #fff7e6;
        border-radius: 1.5rem !important;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .modern-card:hover {
        transform: translateY(-12px);
        box-shadow:
            12px 12px 24px #c9a666,
            -12px -12px 24px #fffbe9;
    }
    .modern-card img:hover {
        transform: scale(1.1);
    }
</style>
@endpush

@endsection
