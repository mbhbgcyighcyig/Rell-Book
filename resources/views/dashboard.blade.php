@extends('layouts.app')
@section('title', 'Dashboard')

@push('styles')
<style>
/* ── Stat Cards Premium ── */
.prem-stat {
    border-radius: 16px;
    padding: 1.5rem;
    color: #fff;
    position: relative;
    overflow: hidden;
    border: none;
    min-height: 140px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    transition: transform .2s, box-shadow .2s;
}
.prem-stat:hover { transform: translateY(-3px); box-shadow: 0 12px 32px rgba(0,0,0,.18) !important; }

.prem-stat .bg-img {
    position: absolute;
    inset: 0;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    filter: brightness(.5) saturate(.8);
}
.prem-stat .bg-overlay {
    position: absolute;
    inset: 0;
}
.prem-stat .bg-circle {
    position: absolute;
    border-radius: 50%;
    background: rgba(255,255,255,.06);
}
.prem-stat > .content { position: relative; z-index: 1; }

.prem-stat .s-icon {
    width: 46px; height: 46px;
    background: rgba(255,255,255,.15);
    border: 1px solid rgba(255,255,255,.18);
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.3rem;
    backdrop-filter: blur(4px);
}
.prem-stat .s-val {
    font-size: 2.2rem;
    font-weight: 800;
    line-height: 1;
    font-family: 'Playfair Display', serif;
    letter-spacing: -.02em;
}
.prem-stat .s-label {
    font-size: .75rem;
    opacity: .8;
    font-weight: 500;
    letter-spacing: .03em;
}
.prem-stat .s-sub {
    font-size: .68rem;
    opacity: .55;
    margin-top: 2px;
}

/* ── Quick action bar ── */
.quick-bar {
    background: #fffaf4;
    border: 1px solid #ede0cc;
    border-radius: 14px;
    padding: 1rem 1.4rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    flex-wrap: wrap;
}
.quick-btn {
    display: inline-flex;
    align-items: center;
    gap: .5rem;
    padding: .5rem 1rem;
    border-radius: 9px;
    font-size: .82rem;
    font-weight: 600;
    text-decoration: none;
    transition: .18s;
    border: 1.5px solid transparent;
}
.quick-btn-primary {
    background: linear-gradient(135deg, #c47a3a, #d4a843);
    color: #fff;
    box-shadow: 0 3px 10px rgba(196,122,58,.3);
}
.quick-btn-primary:hover { color: #fff; transform: translateY(-1px); box-shadow: 0 6px 16px rgba(196,122,58,.4); }
.quick-btn-outline {
    background: transparent;
    border-color: #ede0cc;
    color: #8b5e3c;
}
.quick-btn-outline:hover { background: #f5efe6; border-color: #c49a6c; color: #5c3d1e; }

/* ── Section header ── */
.sec-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: .85rem;
}
.sec-title {
    font-size: .88rem;
    font-weight: 700;
    color: #3d2b1a;
    display: flex;
    align-items: center;
    gap: .5rem;
}
.sec-title::before {
    content: '';
    width: 3px; height: 16px;
    background: linear-gradient(180deg, #c47a3a, #d4a843);
    border-radius: 2px;
}

/* ── Loan row ── */
.loan-row-item {
    display: flex;
    align-items: center;
    gap: .85rem;
    padding: .7rem 1rem;
    border-bottom: 1px solid #f5ede0;
    transition: background .15s;
}
.loan-row-item:last-child { border-bottom: none; }
.loan-row-item:hover { background: #fdf5ec; }

.loan-avatar {
    width: 32px; height: 32px;
    border-radius: 50%;
    background: linear-gradient(135deg, #c47a3a, #d4a843);
    display: flex; align-items: center; justify-content: center;
    color: #fff; font-weight: 700; font-size: .75rem;
    flex-shrink: 0;
}

/* ── Overdue card ── */
.overdue-item {
    display: flex;
    align-items: center;
    gap: .75rem;
    padding: .65rem 1rem;
    border-bottom: 1px solid #fef2f2;
    transition: background .15s;
}
.overdue-item:last-child { border-bottom: none; }
.overdue-item:hover { background: #fff5f5; }

/* ── Popular book rank ── */
.rank-num {
    width: 26px; height: 26px;
    border-radius: 7px;
    display: flex; align-items: center; justify-content: center;
    font-size: .78rem; font-weight: 800;
    flex-shrink: 0;
}

/* ── Pending banner ── */
.pending-banner {
    background: linear-gradient(135deg, rgba(196,122,58,.12), rgba(212,168,67,.08));
    border: 1px solid rgba(196,122,58,.25);
    border-radius: 12px;
    padding: .85rem 1.2rem;
    display: flex;
    align-items: center;
    gap: .85rem;
}
</style>
@endpush

@section('content')

{{-- ── Page Header ── --}}
<div class="page-header mb-4">
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3" style="position:relative;z-index:1">
        <div>
            <div style="font-size:.72rem;letter-spacing:.12em;text-transform:uppercase;opacity:.65;margin-bottom:.3rem">
                <i class="bi bi-grid-1x2-fill me-1"></i>Dashboard
            </div>
            <h4 style="font-family:'Playfair Display',serif;font-weight:800;margin:0;font-size:1.5rem">
                Selamat datang, {{ auth()->user()->name }}
            </h4>
            <div style="font-size:.82rem;opacity:.7;margin-top:.3rem">
                <i class="bi bi-calendar3 me-1"></i>{{ now()->translatedFormat('l, d F Y') }}
                &nbsp;&bull;&nbsp; Ringkasan aktivitas perpustakaan
            </div>
        </div>
        @if(auth()->user()->isPetugas())
        <a href="{{ route('loans.create') }}"
           style="background:rgba(255,255,255,.18);backdrop-filter:blur(8px);border:1px solid rgba(255,255,255,.25);
                  color:#fff;border-radius:10px;padding:.55rem 1.1rem;text-decoration:none;
                  font-size:.84rem;font-weight:600;display:flex;align-items:center;gap:.5rem;transition:.18s"
           onmouseover="this.style.background='rgba(255,255,255,.28)'"
           onmouseout="this.style.background='rgba(255,255,255,.18)'">
            <i class="bi bi-plus-circle-fill"></i> Pinjam Buku
        </a>
        @endif
    </div>
</div>

{{-- ── Pending Banner ── --}}
@php $pendingCount = \App\Models\Loan::where('status','pending_approval')->count(); @endphp
@if($pendingCount > 0)
<div class="pending-banner mb-4">
    <div style="width:40px;height:40px;border-radius:10px;background:linear-gradient(135deg,#c47a3a,#d4a843);
                display:flex;align-items:center;justify-content:center;color:#fff;font-size:1.1rem;flex-shrink:0">
        <i class="bi bi-hourglass-split"></i>
    </div>
    <div class="flex-grow-1">
        <div style="font-weight:700;font-size:.88rem;color:#5c3d1e">
            {{ $pendingCount }} permintaan peminjaman menunggu konfirmasi
        </div>
        <div style="font-size:.75rem;color:#9c7c5c">Segera proses agar anggota dapat meminjam buku</div>
    </div>
    <a href="{{ route('loans.index') }}" class="quick-btn quick-btn-primary" style="white-space:nowrap">
        <i class="bi bi-arrow-right-circle-fill"></i> Proses Sekarang
    </a>
</div>
@endif

{{-- ── Stat Cards ── --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-xl-3">
        <div class="prem-stat" style="box-shadow:0 6px 24px rgba(79,70,229,.2)">
            <div class="bg-img" style="background-image:url('{{ asset('images/photo-1507842217343-583bb7270b66.jfif') }}')"></div>
            <div class="bg-overlay" style="background:linear-gradient(135deg,rgba(67,56,202,.62),rgba(99,102,241,.45))"></div>
            <div class="bg-circle" style="width:120px;height:120px;right:-30px;top:-30px"></div>
            <div class="bg-circle" style="width:70px;height:70px;left:-15px;bottom:-15px"></div>
            <div class="content d-flex justify-content-between align-items-start">
                <div class="s-icon"><i class="bi bi-book-fill"></i></div>
                <span style="font-size:.65rem;background:rgba(255,255,255,.15);padding:.2rem .6rem;border-radius:20px;letter-spacing:.06em">KOLEKSI</span>
            </div>
            <div class="content">
                <div class="s-val">{{ $stats['total_titles'] }}</div>
                <div class="s-label">Judul Buku</div>
                <div class="s-sub">{{ $stats['total_books'] }} eksemplar total</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="prem-stat" style="box-shadow:0 6px 24px rgba(5,150,105,.2)">
            <div class="bg-img" style="background-image:url('{{ asset('images/as.jpg') }}')"></div>
            <div class="bg-overlay" style="background:linear-gradient(135deg,rgba(4,120,87,.62),rgba(16,185,129,.45))"></div>
            <div class="bg-circle" style="width:120px;height:120px;right:-30px;top:-30px"></div>
            <div class="bg-circle" style="width:70px;height:70px;left:-15px;bottom:-15px"></div>
            <div class="content d-flex justify-content-between align-items-start">
                <div class="s-icon"><i class="bi bi-people-fill"></i></div>
                <span style="font-size:.65rem;background:rgba(255,255,255,.15);padding:.2rem .6rem;border-radius:20px;letter-spacing:.06em">ANGGOTA</span>
            </div>
            <div class="content">
                <div class="s-val">{{ $stats['total_members'] }}</div>
                <div class="s-label">Anggota Aktif</div>
                <div class="s-sub">terdaftar di sistem</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="prem-stat" style="box-shadow:0 6px 24px rgba(196,122,58,.25)">
            <div class="bg-img" style="background-image:url('{{ asset('images/dgn.jpg') }}')"></div>
            <div class="bg-overlay" style="background:linear-gradient(135deg,rgba(146,64,14,.62),rgba(217,119,6,.45))"></div>
            <div class="bg-circle" style="width:120px;height:120px;right:-30px;top:-30px"></div>
            <div class="bg-circle" style="width:70px;height:70px;left:-15px;bottom:-15px"></div>
            <div class="content d-flex justify-content-between align-items-start">
                <div class="s-icon"><i class="bi bi-arrow-left-right"></i></div>
                <span style="font-size:.65rem;background:rgba(255,255,255,.15);padding:.2rem .6rem;border-radius:20px;letter-spacing:.06em">AKTIF</span>
            </div>
            <div class="content">
                <div class="s-val">{{ $stats['active_loans'] }}</div>
                <div class="s-label">Sedang Dipinjam</div>
                <div class="s-sub">{{ $stats['returned_today'] }} dikembalikan hari ini</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="prem-stat" style="box-shadow:0 6px 24px rgba(220,38,38,.2)">
            <div class="bg-img" style="background-image:url('{{ asset('images/lol.jpg') }}')"></div>
            <div class="bg-overlay" style="background:linear-gradient(135deg,rgba(153,27,27,.62),rgba(239,68,68,.45))"></div>
            <div class="bg-circle" style="width:120px;height:120px;right:-30px;top:-30px"></div>
            <div class="bg-circle" style="width:70px;height:70px;left:-15px;bottom:-15px"></div>
            <div class="content d-flex justify-content-between align-items-start">
                <div class="s-icon"><i class="bi bi-exclamation-triangle-fill"></i></div>
                <span style="font-size:.65rem;background:rgba(255,255,255,.15);padding:.2rem .6rem;border-radius:20px;letter-spacing:.06em">PERLU AKSI</span>
            </div>
            <div class="content">
                <div class="s-val">{{ $stats['overdue_loans'] }}</div>
                <div class="s-label">Terlambat</div>
                <div class="s-sub">melewati jatuh tempo</div>
            </div>
        </div>
    </div>
</div>

{{-- ── Quick Actions ── --}}
<div class="quick-bar mb-4">
    <span style="font-size:.78rem;font-weight:700;color:#9c7c5c;letter-spacing:.04em;text-transform:uppercase">Aksi Cepat</span>
    <div class="d-flex gap-2 flex-wrap">
        @if(auth()->user()->isPetugas())
        <a href="{{ route('loans.create') }}" class="quick-btn quick-btn-primary">
            <i class="bi bi-plus-circle-fill"></i> Pinjam Buku
        </a>
        <a href="{{ route('returns.staff.index') }}" class="quick-btn quick-btn-outline">
            <i class="bi bi-arrow-return-left"></i> Pengembalian
        </a>
        @endif
        <a href="{{ route('books.create') }}" class="quick-btn quick-btn-outline">
            <i class="bi bi-book-fill"></i> Tambah Buku
        </a>
        <a href="{{ route('reports.fines') }}" class="quick-btn quick-btn-outline">
            <i class="bi bi-cash-coin"></i> Lap. Denda
        </a>
        <a href="{{ route('reports.popular-books') }}" class="quick-btn quick-btn-outline">
            <i class="bi bi-trophy-fill"></i> Buku Populer
        </a>
    </div>
</div>

{{-- ── Main Content ── --}}
<div class="row g-3">

    {{-- Recent Loans --}}
    <div class="col-lg-7">
        <div class="card h-100">
            <div class="card-header">
                <div class="sec-head mb-0">
                    <div class="sec-title">Peminjaman Terbaru</div>
                    <a href="{{ route('loans.index') }}"
                       style="font-size:.78rem;color:#c47a3a;text-decoration:none;font-weight:600;
                              display:flex;align-items:center;gap:.3rem">
                        Lihat Semua <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
            <div class="card-body p-0">
                @forelse($recentLoans as $loan)
                <div class="loan-row-item">
                    <div class="loan-avatar">{{ strtoupper(substr($loan->member->name, 0, 1)) }}</div>
                    <div class="flex-grow-1 min-w-0">
                        <div style="font-size:.83rem;font-weight:600;color:#2d1f0f" class="text-truncate">
                            {{ $loan->member->name }}
                        </div>
                        <div style="font-size:.75rem;color:#9c7c5c" class="text-truncate">
                            {{ $loan->book->title }}
                        </div>
                    </div>
                    <div class="text-end flex-shrink-0">
                        <span class="badge rounded-pill badge-status-{{ $loan->status }}" style="font-size:.68rem">
                            @php $statusLabel = ['pending_approval'=>'Pending','borrowed'=>'Dipinjam','returned'=>'Kembali','overdue'=>'Terlambat','rejected'=>'Ditolak']; @endphp
                            {{ $statusLabel[$loan->status] ?? $loan->status }}
                        </span>
                        <div style="font-size:.7rem;color:#b89a7a;margin-top:2px">
                            {{ $loan->due_date->format('d/m/Y') }}
                        </div>
                    </div>
                    <a href="{{ route('loans.show', $loan) }}"
                       style="width:28px;height:28px;border-radius:7px;background:#f5efe6;border:1px solid #ede0cc;
                              display:flex;align-items:center;justify-content:center;color:#8b5e3c;
                              text-decoration:none;flex-shrink:0;transition:.15s"
                       onmouseover="this.style.background='#ede0cc'"
                       onmouseout="this.style.background='#f5efe6'">
                        <i class="bi bi-arrow-right" style="font-size:.75rem"></i>
                    </a>
                </div>
                @empty
                <div class="text-center py-5" style="color:#b89a7a">
                    <i class="bi bi-inbox" style="font-size:2rem;display:block;margin-bottom:.5rem;opacity:.4"></i>
                    <div style="font-size:.85rem">Belum ada peminjaman</div>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Right Column --}}
    <div class="col-lg-5 d-flex flex-column gap-3">

        {{-- Overdue --}}
        @if($overdueLoans->count())
        <div class="card" style="border-left:3px solid #ef4444">
            <div class="card-header" style="color:#dc2626">
                <div class="sec-head mb-0">
                    <div style="display:flex;align-items:center;gap:.5rem;font-size:.88rem;font-weight:700">
                        <i class="bi bi-alarm-fill"></i> Terlambat
                        <span class="badge rounded-pill" style="background:#fee2e2;color:#991b1b;font-size:.65rem">
                            {{ $overdueLoans->count() }}
                        </span>
                    </div>
                    <a href="{{ route('loans.index') }}?status=overdue"
                       style="font-size:.75rem;color:#ef4444;text-decoration:none;font-weight:600">
                        Semua <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
            <div class="card-body p-0">
                @foreach($overdueLoans as $loan)
                <div class="overdue-item">
                    <div style="width:8px;height:8px;border-radius:50%;background:#ef4444;flex-shrink:0;
                                box-shadow:0 0 0 3px rgba(239,68,68,.15)"></div>
                    <div class="flex-grow-1 min-w-0">
                        <div style="font-size:.82rem;font-weight:600;color:#2d1f0f" class="text-truncate">
                            {{ $loan->member->name }}
                        </div>
                        <div style="font-size:.72rem;color:#ef4444">
                            <i class="bi bi-clock me-1"></i>{{ $loan->due_date->diffForHumans() }}
                        </div>
                    </div>
                    <a href="{{ route('loans.show', $loan) }}"
                       style="font-size:.75rem;background:#fee2e2;color:#991b1b;border:none;border-radius:7px;
                              padding:.3rem .65rem;text-decoration:none;font-weight:600;white-space:nowrap">
                        <i class="bi bi-arrow-return-left me-1"></i>Proses
                    </a>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Popular Books --}}
        <div class="card flex-grow-1">
            <div class="card-header">
                <div class="sec-head mb-0">
                    <div class="sec-title">
                        <i class="bi bi-trophy-fill" style="color:#d4a843"></i> Populer Bulan Ini
                    </div>
                    <a href="{{ route('reports.popular-books') }}"
                       style="font-size:.75rem;color:#c47a3a;text-decoration:none;font-weight:600">
                        Semua <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
            <div class="card-body p-0">
                @forelse($popularBooks as $i => $book)
                @php
                    $rankColors = ['#d4a843','#94a3b8','#cd7c2f'];
                    $rankBg     = ['rgba(212,168,67,.12)','rgba(148,163,184,.1)','rgba(205,124,47,.1)'];
                @endphp
                <div style="display:flex;align-items:center;gap:.85rem;padding:.7rem 1rem;
                            border-bottom:1px solid #f5ede0;transition:background .15s"
                     onmouseover="this.style.background='#fdf5ec'"
                     onmouseout="this.style.background='transparent'">
                    <div class="rank-num"
                         style="background:{{ $rankBg[$i] ?? 'rgba(196,154,108,.08)' }};
                                color:{{ $rankColors[$i] ?? '#b89a7a' }}">
                        {{ $i + 1 }}
                    </div>
                    <div class="flex-grow-1 min-w-0">
                        <div style="font-size:.83rem;font-weight:600;color:#2d1f0f" class="text-truncate">
                            {{ $book->title }}
                        </div>
                        <div style="font-size:.72rem;color:#9c7c5c">{{ $book->author }}</div>
                    </div>
                    <span style="font-size:.72rem;background:#f5efe6;color:#8b5e3c;
                                 padding:.2rem .6rem;border-radius:20px;font-weight:700;
                                 border:1px solid #ede0cc;white-space:nowrap">
                        {{ $book->loans_count }}× dipinjam
                    </span>
                </div>
                @empty
                <div class="text-center py-4" style="color:#b89a7a;font-size:.85rem">
                    <i class="bi bi-bar-chart" style="font-size:1.5rem;display:block;margin-bottom:.4rem;opacity:.4"></i>
                    Belum ada data bulan ini
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

@endsection
