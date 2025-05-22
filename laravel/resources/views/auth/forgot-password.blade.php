@extends('layouts.appl')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="card shadow-lg p-4" style="width: 100%; max-width: 400px;">
        <h3 class="text-center mb-4">Forgot Password</h3>

        @if(session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input 
                    type="email" 
                    name="email" 
                    id="email" 
                    class="form-control" 
                    required 
                    value="{{ old('email') }}">
            </div>

            <div class="d-grid mb-3">
                <button type="submit" class="btn" style="background: rgba(212, 163, 115, 0.9); color: white;">
                    Send Reset Link
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
