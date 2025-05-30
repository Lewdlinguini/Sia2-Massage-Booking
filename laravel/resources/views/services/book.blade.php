@extends('layouts.app')

@section('content')
<div class="container mt-5" style="max-width: 900px;">
    <h2 class="fw-bold text-center mb-5" style="letter-spacing: 1.1px; color: #2c3e50;">
        Book Service: <span class="text-primary">{{ $service->name }}</span>
    </h2>

    <form method="POST" action="{{ route('bookings.store') }}" 
          class="shadow-sm p-3 rounded-4 bg-white border d-flex flex-column flex-lg-row gap-3 align-items-start" 
          style="border-color: #d4a373;">
        @csrf
        <input type="hidden" name="service_id" value="{{ $service->id }}">

        {{-- Left side: Inputs --}}
        <div class="flex-grow-1 d-flex flex-column gap-3">
            <div>
                <label for="bookingDate" class="form-label fw-semibold text-secondary mb-1">Select a date</label>
                <input 
                    type="date" 
                    class="form-control form-control-lg rounded-pill border-2 py-2" 
                    name="booking_date" 
                    id="bookingDate" 
                    required
                    style="border-color: #d4a373;"
                >
            </div>

            <div>
    <label for="bookingTime" class="form-label fw-semibold text-secondary mb-1">Select a time</label>
    <input 
        type="time" 
        class="form-control form-control-lg rounded-pill border-2 py-2" 
        name="booking_time" 
        id="bookingTime" 
        required
        style="border-color: #d4a373;"
    >
</div>


            <div>
                <label class="form-label fw-semibold text-secondary mb-1">Payment Method</label>
                <select 
                    class="form-select form-select-lg rounded-pill border-2 py-2" 
                    name="payment_method" 
                    required
                    style="border-color: #d4a373;"
                >
                    <option value="cash">Cash on hand</option>
                </select>
            </div>

            <div class="d-flex gap-3">
                <button type="submit" 
                        class="btn btn-primary btn-lg px-4 rounded-pill fw-semibold shadow-sm" 
                        style="background-color: #d4a373; border: none; transition: background-color 0.3s;">
                    Confirm Booking
                </button>
                <a href="{{ url()->previous() }}" 
                   class="btn btn-outline-secondary btn-lg px-3 rounded-pill fw-semibold">
                    Cancel
                </a>
            </div>
        </div>

        {{-- Right side: Map --}}
        <div style="flex-basis: 50%; min-width: 300px;">
            <label class="form-label fw-semibold text-secondary mb-2 d-block">Your Location</label>
            <div id="map" style="height: 280px; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);"></div>
        </div>

        <input type="hidden" name="latitude" id="latitude">
        <input type="hidden" name="longitude" id="longitude">

    </form>
</div>

<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
@endsection

@push('scripts')
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let map = L.map('map').setView([0, 0], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            const lat = position.coords.latitude;
            const lng = position.coords.longitude;

            // Set the map view
            map.setView([lat, lng], 15);
            L.marker([lat, lng]).addTo(map).bindPopup("Your Location").openPopup();

            // ✅ Set hidden input values
            document.getElementById('latitude').value = lat;
            document.getElementById('longitude').value = lng;

        }, function() {
            alert("Location permission denied.");
        });
    } else {
        alert("Geolocation is not supported by your browser.");
    }
});
</script>
@endpush

<style>
/* Hover effect on buttons */
.btn-primary:hover {
    background-color: #b5895b !important;
}

.btn-outline-secondary:hover {
    background-color: #f0ead4;
    color: #6c757d;
}

/* Responsive tweaks */
@media (max-width: 991px) {
    form.d-flex.flex-lg-row {
        flex-direction: column !important;
    }
}
</style>