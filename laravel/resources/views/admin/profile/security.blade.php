@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-center align-items-center" style="min-height:100vh;">
    <div class="shadow-sm rounded-4 p-4 bg-white w-100" style="max-width:480px;">
        <h3 class="text-center mb-4" style="color:rgba(212,163,115,.9);">Security Settings</h3>

        {{-- ───────── Global success flash (password change, etc.) ───────── --}}
        @if(session('success'))
            <div class="modal fade" id="flashModal" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content rounded-4 shadow-sm">
                        <div class="modal-header bg-success text-white rounded-top">
                            <h5 class="modal-title"><i class="bi bi-check-circle-fill me-2"></i>Success</h5>
                            <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">{{ session('success') }}</div>
                    </div>
                </div>
            </div>
        @endif

        {{-- ─────────────────────── 2-FA toggle ─────────────────────── --}}
        @auth
        <div class="mb-4 d-flex justify-content-between align-items-center" style="color:#4a3b2b;">
            <label for="twoFactorToggle" class="form-label mb-0 fw-semibold">Enable Two-Factor Authentication (2FA)</label>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="twoFactorToggle"
                       {{ auth()->user()->two_factor_enabled ? 'checked' : '' }}>
            </div>
        </div>
        @endauth

        {{-- Password-verify modal -- centered --}}
        <div class="modal fade" id="passwordVerifyModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content rounded-4 shadow-sm">
                    <div class="modal-header bg-warning text-white rounded-top">
                        <h5 class="modal-title">Verify Password to Change 2FA</h5>
                        <button class="btn-close btn-close-white" data-bs-dismiss="modal" id="closeModalBtn"></button>
                    </div>
                    <div class="modal-body">
                        <form id="passwordVerifyForm">
                            @csrf
                            <input type="hidden" id="desired2FAStatus">
                            <div class="mb-3">
                                <label class="form-label">Current Password</label>
                                <input type="password" class="form-control" id="current_password_modal" required>
                                <div id="passwordError" class="text-danger mt-2 d-none"></div>
                            </div>
                            <button class="btn btn-warning w-100 fw-semibold">Verify & Confirm</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- Success on/off modal --}}
        <div class="modal fade" id="twoFactorSuccessModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content rounded-4 shadow-sm">
                    <div class="modal-header bg-success text-white rounded-top">
                        <h5 class="modal-title"><i class="bi bi-shield-lock-fill me-2"></i>Two-Factor Authentication</h5>
                        <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body" id="twoFactorSuccessText"></div>
                </div>
            </div>
        </div>

        {{-- ─────────────── Password-change form ─────────────── --}}
        <form method="POST" action="{{ route('profile.password.update') }}">
            @csrf @method('PUT')
            <div class="mb-3">
                <label class="form-label" style="color:#4a3b2b;">Current Password</label>
                <input type="password" class="form-control @error('current_password') is-invalid @enderror"
                       name="current_password" required>
                @error('current_password')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label" style="color:#4a3b2b;">New Password</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror"
                       name="password" required>
                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-4">
                <label class="form-label" style="color:#4a3b2b;">Confirm New Password</label>
                <input type="password" class="form-control" name="password_confirmation" required>
            </div>
            <button class="btn w-100 fw-semibold py-1"
                    style="background:rgba(212,163,115,.9);color:white;font-size:.9rem;">
                Change Password
            </button>
        </form>
    </div>
</div>

{{-- ───────────────────────────── JS ───────────────────────────── --}}
<script>
document.addEventListener('DOMContentLoaded', () => {

    // Show flash-success modal after page load
    if (document.getElementById('flashModal')) {
        new bootstrap.Modal('#flashModal').show();
    }

    const toggle   = document.getElementById('twoFactorToggle');
    if (!toggle) return;          // guest view

    const pwdModal = new bootstrap.Modal('#passwordVerifyModal');
    const okModal  = new bootstrap.Modal('#twoFactorSuccessModal');

    const pwdForm  = document.getElementById('passwordVerifyForm');
    const pwdInput = document.getElementById('current_password_modal');
    const errBox   = document.getElementById('passwordError');
    const statusEl = document.getElementById('desired2FAStatus');
    const okText   = document.getElementById('twoFactorSuccessText');

    let current = toggle.checked; // initial state

    // toggle clicked
    toggle.addEventListener('change', () => {
        statusEl.value = toggle.checked ? 'enable' : 'disable';
        pwdModal.show();
        toggle.checked = current;           // revert visually
        errBox.classList.add('d-none');
        pwdInput.value = '';
    });

    // form submit
    pwdForm.addEventListener('submit', e => {
        e.preventDefault();
        errBox.classList.add('d-none');

        const action = statusEl.value;
        const url    = action === 'enable'
                     ? "{{ route('profile.2fa.enable') }}"
                     : "{{ route('profile.2fa.disable') }}";

        fetch(url, {
            method : 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept'      : 'application/json'
            },
            body: JSON.stringify({ current_password: pwdInput.value })
        })
        .then(r => r.json())
        .then(res => {
            if (res.success) {
                current       = (action === 'enable');
                toggle.checked = current;
                pwdModal.hide();

                okText.textContent =
                    `Two-Factor Authentication has been ${action === 'enable' ? 'enabled' : 'disabled'}.`;
                okModal.show();
            } else {
                errBox.textContent = res.message || 'Incorrect password.';
                errBox.classList.remove('d-none');
            }
        })
        .catch(() => {
            errBox.textContent = 'An error occurred. Please try again.';
            errBox.classList.remove('d-none');
        });
    });
});
</script>
@endsection