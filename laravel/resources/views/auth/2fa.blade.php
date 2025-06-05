@extends('layouts.appl')

@section('content')
<div class="d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="card p-4 shadow-sm rounded-4" style="max-width: 400px; width: 100%;">
        <h4 class="mb-3 text-center" style="color: rgba(212, 163, 115, 0.9);">Two-Factor Authentication</h4>
        <p class="text-center mb-4 text-muted">Please enter the 6-digit code sent to your email.</p>

        @if($errors->any())
            <div class="alert alert-danger text-center">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('2fa.verify') }}">
            @csrf
            <div class="mb-3">
                <input
                    type="text"
                    name="code"
                    maxlength="6"
                    class="form-control text-center fs-4"
                    placeholder="Enter 2FA code"
                    required
                    autofocus
                >
            </div>

            <button type="submit" class="btn fw-semibold w-100 py-2"
                    style="background: rgba(212, 163, 115, 0.9); color: white;">
                Verify
            </button>
        </form>
    </div>
</div>
@endsection
