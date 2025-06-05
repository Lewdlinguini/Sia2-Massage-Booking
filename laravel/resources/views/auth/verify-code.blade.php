@extends('layouts.appl')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="card shadow-sm p-4 rounded-4" style="width: 100%; max-width: 500px; border: 2px solid #d4a373;">
        <h4 class="text-center mb-4 fw-bold" style="color: #2c3e50; letter-spacing: 1px;">
            Enter Verification Code
        </h4>

        @if(session('message'))
            <div class="alert alert-success text-center">{{ session('message') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger text-center">{{ session('error') }}</div>
        @endif

        <form method="POST" action="{{ route('verification.code.verify') }}">
            @csrf
            <label class="form-label fw-semibold text-secondary mb-2" style="font-size: 0.9rem;">Verification Code</label>
            <input 
                type="text"
                name="code"
                maxlength="6"
                class="form-control form-control-lg rounded-pill border-2 text-center @error('code') is-invalid @enderror"
                placeholder="######"
                required
                style="border-color: #d4a373; padding: 0.5rem 1.25rem; font-size: 1.2rem; letter-spacing: 0.3rem;"
            >
            @error('code')
                <div class="invalid-feedback text-center">{{ $message }}</div>
            @enderror

            <div class="d-grid mt-4 mb-2">
                <button 
                    type="submit" 
                    class="btn btn-lg rounded-pill fw-semibold shadow-sm" 
                    style="background-color: #d4a373; border: none; color: white; transition: background-color 0.3s;">
                    Verify
                </button>
            </div>
        </form>

        <form method="POST" action="{{ route('verification.code.resend') }}">
            @csrf
            <div class="text-center mt-2">
                <button type="submit" class="btn btn-link fw-semibold p-0" style="color: #d4a373; font-size: 0.9rem;">
                    Resend Code
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

<style>
    .btn:hover {
        background-color: #b5895b !important;
        color: white !important;
    }
</style>