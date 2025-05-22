@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="card shadow-lg p-4" style="width: 100%; max-width: 400px;">
        <h3 class="text-center mb-4" style="color: rgba(212, 163, 115, 0.9);">Edit Profile</h3>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <!-- Show current profile picture -->
        <div class="text-center mb-3">
            @if(auth()->user()->profile_picture)
                <img src="{{ asset('storage/' . auth()->user()->profile_picture) }}" class="rounded-circle" width="100" height="100" alt="Profile Picture">
            @else
                <img src="{{ asset('default-avatar.png') }}" class="rounded-circle" width="100" height="100" alt="Default Avatar">
            @endif
        </div>

        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name" class="form-label" style="color: #4a3b2b;">Name</label>
                <input
                    type="text"
                    class="form-control @error('name') is-invalid @enderror"
                    id="name"
                    name="name"
                    value="{{ old('name', auth()->user()->name) }}"
                    required
                >
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label" style="color: #4a3b2b;">Email</label>
                <input
                    type="email"
                    class="form-control"
                    id="email"
                    name="email"
                    value="{{ auth()->user()->email }}"
                    readonly
                >
            </div>

            <div class="mb-3">
                <label for="profile_picture" class="form-label" style="color: #4a3b2b;">Upload New Profile Picture</label>
                <input type="file" class="form-control" id="profile_picture" name="profile_picture" accept="image/*">
            </div>

            <button type="submit" class="btn" style="background: rgba(212, 163, 115, 0.9); color: white; width: 100%;">Save Changes</button>
        </form>
    </div>
</div>
@endsection
