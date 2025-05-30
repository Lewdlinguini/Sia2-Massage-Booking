@extends('layouts.app')

@section('content')

<div class="container-fluid px-4 py-5" min-height: 100vh;">
    <div class="container py-5">
        <h2 class="fw-bold text-center mb-2" style="letter-spacing: 1.2px; color: #4b4b4b; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
            Available Services
        </h2>

        {{-- Success Message Modal --}}
        @if(session('success'))
        <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-sm">
                <div class="modal-content border-0 shadow rounded-4">
                    <div class="modal-header bg-success text-white rounded-top">
                        <h5 class="modal-title" id="successModalLabel"><i class="bi bi-check-circle-fill me-2"></i>Success!</h5>
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

        <form action="{{ route('services.index') }}" method="GET" class="mb-4 d-flex justify-content-center">
            <div class="input-group" style="max-width: 320px;">
                <input 
                    type="text" 
                    name="search" 
                    class="form-control form-control-sm rounded-start shadow-sm" 
                    placeholder="Search..." 
                    value="{{ request('search') }}" 
                    style="font-size: 0.9rem;"
                >
                <button 
                    class="btn btn-sm text-white rounded-end" 
                    type="submit" 
                    style="background-color: #d4a373; border: none;"
                >
                    <i class="bi bi-search"></i>
                </button>
            </div>
        </form>

        <div class="row g-3">
            @forelse ($services as $service)
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm rounded-4 modern-card" style="transition: transform 0.3s ease;">
                    {{-- Service Image --}}
                    @if($service->image)
                    <img src="{{ asset('storage/' . $service->image) }}" 
                         class="card-img-top rounded-top" 
                         style="height: 160px; object-fit: cover; transition: transform 0.5s ease;" 
                         alt="{{ $service->name }}">
                    @else
                    <div class="bg-light d-flex align-items-center justify-content-center rounded-top" style="height: 160px;">
                        <i class="bi bi-camera fs-3 text-muted"></i>
                    </div>
                    @endif

                    <div class="card-body text-center px-3 py-2">
                        {{-- Service Title & Description --}}
                        <h5 class="card-title fw-semibold mb-1 fs-6" style="color: #4a3b2b; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
                            {{ $service->name }}
                        </h5>
                        <p class="card-text text-muted mb-3 fs-sm" style="min-height: 50px; font-size: 0.85rem;">
                            {{ Str::limit($service->description, 90) }}
                        </p>

                        {{-- Provider Profile Info --}}
                        @if($service->user)
                        <div class="d-flex align-items-center justify-content-center mb-3 gap-2">
                            <img 
                                src="{{ $service->user->profile_picture ? asset('storage/' . $service->user->profile_picture) : asset('default-profile.png') }}" 
                                alt="Profile" 
                                class="rounded-circle" 
                                style="width: 35px; height: 35px; object-fit: cover; border: 2px solid #d4a373;">
                            <span class="text-secondary fs-7" style="font-size: 0.85rem;">
                                {{ $service->user->first_name }} {{ $service->user->last_name }}
                            </span>
                        </div>
                        @endif

                        {{-- Booking & Action Buttons --}}
                        @if(auth()->check() && in_array($service->id, $activeBookings))
                        <button class="btn btn-outline-secondary w-100 fw-semibold py-1" disabled style="font-size: 0.9rem;">
                            Already Booked
                        </button>
                        @else
                        <a href="{{ route('services.book', $service->id) }}" class="btn btn-primary w-100 fw-semibold py-1" style="background: linear-gradient(90deg, #caa974, #d4a373); border: none; font-size: 0.9rem; transition: background 0.3s; border-radius: 50px;">
                            Book This Service
                        </a>
                        @endif

                        @if(auth()->check() && auth()->id() === $service->user_id)
                        <div class="d-flex flex-column gap-2 mt-2">
                            {{-- Edit Button --}}
                           <a href="{{ route('services.edit', $service->id) }}" class="btn w-100 fw-semibold py-1" style="background-color: #28a745; color: white; font-size: 0.9rem; border-radius: 50px;">
                            Edit
                           </a>

                            {{-- Delete Button Trigger --}}
                            <button 
                                type="button" 
                                class="btn btn-danger w-100 fw-semibold py-1 delete-btn" 
                                data-bs-toggle="modal" 
                                data-bs-target="#deleteModal" 
                                data-service-id="{{ $service->id }}" 
                                data-service-name="{{ $service->name }}" 
                                style="font-size: 0.9rem; border-radius: 50px;"
                            >
                                Delete
                            </button>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <p class="text-center fs-6 text-muted mt-5">No services available at the moment.</p>
            @endforelse
        </div>
    </div>
</div>

{{-- Single Delete Confirmation Modal --}}
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 shadow-sm">
            <div class="modal-header bg-danger text-white rounded-top">
                <h5 class="modal-title" id="deleteModalLabel">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>Confirm Delete
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body fs-6 px-4 py-3">
                Are you sure you want to delete <strong id="deleteServiceName"></strong>?
            </div>
            <div class="modal-footer justify-content-center gap-3">
                <form id="deleteServiceForm" action="" method="POST" class="m-0 p-0">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger px-4 fw-semibold">Delete</button>
                </form>
                <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

{{-- Show success modal via JavaScript --}}
@if(session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var successModal = new bootstrap.Modal(document.getElementById('successModal'));
        successModal.show();
    });
</script>
@endif

{{-- Script to update delete modal dynamically --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    var deleteModal = document.getElementById('deleteModal');
    var deleteServiceName = document.getElementById('deleteServiceName');
    var deleteServiceForm = document.getElementById('deleteServiceForm');
    var baseDeleteUrl = "{{ url('services') }}/";

    deleteModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget; // Button that triggered the modal
        var serviceId = button.getAttribute('data-service-id');
        var serviceName = button.getAttribute('data-service-name');

        // Update modal service name text
        deleteServiceName.textContent = serviceName;

        // Update form action URL dynamically
        deleteServiceForm.action = baseDeleteUrl + serviceId;
    });
});
</script>

<style>
    .hover-shadow:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.12) !important;
    }

    /* Added from home.php for card design */
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

    /* Button hover effect consistent with home.php */
    a.btn-primary:hover {
        background: linear-gradient(90deg, #d4a373, #caa974) !important;
    }
</style>
@endsection
