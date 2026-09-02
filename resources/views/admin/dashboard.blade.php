@extends('layouts.admin', ['withDataTables' => false, 'title' => 'Dashboard'])

@section('head')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="font-heading text-primary-custom fw-bold mb-0">Dashboard</h2>
</div>

@php
    $cards = [
        ['fa-folder', 'Kategori', $stats['categories'], 'category'],
        ['fa-box', 'Produk', $stats['products'], 'product'],
        ['fa-clipboard-check', 'Pesanan', $stats['orders'], 'order'],
        ['fa-calendar-days', 'Pesanan Hari Ini', $stats['ordersToday'], 'order'],
        ['fa-sack-dollar', 'Estimasi Pendapatan', 'Rp ' . number_format($stats['revenue'], 0, ',', '.'), 'order'],
    ];
@endphp
<div class="row g-3 mb-4">
    @foreach ($cards as $i => [$icon, $label, $value, $href])
        <div class="col-12 col-md-6 col-xl">
            <a class="text-decoration-none d-block h-100" href="{{ route($href) }}">
                <div
                    class="bg-surface-lowest border border-outline-variant rounded-4 p-4 ambient-shadow h-100">
                    <div class="icon-box mb-3"><i class="fa-solid {{ $icon }} fs-4"></i></div>
                    <p class="label-caps text-muted-custom mb-1">{{ $label }}</p>
                    <p class="font-heading fs-4 fw-bold text-primary-custom mb-0">{{ $value }}</p>
                </div>
            </a>
        </div>
    @endforeach
</div>

<div class="row g-3 mb-4">
    <div class="col-12 col-lg-6">
        <div class="bg-surface-lowest border border-outline-variant rounded-4 p-4 ambient-shadow h-100">
            <h3 class="font-heading text-primary-custom fw-bold mb-3">Pendapatan 6 Bulan Terakhir</h3>
            <div style="position: relative; height: 260px;">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-6">
        <div class="bg-surface-lowest border border-outline-variant rounded-4 p-4 ambient-shadow h-100">
            <h3 class="font-heading text-primary-custom fw-bold mb-3">Pesanan per Kategori</h3>
            <div style="position: relative; height: 260px;">
                <canvas id="categoryChart"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="bg-surface-lowest border border-outline-variant rounded-4 p-4 ambient-shadow">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="font-heading text-primary-custom fw-bold mb-0">Pesanan Terbaru</h3>
        <a class="nav-link-custom d-flex align-items-center gap-2 p-2 rounded" href="{{ route('order') }}">
            Lihat semua<i class="fa-solid fa-arrow-right"></i>
        </a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th class="font-heading">No. Order</th>
                    <th class="font-heading">Customer</th>
                    <th class="font-heading">Produk</th>
                    <th class="font-heading">Total</th>
                    <th class="font-heading">Status</th>
                    <th class="font-heading">Masuk</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($recentOrders as $order)
                    <tr>
                        <td>
                            <a class="fw-semibold text-decoration-none"
                                href="{{ route('order.show', $order->id) }}">{{ $order->order_number }}</a>
                        </td>
                        <td>{{ $order->customer_name }}</td>
                        <td>{{ $order->product->name }}</td>
                        <td class="fw-semibold">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                        <td>
                            <span class="badge {{ $order->statusBadgeClass() }}">{{ ucfirst($order->status) }}</span>
                        </td>
                        <td class="text-muted">{{ $order->created_at->diffForHumans() }}</td>
                    </tr>
                @empty
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const monthlyRevenue = @json($monthlyRevenue);
        const ordersPerCategory = @json($ordersPerCategory);

        const browns = ['#8B4513', '#A0522D', '#CD853F', '#D2691E', '#DEB887', '#F4A460'];

        const months = Object.keys(monthlyRevenue).sort();
        const revenueValues = months.map(m => monthlyRevenue[m]);
        const monthLabels = months.map(m => {
            const [y, mo] = m.split('-');
            return new Date(y, mo - 1).toLocaleDateString('id-ID', { month: 'short', year: '2-digit' });
        });

        new Chart(document.getElementById('revenueChart'), {
            type: 'line',
            data: {
                labels: monthLabels,
                datasets: [{
                    label: 'Pendapatan (Rp)',
                    data: revenueValues,
                    borderColor: '#8B4513',
                    backgroundColor: '#8B451333',
                    fill: true,
                    tension: 0.3,
                    pointBackgroundColor: '#8B4513',
                    pointRadius: 4,
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { callback: v => 'Rp ' + v.toLocaleString('id-ID') },
                    },
                },
            },
        });

        const catLabels = Object.keys(ordersPerCategory);
        const catValues = catLabels.map(l => ordersPerCategory[l]);

        new Chart(document.getElementById('categoryChart'), {
            type: 'doughnut',
            data: {
                labels: catLabels,
                datasets: [{
                    data: catValues,
                    backgroundColor: browns.slice(0, catLabels.length),
                    borderColor: '#fff',
                    borderWidth: 2,
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom', labels: { padding: 16 } },
                },
            },
        });
    });
</script>
@endsection
