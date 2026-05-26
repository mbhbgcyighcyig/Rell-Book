@extends('layouts.peminjam')
@section('title', 'Beranda')

@push('styles')
<style>
/* ── Hero ── */
.hero-wrap {
    border-radius: 22px;
    overflow: hidden;
    position: relative;
    min-height: 240px;
    display: flex;
    align-items: center;
    margin-bottom: 1.75rem;
}
.hero-wrap .hbg {
    position: absolute; inset: 0;
    background: url('{{ asset("images/bukus.jpg") }}') center/cover no-repeat;
    filter: brightness(.38) saturate(.75);
}
.hero-wrap .hov {
    position: absolute; inset: 0;
    background: linear-gradient(
        120deg,
        rgba(45,22,8,.96) 0%,
        rgba(92,61,30,.82) 45%,
        rgba(139,94,60,.55) 75%,
        rgba(196,154,108,.25) 100%
    );
}
.hero-wrap .hdeco {
    position: absolute; border-radius: 50%;
    border: 1px solid rgba(201,151,58,.12);
}
.hero-content { position: relative; z-index: 1; padding: 2.5rem 2.8rem; width: 100%; display: flex; align-items: center; justify-content: space-between; gap: 2rem; }
.hero-badge {
    display: inline-flex; align-items: center; gap: .4rem;
    background: rgba(201,151,58,.2); border: 1px solid rgba(201,151,58,.35);
    color: #f5d5a8; font-size: .68rem; font-weight: 700;
    padding: .28rem .85rem; border-radius: 20px; margin-bottom: .85rem;
    letter-spacing: .06em; text-transform: uppercase;
}
.hero-title {
    font-family: 'Playfair Display', serif;
    font-size: 2.2rem; font-weight: 800;
    color: #fff; margin: 0 0 .5rem;
    text-shadow: 0 2px 12px rgba(0,0,0,.35);
    line-height: 1.15;
}
.hero-sub { color: rgba(255,255,255,.7); font-size: .88rem; margin: 0 0 1.4rem; line-height: 1.6; }
.hero-btn-primary {
    display: inline-flex; align-items: center; gap: .5rem;
    background: #fff; color: var(--brown-dark);
    font-weight: 700; font-size: .84rem;
    padding: .6rem 1.4rem; border-radius: 22px;
    text-decoration: none; transition: .2s;
    box-shadow: 0 4px 14px rgba(0,0,0,.15);
}
.hero-btn-primary:hover { background: #f5d5a8; color: var(--brown-dark); transform: translateY(-1px); }
.hero-btn-ghost {
    display: inline-flex; align-items: center; gap: .5rem;
    background: rgba(255,255,255,.12); color: rgba(255,255,255,.9);
    font-weight: 500; font-size: .84rem;
    padding: .6rem 1.4rem; border-radius: 22px;
    text-decoration: none; transition: .2s;
    border: 1.5px solid rgba(255,255,255,.25);
}
.hero-btn-ghost:hover { background: rgba(255,255,255,.22); color: #fff; }
.hero-quote {
    text-align: right; flex-shrink: 0;
    max-width: 220px;
}
.hero-quote .qmark {
    font-family: 'Cormorant Garamond', 'Playfair Display', serif;
    font-size: 5rem; line-height: .8;
    color: rgba(201,151,58,.35); font-style: italic;
}
.hero-quote .qtext {
    font-family: 'Cormorant Garamond', 'Playfair Display', serif;
    font-style: italic; font-size: 1rem;
    color: rgba(255,255,255,.55); line-height: 1.65;
}

/* ── Stat Cards ── */
.stat-card-user {
    border-radius: 16px;
    padding: 1.3rem 1.4rem;
    position: relative; overflow: hidden;
    border: 1px solid rgba(196,154,108,.2);
    background: rgba(253,248,242,.9);
    backdrop-filter: blur(10px);
    transition: transform .2s, box-shadow .2s;
}
.stat-card-user:hover { transform: translateY(-3px); box-shadow: 0 10px 28px rgba(92,61,30,.12); }
.stat-card-user .sc-icon {
    width: 44px; height: 44px;
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.2rem; margin-bottom: .85rem;
}
.stat-card-user .sc-val {
    font-family: 'Playfair Display', serif;
    font-size: 1.8rem; font-weight: 800;
    color: var(--brown-dark); line-height: 1;
}
.stat-card-user .sc-label {
    font-size: .72rem; color: var(--text-muted);
    margin-top: .25rem; font-weight: 500;
    text-transform: uppercase; letter-spacing: .06em;
}
.stat-card-user .sc-deco {
    position: absolute; right: -15px; top: -15px;
    width: 80px; height: 80px; border-radius: 50%;
    opacity: .08;
}

/* ── Fine Alert ── */
.fine-alert {
    background: rgba(254,242,242,.95);
    border: 1px solid rgba(252,165,165,.4);
    border-left: 4px solid #ef4444;
    border-radius: 12px;
    padding: 1rem 1.25rem;
    display: flex; align-items: center; gap: .85rem;
    backdrop-filter: blur(8px);
    margin-bottom: 1.5rem;
}

/* ── Section header ── */
.sec-hd {
    display: flex; align-items: center; justify-content: space-between;
    margin-bottom: .85rem;
}
.sec-hd-title {
    font-size: .88rem; font-weight: 700; color: var(--brown-dark);
    display: flex; align-items: center; gap: .5rem;
}
.sec-hd-title::before {
    content: '';
    width: 3px; height: 16px;
    background: linear-gradient(180deg, var(--gold), var(--brown-light));
    border-radius: 2px;
}
.sec-hd-link {
    font-size: .78rem; color: var(--gold); text-decoration: none;
    font-weight: 600; display: flex; align-items: center; gap: .3rem;
    transition: .15s;
}
.sec-hd-link:hover { color: var(--brown); }

/* ── Active loan row ── */
.loan-item {
    display: flex; align-items: center; gap: .85rem;
    padding: .75rem 1.1rem;
    border-bottom: 1px solid rgba(196,154,108,.12);
    transition: background .15s;
}
.loan-item:last-child { border-bottom: none; }
.loan-item:hover { background: rgba(245,239,230,.5); }
.loan-thumb {
    width: 42px; height: 56px;
    border-radius: 3px 6px 6px 3px;
    flex-shrink: 0; position: relative; overflow: hidden;
    display: flex; align-items: center; justify-content: center;
    box-shadow: 2px 3px 8px rgba(92,61,30,.2);
}
.loan-thumb::before {
    content: ''; position: absolute;
    left: 0; top: 0; bottom: 0; width: 5px;
    background: rgba(0,0,0,.18); z-index: 2;
}

/* ── Book Slider ── */
.bslider-wrap { position: relative; display: flex; align-items: center; gap: .5rem; }
.bslider {
    display: flex; gap: .85rem;
    overflow-x: auto; scroll-behavior: smooth;
    padding: .25rem .1rem .6rem; scrollbar-width: none;
    flex: 1;
}
.bslider::-webkit-scrollbar { display: none; }
.bslider-btn {
    width: 34px; height: 34px; border-radius: 50%;
    background: rgba(253,248,242,.95);
    border: 1.5px solid rgba(196,154,108,.3);
    color: var(--brown); display: flex; align-items: center; justify-content: center;
    cursor: pointer; flex-shrink: 0; transition: .18s; font-size: .85rem;
    box-shadow: 0 2px 8px rgba(92,61,30,.1);
}
.bslider-btn:hover { background: var(--brown); color: #fff; border-color: var(--brown); }
.bslider-card {
    width: 130px; flex-shrink: 0;
    border-radius: 12px; overflow: hidden;
    background: rgba(253,248,242,.9);
    border: 1px solid rgba(196,154,108,.2);
    transition: .22s;
    box-shadow: 0 2px 10px rgba(92,61,30,.07);
}
.bslider-card:hover { transform: translateY(-5px); box-shadow: 0 10px 24px rgba(92,61,30,.16); }
.bslider-cover {
    height: 165px; position: relative; overflow: hidden;
    display: flex; align-items: center; justify-content: center;
}
.bslider-badge {
    position: absolute; bottom: 7px; left: 50%; transform: translateX(-50%);
    font-size: .58rem; font-weight: 700;
    padding: .18rem .55rem; border-radius: 20px; white-space: nowrap; z-index: 2;
}
.bslider-badge.avail   { background: rgba(209,250,229,.92); color: #065f46; }
.bslider-badge.unavail { background: rgba(254,226,226,.92); color: #991b1b; }
.bslider-info { padding: .55rem .65rem; }
.bslider-title  { font-size: .74rem; font-weight: 700; color: var(--brown-dark); line-height: 1.3; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; margin-bottom: .15rem; }
.bslider-author { font-size: .65rem; color: var(--text-muted); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
</style>
@endpush

@section('content')
@if(!$member)
<div class="fine-alert">
    <i class="bi bi-exclamation-triangle-fill text-danger fs-5"></i>
    <div>Data anggota tidak ditemukan. Hubungi petugas perpustakaan.</div>
</div>
@else

{{-- ── Hero ── --}}
<div class="hero-wrap mb-4">
    <div class="hbg"></div>
    <div class="hov"></div>
    <div class="hdeco" style="width:350px;height:350px;right:-80px;top:-80px"></div>
    <div class="hdeco" style="width:200px;height:200px;left:-50px;bottom:-60px"></div>
    <div class="hero-content">
        <div>
            <div class="hero-badge"><i class="bi bi-stars"></i> Selamat Datang</div>
            <h2 class="hero-title">Halo, {{ auth()->user()->name }}!</h2>
            <p class="hero-sub">Temukan buku favoritmu dan mulai<br>petualangan membaca hari ini.</p>
            <div class="d-flex gap-2 flex-wrap">
                <a href="{{ route('peminjam.books') }}" class="hero-btn-primary">
                    <i class="bi bi-search"></i> Cari Buku
                </a>
                <a href="{{ route('peminjam.loans') }}" class="hero-btn-ghost">
                    <i class="bi bi-bookmark"></i> Pinjaman Saya
                </a>
            </div>
        </div>
        <div class="hero-quote d-none d-md-block">
            <div class="qmark">"</div>
            <div class="qtext">Membaca adalah jendela dunia yang tak pernah tertutup</div>
        </div>
    </div>
</div>

{{-- ── Stat Cards ── --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="stat-card-user">
            <div class="sc-deco" style="background:var(--brown)"></div>
            <div class="sc-icon" style="background:rgba(139,94,60,.1);color:var(--brown)">
                <i class="bi bi-book-fill"></i>
            </div>
            <div class="sc-val">{{ $activeLoans }}</div>
            <div class="sc-label">Sedang Dipinjam</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card-user">
            <div class="sc-deco" style="background:#5c8a3c"></div>
            <div class="sc-icon" style="background:rgba(92,138,60,.1);color:#5c8a3c">
                <i class="bi bi-bookmark-check-fill"></i>
            </div>
            <div class="sc-val">{{ max(0, 3 - $activeLoans) }}</div>
            <div class="sc-label">Sisa Kuota</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card-user">
            <div class="sc-deco" style="background:{{ $unpaidFines > 0 ? '#c0392b' : '#5c8a3c' }}"></div>
            <div class="sc-icon" style="background:{{ $unpaidFines > 0 ? 'rgba(192,57,43,.1)' : 'rgba(92,138,60,.1)' }};color:{{ $unpaidFines > 0 ? '#c0392b' : '#5c8a3c' }}">
                <i class="bi bi-cash-coin"></i>
            </div>
            <div class="sc-val" style="font-size:1.1rem;color:{{ $unpaidFines > 0 ? '#c0392b' : '#5c8a3c' }}">
                {{ $unpaidFines > 0 ? 'Ada Denda' : 'Lunas' }}
            </div>
            <div class="sc-label">Status Denda</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card-user">
            <div class="sc-deco" style="background:var(--gold)"></div>
            <div class="sc-icon" style="background:rgba(201,151,58,.1);color:var(--gold)">
                <i class="bi bi-calendar-check"></i>
            </div>
            <div class="sc-val" style="font-size:1rem">
                {{ $member->membership_expiry ? $member->membership_expiry->format('d/m/Y') : '—' }}
            </div>
            <div class="sc-label">Masa Berlaku</div>
        </div>
    </div>
</div>

{{-- ── Fine Alert ── --}}
@if($unpaidFines > 0)
<div class="fine-alert">
    <i class="bi bi-exclamation-triangle-fill text-danger fs-5 flex-shrink-0"></i>
    <div>
        <div style="font-weight:700;font-size:.88rem;color:#991b1b">Ada denda yang belum dibayar</div>
        <div style="font-size:.8rem;color:#b91c1c">
            Total: <strong>Rp {{ number_format($unpaidFines,0,',','.') }}</strong> — Hubungi petugas untuk pembayaran.
        </div>
    </div>
</div>
@endif

{{-- ── Main Content ── --}}
<div class="row g-4">

    {{-- Pinjaman Aktif --}}
    <div class="col-lg-5">
        <div class="card h-100">
            <div class="card-header">
                <div class="sec-hd mb-0">
                    <div class="sec-hd-title">Pinjaman Aktif</div>
                    <a href="{{ route('peminjam.loans') }}" class="sec-hd-link">
                        Semua <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
            <div class="card-body p-0">
                @forelse($loans->whereIn('status',['borrowed','overdue']) as $loan)
                @php $grad = ['linear-gradient(160deg,#8b5e3c,#c49a6c)','linear-gradient(160deg,#5c8a3c,#8bc34a)','linear-gradient(160deg,#c0392b,#e57373)','linear-gradient(160deg,#1565c0,#64b5f6)','linear-gradient(160deg,#6a1b9a,#ce93d8)','linear-gradient(160deg,#e65100,#ffb74d)','linear-gradient(160deg,#00695c,#4db6ac)','linear-gradient(160deg,#37474f,#90a4ae)'][($loan->book_id-1)%8]; @endphp
                <div class="loan-item">
                    <div class="loan-thumb" style="background:{{ $grad }}">
                        @if($loan->book->coverUrl())
                            <img src="{{ $loan->book->coverUrl() }}"
                                 style="position:absolute;inset:0;width:100%;height:100%;object-fit:contain;background:#fff;padding:2px">
                        @else
                            <i class="bi bi-book-fill text-white" style="font-size:.9rem;opacity:.8;position:relative;z-index:1"></i>
                        @endif
                    </div>
                    <div class="flex-grow-1 min-w-0">
                        <div style="font-size:.84rem;font-weight:700;color:var(--brown-dark)" class="text-truncate">
                            {{ $loan->book->title }}
                        </div>
                        <div style="font-size:.74rem;color:var(--text-muted)">
                            <i class="bi bi-alarm me-1"></i>{{ $loan->due_date->format('d M Y') }}
                            @if($loan->status === 'overdue')
                            <span style="color:#dc2626;font-weight:600"> · Terlambat!</span>
                            @endif
                        </div>
                    </div>
                    <span class="badge rounded-pill badge-status-{{ $loan->status }}" style="font-size:.68rem;white-space:nowrap">
                        {{ $loan->status === 'overdue' ? 'Terlambat' : 'Dipinjam' }}
                    </span>
                </div>
                @empty
                <div class="text-center py-5">
                    <i class="bi bi-bookmark" style="font-size:2.5rem;color:rgba(196,154,108,.3);display:block;margin-bottom:.75rem"></i>
                    <div style="color:var(--text-muted);font-size:.85rem;margin-bottom:.75rem">Tidak ada pinjaman aktif</div>
                    <a href="{{ route('peminjam.books') }}" class="btn btn-primary btn-sm px-3">
                        <i class="bi bi-search me-1"></i>Cari Buku
                    </a>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Buku Tersedia --}}
    <div class="col-lg-7">
        <div class="card h-100">
            <div class="card-header">
                <div class="sec-hd mb-0">
                    <div class="sec-hd-title">Buku Tersedia</div>
                    <a href="{{ route('peminjam.books') }}" class="sec-hd-link">
                        Lihat Semua <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
            <div class="card-body p-3">
                <div class="bslider-wrap">
                    <button class="bslider-btn" onclick="slideBooks(-1)">
                        <i class="bi bi-chevron-left"></i>
                    </button>
                    <div class="bslider" id="bookSlider">
                        @foreach($availableBooks as $book)
                        <a href="{{ route('peminjam.book.detail', $book) }}" class="text-decoration-none flex-shrink-0">
                            <div class="bslider-card">
                                @php $grad = ['linear-gradient(160deg,#8b5e3c,#c49a6c)','linear-gradient(160deg,#5c8a3c,#8bc34a)','linear-gradient(160deg,#c0392b,#e57373)','linear-gradient(160deg,#1565c0,#64b5f6)','linear-gradient(160deg,#6a1b9a,#ce93d8)','linear-gradient(160deg,#e65100,#ffb74d)','linear-gradient(160deg,#00695c,#4db6ac)','linear-gradient(160deg,#37474f,#90a4ae)'][($book->id-1)%8]; @endphp
                                <div class="bslider-cover" style="background:{{ $grad }}">
                                    @if($book->coverUrl())
                                        <img src="{{ $book->coverUrl() }}"
                                             style="position:absolute;inset:0;width:100%;height:100%;object-fit:contain;background:#fff;padding:4px"
                                             alt="{{ $book->title }}">
                                    @else
                                        <div style="text-align:center;color:rgba(255,255,255,.85);padding:.5rem;position:relative;z-index:1">
                                            <i class="bi bi-book-fill" style="font-size:1.8rem;display:block;margin-bottom:.3rem"></i>
                                            <div style="font-size:.65rem;font-weight:600;line-height:1.3">{{ Str::limit($book->title,20) }}</div>
                                        </div>
                                    @endif
                                    <span class="bslider-badge {{ $book->stock > 0 ? 'avail' : 'unavail' }}">
                                        {{ $book->stock > 0 ? $book->stock.' tersedia' : 'Habis' }}
                                    </span>
                                </div>
                                <div class="bslider-info">
                                    <div class="bslider-title">{{ $book->title }}</div>
                                    <div class="bslider-author">{{ $book->author }}</div>
                                </div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                    <button class="bslider-btn" onclick="slideBooks(1)">
                        <i class="bi bi-chevron-right"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection

@push('scripts')
<script>
function slideBooks(dir) {
    const s = document.getElementById('bookSlider');
    if (s) s.scrollBy({ left: dir * 300, behavior: 'smooth' });
}
const slider = document.getElementById('bookSlider');
if (slider) {
    let isDown = false, startX, scrollLeft;
    slider.addEventListener('mousedown', e => { isDown = true; slider.style.cursor = 'grabbing'; startX = e.pageX - slider.offsetLeft; scrollLeft = slider.scrollLeft; });
    slider.addEventListener('mouseleave', () => { isDown = false; slider.style.cursor = 'grab'; });
    slider.addEventListener('mouseup', () => { isDown = false; slider.style.cursor = 'grab'; });
    slider.addEventListener('mousemove', e => { if (!isDown) return; e.preventDefault(); slider.scrollLeft = scrollLeft - (e.pageX - slider.offsetLeft - startX) * 1.5; });
    slider.style.cursor = 'grab';
}
</script>
@endpush
