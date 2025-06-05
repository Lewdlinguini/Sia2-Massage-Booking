@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4 py-5" style="min-height: 100vh; max-width: 600px;">

    <h1 class="fw-bold mb-4" style="color:#b97f5a; font-family:'Segoe UI',Tahoma,Geneva,Verdana,sans-serif;">
        Edit User
    </h1>

    <form method="POST" action="{{ route('admin.users.update', $user) }}">
        @csrf
        @method('PUT')

        <div class="mb-4 modern-input-group">
            <label for="first_name" class="form-label fw-semibold" style="color:#4a3b2b;">First Name</label>
            <input type="text" id="first_name" name="first_name" class="form-control modern-input" value="{{ old('first_name', $user->first_name) }}" required>
            @error('first_name')<div class="text-danger mt-1">{{ $message }}</div>@enderror
        </div>

        <div class="mb-4 modern-input-group">
            <label for="last_name" class="form-label fw-semibold" style="color:#4a3b2b;">Last Name</label>
            <input type="text" id="last_name" name="last_name" class="form-control modern-input" value="{{ old('last_name', $user->last_name) }}" required>
            @error('last_name')<div class="text-danger mt-1">{{ $message }}</div>@enderror
        </div>

        <div class="mb-4 modern-input-group">
             <label for="date_of_birth" class="form-label fw-semibold" style="color:#4a3b2b;">Date of Birth</label>
             <input type="date" id="date_of_birth" name="date_of_birth" class="form-control modern-input" value="{{ old('date_of_birth', isset($user) ? $user->date_of_birth->format('Y-m-d') : '') }}" required>
             @error('date_of_birth')
        <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4 modern-input-group">
            <label for="email" class="form-label fw-semibold" style="color:#4a3b2b;">Email (cannot change)</label>
            <input type="email" id="email" name="email" class="form-control modern-input" value="{{ $user->email }}" disabled>
        </div>

        <div class="mb-4 modern-input-group">
            <label for="role" class="form-label fw-semibold" style="color:#4a3b2b;">Role</label>
            <select id="role" name="role" class="form-select modern-select" required>
                <option value="user" {{ old('role', $user->role)=='user' ? 'selected' : '' }}>User</option>
                <option value="admin" {{ old('role', $user->role)=='admin' ? 'selected' : '' }}>Admin</option>
                <option value="masseuse" {{ old('role', $user->role)=='masseuse' ? 'selected' : '' }}>Masseuse</option>
            </select>
        </div>

        <hr class="my-4" style="border-color: #d1b58e;">

        <h5 class="fw-semibold mb-3" style="color:#b97f5a;">Change Password</h5>

        <div class="mb-4 modern-input-group">
            <label for="password" class="form-label fw-semibold" style="color:#4a3b2b;">New Password (leave blank to keep current)</label>
            <input type="password" id="password" name="password" class="form-control modern-input">
            @error('password')<div class="text-danger mt-1">{{ $message }}</div>@enderror
        </div>

        <div class="mb-5 modern-input-group">
            <label for="password_confirmation" class="form-label fw-semibold" style="color:#4a3b2b;">Confirm New Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control modern-input">
        </div>

        <button type="submit" class="btn btn-primary btn-lg fw-semibold modern-btn me-3">
            Update User
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
    /* Optional: customize the checkbox for neumorphic style */
    .modern-check .form-check-input {
        width: 1.25rem;
        height: 1.25rem;
        border-radius: 0.5rem;
        box-shadow: 3px 3px 6px #d1b58e, -3px -3px 6px #fff7e6;
        transition: box-shadow 0.3s ease;
        border: none;
    }
    .modern-check .form-check-input:checked {
        background-color: #caa974;
        box-shadow: inset 3px 3px 6px #d1b58e, inset -3px -3px 6px #fff7e6;
    }
    .modern-check .form-check-input:focus {
        outline: none;
        box-shadow: inset 3px 3px 6px #c9a666, inset -3px -3px 6px #fffbe9;
    }
    .modern-check label {
        user-select: none;
    }
</style>
@endpush