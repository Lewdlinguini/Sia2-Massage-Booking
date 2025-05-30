@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-center align-items-start py-5" style="min-height: 90vh;">
    <div class="card shadow-sm rounded-4 p-4 d-flex flex-row" style="width: 100%; max-width: 900px; border: none; gap: 2rem;">

        {{-- Left Column: Form --}}
        <div style="flex: 2;">
            <h2 class="mb-4 fw-bold" style="color: rgba(212, 163, 115, 0.9);">
                {{ isset($service) ? 'Edit Service' : 'Add a New Service' }}
            </h2>

            @if ($errors->any())
                <div class="alert alert-danger rounded-3 shadow-sm">
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form 
                action="{{ isset($service) ? route('services.update', $service->id) : route('services.store') }}" 
                method="POST" 
                enctype="multipart/form-data"
                class="mt-3"
            >
                @csrf
                @if(isset($service))
                    @method('PUT')
                @endif

                {{-- Service Name --}}
                <div class="mb-4">
                    <label for="name" class="form-label fw-semibold" style="color: #4a3b2b;">Service Name</label>
                    <input 
                        type="text" 
                        class="form-control form-control-lg rounded-3 border-0 shadow-sm" 
                        name="name" 
                        id="name" 
                        placeholder="e.g., Hot Stone Massage" 
                        value="{{ old('name', $service->name ?? '') }}" 
                        required
                        autofocus
                    >
                </div>

                {{-- Service Description --}}
                <div class="mb-4">
                    <label for="description" class="form-label fw-semibold" style="color: #4a3b2b;">Service Description</label>
                    <textarea 
                        class="form-control rounded-3 border-0 shadow-sm" 
                        name="description" 
                        id="description" 
                        rows="6" 
                        placeholder="Describe the service..."
                        style="resize: vertical;"
                    >{{ old('description', $service->description ?? '') }}</textarea>
                </div>

                {{-- Service Image --}}
                <div class="mb-4">
                    <label for="image" class="form-label fw-semibold" style="color: #4a3b2b;">Service Image <small class="text-muted">(Optional)</small></label>
                    <input 
                        type="file" 
                        class="form-control rounded-3 border-0 shadow-sm" 
                        name="image" 
                        id="image" 
                        accept="image/*"
                    >
                </div>

                {{-- Submit Button --}}
                <button 
                    type="submit" 
                    class="btn w-100 fw-semibold py-2 rounded-3" 
                    style="background: rgba(212, 163, 115, 0.9); color: white; font-size: 1.05rem; box-shadow: 0 4px 8px rgba(212, 163, 115, 0.4); transition: background-color 0.3s ease;"
                    onmouseover="this.style.backgroundColor='rgba(212, 163, 115, 1)'"
                    onmouseout="this.style.backgroundColor='rgba(212, 163, 115, 0.9)'"
                >
                    {{ isset($service) ? 'Update Service' : 'Add Service' }}
                </button>
            </form>
        </div>

        {{-- Right Column: Profile Info --}}
        <div style="flex: 1; background: white; border-radius: 12px; padding: 2rem; box-shadow: 0 0 10px rgb(0 0 0 / 0.05); display: flex; flex-direction: column; align-items: center; justify-content: center;">

            <div class="d-flex flex-column align-items-center gap-3">
                <div class="mb-3" style="width: 120px; height: 120px; border-radius: 50%; overflow: hidden; box-shadow: 0 4px 8px rgba(212, 163, 115, 0.3);">
                    @if(auth()->user()->profile_picture)
                        <img 
                            src="{{ asset('storage/' . auth()->user()->profile_picture) }}" 
                            alt="Profile Picture" 
                            style="width: 100%; height: 100%; object-fit: cover;"
                        >
                    @else
                        <div class="rounded-circle bg-secondary d-flex justify-content-center align-items-center" 
                             style="width: 120px; height: 120px; color: white; font-weight: 700; font-size: 3rem;">
                            {{ strtoupper(substr(auth()->user()->first_name, 0, 1)) }}
                        </div>
                    @endif
                </div>

                <h5 class="fw-semibold" style="color: #4a3b2b; text-align: center;">
                    {{ auth()->user()->first_name }} {{ auth()->user()->last_name }}
                </h5>

                <p class="text-muted text-center" style="font-size: 0.9rem;">
                    Service Provider
                </p>
            </div>

        </div>

    </div>
</div>
@endsection
