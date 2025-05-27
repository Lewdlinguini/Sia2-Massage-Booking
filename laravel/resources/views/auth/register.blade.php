@extends('layouts.appl')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="card shadow-lg p-4" style="width: 100%; max-width: 500px;">
        <h3 class="text-center mb-4">Create an Account</h3>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

           <div class="mb-3">
           <label class="form-label">First Name</label>
           <input type="text" name="first_name" class="form-control" required value="{{ old('first_name') }}">
           </div>

           <div class="mb-3">
           <label class="form-label">Last Name</label>
           <input type="text" name="last_name" class="form-control" required value="{{ old('last_name') }}">
           </div> 

           <div class="mb-3">
           <label class="form-label">Date of Birth</label>
           <input type="date" name="date_of_birth" class="form-control" required value="{{ old('date_of_birth') }}">
           </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" required value="{{ old('email') }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Confirm Password</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>

            <div class="mb-3">
            <label class="form-label">Registering As</label>
            <select name="role" class="form-select" required>
            <option value="User" {{ old('role') == 'User' ? 'selected' : '' }}>User</option>
            <option value="Masseuse" {{ old('role') == 'Masseuse' ? 'selected' : '' }}>Masseuse</option>
            </select>
            </div>

            <div class="d-grid mb-3">
                <button type="submit" class="btn" style="background: rgba(212, 163, 115, 0.9); color: white;">Register</button>
            </div>

            <div class="text-center">
                <a href="{{ route('login') }}" 
                   style="color: rgba(212, 163, 115, 0.9); text-decoration: none;">
                   Already have an account?
                </a>
            </div>
        </form>
    </div>
</div>
@endsection