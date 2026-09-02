@extends('layouts.admin', ['withDataTables' => true, 'title' => 'Order'])

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="font-heading text-primary-custom fw-bold mb-0">Manajemen Order</h2>
</div>

{{-- Filter status --}}
<div class="d-flex flex-wrap gap-2 mb-3">
    <a href="{{ route('order', ['q' => $currentSearch]) }}"
        class="btn btn-sm {{ ! $currentStatus ? 'text-white' : 'btn-outline-secondary' }}"
        style="{{ ! $currentStatus ? 'background-color: var(--primary-color);' : '' }}">
        Semua
    </a>
    @foreach ($statuses as $s)
        <a href="{{ route('order', ['status' => $s, 'q' => $currentSearch]) }}"
            class="btn btn-sm {{ $currentStatus === $s ? 'text-white' : 'btn-outline-secondary' }}"
            style="{{ $currentStatus === $s ? 'background-color: var(--primary-color);' : '' }}">
            {{ ucfirst($s) }}
        </a>
    @endforeach
</div>

<div class="bg-surface-lowest border border-outline-variant rounded-4 p-4 ambient-shadow">
    <div class="table-responsive">
        <table class="table table-hover align-middle js-datatable">
            <thead class="table-light">
                <tr>
                    <th class="font-heading">No. Order</th>
                    <th class="font-heading">Customer</th>
                    <th class="font-heading">Produk</th>
                    <th class="font-heading">Jumlah</th>
                    <th class="font-heading">Total</th>
                    <th class="font-heading">Status</th>
                    <th class="font-heading">Masuk</th>
                    <th class="font-heading text-center no-export">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($orders as $order)
                    <tr>
                        <td class="fw-semibold">
                            <a class="text-decoration-none" href="{{ route('order.show', $order->id) }}">{{ $order->order_number }}</a>
                        </td>
                        <td>
                            {{ $order->customer_name }}
                            <div class="small text-muted">{{ $order->customer_phone }}</div>
                        </td>
                        <td>{{ $order->product->name }}</td>
                        <td>{{ $order->quantity }}</td>
                        <td class="fw-semibold">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                        <td>
                            <span class="badge {{ $order->statusBadgeClass() }}">{{ ucfirst($order->status) }}</span>
                        </td>
                        <td class="text-muted">{{ $order->created_at->diffForHumans() }}</td>
                        <td class="text-center">
                            <a class="btn btn-sm btn-outline-primary" href="{{ route('order.show', $order->id) }}">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
