@extends('layouts.app')
@section('title', 'Laporan Denda')

@section('content')
@if($totalUnpaid > 0)
<div class="alert alert-warning d-flex align-items-center gap-2 mb-4">
    <i class="bi bi-exclamation-triangle fs-5"></i>
    <div>Total denda belum dibayar: <strong>Rp {{ number_format($totalUnpaid, 0, ',', '.') }}</strong></div>
</div>
@endif

<div class="card mb-4">
    <div class="card-body py-3">
        <form method="GET" class="row g-2">
            <div class="col-md-4">
                <select name="paid" class="form-select">
                    <option value="">Semua Denda</option>
                    <option value="0" {{ request('paid') === '0' ? 'selected' : '' }}>Belum Dibayar</option>
                    <option value="1" {{ request('paid') === '1' ? 'selected' : '' }}>Sudah Dibayar</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100"><i class="bi bi-filter me-1"></i>Filter</button>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr><th>Kode</th><th>Anggota</th><th>Buku</th><th>Hari Telat</th><th>Denda</th><th>Status</th><th>Aksi</th></tr>
            </thead>
            <tbody>
                @forelse($loans as $loan)
                <tr>
                    <td><code class="small">{{ $loan->loan_code }}</code></td>
                    <td class="small">{{ $loan->member->name }}</td>
                    <td class="small">{{ $loan->book->title }}</td>
                    <td class="small text-center">{{ $loan->fine_days }} hari</td>
                    <td class="small fw-semibold">Rp {{ number_format($loan->fine_amount, 0, ',', '.') }}</td>
                    <td>
                        @if($loan->fine_paid)
                            <span class="badge bg-success rounded-pill">Lunas</span>
                        @else
                            <span class="badge bg-danger rounded-pill">Belum Bayar</span>
                        @endif
                    </td>
                    <td>
                        @if(!$loan->fine_paid)
                        <form action="{{ route('loans.pay-fine', $loan) }}" method="POST"
                              onsubmit="return confirm('Konfirmasi pembayaran denda?')">
                            @csrf @method('PATCH')
                            <button class="btn btn-sm btn-success">
                                <i class="bi bi-cash me-1"></i>Bayar
                            </button>
                        </form>
                        @else
                            <span class="text-muted small">-</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center text-muted py-4">Tidak ada data denda</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-4">{{ $loans->links() }}</div>
@endsection
