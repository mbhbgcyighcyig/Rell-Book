@extends('layouts.app')
@section('title', 'Detail Peminjaman')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center py-3">
                <span><i class="bi bi-file-text me-2 text-primary"></i>Detail Peminjaman</span>
                <span class="badge badge-status-{{ $loan->status }} rounded-pill px-3 fs-6">
                    {{ ucfirst($loan->status) }}
                </span>
            </div>
            <div class="card-body">
                <div class="row g-3 mb-4">
                    <div class="col-6">
                        <div class="small text-muted">Kode Peminjaman</div>
                        <code class="fs-6">{{ $loan->loan_code }}</code>
                    </div>
                    <div class="col-6">
                        <div class="small text-muted">Petugas</div>
                        <div class="fw-semibold small">{{ $loan->user->name }}</div>
                    </div>
                </div>

                <div class="p-3 bg-light rounded mb-3">
                    <div class="small text-muted mb-1">Anggota</div>
                    <div class="d-flex align-items-center gap-2">
                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center"
                             style="width:36px;height:36px;font-size:.9rem;flex-shrink:0">
                            {{ strtoupper(substr($loan->member->name, 0, 1)) }}
                        </div>
                        <div>
                            <div class="fw-semibold">{{ $loan->member->name }}</div>
                            <div class="small text-muted">{{ $loan->member->member_code }}</div>
                        </div>
                    </div>
                </div>

                <div class="p-3 bg-light rounded mb-4">
                    <div class="small text-muted mb-1">Buku</div>
                    <div class="fw-semibold">{{ $loan->book->title }}</div>
                    <div class="small text-muted">{{ $loan->book->author }}</div>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-4">
                        <div class="small text-muted">Tgl Pinjam</div>
                        <div class="fw-semibold">{{ $loan->loan_date->format('d M Y') }}</div>
                    </div>
                    <div class="col-4">
                        <div class="small text-muted">Jatuh Tempo</div>
                        <div class="fw-semibold {{ $loan->isOverdue() ? 'text-danger' : '' }}">
                            {{ $loan->due_date->format('d M Y') }}
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="small text-muted">Dikembalikan</div>
                        <div class="fw-semibold">{{ $loan->return_date ? $loan->return_date->format('d M Y') : '-' }}</div>
                    </div>
                </div>

                @if($loan->fine_amount > 0)
                <div class="alert {{ $loan->fine_paid ? 'alert-success' : 'alert-danger' }} d-flex justify-content-between align-items-center">
                    <div>
                        <strong>Denda: Rp {{ number_format($loan->fine_amount, 0, ',', '.') }}</strong>
                        <div class="small">{{ $loan->fine_days }} hari keterlambatan</div>
                    </div>
                    @if(!$loan->fine_paid)
                    <form action="{{ route('loans.pay-fine', $loan) }}" method="POST">
                        @csrf @method('PATCH')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Konfirmasi pembayaran denda?')">
                            <i class="bi bi-cash me-1"></i>Bayar Denda
                        </button>
                    </form>
                    @else
                        <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>Lunas</span>
                    @endif
                </div>
                @endif

                @if($loan->notes)
                <div class="mb-3">
                    <div class="small text-muted">Catatan</div>
                    <div class="small">{{ $loan->notes }}</div>
                </div>
                @endif

                <div class="d-flex gap-2 mt-4">
                    @if($loan->status !== 'returned')
                    <form action="{{ route('loans.return', $loan) }}" method="POST"
                          onsubmit="return confirm('Konfirmasi pengembalian buku ini?')">
                        @csrf @method('PATCH')
                        <button class="btn btn-success px-4">
                            <i class="bi bi-arrow-return-left me-1"></i>Kembalikan Buku
                        </button>
                    </form>
                    @endif
                    <a href="{{ route('loans.index') }}" class="btn btn-outline-secondary">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
