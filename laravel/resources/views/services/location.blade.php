@extends('layouts.applocation')

@section('title', 'Booking Location Map')

@section('content')

    <div class="container" style="max-width: 700px;">
        <h2 class="fw-bold mb-3" style="color: #b97f5a; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
            Location for Booking: {{ $booking->service->name }}
        </h2>
        <p class="text-secondary mb-4" style="font-weight: 500;">
            Booked by: {{ $booking->user->first_name ?? 'N/A' }} {{ $booking->user->last_name ?? '' }}
        </p>

        <div id="map" class="modern-map shadow rounded-4"></div>
    </div>
</div>
@endsection

@push('styles')
<style>
    #map.modern-map {
        height: 350px;
        width: 100%;
        border-radius: 1rem;
        box-shadow:
            8px 8px 16px #d1b58e,
            -8px -8px 16px #fff7e6;
        transition: box-shadow 0.3s ease;
    }
    #map.modern-map:hover {
        box-shadow:
            12px 12px 24px #c9a666,
            -12px -12px 24px #fffbe9;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const lat = {{ $booking->latitude ?? 14.5995 }};
    const lng = {{ $booking->longitude ?? 120.9842 }};

    var map = L.map('map').setView([lat, lng], 15);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    L.marker([lat, lng]).addTo(map)
        .bindPopup('Booking Location')
        .openPopup();

    setTimeout(() => map.invalidateSize(), 300);
});
</script>
@endpush