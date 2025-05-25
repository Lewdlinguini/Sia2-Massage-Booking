@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Add a New Service</h2>
    
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('services.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Service Name</label>
            <input type="text" class="form-control" name="name" id="name" placeholder="e.g., Hot Stone Massage" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Service Description</label>
            <textarea class="form-control" name="description" id="description" rows="3" placeholder="Describe the service..."></textarea>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Optional Image</label>
            <input type="file" class="form-control" name="image" id="image">
        </div>

       <button type="submit" class="btn" style="background: rgba(212, 163, 115, 0.9); color: white; padding: 0.5rem 1.5rem; border-radius: 5px;">
       Add Service
       </button>
    </form>
</div>
@endsection