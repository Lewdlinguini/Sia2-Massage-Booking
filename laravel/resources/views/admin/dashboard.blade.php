@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4 py-5" style="min-height: 100vh;">

    <!-- ── Dashboard Header ─────────────────────────────── -->
    <div class="container text-center mb-5">
        <h1 class="display-4 fw-bold mb-3" style="color:#b97f5a;font-family:'Segoe UI',Tahoma,Geneva,Verdana,sans-serif;">
            Admin Dashboard
        </h1>
        <p class="lead text-secondary mb-4" style="font-weight:500; max-width:600px; margin:0 auto;">
            Overview of Active and Inactive Users
        </p>
    </div>

    <!-- ── Bar Chart Card ────────────────────────────────── -->
    <div class="container d-flex justify-content-center">
        <div class="card modern-card p-4" style="max-width: 450px; width: 100%;">
            <h5 class="fw-semibold mb-4" style="color:#b97f5a; font-family:'Segoe UI',Tahoma,Geneva,Verdana,sans-serif;">
                Active vs Inactive Users
            </h5>
            <canvas id="userStatusChart" style="max-height: 300px;"></canvas>
        </div>
    </div>

</div>
@endsection

@push('styles')
<style>
    .modern-card {
        background: #fff;
        box-shadow: 8px 8px 16px #d1b58e, -8px -8px 16px #fff7e6;
        border-radius: 1.5rem !important;
        transition: transform .3s ease, box-shadow .3s ease;
    }
    .modern-card:hover {
        transform: translateY(-8px);
        box-shadow: 12px 12px 24px #c9a666, -12px -12px 24px #fffbe9;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('userStatusChart').getContext('2d');

    const activeUsers = {{ $activeUsers }};
    const inactiveUsers = {{ $inactiveUsers }};

    const data = {
        labels: ['Active Users', 'Inactive Users'],
        datasets: [{
            label: 'User Count',
            data: [activeUsers, inactiveUsers],
            backgroundColor: ['#caa974', '#8c7b6b'],
            borderRadius: 10,
            barThickness: 50
        }]
    };

    const config = {
        type: 'bar',
        data: data,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                },
                title: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return `${context.label}: ${context.parsed.y}`;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                        color: '#4a3b2b',
                        font: { size: 14, weight: '600' }
                    },
                    title: {
                        display: true,
                        text: 'Number of Users',
                        color: '#4a3b2b',
                        font: { size: 16, weight: '600' }
                    }
                },
                x: {
                    ticks: {
                        color: '#4a3b2b',
                        font: { size: 14, weight: '600' }
                    }
                }
            }
        }
    };

    new Chart(ctx, config);
</script>
@endpush
