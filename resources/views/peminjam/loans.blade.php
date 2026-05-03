@extends('layouts.peminjam')
@section('title', 'Pinjaman Saya')

@section('content')

<div class="loans-hero mb-4">
    <div class="position-relative" style="z-index:1">
        <h4 style="font-family:'Playfair Display',serif;font-weight:800;color:#fff;margin:0 0 .3rem;font-size:1.6rem;text-shadow:0 2px 8px rgba(0,0,0,.4)">Pinjaman Saya</h4>
        <p style="color:rgba(255,255,255,.8);font-size:.88rem;margin:0">Riwayat dan status semua buku yang kamu pinjam</p>
    </div>
</div>

@if($loans->isEmpty())
<div class="card">
    <div class="card-body text-center py-5">
        <div style="font-size:3.5rem;margin-bottom:.75rem">📚</div>
        <div class="fw-700 mb-1" style="color:var(--brown-dark);font-family:'Playfair Display',serif">Belum ada peminjaman</div>
        <div style="color:var(--text-muted);font-size:.875rem" class="mb-3">Yuk mulai pinjam buku dari katalog kami!</div>
        <a href="{{ route('peminjam.books') }}" class="btn btn-primary px-4">
            <i class="bi bi-book me-2"></i>Jelajahi Katalog
        </a>
    </div>
</div>
@else
<div class="d-flex flex-column gap-3">
    @foreach($loans as $loan)
    <div class="loan-row {{ $loan->status=='overdue'?'overdue':'' }}">
        @php $grad = ['linear-gradient(160deg,#8b5e3c,#c49a6c)','linear-gradient(160deg,#5c8a3c,#8bc34a)','linear-gradient(160deg,#c0392b,#e57373)','linear-gradient(160deg,#1565c0,#64b5f6)','linear-gradient(160deg,#6a1b9a,#ce93d8)','linear-gradient(160deg,#e65100,#ffb74d)','linear-gradient(160deg,#00695c,#4db6ac)','linear-gradient(160deg,#37474f,#90a4ae)'][($loan->book_id-1)%8]; @endphp
        <div class="loan-cover" style="background:{{ $grad }}">
            @if($loan->book->coverUrl())
                <img src="{{ $loan->book->coverUrl() }}"
                     style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover">
            @else
                <i class="bi bi-book-fill text-white" style="font-size:1.2rem;opacity:.8;position:relative;z-index:1"></i>
            @endif
        </div>
        <div class="loan-info">
            <div class="d-flex align-items-start justify-content-between gap-2">
                <div>
                    <div class="loan-title">{{ $loan->book->title }}</div>
                    <div class="loan-author">{{ $loan->book->author }}</div>
                </div>
                <span class="badge rounded-pill px-2" style="font-size:.7rem;white-space:nowrap;
                    @if($loan->status==='pending_approval') background:#fef3c7;color:#92400e;
                    @elseif($loan->status==='rejected') background:#e5e7eb;color:#374151;
                    @elseif($loan->status==='borrowed') background:#ede9fe;color:#6d28d9;
                    @elseif($loan->status==='returned') background:#dcfce7;color:#15803d;
                    @elseif($loan->status==='overdue') background:#fee2e2;color:#dc2626;
                    @endif">
                    @if($loan->status==='pending_approval') ⏳ Menunggu Konfirmasi
                    @elseif($loan->status==='rejected') ✗ Ditolak
                    @else {{ ucfirst($loan->status) }}
                    @endif
                </span>
            </div>
            <div class="loan-meta">
                <span><code style="font-size:.72rem;color:var(--brown)">{{ $loan->loan_code }}</code></span>
                <span><i class="bi bi-calendar3 me-1"></i>{{ $loan->loan_date->format('d M Y') }}</span>
                <span class="{{ $loan->status=='overdue'?'text-danger fw-600':'' }}">
                    <i class="bi bi-alarm me-1"></i>Jatuh tempo: {{ $loan->due_date->format('d M Y') }}
                    @if($loan->status=='overdue')
                    <span class="badge bg-danger ms-1" style="font-size:.62rem">{{ $loan->due_date->diffForHumans() }}</span>
                    @endif
                </span>
                @if($loan->return_date)
                <span style="color:#5c8a3c"><i class="bi bi-check-circle me-1"></i>Kembali: {{ $loan->return_date->format('d M Y') }}</span>
                @endif
            </div>
            @if($loan->fine_amount > 0)
            <div class="loan-fine {{ $loan->fine_paid?'paid':'unpaid' }}">
                <i class="bi bi-cash-coin me-1"></i>
                Denda: <strong>Rp {{ number_format($loan->fine_amount,0,',','.') }}</strong>
                — {{ $loan->fine_paid ? '✓ Lunas' : '⚠ Belum dibayar, hubungi petugas' }}
            </div>
            @endif
            {{-- Aksi --}}
            <div class="d-flex gap-2 mt-2">
                @if($loan->status === 'pending_approval')
                <form action="{{ route('peminjam.loans.cancel', $loan) }}" method="POST"
                      onsubmit="return confirm('Batalkan permintaan peminjaman ini?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-outline-danger" style="font-size:.75rem">
                        <i class="bi bi-x me-1"></i>Batalkan Permintaan
                    </button>
                </form>
                @elseif(in_array($loan->status, ['borrowed','overdue','returned']))
                <a href="{{ route('peminjam.loans.nota', $loan) }}" target="_blank"
                   class="btn btn-sm btn-outline-primary" style="font-size:.75rem">
                    <i class="bi bi-printer me-1"></i>Cetak Nota Pinjam
                </a>
                @endif
            </div>
        </div>
    </div>
    @endforeach
</div>
<div class="mt-4">{{ $loans->links() }}</div>
@endif

@push('styles')
<style>
.page-header-cream { background:linear-gradient(135deg,#fff9f2,var(--cream));border:1px solid var(--cream-dark);border-radius:14px;padding:1.5rem 2rem;display:flex;justify-content:space-between;align-items:center; }
.page-title { font-family:'Playfair Display',serif;font-weight:800;color:var(--brown-dark);margin:0 0 .25rem; }
.page-sub { color:var(--text-muted);font-size:.85rem;margin:0; }
.loans-hero {
    background: url('{{ asset("images/ss.jpg") }}') center/cover no-repeat;
    border-radius: 16px;
    padding: 2.5rem 2rem;
    position: relative;
    overflow: hidden;
    min-height: 140px;
    display: flex;
    align-items: center;
}
.loans-hero::before {
    content: '';
    position: absolute; inset: 0;
    background: linear-gradient(135deg, rgba(92,61,30,.8) 0%, rgba(139,94,60,.6) 60%, rgba(0,0,0,.3) 100%);
    border-radius: 16px;
}
.loan-row { background:var(--cream-card);border:1px solid var(--cream-dark);border-radius:14px;padding:1.1rem;display:flex;gap:1rem;align-items:flex-start;transition:.2s; }
.loan-row:hover { box-shadow:0 4px 16px rgba(139,94,60,.1); }
.loan-row.overdue { border-color:#fecaca;background:#fffafa; }
.loan-cover { width:54px;height:70px;border-radius:3px 8px 8px 3px;flex-shrink:0;display:flex;align-items:center;justify-content:center;position:relative;overflow:hidden;box-shadow:3px 3px 10px rgba(0,0,0,.15); }
.loan-info { flex:1;min-width:0; }
.loan-title { font-size:.88rem;font-weight:700;color:var(--brown-dark);margin-bottom:.15rem; }
.loan-author { font-size:.76rem;color:var(--text-muted);margin-bottom:.5rem; }
.loan-meta { display:flex;flex-wrap:wrap;gap:.35rem .75rem;font-size:.76rem;color:var(--text-muted); }
.loan-fine { margin-top:.6rem;padding:.4rem .75rem;border-radius:8px;font-size:.76rem;font-weight:500; }
.loan-fine.paid { background:#f0fdf4;color:#166534; }
.loan-fine.unpaid { background:#fef2f2;color:#991b1b; }
</style>
@endpush
@endsection
