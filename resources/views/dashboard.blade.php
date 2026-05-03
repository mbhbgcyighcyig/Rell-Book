@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')

{{-- Page Header --}}
<div class="page-header mb-4">
    <div class="d-flex justify-content-between align-items-center position-relative" style="z-index:1">
        <div>
            <h5 class="mb-1">Selamat datang, {{ auth()->user()->name }} 👋</h5>
            <small>{{ now()->translatedFormat('l, d F Y') }} &mdash; Ringkasan aktivitas perpustakaan hari ini</small>
        </div>
        @if(auth()->user()->isPetugas())
        <a href="{{ route('loans.create') }}" class="btn btn-light fw-600 d-none d-md-flex align-items-center gap-2"
           style="border-radius:10px;font-size:.85rem">
            <i class="bi bi-plus-circle-fill text-primary"></i> Pinjam Buku
        </a>
        @endif
    </div>
</div>

{{-- Stat Cards --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-xl-3">
        <div class="stat-card h-100" style="background:linear-gradient(135deg,#4f46e5,#6366f1)">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div class="stat-icon"><i class="bi bi-book"></i></div>
                <span class="badge bg-white bg-opacity-25 rounded-pill" style="font-size:.7rem">Koleksi</span>
            </div>
            <div class="fs-2 fw-700 lh-1 mb-1">{{ $stats['total_titles'] }}</div>
            <div style="font-size:.8rem;opacity:.8">Judul Buku</div>
            <div style="font-size:.75rem;opacity:.6">{{ $stats['total_books'] }} eksemplar total</div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="stat-card h-100" style="background:linear-gradient(135deg,#059669,#10b981)">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div class="stat-icon"><i class="bi bi-people"></i></div>
                <span class="badge bg-white bg-opacity-25 rounded-pill" style="font-size:.7rem">Anggota</span>
            </div>
            <div class="fs-2 fw-700 lh-1 mb-1">{{ $stats['total_members'] }}</div>
            <div style="font-size:.8rem;opacity:.8">Anggota Aktif</div>
            <div style="font-size:.75rem;opacity:.6">terdaftar di sistem</div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="stat-card h-100" style="background:linear-gradient(135deg,#d97706,#f59e0b)">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div class="stat-icon"><i class="bi bi-arrow-left-right"></i></div>
                <span class="badge bg-white bg-opacity-25 rounded-pill" style="font-size:.7rem">Aktif</span>
            </div>
            <div class="fs-2 fw-700 lh-1 mb-1">{{ $stats['active_loans'] }}</div>
            <div style="font-size:.8rem;opacity:.8">Sedang Dipinjam</div>
            <div style="font-size:.75rem;opacity:.6">{{ $stats['returned_today'] }} dikembalikan hari ini</div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="stat-card h-100" style="background:linear-gradient(135deg,#dc2626,#ef4444)">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div class="stat-icon"><i class="bi bi-exclamation-triangle"></i></div>
                <span class="badge bg-white bg-opacity-25 rounded-pill" style="font-size:.7rem">Perlu Aksi</span>
            </div>
            <div class="fs-2 fw-700 lh-1 mb-1">{{ $stats['overdue_loans'] }}</div>
            <div style="font-size:.8rem;opacity:.8">Terlambat</div>
            <div style="font-size:.75rem;opacity:.6">peminjaman melewati jatuh tempo</div>
        </div>
    </div>
</div>

<div class="row g-3">
    {{-- Recent Loans --}}
    <div class="col-lg-7">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-2">
                    <div style="width:8px;height:8px;background:#4f46e5;border-radius:50%"></div>
                    Peminjaman Terbaru
                </div>
                <a href="{{ route('loans.index') }}" class="btn btn-sm btn-outline-primary" style="font-size:.78rem">
                    Lihat Semua <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Anggota</th>
                            <th>Buku</th>
                            <th>Jatuh Tempo</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentLoans as $loan)
                        <tr>
                            <td>
                                <a href="{{ route('loans.show', $loan) }}" class="text-decoration-none">
                                    <code style="font-size:.78rem;color:#4f46e5">{{ $loan->loan_code }}</code>
                                </a>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-700 flex-shrink-0"
                                         style="width:28px;height:28px;font-size:.72rem;background:linear-gradient(135deg,#4f46e5,#818cf8)">
                                        {{ strtoupper(substr($loan->member->name, 0, 1)) }}
                                    </div>
                                    <span style="font-size:.83rem">{{ $loan->member->name }}</span>
                                </div>
                            </td>
                            <td class="text-truncate" style="max-width:130px;font-size:.83rem" title="{{ $loan->book->title }}">
                                {{ $loan->book->title }}
                            </td>
                            <td style="font-size:.83rem">{{ $loan->due_date->format('d/m/Y') }}</td>
                            <td>
                                <span class="badge badge-status-{{ $loan->status }} rounded-pill px-2" style="font-size:.72rem">
                                    {{ ucfirst($loan->status) }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="text-center text-muted py-4">Belum ada peminjaman</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Right Column --}}
    <div class="col-lg-5 d-flex flex-column gap-3">

        {{-- Overdue Alert --}}
        @if($overdueLoans->count())
        <div class="card border-0" style="border-left:4px solid #ef4444!important">
            <div class="card-header" style="color:#dc2626">
                <i class="bi bi-alarm me-2"></i>Terlambat Dikembalikan
                <span class="badge bg-danger ms-1">{{ $overdueLoans->count() }}</span>
            </div>
            <div class="card-body p-0">
                @foreach($overdueLoans as $loan)
                <div class="d-flex align-items-center gap-3 px-3 py-2 border-bottom">
                    <div class="flex-grow-1 min-w-0">
                        <div style="font-size:.83rem;font-weight:600" class="text-truncate">{{ $loan->member->name }}</div>
                        <div class="text-muted text-truncate" style="font-size:.75rem">{{ $loan->book->title }}</div>
                        <div style="font-size:.72rem;color:#ef4444">
                            <i class="bi bi-clock me-1"></i>{{ $loan->due_date->diffForHumans() }}
                        </div>
                    </div>
                    <a href="{{ route('loans.show', $loan) }}" class="btn btn-sm btn-danger" style="font-size:.75rem">
                        <i class="bi bi-arrow-return-left"></i>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Popular Books --}}
        <div class="card flex-grow-1">
            <div class="card-header d-flex align-items-center gap-2">
                <i class="bi bi-trophy-fill text-warning"></i> Buku Populer Bulan Ini
            </div>
            <div class="card-body p-0">
                @forelse($popularBooks as $i => $book)
                <div class="d-flex align-items-center gap-3 px-3 py-2 border-bottom">
                    <div class="fw-700 text-center flex-shrink-0"
                         style="width:24px;font-size:.85rem;color:{{ ['#f59e0b','#94a3b8','#cd7c2f'][$i] ?? '#cbd5e1' }}">
                        {{ $i + 1 }}
                    </div>
                    <div class="flex-grow-1 min-w-0">
                        <div style="font-size:.83rem;font-weight:600" class="text-truncate">{{ $book->title }}</div>
                        <div class="text-muted" style="font-size:.75rem">{{ $book->author }}</div>
                    </div>
                    <span class="badge rounded-pill px-2" style="background:#ede9fe;color:#6d28d9;font-size:.72rem">
                        {{ $book->loans_count }}x
                    </span>
                </div>
                @empty
                <div class="text-center text-muted py-4" style="font-size:.85rem">Belum ada data bulan ini</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
