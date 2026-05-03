@extends('layouts.app')
@section('title', 'Peminjaman')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="fw-bold mb-0">Daftar Peminjaman</h5>
        <small class="text-muted">{{ $loans->total() }} data</small>
    </div>
    @if(auth()->user()->isPetugas())
    <a href="{{ route('loans.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i>Pinjam Buku
    </a>
    @endif
</div>

@if(isset($pendingCount) && $pendingCount > 0)
<div class="alert d-flex align-items-center gap-2 mb-4"
     style="background:#fef9ec;border:1px solid #f5d98b;color:#7c5a00">
    <i class="bi bi-bell-fill" style="color:#d97706"></i>
    Ada <strong>{{ $pendingCount }}</strong> permintaan peminjaman menunggu konfirmasi.
    <a href="?status=pending_approval" class="ms-2 fw-semibold" style="color:#7c5a00">Lihat →</a>
</div>
@endif

<div class="card mb-4">
    <div class="card-body py-3">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-6">
                <input type="text" name="search" class="form-control" placeholder="Cari kode, nama anggota, judul buku..."
                       value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <select name="status" class="form-select">
                    <option value="">Semua Status</option>
                    <option value="pending_approval" {{ request('status') == 'pending_approval' ? 'selected' : '' }}>Menunggu Konfirmasi</option>
                    <option value="borrowed" {{ request('status') == 'borrowed' ? 'selected' : '' }}>Dipinjam</option>
                    <option value="overdue" {{ request('status') == 'overdue' ? 'selected' : '' }}>Terlambat</option>
                    <option value="returned" {{ request('status') == 'returned' ? 'selected' : '' }}>Dikembalikan</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-primary flex-fill"><i class="bi bi-search me-1"></i>Cari</button>
                <a href="{{ route('loans.index') }}" class="btn btn-outline-secondary"><i class="bi bi-x"></i></a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Kode</th>
                    <th>Anggota</th>
                    <th>Buku</th>
                    <th>Tgl Pinjam</th>
                    <th>Jatuh Tempo</th>
                    <th>Status</th>
                    <th>Denda</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($loans as $loan)
                <tr class="{{ $loan->status == 'overdue' ? 'table-danger' : '' }}">
                    <td><code class="small">{{ $loan->loan_code }}</code></td>
                    <td class="small">{{ $loan->member->name }}</td>
                    <td class="small text-truncate" style="max-width:150px" title="{{ $loan->book->title }}">
                        {{ $loan->book->title }}
                    </td>
                    <td class="small">{{ $loan->loan_date->format('d/m/Y') }}</td>
                    <td class="small {{ $loan->status == 'overdue' ? 'text-danger fw-semibold' : '' }}">
                        {{ $loan->due_date->format('d/m/Y') }}
                        @if($loan->status == 'overdue')
                            <br><small>({{ $loan->due_date->diffForHumans() }})</small>
                        @endif
                    </td>
                    <td>
                        @if($loan->status === 'pending_approval')
                            <span class="badge rounded-pill px-2" style="background:#fef3c7;color:#92400e;font-size:.72rem">
                                Menunggu Konfirmasi
                            </span>
                        @elseif($loan->status === 'rejected')
                            <span class="badge rounded-pill px-2 bg-secondary" style="font-size:.72rem">Ditolak</span>
                        @else
                            <span class="badge badge-status-{{ $loan->status }} rounded-pill px-2">
                                {{ ucfirst($loan->status) }}
                            </span>
                        @endif
                    </td>
                    <td class="small">
                        @if($loan->fine_amount > 0)
                            <span class="{{ $loan->fine_paid ? 'text-success' : 'text-danger' }}">
                                Rp {{ number_format($loan->fine_amount, 0, ',', '.') }}
                            </span>
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        <div class="d-flex gap-1 flex-wrap">
                            <a href="{{ route('loans.show', $loan) }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-eye"></i>
                            </a>
                            @if($loan->status === 'pending_approval')
                                <form action="{{ route('loans.confirm', $loan) }}" method="POST"
                                      onsubmit="return confirm('Konfirmasi peminjaman ini?')">
                                    @csrf @method('PATCH')
                                    <button class="btn btn-sm btn-success" title="Konfirmasi">
                                        <i class="bi bi-check-lg"></i>
                                    </button>
                                </form>
                                <form action="{{ route('loans.reject', $loan) }}" method="POST"
                                      onsubmit="return confirm('Tolak peminjaman ini?')">
                                    @csrf @method('PATCH')
                                    <button class="btn btn-sm btn-outline-danger" title="Tolak">
                                        <i class="bi bi-x-lg"></i>
                                    </button>
                                </form>
                            @elseif(in_array($loan->status, ['borrowed','overdue']))
                                <form action="{{ route('loans.return', $loan) }}" method="POST"
                                      onsubmit="return confirm('Konfirmasi pengembalian buku ini?')">
                                    @csrf @method('PATCH')
                                    <button class="btn btn-sm btn-success" title="Kembalikan">
                                        <i class="bi bi-arrow-return-left"></i>
                                    </button>
                                </form>
                                <a href="{{ route('loans.nota', $loan) }}" target="_blank"
                                   class="btn btn-sm btn-outline-secondary" title="Nota Pinjam">
                                    <i class="bi bi-printer"></i>
                                </a>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center text-muted py-5">
                        <i class="bi bi-inbox fs-1 d-block mb-2"></i>Tidak ada data peminjaman
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-4">{{ $loans->links() }}</div>
@endsection
