@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="fw-bold text-center">Available Services</h2>
    <p class="text-muted text-center">Select a service and schedule your appointment.</p>

    {{-- Success Message Modal --}}
    @if(session('success'))
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header" style="background: rgba(212, 163, 115, 0.9); color: white;">
                    <h5 class="modal-title" id="successModalLabel">Success!</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {{ session('success') }}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    @endif

    <div class="row mt-4">
        @forelse ($services as $service)
        <div class="col-md-4">
            <div class="card shadow-sm mb-4">
                {{-- Service Image --}}
                @if($service->image)
                <img src="{{ asset('storage/' . $service->image) }}" class="card-img-top" style="height: 200px; object-fit: cover;" alt="Service Image">
                @endif

                <div class="card-body text-center">
                    {{-- Service Title & Description --}}
                    <h5 class="card-title">{{ $service->name }}</h5>
                    <p class="card-text">{{ $service->description }}</p>

                    {{-- Provider Profile Info --}}
                    @if($service->user)
                    <div class="d-flex align-items-center justify-content-center mb-3">
                        <img 
                            src="{{ $service->user->profile_picture ? asset('storage/' . $service->user->profile_picture) : asset('default-profile.png') }}" 
                            alt="Profile" 
                            style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover; margin-right: 10px;">
                        <span class="text-muted">{{ $service->user->first_name }} {{ $service->user->last_name }}</span>
                    </div>
                    @endif

                    {{-- Book Button --}}
                    <a href="#" class="btn" style="background: rgba(212, 163, 115, 0.9); color: white; width: 100%;">
                        Book This Service
                    </a>

                    @if(auth()->check() && auth()->id() === $service->user_id)
                    {{-- Delete Button Trigger --}}
                    <button type="button" class="btn btn-danger w-100 mt-2" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $service->id }}">
                        Delete
                    </button>

                    {{-- Edit Button --}}
                    <a href="{{ route('services.edit', $service->id) }}" class="btn btn-secondary w-100 mt-2">
                        Edit
                    </a>

                    {{-- Delete Modal --}}
                    <div class="modal fade" id="deleteModal{{ $service->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $service->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                    <div class="modal-header" style="background: rgba(212, 163, 115, 0.9); color: white;">
                    <h5 class="modal-title" id="deleteModalLabel{{ $service->id }}">Confirm Delete</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    Are you sure you want to delete <strong>{{ $service->name }}</strong>?
                    </div>
                    <div class="modal-footer">
                    <form action="{{ route('services.destroy', $service->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                    </div>
                    </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <p class="text-center">No services available at the moment.</p>
        @endforelse
    </div>
</div>

{{-- Show modal via JavaScript if success message is set --}}
@if(session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var successModal = new bootstrap.Modal(document.getElementById('successModal'));
        successModal.show();
    });
</script>
@endif
@endsection
