@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4 py-5" style="min-height: 100vh;">

    <!-- ── Header ─────────────────────────────────────────── -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold" style="color:#b97f5a; font-family:'Segoe UI',Tahoma,Geneva,Verdana,sans-serif;">
            Manage Users
        </h1>
        <a href="{{ route('admin.users.create') }}" 
           class="btn btn-lg fw-semibold text-white shadow"
           style="
                background: linear-gradient(90deg, #caa974, #d4a373);
                border-radius: 50px;
                box-shadow: 0 6px 15px rgba(212,163,115,.4);
                transition: all .3s ease;
            "
            onmouseover="this.style.background='linear-gradient(90deg,#d4a373,#caa974)'"
            onmouseout="this.style.background='linear-gradient(90deg,#caa974,#d4a373)'"
        >
            <i class="bi bi-plus-circle me-2"></i> Add New User
        </a>
    </div>

    <!-- ── Success Message ─────────────────────────────────── -->
    @if(session('success'))
        <div class="alert alert-success modern-alert" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <!-- ── Users Table ────────────────────────────────────── -->
    <div class="card modern-card shadow-sm">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="color:#4a3b2b;">Name</th>
                        <th style="color:#4a3b2b;">Email</th>
                        <th style="color:#4a3b2b;">Role</th>
                        <th style="color:#4a3b2b;">Status</th>
                        <th style="color:#4a3b2b;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td class="fw-semibold">{{ $user->first_name }} {{ $user->last_name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ ucfirst($user->role) }}</td>
                        <td>
                            @if($user->is_active)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-secondary">Inactive</span>
                            @endif
                        </td>
                        <td class="d-flex gap-2">
                            <a href="{{ route('admin.users.edit', $user) }}" 
                               class="btn btn-sm btn-warning d-flex align-items-center gap-1 modern-btn">
                                <i class="bi bi-pencil-square"></i> Edit
                            </a>

                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                  onsubmit="return confirm('Are you sure you want to delete this user?');"
                                  class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger d-flex align-items-center gap-1 modern-btn" type="submit">
                                    <i class="bi bi-trash-fill"></i> Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted fst-italic">No users found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- ── Pagination ─────────────────────────────────────── -->
    <div class="mt-4 d-flex justify-content-center">
        {{ $users->links() }}
    </div>

</div>
@endsection

@push('styles')
<style>
    .modern-card {
        background: #fff;
        border-radius: 1.5rem !important;
        box-shadow: 8px 8px 16px #d1b58e, -8px -8px 16px #fff7e6;
        transition: transform .3s ease, box-shadow .3s ease;
    }
    .modern-card:hover {
        transform: translateY(-8px);
        box-shadow: 12px 12px 24px #c9a666, -12px -12px 24px #fffbe9;
    }
    .modern-alert {
        border-radius: 1rem;
        font-weight: 600;
        box-shadow: 4px 4px 12px #d1b58e;
        background-color: #e8f5e9;
        color: #2e7d32;
    }
    table thead th {
        font-weight: 600;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        user-select: none;
    }
    table tbody tr:hover {
        background-color: #fff7e6;
        transition: background-color 0.3s ease;
    }
    .modern-btn {
        border-radius: 0.7rem;
        box-shadow: 3px 3px 6px #d1b58e, -3px -3px 6px #fff7e6;
        transition: box-shadow 0.3s ease, transform 0.2s ease;
        font-weight: 600;
    }
    .modern-btn:hover, .modern-btn:focus {
        box-shadow: inset 3px 3px 6px #d1b58e, inset -3px -3px 6px #fff7e6;
        transform: translateY(-2px);
        outline: none;
    }
</style>
@endpush