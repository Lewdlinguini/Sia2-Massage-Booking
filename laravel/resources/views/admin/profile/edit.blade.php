@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="shadow-sm rounded-4 p-4 bg-white w-100" style="max-width: 480px;">
        <h3 class="text-center mb-4" style="color: rgba(212, 163, 115, 0.9);">Edit Profile</h3>

        <!-- Success Modal -->
@if(session('success'))
<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 shadow-sm">
            <div class="modal-header bg-success text-white rounded-top">
                <h5 class="modal-title" id="successModalLabel">
                    <i class="bi bi-check-circle-fill me-2"></i>Success
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body fs-6 px-4 py-3">
                {{ session('success') }}
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-outline-success px-4 fw-semibold" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endif
        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" id="profile-form">
            @csrf
            @method('PUT')

            <!-- Profile Picture Upload -->
            <div class="text-center mb-4 position-relative" style="width: 100px; margin: 0 auto;">
                @if(auth()->user()->profile_picture)
                    <img src="{{ asset('storage/' . auth()->user()->profile_picture) }}" 
                         class="rounded-circle img-fluid profile-border" 
                         alt="Profile Picture" 
                         id="profile-picture-display" 
                         style="width: 100px; height: 100px; object-fit: cover;">
                @else
                    <img src="{{ asset('default-avatar.png') }}" 
                         class="rounded-circle img-fluid profile-border" 
                         alt="Default Avatar" 
                         id="profile-picture-display" 
                         style="width: 100px; height: 100px; object-fit: cover;">
                @endif

                <div id="file-picker-icon" style="position: absolute; bottom: 0; right: 0; background: rgba(0,0,0,0.6); border-radius: 50%; width: 28px; height: 28px; display: flex; align-items: center; justify-content: center; color: white; font-size: 16px; cursor: pointer;">
                    <svg xmlns="http://www.w3.org/2000/svg" 
                         width="16" height="16" fill="currentColor" 
                         class="bi bi-image" viewBox="0 0 16 16">
                        <path d="M14.002 3a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h12zm-1 1H3v7.293l3.146-3.147a.5.5 0 0 1 .708 0L10 12.293l3-3V4z"/>
                        <path d="M10.648 8.646a1.5 1.5 0 1 0-2.195 2.195l2.195-2.195z"/>
                    </svg>
                </div>

                <input type="file" class="d-none" id="profile_picture" name="profile_picture" accept="image/*">
            </div>

            <!-- First Name -->
            <div class="mb-3">
                <label for="first_name" class="form-label" style="color: #4a3b2b;">First Name</label>
                <input type="text" class="form-control @error('first_name') is-invalid @enderror"
                    id="first_name" name="first_name"
                    value="{{ old('first_name', auth()->user()->first_name) }}" required>
                @error('first_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Last Name -->
            <div class="mb-3">
                <label for="last_name" class="form-label" style="color: #4a3b2b;">Last Name</label>
                <input type="text" class="form-control @error('last_name') is-invalid @enderror"
                    id="last_name" name="last_name"
                    value="{{ old('last_name', auth()->user()->last_name) }}" required>
                @error('last_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Date of Birth -->
            <div class="mb-3">
                <label for="date_of_birth" class="form-label" style="color: #4a3b2b;">Date of Birth</label>
                <input type="date" class="form-control @error('date_of_birth') is-invalid @enderror"
                    id="date_of_birth" name="date_of_birth"
                    value="{{ old('date_of_birth', auth()->user()->date_of_birth ? auth()->user()->date_of_birth->format('Y-m-d') : '') }}">
                @error('date_of_birth')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Cellphone -->
            <div class="mb-3">
                <label class="form-label" style="color: #4a3b2b;">Cellphone Number</label>
                <div class="input-group">
                    <span class="input-group-text bg-white border" style="font-weight: bold;">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/9/99/Flag_of_the_Philippines.svg/24px-Flag_of_the_Philippines.svg.png" alt="PH Flag" style="width: 20px; height: 14px; margin-right: 6px;">
                        +63
                    </span>
                    <input type="hidden" name="country_code" value="+63">
                    <input type="tel" inputmode="numeric" maxlength="13"
                        class="form-control @error('cellphone') is-invalid @enderror"
                        id="cellphone" name="cellphone"
                        placeholder="912 345 6789"
                        value="{{ old('cellphone', preg_replace('/^\+63/', '', auth()->user()->cellphone)) }}"
                        required>
                </div>
                @error('cellphone')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Address -->
            <div class="mb-3">
                <label for="address" class="form-label" style="color: #4a3b2b;">House Address</label>
                <input type="text" class="form-control @error('address') is-invalid @enderror"
                    id="address" name="address"
                    value="{{ old('address', auth()->user()->address) }}">
                @error('address')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Email (Read-only) -->
            <div class="mb-3">
                <label for="email" class="form-label" style="color: #4a3b2b;">Email</label>
                <input type="email" class="form-control" id="email" name="email"
                    value="{{ auth()->user()->email }}" readonly>
            </div>

            <button type="submit" 
        class="btn w-100 fw-semibold py-1" 
        style="background: rgba(212, 163, 115, 0.9); color: white; font-size: 0.9rem; border-radius: 50px;">
    Save Changes
</button>
        </form>
        <!-- Delete Profile Button -->
<button 
    type="button" 
    class="btn btn-danger w-100 fw-semibold py-1 delete-btn mt-4" 
    data-bs-toggle="modal" 
    data-bs-target="#deleteProfileModal"
    style="font-size: 0.9rem; border-radius: 50px;"
>
    Delete Profile
</button>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteProfileModal" tabindex="-1" aria-labelledby="deleteProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 shadow">
            <div class="modal-header bg-danger text-white rounded-top">
                <h5 class="modal-title" id="deleteProfileModalLabel"><i class="bi bi-exclamation-triangle-fill me-2"></i>Confirm Deletion</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('profile.destroy') }}">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <p class="text-muted">Please enter your password to confirm account deletion.</p>
                    <div class="mb-3">
                        <label for="delete-password" class="form-label">Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                               id="delete-password" name="password" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <p class="text-danger small mt-2">This action is permanent and cannot be undone.</p>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger fw-semibold">Delete Account</button>
                </div>
            </form>
        </div>
    </div>
</div>
    </div>
</div>

<style>
    .profile-border {
        border: 4px solid rgba(212, 163, 115, 0.9);
        box-shadow: 0 0 10px rgba(212, 163, 115, 0.6);
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Show success modal if it exists
    @if(session('success'))
        var successModal = new bootstrap.Modal(document.getElementById('successModal'));
        successModal.show();
    @endif

    // Handle profile picture preview
    const filePickerIcon = document.getElementById('file-picker-icon');
    const profilePictureInput = document.getElementById('profile_picture');
    const profilePictureDisplay = document.getElementById('profile-picture-display');

    filePickerIcon.addEventListener('click', () => {
        profilePictureInput.click();
    });

    profilePictureInput.addEventListener('change', event => {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = e => {
                profilePictureDisplay.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });

    // Format cellphone number
    const cellphoneInput = document.getElementById('cellphone');
    cellphoneInput.addEventListener('input', () => {
        let digits = cellphoneInput.value.replace(/\D/g, '').slice(0, 10);
        if (digits.length > 6) {
            cellphoneInput.value = digits.replace(/(\d{3})(\d{3})(\d{1,4})/, '$1 $2 $3');
        } else if (digits.length > 3) {
            cellphoneInput.value = digits.replace(/(\d{3})(\d{1,3})/, '$1 $2');
        } else {
            cellphoneInput.value = digits;
        }
    });
});
</script>
@endsection