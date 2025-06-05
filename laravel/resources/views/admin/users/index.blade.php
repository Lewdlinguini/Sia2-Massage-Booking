@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4 py-5" style="min-height: 100vh;">

    <!-- ── Header ─────────────────────────────────────────── -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold" style="color:#b97f5a; font-family:'Segoe UI',Tahoma,Geneva,Verdana,sans-serif;">
            Manage Users
        </h1>
    </div>
    
    <!-- Success Modal (hidden by default) -->
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 shadow">
          <div class="modal-header bg-success text-white">
            <h5 class="modal-title" id="successModalLabel">Success</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            {{ session('success') }}
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-success" data-bs-dismiss="modal">OK</button>
          </div>
        </div>
      </div>
    </div>

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

                            <!-- Delete button triggers modal -->
                            <button 
                                class="btn btn-sm btn-danger d-flex align-items-center gap-1 modern-btn" 
                                data-bs-toggle="modal" 
                                data-bs-target="#confirmDeleteModal" 
                                data-user-id="{{ $user->id }}" 
                                data-user-name="{{ $user->first_name }} {{ $user->last_name }}">
                                <i class="bi bi-trash-fill"></i> Delete
                            </button>
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

<!-- Confirm Delete Modal -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <form id="deleteUserForm" method="POST" action="">
      @csrf
      @method('DELETE')
      <div class="modal-content rounded-4 shadow">
        <div class="modal-header bg-danger text-white">
          <h5 class="modal-title" id="confirmDeleteLabel">Confirm Delete</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          Are you sure you want to delete <strong id="userName"></strong>?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-danger">Yes, Delete</button>
        </div>
      </div>
    </form>
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

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Show success modal if session success exists
        @if(session('success'))
            var successModal = new bootstrap.Modal(document.getElementById('successModal'));
            successModal.show();
        @endif

        // Setup delete modal
        var confirmDeleteModal = document.getElementById('confirmDeleteModal');
        confirmDeleteModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var userId = button.getAttribute('data-user-id');
            var userName = button.getAttribute('data-user-name');
            var form = document.getElementById('deleteUserForm');
            var userNameElem = document.getElementById('userName');

            userNameElem.textContent = userName;
            form.action = '/admin/users/' + userId;  // Adjust URL if needed
        });
    });
</script>
@endpush