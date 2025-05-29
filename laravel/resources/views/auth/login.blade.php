@extends('layouts.appl')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="card shadow-sm p-4 rounded-4" style="width: 100%; max-width: 400px; border: 2px solid #d4a373;">
        <h3 class="text-center mb-4 fw-bold" style="color: #2c3e50; letter-spacing: 1.1px;">
            Login to Your Account
        </h3>

        @if(session('success'))
            <div class="alert alert-success py-2">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger py-2">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label fw-semibold text-secondary mb-1" style="font-size: 0.9rem;">
                    Email
                </label>
                <input 
                    type="email" 
                    name="email" 
                    id="email" 
                    class="form-control form-control-lg rounded-pill border-2" 
                    required 
                    autofocus 
                    value="{{ old('email') }}"
                    style="border-color: #d4a373; font-size: 1rem; padding: 0.5rem 1.25rem;"
                >
            </div>

            <div class="mb-3">
                <label for="password" class="form-label fw-semibold text-secondary mb-1" style="font-size: 0.9rem;">
                    Password
                </label>
                <input 
                    type="password" 
                    name="password" 
                    id="password" 
                    class="form-control form-control-lg rounded-pill border-2" 
                    required
                    style="border-color: #d4a373; font-size: 1rem; padding: 0.5rem 1.25rem;"
                >
            </div>

            <div class="mb-3 form-check">
                <input 
                    type="checkbox" 
                    name="remember" 
                    class="form-check-input" 
                    id="remember"
                    style="width: 1.15rem; height: 1.15rem; border-color: #d4a373;"
                >
                <label class="form-check-label fw-semibold text-secondary" for="remember" style="font-size: 0.9rem;">
                    Remember Me
                </label>
            </div>

            <div class="d-grid mb-3">
                <button 
                    type="submit" 
                    class="btn btn-lg rounded-pill fw-semibold shadow-sm" 
                    style="background-color: #d4a373; border: none; color: white; transition: background-color 0.3s;">
                    Login
                </button>
            </div>

            <div class="d-flex justify-content-between" style="font-size: 0.9rem;">
                <a href="{{ route('password.request') }}" 
                   style="color: #d4a373; text-decoration: none; font-weight: 600;">
                   Forgot Password?
                </a>

                <a href="{{ route('register') }}" 
                   style="color: #d4a373; text-decoration: none; font-weight: 600;">
                   Register
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

<style>
    /* Button hover */
    .btn:hover {
        background-color: #b5895b !important;
        color: white !important;
    }
    /* Checkbox focus */
    input.form-check-input:focus {
        box-shadow: 0 0 0 0.2rem rgba(212, 163, 115, 0.5);
    }
</style>