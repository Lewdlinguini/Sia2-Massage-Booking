@extends('layouts.app')

@section('content')
<div class="container-fluid px-4 py-5" style="min-height: 100vh;">

    <!-- ── Hero ─────────────────────────────────────────────── -->
    <div class="container text-center mb-5">
        <h1 class="display-4 fw-bold mb-3" style="color:#b97f5a;font-family:'Segoe UI',Tahoma,Geneva,Verdana,sans-serif;">
            Book Your Appointment Today
        </h1>
        <p class="lead text-secondary mb-4" style="font-weight:500;max-width:600px;margin:0 auto;">
            Step into a world of tranquility and relaxation.
        </p>
        <a href="{{ route('services.index') }}"
           class="btn btn-lg px-5 py-3 fw-semibold text-white shadow-lg"
           style="
                background:linear-gradient(90deg,#caa974,#d4a373);
                border-radius:50px;
                box-shadow:0 6px 15px rgba(212,163,115,.4);
                transition:all .3s ease;
           "
           onmouseover="this.style.background='linear-gradient(90deg,#d4a373,#caa974)'"
           onmouseout="this.style.background='linear-gradient(90deg,#caa974,#d4a373)'">
            Schedule Now
        </a>
    </div>

    <!-- ── Highlighted Services ──────────────────────────────── -->
    <div class="container">
        <div class="text-center mb-4">
            <h2 class="fw-bold mb-3" style="color:#b97f5a;font-family:'Segoe UI',Tahoma,Geneva,Verdana,sans-serif;">
                Highlighted Services
            </h2>
            <p class="text-secondary fs-5 mx-auto" style="max-width:700px;">
                Top-rated treatments chosen by our customers.
            </p>
        </div>

        <div class="row justify-content-center">
            @if($featuredServices->count())
                @foreach($featuredServices as $featuredService)
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card rounded-5 shadow border-0 h-100 service-card modern-card">
                            <div class="overflow-hidden rounded-top-5" style="height:260px;">
                                <img src="{{ asset('storage/'.$featuredService->image) }}"
                                     alt="{{ $featuredService->name }}"
                                     class="w-100 h-100 object-fit-cover"/>
                            </div>

                            <div class="card-body text-center px-4 py-4">
                                <h5 class="fw-bold mb-3">{{ $featuredService->name }}</h5>

                                <p class="text-muted mb-3" style="font-size:.95rem;">
                                    {{ Str::limit($featuredService->description, 100) }}
                                </p>

                                <div class="d-flex justify-content-center align-items-center gap-2 mb-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="bi {{ $i <= round($featuredService->ratings_avg_stars) ? 'bi-star-fill text-warning' : 'bi-star text-muted' }}"></i>
                                    @endfor
                                    <small class="text-muted">({{ number_format($featuredService->ratings_avg_stars, 1) }})</small>
                                </div>

                                <div class="small text-muted mb-3">
                                    <i class="bi bi-bookmark-check me-1"></i>{{ $featuredService->bookings_count }} bookings
                                </div>

                                <a href="{{ route('services.index') }}"
                                   class="btn btn-lg px-4 py-2 fw-semibold text-white shadow"
                                   style="
                                        background:linear-gradient(90deg,#caa974,#d4a373);
                                        border-radius:50px;
                                        box-shadow:0 6px 15px rgba(212,163,115,.4);
                                        transition:all .3s ease;
                                   "
                                   onmouseover="this.style.background='linear-gradient(90deg,#d4a373,#caa974)'"
                                   onmouseout="this.style.background='linear-gradient(90deg,#caa974,#d4a373)'">
                                    View Service
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <p class="text-center text-muted">No featured services yet — check back soon!</p>
            @endif
        </div>
    </div>
</div>

@push('styles')
<style>
    .modern-card {
        background: #fff;
        box-shadow: 8px 8px 16px #d1b58e, -8px -8px 16px #fff7e6;
        border-radius: 1.5rem!important;
        transition: transform .3s ease, box-shadow .3s ease;
    }
    .modern-card:hover {
        transform: translateY(-12px);
        box-shadow: 12px 12px 24px #c9a666, -12px -12px 24px #fffbe9;
    }
    .modern-card img:hover {
        transform: scale(1.1);
    }
</style>
@endpush
@endsection
