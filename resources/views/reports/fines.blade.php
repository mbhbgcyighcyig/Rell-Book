@extends('layouts.app')
@section('title', 'Laporan Denda')

@push('styles')
<style>
/* ── Hero Banner ── */
.fines-hero {
    border-radius: 20px;
    overflow: hidden;
    position: relative;
    min-height: 180px;
    display: flex;
    align-items: flex-end;
    margin-bottom: 1.75rem;
}
.fines-hero .hero-bg {
    position: absolute; inset: 0;
    background: url('{{ asset("images/dgn.jpg") }}') center/cover no-repeat;
    filter: brightness(.38) saturate(.7);
}
.fines-hero .hero-overlay {
    position: absolute; inset: 0;
    background: linear-gradient(
        135deg,
        rgba(92,61,30,.95) 0%,
        rgba(139,94,60,.8) 45%,
        rgba(196,122,58,.65) 20%
    );
}
.fines-hero .hero-deco {
    position: absolute;
    border-radius: 50%;
    background: rgba(212,168,67,.08);
    border: 1px solid rgba(212,168,67,.12);
}
.fines-hero .hero-content {
    position: relative; z-index: 1;
    padding: 2rem 2.2rem;
    width: 100%;
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 1rem;
}

/* ── Stat Cards ── */
.fine-stat {
    border-radius: 16px;
    padding: 1.4rem 1.5rem;
    color: #fff;
    position: relative;
    overflow: hidden;
    border: none;
    transition: transform .22s, box-shadow .22s;
    cursor: default;
}
.fine-stat:hover {
    transform: translateY(-4px);
    box-shadow: 0 16px 40px rgba(0,0,0,.18) !important;
}
.fine-stat .bg-img {
    position: absolute; inset: 0;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    filter: brightness(.5) saturate(.75);
}
.fine-stat .bg-ov { position: absolute; inset: 0; }
.fine-stat .deco-ring {
    position: absolute; border-radius: 20%;
    border: 1px solid rgba(255,255,255,.07);
}
.fine-stat > .fc { position: relative; z-index: 1; }
.fine-stat .fi-icon {
    width: 46px; height: 46px;
    background: rgba(255,255,255,.14);
    border: 1px solid rgba(255,255,255,.18);
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.25rem;
    backdrop-filter: blur(4px);
    margin-bottom: .85rem;
}
.fine-stat .fi-val {
    font-size: 1.45rem; font-weight: 800; line-height: 1;
    font-family: 'Playfair Display', serif;
    letter-spacing: -.01em;
}
.fine-stat .fi-label {
    font-size: .68rem; opacity: .7;
    text-transform: uppercase; letter-spacing: .1em;
    margin-top: .3rem;
}
.fine-stat .fi-sub {
    font-size: .72rem; opacity: .55; margin-top: .15rem;
}

/* ── Filter Panel ── */
.filter-panel {
    background: #fffaf4;
    border: 1px solid #ede0cc;
    border-radius: 16px;
    overflow: hidden;
}
.filter-panel .fp-head {
    background: linear-gradient(90deg, rgba(196,122,58,.08), rgba(212,168,67,.05));
    border-bottom: 1px solid #ede0cc;
    padding: .75rem 1.4rem;
    display: flex; align-items: center; gap: .5rem;
    font-size: .78rem; font-weight: 700; color: #6b4c2a;
    letter-spacing: .04em; text-transform: uppercase;
}
.filter-panel .fp-body { padding: 1rem 1.4rem; }

/* ── Print button ── */
.btn-print {
    background: linear-gradient(135deg, #5c3d1e, #8b5e3c);
    color: #fff; border: none; border-radius: 10px;
    padding: .6rem 1.3rem; font-size: .84rem; font-weight: 600;
    cursor: pointer; display: inline-flex; align-items: center; gap: .5rem;
    transition: .2s; letter-spacing: .02em;
    box-shadow: 0 4px 14px rgba(92,61,30,.25);
}
.btn-print:hover {
    background: linear-gradient(135deg, #3d2510, #5c3d1e);
    color: #fff; transform: translateY(-2px);
    box-shadow: 0 8px 22px rgba(92,61,30,.35);
}

/* ── Table ── */
.fine-table th {
    font-size: .67rem; text-transform: uppercase; letter-spacing: .09em;
    color: #9c7c5c; font-weight: 700;
    border-bottom: 1px solid #f0e6d6;
    padding: .9rem 1rem; background: #fffaf4; white-space: nowrap;
}
.fine-table td {
    padding: .85rem 1rem; vertical-align: middle;
    border-color: #f5ede0; color: #2d1f0f;
}
.fine-table tbody tr { transition: background .12s; }
.fine-table tbody tr:hover { background: #fdf5ec; }
.fine-table tfoot td {
    background: linear-gradient(90deg, #fffaf4, #fdf5ec);
    border-top: 2px solid #ede0cc;
}

/* ── PRINT ── */
@media print {
    body * { visibility: hidden !important; }
    #printable-area, #printable-area * { visibility: visible !important; }
    #printable-area {
        position: fixed !important; inset: 0 !important;
        padding: 1.5rem 2rem !important; background: #fff !important;
    }
    .no-print { display: none !important; }
    .print-only { display: block !important; }
    .fine-table th { background: #f5efe6 !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
    .fine-table tbody tr:hover { background: transparent !important; }
    .fine-table tfoot td { background: #f5efe6 !important; -webkit-print-color-adjust: exact; }
    @page { margin: 1.5cm; size: A4 landscape; }
}
.print-only { display: none; }
</style>
@endpush

@section('content')

{{-- ── Hero Banner ── --}}
<div class="fines-hero no-print">
    <div class="hero-bg"></div>
    <div class="hero-overlay"></div>
    <div class="hero-deco" style="width:300px;height:300px;right:-80px;top:-80px"></div>
    <div class="hero-deco" style="width:180px;height:180px;left:-40px;bottom:-60px"></div>
    <div class="hero-deco" style="width:100px;height:100px;right:200px;bottom:20px"></div>
    <div class="hero-content">
        <div>
            <div style="font-size:.68rem;letter-spacing:.16em;text-transform:uppercase;
                        color:rgba(212,168,67,.7);margin-bottom:.5rem;font-weight:600">
                <i class="bi bi-cash-coin me-1"></i> Laporan Keuangan
            </div>
            <h3 style="font-family:'Playfair Display',serif;font-weight:800;color:#fff;
                       margin:0;font-size:1.8rem;text-shadow:0 2px 12px rgba(0,0,0,.3)">
                Rekap Denda Keterlambatan
            </h3>
            <div style="font-size:.82rem;color:rgba(255,255,255,.65);margin-top:.4rem">
                @if(request('month') && request('year'))
                    <i class="bi bi-calendar3 me-1"></i>
                    {{ ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'][request('month')-1] }}
                    {{ request('year') }}
                @elseif(request('year'))
                    <i class="bi bi-calendar3 me-1"></i>Tahun {{ request('year') }}
                @else
                    <i class="bi bi-calendar3 me-1"></i>Semua periode
                @endif
                &nbsp;&bull;&nbsp; {{ $summary['total_cases'] }} kasus ditemukan
            </div>
        </div>
        <button class="btn-print" onclick="window.print()">
            <i class="bi bi-printer-fill"></i> Cetak Laporan
        </button>
    </div>
</div>

{{-- ── Stat Cards ── --}}
<div class="row g-3 mb-4 no-print">
    {{-- Total --}}
    <div class="col-6 col-md-3">
        <div class="fine-stat" style="box-shadow:0 6px 24px rgba(92,61,30,.22)">
            <div class="bg-img" style="background-image:url('{{ asset('images/dgn.jpg') }}')"></div>
            <div class="bg-ov" style="background:linear-gradient(145deg,rgba(92,61,30,.65),rgba(139,94,60,.5))"></div>
            <div class="deco-ring" style="width:120px;height:120px;right:-30px;top:-30px"></div>
            <div class="deco-ring" style="width:60px;height:60px;left:-10px;bottom:-10px"></div>
            <div class="fc">
                <div class="fi-icon"><i class="bi bi-cash-stack"></i></div>
                <div class="fi-val">Rp {{ number_format($summary['total_amount'], 0, ',', '.') }}</div>
                <div class="fi-label">Total Denda</div>
                <div class="fi-sub">{{ $summary['total_cases'] }} kasus</div>
            </div>
        </div>
    </div>
    {{-- Belum Bayar --}}
    <div class="col-6 col-md-3">
        <div class="fine-stat" style="box-shadow:0 6px 24px rgba(153,27,27,.22)">
            <div class="bg-img" style="background-image:url('{{ asset('images/as.jpg') }}')"></div>
            <div class="bg-ov" style="background:linear-gradient(145deg,rgba(153,27,27,.65),rgba(220,38,38,.5))"></div>
            <div class="deco-ring" style="width:120px;height:120px;right:-30px;top:-30px"></div>
            <div class="deco-ring" style="width:60px;height:60px;left:-10px;bottom:-10px"></div>
            <div class="fc">
                <div class="fi-icon"><i class="bi bi-exclamation-circle-fill"></i></div>
                <div class="fi-val">Rp {{ number_format($summary['unpaid_amount'], 0, ',', '.') }}</div>
                <div class="fi-label">Belum Dibayar</div>
                <div class="fi-sub">{{ $summary['unpaid_cases'] }} kasus</div>
            </div>
        </div>
    </div>
    {{-- Lunas --}}
    <div class="col-6 col-md-3">
        <div class="fine-stat" style="box-shadow:0 6px 24px rgba(4,120,87,.22)">
            <div class="bg-img" style="background-image:url('{{ asset('images/photo-1507842217343-583bb7270b66.jfif') }}')"></div>
            <div class="bg-ov" style="background:linear-gradient(145deg,rgba(4,120,87,.65),rgba(16,185,129,.5))"></div>
            <div class="deco-ring" style="width:120px;height:120px;right:-30px;top:-30px"></div>
            <div class="deco-ring" style="width:60px;height:60px;left:-10px;bottom:-10px"></div>
            <div class="fc">
                <div class="fi-icon"><i class="bi bi-check-circle-fill"></i></div>
                <div class="fi-val">Rp {{ number_format($summary['paid_amount'], 0, ',', '.') }}</div>
                <div class="fi-label">Sudah Lunas</div>
                @php $paidPct = $summary['total_cases'] > 0 ? round(($summary['total_cases'] - $summary['unpaid_cases']) / $summary['total_cases'] * 100) : 0; @endphp
                <div class="fi-sub">{{ $paidPct }}% dari total kasus</div>
            </div>
        </div>
    </div>
    {{-- Kasus --}}
    <div class="col-6 col-md-3">
        <div class="fine-stat" style="box-shadow:0 6px 24px rgba(30,58,138,.22)">
            <div class="bg-img" style="background-image:url('{{ asset('images/lol.jpg') }}')"></div>
            <div class="bg-ov" style="background:linear-gradient(145deg,rgba(30,58,138,.65),rgba(59,130,246,.5))"></div>
            <div class="deco-ring" style="width:120px;height:120px;right:-30px;top:-30px"></div>
            <div class="deco-ring" style="width:60px;height:60px;left:-10px;bottom:-10px"></div>
            <div class="fc">
                <div class="fi-icon"><i class="bi bi-file-earmark-text-fill"></i></div>
                <div class="fi-val">{{ $summary['total_cases'] }}</div>
                <div class="fi-label">Jumlah Kasus</div>
                <div class="fi-sub">{{ $summary['unpaid_cases'] }} belum lunas</div>
            </div>
        </div>
    </div>
</div>

{{-- ── Filter Panel ── --}}
<div class="filter-panel mb-4 no-print">
    <div class="fp-head">
        <i class="bi bi-funnel-fill" style="color:#c47a3a"></i>
        Filter Laporan
    </div>
    <div class="fp-body">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-sm-6 col-md-3">
                <label class="form-label small fw-semibold" style="color:#6b4c2a;font-size:.75rem">Status Pembayaran</label>
                <select name="paid" class="form-select form-select-sm">
                    <option value="">Semua Denda</option>
                    <option value="0" {{ request('paid') === '0' ? 'selected' : '' }}>Belum Dibayar</option>
                    <option value="1" {{ request('paid') === '1' ? 'selected' : '' }}>Sudah Dibayar</option>
                </select>
            </div>
            <div class="col-sm-6 col-md-3">
                <label class="form-label small fw-semibold" style="color:#6b4c2a;font-size:.75rem">Bulan</label>
                <select name="month" class="form-select form-select-sm">
                    <option value="">Semua Bulan</option>
                    @foreach(['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'] as $i => $bln)
                    <option value="{{ $i+1 }}" {{ request('month') == ($i+1) ? 'selected' : '' }}>{{ $bln }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-sm-6 col-md-2">
                <label class="form-label small fw-semibold" style="color:#6b4c2a;font-size:.75rem">Tahun</label>
                <select name="year" class="form-select form-select-sm">
                    <option value="">Semua Tahun</option>
                    @for($y = now()->year; $y >= now()->year - 3; $y--)
                    <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
            </div>
            <div class="col-sm-6 col-md-2">
                <button type="submit" class="btn btn-primary btn-sm w-100">
                    <i class="bi bi-search me-1"></i>Terapkan
                </button>
            </div>
            @if(request()->hasAny(['paid','month','year']))
            <div class="col-sm-6 col-md-2">
                <a href="{{ route('reports.fines') }}" class="btn btn-sm w-100"
                   style="background:#f5efe6;border:1px solid #ede0cc;color:#8b5e3c">
                    <i class="bi bi-x-circle me-1"></i>Reset
                </a>
            </div>
            @endif
        </form>
    </div>
</div>

{{-- ── PRINTABLE AREA ── --}}
<div id="printable-area">

    {{-- Print header (hidden on screen) --}}
    <div class="print-only mb-4">
        <div style="text-align:center;border-bottom:2px solid #8b5e3c;padding-bottom:1rem;margin-bottom:1rem">
            <div style="font-size:1.4rem;font-weight:800;font-family:'Georgia',serif;color:#3d2b1a">
                REKAP DENDA PERPUSTAKAAN
            </div>
            @if(request('month') && request('year'))
            <div style="font-size:1rem;font-weight:600;color:#5c3d1e;margin-top:.25rem">
                Bulan {{ ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'][request('month')-1] }} {{ request('year') }}
            </div>
            @elseif(request('year'))
            <div style="font-size:1rem;font-weight:600;color:#5c3d1e;margin-top:.25rem">Tahun {{ request('year') }}</div>
            @endif
            <div style="font-size:.82rem;color:#777;margin-top:.3rem">{{ config('app.name') }}</div>
            <div style="font-size:.75rem;color:#999">Dicetak: {{ now()->translatedFormat('d F Y, H:i') }} WIB</div>
        </div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:.5rem 2rem;font-size:.82rem;margin-bottom:1rem">
            <div><strong>Total Denda:</strong> Rp {{ number_format($summary['total_amount'], 0, ',', '.') }}</div>
            <div><strong>Sudah Lunas:</strong> Rp {{ number_format($summary['paid_amount'], 0, ',', '.') }}</div>
            <div><strong>Belum Dibayar:</strong> Rp {{ number_format($summary['unpaid_amount'], 0, ',', '.') }}</div>
            <div><strong>Jumlah Kasus:</strong> {{ $summary['total_cases'] }} kasus ({{ $summary['unpaid_cases'] }} belum lunas)</div>
        </div>
    </div>

    {{-- Table --}}
    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <span style="display:flex;align-items:center;gap:.5rem">
                <i class="bi bi-table" style="color:#d4a843"></i>
                Data Denda
            </span>
            <span style="font-size:.72rem;background:#f5efe6;color:#8b5e3c;padding:.2rem .7rem;
                         border-radius:20px;border:1px solid #ede0cc;font-weight:600">
                {{ $summary['total_cases'] }} kasus &bull; {{ $summary['unpaid_cases'] }} belum lunas
            </span>
        </div>
        <div class="table-responsive">
            <table class="table fine-table mb-0">
                <thead>
                    <tr>
                        <th style="width:40px">#</th>
                        <th>Kode Pinjam</th>
                        <th>Anggota</th>
                        <th>Buku</th>
                        <th class="text-center">Hari Telat</th>
                        <th>Denda</th>
                        <th class="text-center">Status</th>
                        <th class="no-print">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($loans as $i => $loan)
                    <tr>
                        <td style="color:#b89a7a;font-size:.78rem">{{ $loans->firstItem() + $i }}</td>
                        <td>
                            <code style="background:#f5efe6;color:#8b5e3c;padding:.15rem .45rem;
                                         border-radius:5px;font-size:.78rem">
                                {{ $loan->loan_code }}
                            </code>
                        </td>
                        <td>
                            <div style="font-weight:600;font-size:.83rem">{{ $loan->member->name }}</div>
                            <div style="font-size:.72rem;color:#9c7c5c">{{ $loan->member->member_code ?? '' }}</div>
                        </td>
                        <td>
                            <div style="max-width:200px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;
                                        font-size:.83rem" title="{{ $loan->book->title }}">
                                {{ $loan->book->title }}
                            </div>
                        </td>
                        <td class="text-center">
                            <span style="background:#fef3c7;color:#92400e;padding:.2rem .6rem;
                                         border-radius:20px;font-size:.75rem;font-weight:700">
                                {{ $loan->fine_days }} hari
                            </span>
                        </td>
                        <td>
                            <span style="font-weight:700;color:#8b5e3c;font-size:.88rem">
                                Rp {{ number_format($loan->fine_amount, 0, ',', '.') }}
                            </span>
                        </td>
                        <td class="text-center">
                            @if($loan->fine_paid)
                                <span style="background:#d1fae5;color:#065f46;padding:.2rem .65rem;
                                             border-radius:20px;font-size:.72rem;font-weight:700">
                                    <i class="bi bi-check-circle-fill me-1"></i>Lunas
                                </span>
                            @else
                                <span style="background:#fee2e2;color:#991b1b;padding:.2rem .65rem;
                                             border-radius:20px;font-size:.72rem;font-weight:700">
                                    <i class="bi bi-clock-fill me-1"></i>Belum Bayar
                                </span>
                            @endif
                        </td>
                        <td class="no-print">
                            @if(!$loan->fine_paid)
                            @php $fineFormatted = number_format($loan->fine_amount, 0, ',', '.'); @endphp
                            <form action="{{ route('loans.pay-fine', $loan) }}" method="POST"
                                  onsubmit="return confirm('Konfirmasi pembayaran denda Rp {{ $fineFormatted }}?')">
                                @csrf @method('PATCH')
                                <button style="background:linear-gradient(135deg,#065f46,#10b981);color:#fff;
                                               border:none;border-radius:7px;padding:.3rem .75rem;
                                               font-size:.78rem;font-weight:600;cursor:pointer;
                                               display:flex;align-items:center;gap:.3rem;transition:.15s"
                                        onmouseover="this.style.opacity='.85'"
                                        onmouseout="this.style.opacity='1'">
                                    <i class="bi bi-cash"></i> Bayar
                                </button>
                            </form>
                            @else
                                <span style="color:#b89a7a;font-size:.8rem">—</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-5">
                            <i class="bi bi-inbox" style="font-size:2.5rem;color:#c49a6c;display:block;
                                                           margin-bottom:.6rem;opacity:.4"></i>
                            <div style="color:#9c7c5c;font-size:.88rem">Tidak ada data denda</div>
                            @if(request()->hasAny(['paid','month','year']))
                            <a href="{{ route('reports.fines') }}"
                               style="font-size:.8rem;color:#c47a3a;text-decoration:none;margin-top:.4rem;display:inline-block">
                                Reset filter
                            </a>
                            @endif
                        </td>
                    </tr>
                    @endforelse
                </tbody>
                @if($loans->count() > 0)
                <tfoot>
                    <tr>
                        <td colspan="5" style="text-align:right;font-size:.8rem;color:#6b4c2a;padding:.85rem 1rem">
                            Subtotal halaman ini:
                        </td>
                        <td style="font-weight:800;color:#8b5e3c;font-size:.9rem;padding:.85rem 1rem">
                            Rp {{ number_format($loans->sum('fine_amount'), 0, ',', '.') }}
                        </td>
                        <td colspan="2"></td>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
    </div>

</div>{{-- end printable-area --}}

<div class="mt-4 no-print">{{ $loans->links() }}</div>

@endsection
