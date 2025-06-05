@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4 py-5" style="min-height: 100vh; max-width: 600px;">

    <h1 class="fw-bold mb-4" style="color:#b97f5a; font-family:'Segoe UI',Tahoma,Geneva,Verdana,sans-serif;">
        Add New User
    </h1>

    <form method="POST" action="{{ route('admin.users.store') }}">
        @csrf

        <div class="mb-4 modern-input-group">
            <label for="first_name" class="form-label fw-semibold" style="color:#4a3b2b;">First Name</label>
            <input type="text" id="first_name" name="first_name" class="form-control modern-input" value="{{ old('first_name') }}" required>
            @error('first_name')<div class="text-danger mt-1">{{ $message }}</div>@enderror
        </div>

        <div class="mb-4 modern-input-group">
            <label for="last_name" class="form-label fw-semibold" style="color:#4a3b2b;">Last Name</label>
            <input type="text" id="last_name" name="last_name" class="form-control modern-input" value="{{ old('last_name') }}" required>
            @error('last_name')<div class="text-danger mt-1">{{ $message }}</div>@enderror
        </div>

        <div class="mb-4 modern-input-group">
            <label for="email" class="form-label fw-semibold" style="color:#4a3b2b;">Email</label>
            <input type="email" id="email" name="email" class="form-control modern-input" value="{{ old('email') }}" required>
            @error('email')<div class="text-danger mt-1">{{ $message }}</div>@enderror
        </div>

        <div class="mb-4 modern-input-group">
            <label for="role" class="form-label fw-semibold" style="color:#4a3b2b;">Role</label>
            <select id="role" name="role" class="form-select modern-select" required>
                <option value="user" {{ old('role')=='user' ? 'selected' : '' }}>User</option>
                <option value="admin" {{ old('role')=='admin' ? 'selected' : '' }}>Admin</option>
                <option value="masseuse" {{ old('role')=='masseuse' ? 'selected' : '' }}>Masseuse</option>
            </select>
        </div>

        <div class="mb-4 modern-input-group">
            <label for="password" class="form-label fw-semibold" style="color:#4a3b2b;">Password</label>
            <input type="password" id="password" name="password" class="form-control modern-input" required>
            @error('password')<div class="text-danger mt-1">{{ $message }}</div>@enderror
        </div>

        <div class="mb-5 modern-input-group">
            <label for="password_confirmation" class="form-label fw-semibold" style="color:#4a3b2b;">Confirm Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control modern-input" required>
        </div>

        <button type="submit" class="btn btn-success btn-lg fw-semibold modern-btn me-3">
            Add User
        </button>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-lg fw-semibold modern-btn">
            Cancel
        </a>
    </form>
</div>
@endsection

@push('styles')
<style>
    .modern-input-group label {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    .modern-input, .modern-select {
        border-radius: 1rem;
        box-shadow: inset 6px 6px 12px #d1b58e, inset -6px -6px 12px #fff7e6;
        border: none;
        padding: 0.75rem 1rem;
        font-size: 1rem;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        color: #4a3b2b;
        transition: box-shadow 0.3s ease;
    }
    .modern-input:focus, .modern-select:focus {
        outline: none;
        box-shadow: inset 3px 3px 6px #c9a666, inset -3px -3px 6px #fffbe9;
    }
    .modern-btn {
        border-radius: 50px;
        box-shadow: 6px 6px 16px #d1b58e, -6px -6px 16px #fff7e6;
        transition: box-shadow 0.3s ease, transform 0.2s ease;
    }
    .modern-btn:hover, .modern-btn:focus {
        box-shadow: inset 3px 3px 6px #d1b58e, inset -3px -3px 6px #fff7e6;
        transform: translateY(-2px);
        outline: none;
    }
    .text-danger {
        font-weight: 600;
    }
</style>
@endpush