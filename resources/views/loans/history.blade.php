@extends('layouts.app')
@section('title', 'Riwayat Peminjaman')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="fw-bold mb-0">Riwayat Peminjaman</h5>
        <small class="text-muted">Semua buku yang sudah dikembalikan</small>
    </div>
</div>

<div class="card mb-4">
    <div class="card-body py-3">
        <form method="GET" class="row g-2">
            <div class="col-md-8">
                <input type="text" name="search" class="form-control" placeholder="Cari kode atau nama anggota..."
                       value="{{ request('search') }}">
            </div>
            <div class="col-md-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary flex-fill"><i class="bi bi-search me-1"></i>Cari</button>
                <a href="{{ route('loans.history') }}" class="btn btn-outline-secondary"><i class="bi bi-x"></i></a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Kode</th><th>Anggota</th><th>Buku</th><th>Tgl Pinjam</th><th>Dikembalikan</th><th>Denda</th>
                </tr>
            </thead>
            <tbody>
                @forelse($loans as $loan)
                <tr>
                    <td><code class="small">{{ $loan->loan_code }}</code></td>
                    <td class="small">{{ $loan->member->name }}</td>
                    <td class="small">{{ $loan->book->title }}</td>
                    <td class="small">{{ $loan->loan_date->format('d/m/Y') }}</td>
                    <td class="small">{{ $loan->return_date->format('d/m/Y') }}</td>
                    <td class="small">
                        @if($loan->fine_amount > 0)
                            <span class="{{ $loan->fine_paid ? 'text-success' : 'text-danger' }}">
                                Rp {{ number_format($loan->fine_amount, 0, ',', '.') }}
                                {{ $loan->fine_paid ? '(lunas)' : '(belum bayar)' }}
                            </span>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted py-5">Belum ada riwayat</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-4">{{ $loans->links() }}</div>
@endsection
