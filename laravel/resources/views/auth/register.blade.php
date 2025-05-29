@extends('layouts.appl')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="card shadow-sm p-4 rounded-4" style="width: 100%; max-width: 700px; border: 2px solid #d4a373;">
        <h3 class="text-center mb-4 fw-bold" style="color: #2c3e50; letter-spacing: 1.1px;">
            Create an Account
        </h3>

        @if($errors->any())
            <div class="alert alert-danger py-2">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold text-secondary mb-1" style="font-size: 0.9rem;">First Name</label>
                    <input 
                        type="text" 
                        name="first_name" 
                        class="form-control form-control-lg rounded-pill border-2" 
                        required 
                        value="{{ old('first_name') }}"
                        style="border-color: #d4a373; padding: 0.5rem 1.25rem; font-size: 1rem;"
                    >
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold text-secondary mb-1" style="font-size: 0.9rem;">Last Name</label>
                    <input 
                        type="text" 
                        name="last_name" 
                        class="form-control form-control-lg rounded-pill border-2" 
                        required 
                        value="{{ old('last_name') }}"
                        style="border-color: #d4a373; padding: 0.5rem 1.25rem; font-size: 1rem;"
                    >
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold text-secondary mb-1" style="font-size: 0.9rem;">Date of Birth</label>
                    <input 
                        type="date" 
                        name="date_of_birth" 
                        class="form-control form-control-lg rounded-pill border-2" 
                        required 
                        value="{{ old('date_of_birth') }}"
                        style="border-color: #d4a373; padding: 0.5rem 1.25rem; font-size: 1rem;"
                    >
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold text-secondary mb-1" style="font-size: 0.9rem;">Email</label>
                    <input 
                        type="email" 
                        name="email" 
                        class="form-control form-control-lg rounded-pill border-2" 
                        required 
                        value="{{ old('email') }}"
                        style="border-color: #d4a373; padding: 0.5rem 1.25rem; font-size: 1rem;"
                    >
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold text-secondary mb-1" style="font-size: 0.9rem;">Password</label>
                    <input 
                        type="password" 
                        name="password" 
                        class="form-control form-control-lg rounded-pill border-2" 
                        required
                        style="border-color: #d4a373; padding: 0.5rem 1.25rem; font-size: 1rem;"
                    >
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold text-secondary mb-1" style="font-size: 0.9rem;">Confirm Password</label>
                    <input 
                        type="password" 
                        name="password_confirmation" 
                        class="form-control form-control-lg rounded-pill border-2" 
                        required
                        style="border-color: #d4a373; padding: 0.5rem 1.25rem; font-size: 1rem;"
                    >
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold text-secondary mb-1" style="font-size: 0.9rem;">Registering As</label>
                    <select 
                        name="role" 
                        class="form-select form-select-lg rounded-pill border-2" 
                        required
                        style="border-color: #d4a373; font-size: 1rem; padding: 0.375rem 1.25rem;"
                    >
                        <option value="User" {{ old('role') == 'User' ? 'selected' : '' }}>User</option>
                        <option value="Masseuse" {{ old('role') == 'Masseuse' ? 'selected' : '' }}>Masseuse</option>
                    </select>
                </div>
            </div>

            <div class="d-grid mt-4 mb-3">
                <button 
                    type="submit" 
                    class="btn btn-lg rounded-pill fw-semibold shadow-sm" 
                    style="background-color: #d4a373; border: none; color: white; transition: background-color 0.3s;">
                    Register
                </button>
            </div>

            <div class="text-center" style="font-size: 0.9rem;">
                <a href="{{ route('login') }}" 
                   style="color: #d4a373; text-decoration: none; font-weight: 600;">
                   Already have an account?
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
</style>