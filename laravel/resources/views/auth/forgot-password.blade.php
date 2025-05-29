@extends('layouts.appl')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="card shadow-sm p-4 rounded-4" style="width: 100%; max-width: 400px; border: 2px solid #d4a373;">
        <h3 class="text-center mb-4 fw-bold" style="color: #2c3e50; letter-spacing: 1.1px;">
            Forgot Password
        </h3>

        @if(session('status'))
            <div class="alert alert-success py-2">
                {{ session('status') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger py-2">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label fw-semibold text-secondary mb-1" style="font-size: 0.9rem;">Email</label>
                <input 
                    type="email" 
                    name="email" 
                    id="email" 
                    class="form-control form-control-lg rounded-pill border-2" 
                    required 
                    value="{{ old('email') }}"
                    style="border-color: #d4a373; padding: 0.5rem 1.25rem; font-size: 1rem;"
                >
            </div>

            <div class="d-grid mb-3">
                <button 
                    type="submit" 
                    class="btn btn-lg rounded-pill fw-semibold shadow-sm" 
                    style="background-color: #d4a373; border: none; color: white; transition: background-color 0.3s;">
                    Send Reset Link
                </button>
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
</style>