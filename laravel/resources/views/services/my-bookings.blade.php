@extends('layouts.app')

@section('styles')
<style>
    body {
        background-color: #f5f5f5;
    }
    .spinning-hourglass {
        width: 40px;
        height: 40px;
        border: 5px solid #ccc;
        border-top: 5px solid #0073bb;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        display: inline-block;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
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

    /* Thumbnail placeholder */
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

    /* Spinning hourglass animation */
    @keyframes spin {
        0% { transform: rotate(0deg);}
        100% { transform: rotate(360deg);}
    }

    .booking-thumbnail i.bi-hourglass-split {
        animation: spin 2s linear infinite;
        color: #0073bb;
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

    .booking-actions {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
        min-width: 120px;
        align-items: flex-end;
    }
    .booking-actions button {
        width: 100%;
    }
    .btn-reschedule {
        background-color: #0073bb;
        border-color: #0073bb;
        color: white;
        font-weight: 600;
        border-radius: 6px;
        padding: 0.4rem 0;
        font-size: 0.9rem;
        transition: background-color 0.2s ease;
    }
    .btn-reschedule:hover {
        background-color: #005f8d;
        border-color: #005f8d;
        color: white;
    }

    .btn-cancel {
        background-color: #d9534f;
        border-color: #d9534f;
        color: white;
        font-weight: 600;
        border-radius: 6px;
        padding: 0.4rem 0;
        font-size: 0.9rem;
        transition: background-color 0.2s ease;
    }
    .btn-cancel:hover {
        background-color: #b52b27;
        border-color: #b52b27;
        color: white;
    }

    /* Responsive */
    @media (max-width: 576px) {
        .booking-card {
            flex-direction: column;
            align-items: flex-start;
        }
        .booking-actions {
            width: 100%;
            flex-direction: row;
            justify-content: space-between;
            min-width: auto;
        }
        .booking-actions button {
            width: 48%;
        }
    }
</style>
@endsection

@section('content')
@if(session('success'))
<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content border-0 shadow rounded-4">
            <div class="modal-header bg-success text-white rounded-top">
                <h5 class="modal-title" id="successModalLabel">
                    <i class="bi bi-check-circle-fill me-2"></i>Success!
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body fs-6 text-center px-4 py-3">
                {{ session('success') }}
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-outline-success px-4" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endif

<div class="container mt-5">
    <h2 class="mb-4 fw-bold">My Bookings</h2>

    @if($bookings->isEmpty())
        <p class="text-muted fs-5">You have no bookings yet.</p>
    @else
        @foreach ($bookings as $booking)
        <div class="booking-card" role="listitem">
            <div class="booking-thumbnail" aria-hidden="true">
                <!-- Spinning hourglass icon to indicate ongoing/upcoming -->
                <i class="bi bi-hourglass-split"></i>
            </div>

            <div class="booking-details">
                <div class="booking-title">{{ $booking->service->name }}</div>
                <div class="booking-subtitle">Masseuse: {{ $booking->service->user->first_name ?? 'N/A' }}</div>
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
            </div>

            <div class="booking-actions">
                @if(\Carbon\Carbon::parse($booking->booking_date)->isFuture())
                <!-- Reschedule -->
                <button type="button" class="btn btn-reschedule" data-bs-toggle="modal" data-bs-target="#rescheduleModal{{ $booking->id }}">
                    Reschedule
                </button>

                <!-- Cancel -->
                <button type="button" class="btn btn-cancel" data-bs-toggle="modal" data-bs-target="#cancelModal{{ $booking->id }}">
                    Cancel
                </button>
                @else
                <span class="text-muted fst-italic">No actions available</span>
                @endif
            </div>
        </div>

        <!-- Reschedule Modal -->
        <!-- Reschedule Modal -->
<div class="modal fade" id="rescheduleModal{{ $booking->id }}" tabindex="-1" aria-labelledby="rescheduleModalLabel{{ $booking->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form method="POST" action="{{ route('bookings.update', $booking->id) }}">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header" style="background: #d4a373cc; color: white;">
                    <h5 class="modal-title" id="rescheduleModalLabel{{ $booking->id }}">Reschedule Booking</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <label for="booking_date{{ $booking->id }}" class="form-label">Select new date</label>
                    <input type="date" class="form-control" id="booking_date{{ $booking->id }}" name="booking_date" value="{{ \Carbon\Carbon::parse($booking->booking_date)->format('Y-m-d') }}" min="{{ date('Y-m-d') }}" required>

                    <label for="booking_time{{ $booking->id }}" class="form-label mt-3">Select new time</label>
                    <input type="time" class="form-control" id="booking_time{{ $booking->id }}" name="booking_time" value="{{ \Carbon\Carbon::parse($booking->booking_time)->format('H:i') }}" required>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save changes</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>

        <!-- Cancel Confirmation Modal -->
        <div class="modal fade" id="cancelModal{{ $booking->id }}" tabindex="-1" aria-labelledby="cancelModalLabel{{ $booking->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content rounded-4 shadow-sm">
                    <div class="modal-header bg-danger text-white rounded-top">
                        <h5 class="modal-title" id="cancelModalLabel{{ $booking->id }}">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>Confirm Cancellation
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body fs-6 px-4 py-3">
                        Are you sure you want to cancel your booking for <strong>{{ $booking->service->name }}</strong> on 
                        <strong>{{ \Carbon\Carbon::parse($booking->booking_date)->format('M d, Y') }}</strong>?
                    </div>
                    <div class="modal-footer justify-content-center gap-3">
                        <form action="{{ route('bookings.destroy', $booking->id) }}" method="POST" class="m-0 p-0">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger px-4 fw-semibold">Cancel Booking</button>
                        </form>
                        <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    @endif
</div>

@if(session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var successModal = new bootstrap.Modal(document.getElementById('successModal'));
        successModal.show();
    });
</script>
@endif
@endsection