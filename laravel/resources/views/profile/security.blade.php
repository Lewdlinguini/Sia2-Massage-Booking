@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="shadow-sm rounded-4 p-4 bg-white w-100" style="max-width: 480px;">
        <h3 class="text-center mb-4" style="color: rgba(212, 163, 115, 0.9);">Security Settings</h3>

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

        <form method="POST" action="{{ route('profile.password.update') }}">
            @csrf
            @method('PUT')

            <!-- Current Password -->
            <div class="mb-3">
                <label for="current_password" class="form-label" style="color: #4a3b2b;">Current Password</label>
                <input type="password" class="form-control @error('current_password') is-invalid @enderror"
                       id="current_password" name="current_password" required>
                @error('current_password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- New Password -->
            <div class="mb-3">
                <label for="password" class="form-label" style="color: #4a3b2b;">New Password</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror"
                       id="password" name="password" required>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Confirm New Password -->
            <div class="mb-4">
                <label for="password_confirmation" class="form-label" style="color: #4a3b2b;">Confirm New Password</label>
                <input type="password" class="form-control"
                       id="password_confirmation" name="password_confirmation" required>
            </div>

            <!-- 2FA Toggle -->
            <div class="d-flex justify-content-between align-items-center mb-4" style="font-size: 0.9rem;">
                <label for="enable_2fa" class="mb-0 fw-semibold" style="color: #4a3b2b;">Enable Two-Factor Authentication (2FA)</label>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" id="enable_2fa" name="enable_2fa" disabled>
                </div>
            </div>

            <button type="submit" 
                    class="btn w-100 fw-semibold py-1" 
                    style="background: rgba(212, 163, 115, 0.9); color: white; font-size: 0.9rem;">
                Change Password
            </button>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    @if(session('success'))
        new bootstrap.Modal(document.getElementById('successModal')).show();
    @endif
});
</script>
@endsection
