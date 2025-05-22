@extends('layouts.appl')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="card shadow-lg p-4" style="width: 100%; max-width: 400px;">
        <h3 class="text-center mb-4">Login to Your Account</h3>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input 
                    type="email" 
                    name="email" 
                    id="email" 
                    class="form-control" 
                    required 
                    autofocus 
                    value="{{ old('email') }}">
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input 
                    type="password" 
                    name="password" 
                    id="password" 
                    class="form-control" 
                    required>
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" name="remember" class="form-check-input" id="remember">
                <label class="form-check-label" for="remember">Remember Me</label>
            </div>

            <div class="d-grid mb-3">
                <button type="submit" class="btn" style="background: rgba(212, 163, 115, 0.9); color: white;">Login</button>
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('password.request') }}" 
                   style="color: rgba(212, 163, 115, 0.9); text-decoration: none;">
                   Forgot Password?
                </a>

                <a href="{{ route('register') }}" 
                   style="color: rgba(212, 163, 115, 0.9); text-decoration: none;">
                   Register
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
