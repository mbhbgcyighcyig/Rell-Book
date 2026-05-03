@extends('layouts.app')
@section('title', 'Laporan Peminjaman')

@section('content')
<div class="card mb-4">
    <div class="card-body py-3">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-4">
                <label class="form-label small fw-semibold">Dari Tanggal</label>
                <input type="date" name="from" class="form-control" value="{{ $from->format('Y-m-d') }}">
            </div>
            <div class="col-md-4">
                <label class="form-label small fw-semibold">Sampai Tanggal</label>
                <input type="date" name="to" class="form-control" value="{{ $to->format('Y-m-d') }}">
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-filter me-1"></i>Filter
                </button>
            </div>
        </form>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="card text-center p-3">
            <div class="fs-2 fw-bold text-primary">{{ $summary['total'] }}</div>
            <div class="small text-muted">Total Peminjaman</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card text-center p-3">
            <div class="fs-2 fw-bold text-success">{{ $summary['returned'] }}</div>
            <div class="small text-muted">Dikembalikan</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card text-center p-3">
            <div class="fs-2 fw-bold text-danger">{{ $summary['overdue'] }}</div>
            <div class="small text-muted">Terlambat</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card text-center p-3">
            <div class="fs-2 fw-bold text-warning">Rp {{ number_format($summary['fines'], 0, ',', '.') }}</div>
            <div class="small text-muted">Total Denda</div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header py-3">
        Periode: {{ $from->format('d M Y') }} - {{ $to->format('d M Y') }}
    </div>
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr><th>Kode</th><th>Anggota</th><th>Buku</th><th>Tgl Pinjam</th><th>Jatuh Tempo</th><th>Status</th><th>Denda</th></tr>
            </thead>
            <tbody>
                @forelse($loans as $loan)
                <tr>
                    <td><code class="small">{{ $loan->loan_code }}</code></td>
                    <td class="small">{{ $loan->member->name }}</td>
                    <td class="small">{{ $loan->book->title }}</td>
                    <td class="small">{{ $loan->loan_date->format('d/m/Y') }}</td>
                    <td class="small">{{ $loan->due_date->format('d/m/Y') }}</td>
                    <td>
                        <span class="badge badge-status-{{ $loan->status }} rounded-pill px-2">
                            {{ ucfirst($loan->status) }}
                        </span>
                    </td>
                    <td class="small">
                        {{ $loan->fine_amount > 0 ? 'Rp '.number_format($loan->fine_amount,0,',','.') : '-' }}
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center text-muted py-4">Tidak ada data pada periode ini</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
