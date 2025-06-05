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

    <!-- ── Pie Chart Card ────────────────────────────────── -->
    <div class="container d-flex justify-content-center">
        <div class="card modern-card p-4" style="max-width: 350px; width: 100%;">
            <h5 class="fw-semibold mb-4" style="color:#b97f5a; font-family:'Segoe UI',Tahoma,Geneva,Verdana,sans-serif;">
                Active vs Inactive Users
            </h5>
            <canvas id="userStatusChart" style="max-width: 300px; max-height: 300px; margin: 0 auto;"></canvas>
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
    const totalUsers = activeUsers + inactiveUsers;

    const data = {
        labels: ['Active Users', 'Inactive Users'],
        datasets: [{
            data: [activeUsers, inactiveUsers],
            backgroundColor: ['#caa974', '#8c7b6b'],
            hoverOffset: 30
        }]
    };

    const config = {
        type: 'pie',
        data: data,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        color: '#4a3b2b',
                        font: { weight: '600', size: 14 }
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const label = context.label || '';
                            const value = context.parsed || 0;
                            const percentage = totalUsers ? ((value / totalUsers) * 100).toFixed(1) : 0;
                            return `${label}: ${value} (${percentage}%)`;
                        }
                    }
                }
            }
        },
        plugins: [{
            id: 'percentageLabels',
            afterDatasetsDraw(chart) {
                const {ctx, data} = chart;
                ctx.save();
                ctx.font = 'bold 14px "Segoe UI", Tahoma, Geneva, Verdana, sans-serif';
                ctx.fillStyle = '#fff';
                ctx.textAlign = 'center';
                ctx.textBaseline = 'middle';

                chart.getDatasetMeta(0).data.forEach((arc, index) => {
                    const value = data.datasets[0].data[index];
                    const percentage = totalUsers ? ((value / totalUsers) * 100).toFixed(1) : 0;
                    const position = arc.tooltipPosition();
                    ctx.fillText(percentage + '%', position.x, position.y);
                });

                ctx.restore();
            }
        }]
    };

    new Chart(ctx, config);
</script>
@endpush