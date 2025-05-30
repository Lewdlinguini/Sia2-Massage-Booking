@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-center align-items-start py-5" style="min-height: 90vh;">
    <div class="card shadow-sm rounded-4 p-4 d-flex flex-row" style="width: 100%; max-width: 900px; border: none; gap: 2rem;">

        {{-- Left Column: Add User Form --}}
        <div style="flex: 2;">
            <h2 class="mb-4 fw-bold" style="color: rgba(212, 163, 115, 0.9);">Add a New User</h2>

            {{-- Show inline error box if there are validation errors --}}
            @if ($errors->any())
                <div class="alert alert-danger rounded-3 shadow-sm">
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.users.store') }}" method="POST" class="mt-3">
                @csrf

                {{-- First Name --}}
                <div class="mb-4">
                    <label for="first_name" class="form-label fw-semibold" style="color: #4a3b2b;">First Name</label>
                    <input 
                        type="text" 
                        class="form-control form-control-lg rounded-3 border-0 shadow-sm" 
                        name="first_name" 
                        id="first_name" 
                        value="{{ old('first_name') }}" 
                        required
                        autofocus
                    >
                </div>

                {{-- Last Name --}}
                <div class="mb-4">
                    <label for="last_name" class="form-label fw-semibold" style="color: #4a3b2b;">Last Name</label>
                    <input 
                        type="text" 
                        class="form-control form-control-lg rounded-3 border-0 shadow-sm" 
                        name="last_name" 
                        id="last_name" 
                        value="{{ old('last_name') }}" 
                        required
                    >
                </div>

                {{-- Date of Birth --}}
                <div class="mb-4">
                    <label for="date_of_birth" class="form-label fw-semibold" style="color: #4a3b2b;">Date of Birth</label>
                    <input 
                        type="date" 
                        class="form-control form-control-lg rounded-3 border-0 shadow-sm" 
                        name="date_of_birth" 
                        id="date_of_birth" 
                        value="{{ old('date_of_birth') }}" 
                        required
                    >
                </div>

                {{-- Email --}}
                <div class="mb-4">
                    <label for="email" class="form-label fw-semibold" style="color: #4a3b2b;">Email</label>
                    <input 
                        type="email" 
                        class="form-control form-control-lg rounded-3 border-0 shadow-sm" 
                        name="email" 
                        id="email" 
                        value="{{ old('email') }}" 
                        required
                    >
                </div>

                {{-- Password --}}
                <div class="mb-4">
                    <label for="password" class="form-label fw-semibold" style="color: #4a3b2b;">Password</label>
                    <input 
                        type="password" 
                        class="form-control form-control-lg rounded-3 border-0 shadow-sm" 
                        name="password" 
                        id="password" 
                        required
                    >
                </div>

                {{-- Confirm Password --}}
                <div class="mb-4">
                    <label for="password_confirmation" class="form-label fw-semibold" style="color: #4a3b2b;">Confirm Password</label>
                    <input 
                        type="password" 
                        class="form-control form-control-lg rounded-3 border-0 shadow-sm" 
                        name="password_confirmation" 
                        id="password_confirmation" 
                        required
                    >
                </div>

                {{-- Role --}}
                <div class="mb-4">
                    <label for="role" class="form-label fw-semibold" style="color: #4a3b2b;">Role</label>
                    <select 
                        name="role" 
                        id="role"
                        class="form-select form-select-lg rounded-3 border-0 shadow-sm" 
                        required
                    >
                        <option value="User" {{ old('role') == 'User' ? 'selected' : '' }}>User</option>
                        <option value="Masseuse" {{ old('role') == 'Masseuse' ? 'selected' : '' }}>Masseuse</option>
                    </select>
                </div>

                {{-- Submit --}}
                <button 
                    type="submit" 
                    class="btn w-100 fw-semibold py-2 rounded-3" 
                    style="background: rgba(212, 163, 115, 0.9); color: white; font-size: 1.05rem; box-shadow: 0 4px 8px rgba(212, 163, 115, 0.4); transition: background-color 0.3s ease;"
                    onmouseover="this.style.backgroundColor='rgba(212, 163, 115, 1)'"
                    onmouseout="this.style.backgroundColor='rgba(212, 163, 115, 0.9)'"
                >
                    Create User
                </button>
            </form>
        </div>

        {{-- Right Column: SVG Icon --}}
        <div style="flex: 1; background: white; border-radius: 12px; padding: 2rem; box-shadow: 0 0 10px rgb(0 0 0 / 0.05); display: flex; flex-direction: column; align-items: center; justify-content: center;">
            <div class="text-center">
                <svg xmlns="http://www.w3.org/2000/svg" style="width: 100px; height: 100px; color: rgba(212, 163, 115, 0.9);" fill="currentColor" class="bi bi-person-plus" viewBox="0 0 16 16">
                    <path d="M8 7a3 3 0 1 0-6 0 3 3 0 0 0 6 0z"/>
                    <path fill-rule="evenodd" d="M8 8a5 5 0 0 0-4.546 2.916A.5.5 0 0 0 3.5 11h5a.5.5 0 0 0 .454-.584A5 5 0 0 0 8 8zm5-1v1h1v1h-1v1h-1v-1H11v-1h1v-1h1z"/>
                </svg>
                <h5 class="fw-semibold mt-3" style="color: #4a3b2b;">Add a New User</h5>
                <p class="text-muted" style="font-size: 0.9rem;">
                    Fill out the form to register a new user.
                </p>
            </div>
        </div>
    </div>
</div>

{{-- Success Modal --}}
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

{{-- JS to trigger modal --}}
@if(session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var successModal = new bootstrap.Modal(document.getElementById('successModal'));
        successModal.show();
    });
</script>
@endif
@endsection