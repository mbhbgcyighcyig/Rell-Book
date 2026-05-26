@extends('layouts.peminjam')
@section('title', 'Pinjaman Saya')

@push('styles')
<style>
/* ── Hero ── */
.loans-hero {
    border-radius: 22px; overflow: hidden;
    position: relative; min-height: 170px;
    display: flex; align-items: center;
    margin-bottom: 1.75rem;
}
.loans-hero .lhbg {
    position: absolute; inset: 0;
    background: url('{{ asset("images/ss.jpg") }}') center/cover no-repeat;
    filter: brightness(.32) saturate(.7);
}
.loans-hero .lhov {
    position: absolute; inset: 0;
    background: linear-gradient(120deg, rgba(45,22,8,.96) 0%, rgba(92,61,30,.8) 55%, rgba(139,94,60,.45) 100%);
}
.loans-hero .lhdeco {
    position: absolute; border-radius: 50%;
    border: 1px solid rgba(201,151,58,.1);
}
.loans-hero .lh-content { position: relative; z-index: 1; padding: 2rem 2.5rem; width: 100%; }

/* ── Loan Card ── */
.loan-card {
    background: rgba(253,248,242,.9);
    border: 1px solid rgba(196,154,108,.2);
    border-radius: 16px;
    padding: 1.2rem 1.3rem;
    display: flex; gap: 1.1rem; align-items: flex-start;
    transition: transform .2s, box-shadow .2s;
    backdrop-filter: blur(8px);
}
.loan-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(92,61,30,.1);
    border-color: rgba(196,154,108,.35);
}
.loan-card.overdue {
    border-color: rgba(252,165,165,.4);
    background: rgba(255,250,250,.92);
    border-left: 3px solid #ef4444;
}
.loan-cover {
    width: 58px; height: 76px;
    border-radius: 3px 8px 8px 3px;
    flex-shrink: 0; position: relative; overflow: hidden;
    display: flex; align-items: center; justify-content: center;
    box-shadow: 3px 4px 12px rgba(0,0,0,.18);
}
.loan-cover::before {
    content: ''; position: absolute;
    left: 0; top: 0; bottom: 0; width: 6px;
    background: rgba(0,0,0,.18); z-index: 2;
}
.loan-body { flex: 1; min-width: 0; }
.loan-title { font-size: .9rem; font-weight: 700; color: var(--brown-dark); margin-bottom: .15rem; }
.loan-author { font-size: .76rem; color: var(--text-muted); margin-bottom: .6rem; }
.loan-meta {
    display: flex; flex-wrap: wrap; gap: .3rem .8rem;
    font-size: .74rem; color: var(--text-muted); margin-bottom: .6rem;
}
.loan-meta .meta-item { display: flex; align-items: center; gap: .3rem; }
.loan-fine {
    display: inline-flex; align-items: center; gap: .4rem;
    padding: .35rem .8rem; border-radius: 8px;
    font-size: .75rem; font-weight: 600; margin-bottom: .6rem;
}
.loan-fine.paid   { background: rgba(209,250,229,.8); color: #065f46; border: 1px solid rgba(134,239,172,.4); }
.loan-fine.unpaid { background: rgba(254,226,226,.8); color: #991b1b; border: 1px solid rgba(252,165,165,.4); }
.loan-actions { display: flex; gap: .5rem; flex-wrap: wrap; }
.loan-status-badge {
    font-size: .68rem; font-weight: 700;
    padding: .25rem .7rem; border-radius: 20px;
    white-space: nowrap; flex-shrink: 0;
}
</style>
@endpush

@section('content')

{{-- ── Hero ── --}}
<div class="loans-hero">
    <div class="lhbg"></div>
    <div class="lhov"></div>
    <div class="lhdeco" style="width:250px;height:250px;right:-50px;top:-50px"></div>
    <div class="lhdeco" style="width:130px;height:130px;left:-20px;bottom:-30px"></div>
    <div class="lh-content">
        <div style="font-size:.65rem;letter-spacing:.14em;text-transform:uppercase;color:rgba(201,151,58,.75);margin-bottom:.4rem;font-weight:700">
            <i class="bi bi-bookmark-fill me-1"></i>Riwayat
        </div>
        <h3 style="font-family:'Playfair Display',serif;font-weight:800;color:#fff;margin:0 0 .3rem;font-size:1.75rem;text-shadow:0 2px 10px rgba(0,0,0,.3)">
            Pinjaman Saya
        </h3>
        <p style="color:rgba(255,255,255,.65);font-size:.84rem;margin:0">
            Riwayat dan status semua buku yang kamu pinjam
        </p>
    </div>
</div>

@if($loans->isEmpty())
<div class="card">
    <div class="card-body text-center py-5">
        <i class="bi bi-bookmark" style="font-size:3.5rem;color:rgba(196,154,108,.3);display:block;margin-bottom:.85rem"></i>
        <div style="font-family:'Playfair Display',serif;font-weight:800;font-size:1.1rem;color:var(--brown-dark);margin-bottom:.4rem">
            Belum ada peminjaman
        </div>
        <div style="color:var(--text-muted);font-size:.875rem;margin-bottom:1.2rem">
            Yuk mulai pinjam buku dari katalog kami!
        </div>
        <a href="{{ route('peminjam.books') }}" class="btn btn-primary px-4">
            <i class="bi bi-book me-2"></i>Jelajahi Katalog
        </a>
    </div>
</div>
@else
<div class="d-flex flex-column gap-3">
    @foreach($loans as $loan)
    @php
        $grad = ['linear-gradient(160deg,#8b5e3c,#c49a6c)','linear-gradient(160deg,#5c8a3c,#8bc34a)','linear-gradient(160deg,#c0392b,#e57373)','linear-gradient(160deg,#1565c0,#64b5f6)','linear-gradient(160deg,#6a1b9a,#ce93d8)','linear-gradient(160deg,#e65100,#ffb74d)','linear-gradient(160deg,#00695c,#4db6ac)','linear-gradient(160deg,#37474f,#90a4ae)'][($loan->book_id-1)%8];
        $statusStyle = match($loan->status) {
            'pending_approval' => 'background:#fef3c7;color:#92400e',
            'rejected'         => 'background:#f1f5f9;color:#475569',
            'borrowed'         => 'background:#ede9fe;color:#6d28d9',
            'returned'         => 'background:#d1fae5;color:#065f46',
            'overdue'          => 'background:#fee2e2;color:#dc2626',
            default            => 'background:#f1f5f9;color:#475569',
        };
        $statusLabel = match($loan->status) {
            'pending_approval' => '⏳ Menunggu Konfirmasi',
            'rejected'         => '✗ Ditolak',
            'borrowed'         => '📖 Dipinjam',
            'returned'         => '✓ Dikembalikan',
            'overdue'          => '⚠ Terlambat',
            default            => ucfirst($loan->status),
        };
    @endphp
    <div class="loan-card {{ $loan->status=='overdue' ? 'overdue' : '' }}">
        {{-- Cover --}}
        <div class="loan-cover" style="background:{{ $grad }}">
            @if($loan->book->coverUrl())
                <img src="{{ $loan->book->coverUrl() }}"
                     style="position:absolute;inset:0;width:100%;height:100%;object-fit:contain;background:#fff;padding:3px">
            @else
                <i class="bi bi-book-fill text-white" style="font-size:1.1rem;opacity:.8;position:relative;z-index:1"></i>
            @endif
        </div>

        {{-- Info --}}
        <div class="loan-body">
            <div class="d-flex align-items-start justify-content-between gap-2 mb-1">
                <div>
                    <div class="loan-title">{{ $loan->book->title }}</div>
                    <div class="loan-author">{{ $loan->book->author }}</div>
                </div>
                <span class="loan-status-badge" style="{{ $statusStyle }}">{{ $statusLabel }}</span>
            </div>

            <div class="loan-meta">
                <span class="meta-item">
                    <code style="font-size:.7rem;color:var(--gold);background:rgba(201,151,58,.1);padding:.1rem .4rem;border-radius:4px">{{ $loan->loan_code }}</code>
                </span>
                <span class="meta-item">
                    <i class="bi bi-calendar3" style="color:var(--brown-light)"></i>
                    {{ $loan->loan_date->format('d M Y') }}
                </span>
                <span class="meta-item {{ $loan->status=='overdue' ? 'text-danger fw-600' : '' }}">
                    <i class="bi bi-alarm" style="color:{{ $loan->status=='overdue' ? '#dc2626' : 'var(--brown-light)' }}"></i>
                    Jatuh tempo: {{ $loan->due_date->format('d M Y') }}
                    @if($loan->status=='overdue')
                    <span style="background:#fee2e2;color:#dc2626;font-size:.62rem;font-weight:700;padding:.1rem .45rem;border-radius:10px;margin-left:.25rem">
                        {{ $loan->due_date->diffForHumans() }}
                    </span>
                    @endif
                </span>
                @if($loan->return_date)
                <span class="meta-item" style="color:#5c8a3c">
                    <i class="bi bi-check-circle-fill"></i>
                    Kembali: {{ $loan->return_date->format('d M Y') }}
                </span>
                @endif
            </div>

            @if($loan->fine_amount > 0)
            <div class="loan-fine {{ $loan->fine_paid ? 'paid' : 'unpaid' }}">
                <i class="bi bi-cash-coin"></i>
                Denda: <strong>Rp {{ number_format($loan->fine_amount,0,',','.') }}</strong>
                — {{ $loan->fine_paid ? '✓ Lunas' : '⚠ Belum dibayar, hubungi petugas' }}
            </div>
            @endif

            <div class="loan-actions">
                @if($loan->status === 'pending_approval')
                <form action="{{ route('peminjam.loans.cancel', $loan) }}" method="POST"
                      onsubmit="return confirm('Batalkan permintaan peminjaman ini?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-outline-danger" style="font-size:.75rem">
                        <i class="bi bi-x-circle me-1"></i>Batalkan
                    </button>
                </form>
                @elseif(in_array($loan->status, ['borrowed','overdue','returned']))
                <a href="{{ route('peminjam.loans.nota', $loan) }}" target="_blank"
                   class="btn btn-sm" style="font-size:.75rem;background:rgba(196,154,108,.15);border:1px solid rgba(196,154,108,.3);color:var(--brown)">
                    <i class="bi bi-printer me-1"></i>Cetak Nota
                </a>
                @endif
            </div>
        </div>
    </div>
    @endforeach
</div>
<div class="mt-4">{{ $loans->links() }}</div>
@endif

@endsection
