@extends('layouts.app')
@section('title', 'Laporan Peminjaman')

@push('styles')
<style>
.loan-stat {
    border-radius: 16px;
    padding: 1.4rem 1.5rem;
    color: #fff;
    position: relative;
    overflow: hidden;
    border: none;
    transition: transform .22s, box-shadow .22s;
    cursor: default;
}
.loan-stat:hover { transform: translateY(-4px); box-shadow: 0 16px 40px rgba(0,0,0,.18) !important; }
.loan-stat .bg-img {
    position: absolute; inset: 0;
    background-size: cover; background-position: center; background-repeat: no-repeat;
    filter: brightness(.45) saturate(.75);
}
.loan-stat .bg-ov { position: absolute; inset: 0; }
.loan-stat .deco-ring {
    position: absolute; border-radius: 50%;
    border: 1px solid rgba(255,255,255,.07);
}
.loan-stat > .lsc { position: relative; z-index: 1; }
.loan-stat .ls-icon {
    width: 46px; height: 46px;
    background: rgba(255,255,255,.14);
    border: 1px solid rgba(255,255,255,.18);
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.25rem; backdrop-filter: blur(4px);
    margin-bottom: .85rem;
}
.loan-stat .ls-val {
    font-size: 1.6rem; font-weight: 800; line-height: 1;
    font-family: 'Playfair Display', serif;
}
.loan-stat .ls-label {
    font-size: .68rem; opacity: .72;
    text-transform: uppercase; letter-spacing: .1em;
    margin-top: .3rem;
}

.filter-panel {
    background: #fffaf4;
    border: 1px solid #ede0cc;
    border-radius: 16px; overflow: hidden;
    margin-bottom: 1.5rem;
}
.filter-panel .fp-head {
    background: linear-gradient(90deg, rgba(196,122,58,.08), rgba(212,168,67,.05));
    border-bottom: 1px solid #ede0cc;
    padding: .7rem 1.4rem;
    font-size: .72rem; font-weight: 700; color: #6b4c2a;
    letter-spacing: .06em; text-transform: uppercase;
    display: flex; align-items: center; gap: .5rem;
}
.filter-panel .fp-body { padding: 1rem 1.4rem; }
</style>
@endpush

@section('content')

{{-- Page Header --}}
<div class="page-header mb-4">
    <div style="position:relative;z-index:1">
        <div style="font-size:.7rem;letter-spacing:.12em;text-transform:uppercase;opacity:.65;margin-bottom:.3rem">
            <i class="bi bi-bar-chart-line me-1"></i>Laporan
        </div>
        <h5 style="font-family:'Playfair Display',serif;font-weight:800;margin:0;font-size:1.3rem">
            Laporan Peminjaman
        </h5>
        <div style="font-size:.8rem;opacity:.72;margin-top:.25rem">
            Periode: {{ $from->format('d M Y') }} — {{ $to->format('d M Y') }}
        </div>
    </div>
</div>

{{-- Filter --}}
<div class="filter-panel">
    <div class="fp-head">
        <i class="bi bi-calendar-range" style="color:var(--gold)"></i>
        Rentang Periode
    </div>
    <div class="fp-body">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-4">
                <label class="form-label small fw-semibold" style="color:#6b4c2a;font-size:.75rem">Dari Tanggal</label>
                <input type="date" name="from" class="form-control form-control-sm" value="{{ $from->format('Y-m-d') }}">
            </div>
            <div class="col-md-4">
                <label class="form-label small fw-semibold" style="color:#6b4c2a;font-size:.75rem">Sampai Tanggal</label>
                <input type="date" name="to" class="form-control form-control-sm" value="{{ $to->format('Y-m-d') }}">
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary btn-sm w-100">
                    <i class="bi bi-funnel-fill me-1"></i>Terapkan Filter
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Stat Cards --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="loan-stat" style="box-shadow:0 6px 24px rgba(67,56,202,.2)">
            <div class="bg-img" style="background-image:url('{{ asset('images/photo-1507842217343-583bb7270b66.jfif') }}')"></div>
            <div class="bg-ov" style="background:linear-gradient(145deg,rgba(67,56,202,.72),rgba(99,102,241,.55))"></div>
            <div class="deco-ring" style="width:120px;height:120px;right:-30px;top:-30px"></div>
            <div class="lsc">
                <div class="ls-icon"><i class="bi bi-arrow-left-right"></i></div>
                <div class="ls-val">{{ $summary['total'] }}</div>
                <div class="ls-label">Total Peminjaman</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="loan-stat" style="box-shadow:0 6px 24px rgba(4,120,87,.2)">
            <div class="bg-img" style="background-image:url('{{ asset('images/as.jpg') }}')"></div>
            <div class="bg-ov" style="background:linear-gradient(145deg,rgba(4,120,87,.72),rgba(16,185,129,.55))"></div>
            <div class="deco-ring" style="width:120px;height:120px;right:-30px;top:-30px"></div>
            <div class="lsc">
                <div class="ls-icon"><i class="bi bi-check-circle-fill"></i></div>
                <div class="ls-val">{{ $summary['returned'] }}</div>
                <div class="ls-label">Dikembalikan</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="loan-stat" style="box-shadow:0 6px 24px rgba(153,27,27,.2)">
            <div class="bg-img" style="background-image:url('{{ asset('images/dgn.jpg') }}')"></div>
            <div class="bg-ov" style="background:linear-gradient(145deg,rgba(153,27,27,.72),rgba(220,38,38,.55))"></div>
            <div class="deco-ring" style="width:120px;height:120px;right:-30px;top:-30px"></div>
            <div class="lsc">
                <div class="ls-icon"><i class="bi bi-exclamation-triangle-fill"></i></div>
                <div class="ls-val">{{ $summary['overdue'] }}</div>
                <div class="ls-label">Terlambat</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="loan-stat" style="box-shadow:0 6px 24px rgba(92,61,30,.2)">
            <div class="bg-img" style="background-image:url('{{ asset('images/lol.jpg') }}')"></div>
            <div class="bg-ov" style="background:linear-gradient(145deg,rgba(92,61,30,.72),rgba(139,94,60,.55))"></div>
            <div class="deco-ring" style="width:120px;height:120px;right:-30px;top:-30px"></div>
            <div class="lsc">
                <div class="ls-icon"><i class="bi bi-cash-coin"></i></div>
                <div class="ls-val" style="font-size:1.1rem">Rp {{ number_format($summary['fines'], 0, ',', '.') }}</div>
                <div class="ls-label">Total Denda</div>
            </div>
        </div>
    </div>
</div>

{{-- Table --}}
<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <span style="display:flex;align-items:center;gap:.5rem">
            <i class="bi bi-table" style="color:#d4a843"></i>
            Data Peminjaman
        </span>
        <span style="font-size:.72rem;background:#f5efe6;color:#8b5e3c;padding:.2rem .7rem;
                     border-radius:20px;border:1px solid #ede0cc;font-weight:600">
            Periode: {{ $from->format('d M Y') }} — {{ $to->format('d M Y') }}
        </span>
    </div>
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>Kode</th><th>Anggota</th><th>Buku</th>
                    <th>Tgl Pinjam</th><th>Jatuh Tempo</th><th>Status</th><th>Denda</th>
                </tr>
            </thead>
            <tbody>
                @forelse($loans as $loan)
                <tr>
                    <td>
                        <code style="background:#f5efe6;color:#8b5e3c;padding:.15rem .45rem;border-radius:5px;font-size:.78rem">
                            {{ $loan->loan_code }}
                        </code>
                    </td>
                    <td style="font-size:.83rem;font-weight:600">{{ $loan->member->name }}</td>
                    <td style="font-size:.83rem;max-width:180px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis"
                        title="{{ $loan->book->title }}">{{ $loan->book->title }}</td>
                    <td style="font-size:.82rem">{{ $loan->loan_date->format('d/m/Y') }}</td>
                    <td style="font-size:.82rem">{{ $loan->due_date->format('d/m/Y') }}</td>
                    <td>
                        <span class="badge badge-status-{{ $loan->status }} rounded-pill px-2" style="font-size:.7rem">
                            {{ ucfirst($loan->status) }}
                        </span>
                    </td>
                    <td style="font-size:.83rem;font-weight:600;color:#8b5e3c">
                        {{ $loan->fine_amount > 0 ? 'Rp '.number_format($loan->fine_amount,0,',','.') : '—' }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-5">
                        <i class="bi bi-inbox" style="font-size:2.5rem;color:#c49a6c;display:block;margin-bottom:.6rem;opacity:.4"></i>
                        <div style="color:#9c7c5c;font-size:.88rem">Tidak ada data pada periode ini</div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
