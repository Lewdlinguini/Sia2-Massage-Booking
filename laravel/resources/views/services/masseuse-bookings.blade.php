@extends('layouts.app')

@section('styles')
<style>
    body {
        background-color: #f5f5f5;
    }
    .booking-card {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 6px rgb(0 0 0 / 0.15);
        padding: 1.25rem 1.5rem;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        transition: box-shadow 0.3s ease;
    }
    .booking-card:hover {
        box-shadow: 0 4px 12px rgb(0 0 0 / 0.2);
    }
    .booking-thumbnail {
        flex-shrink: 0;
        width: 80px;
        height: 80px;
        background-color: #eaeaea;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        color: #b0b0b0;
        user-select: none;
    }
    .booking-details {
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        gap: 0.3rem;
    }
    .booking-title {
        font-weight: 600;
        font-size: 1.15rem;
        color: #222;
        margin-bottom: 0.3rem;
    }
    .booking-subtitle {
        font-size: 0.9rem;
        color: #555;
    }
    .booking-meta {
        font-size: 0.85rem;
        color: #666;
        margin-top: 0.5rem;
    }
    .booking-status {
        font-weight: 700;
        padding: 0.25rem 0.75rem;
        border-radius: 12px;
        font-size: 0.8rem;
        user-select: none;
        min-width: 90px;
        text-align: center;
    }
    .status-upcoming {
        background-color: #d1e7dd;
        color: #0f5132;
    }
    .status-completed {
        background-color: #e2e3e5;
        color: #41464b;
    }
    /* Responsive */
    @media (max-width: 576px) {
        .booking-card {
            flex-direction: column;
            align-items: flex-start;
        }
    }
</style>
@endsection

@section('content')
<div class="container mt-5">
    <h2 class="mb-4 fw-bold">Bookings Made On Your Services</h2>

    @if($bookings->isEmpty())
        <p class="text-muted fs-5">No bookings found.</p>
    @else
        @foreach ($bookings as $booking)
        <div class="booking-card" role="listitem">
            <div class="booking-thumbnail" aria-hidden="true">
                <i class="bi bi-person-circle"></i>
            </div>

            <div class="booking-details">
                <div class="booking-title">{{ $booking->service->name }}</div>
                <div class="booking-subtitle">
                    Booked by: {{ $booking->user->first_name ?? 'N/A' }} {{ $booking->user->last_name ?? '' }}
                </div>
                <div class="booking-meta">Payment: {{ ucfirst($booking->payment_method) }}</div>
                <div class="booking-meta">
                    Date & Time: {{ \Carbon\Carbon::parse($booking->booking_date . ' ' . $booking->booking_time)->format('M d, Y • h:i A') }}
                </div>

                {{-- Added Duration --}}
                <div class="booking-meta">
                    Duration: {{ $booking->duration }} hour{{ $booking->duration > 1 ? 's' : '' }}
                </div>

                {{-- Added Price --}}
                <div class="booking-meta">
                    Price: ₱{{ number_format($booking->price, 2) }}
                </div>
            </div>

            <div>
                <div class="booking-status {{ \Carbon\Carbon::parse($booking->booking_date)->isPast() ? 'status-completed' : 'status-upcoming' }}">
                    {{ \Carbon\Carbon::parse($booking->booking_date)->isPast() ? 'Completed' : 'Upcoming' }}
                </div>

                <a href="{{ route('services.location', $booking->id) }}" class="btn btn-sm btn-outline-primary mt-2">
                    View Location
                </a>
            </div>
        </div>
        @endforeach
    @endif
</div>
@endsection