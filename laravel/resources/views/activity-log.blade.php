@extends('layouts.app')

@section('content')
<div class="container-fluid px-4 py-5" style="min-height: 100vh;">

    <!-- ── Hero ─────────────────────────────────────────────── -->
    <div class="container text-center mb-5">
        <h1 class="display-4 fw-bold mb-3" style="color:#b97f5a; font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
            Activity Log
        </h1>
        <p class="lead text-secondary mb-4" style="font-weight:500; max-width:600px; margin:0 auto;">
            Track your recent activities to stay informed.
        </p>
    </div>

    <!-- ── Activity Log Table ───────────────────────────────── -->
    <div class="container">
        <div class="card modern-card shadow border-0 p-4">
            <table class="table table-bordered mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Time</th>
                        <th>Activity</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($logs as $log)
                        <tr>
                            <td>{{ $log['time'] }}</td>
                            <td>{{ $log['activity'] }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="text-center text-muted">No activity recorded.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('styles')
<style>
    .modern-card {
        background: #fff;
        box-shadow: 8px 8px 16px #d1b58e, -8px -8px 16px #fff7e6;
        border-radius: 1.5rem !important;
        transition: transform .3s ease, box-shadow .3s ease;
    }
    .modern-card:hover {
        transform: translateY(-12px);
        box-shadow: 12px 12px 24px #c9a666, -12px -12px 24px #fffbe9;
    }
    table th, table td {
        vertical-align: middle;
    }
</style>
@endpush
@endsection