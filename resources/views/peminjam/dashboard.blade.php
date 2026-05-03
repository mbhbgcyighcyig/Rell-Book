@extends('layouts.peminjam')
@section('title', 'Beranda')

@section('content')
@if(!$member)
    <div class="alert" style="background:#fef9ec;border:1px solid #f5d98b;color:#7c5a00">
        <i class="bi bi-exclamation-triangle me-2"></i>Data anggota tidak ditemukan. Hubungi petugas.
    </div>
@else

{{-- Hero --}}
<div class="hero-wrap mb-4">
    <div class="hero-left">
        <div class="hero-badge"><i class="bi bi-stars me-1"></i>Selamat Datang</div>
        <h2 class="hero-title">Halo, {{ auth()->user()->name }}!</h2>
        <p class="hero-sub">Temukan buku favoritmu dan mulai petualangan membaca hari ini.</p>
        <div class="d-flex gap-2 mt-3 flex-wrap">
            <a href="{{ route('peminjam.books') }}" class="btn px-4"
               style="background:#fff;color:var(--brown-dark);font-weight:600;border-radius:8px">
                <i class="bi bi-search me-2"></i>Cari Buku
            </a>
            <a href="{{ route('peminjam.loans') }}" class="btn px-4"
               style="background:rgba(255,255,255,.15);color:#fff;border:1.5px solid rgba(255,255,255,.4);font-weight:500;border-radius:8px">
                <i class="bi bi-bookmark me-2"></i>Pinjaman Saya
            </a>
        </div>
    </div>
    <div class="hero-right d-none d-md-flex">
        <div style="text-align:right;color:rgba(255,255,255,.6)">
            <div style="font-family:'Playfair Display',serif;font-size:3rem;line-height:1;opacity:.4">"</div>
            <div style="font-size:.82rem;font-style:italic;max-width:180px;line-height:1.6">
                Membaca adalah jendela dunia yang tak pernah tertutup
            </div>
        </div>
    </div>
</div>

{{-- Stats --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="stat-box" style="--c:var(--brown)">
            <div class="stat-icon"><i class="bi bi-book-fill"></i></div>
            <div class="stat-val">{{ $activeLoans }}</div>
            <div class="stat-label">Dipinjam</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-box" style="--c:#5c8a3c">
            <div class="stat-icon"><i class="bi bi-bookmark-check-fill"></i></div>
            <div class="stat-val">{{ 3 - $activeLoans }}</div>
            <div class="stat-label">Sisa Kuota</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-box" style="--c:{{ $unpaidFines > 0 ? '#c0392b' : '#5c8a3c' }}">
            <div class="stat-icon"><i class="bi bi-cash-coin"></i></div>
            <div class="stat-val" style="font-size:.9rem">{{ $unpaidFines > 0 ? 'Ada Denda' : 'Lunas' }}</div>
            <div class="stat-label">Status Denda</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-box" style="--c:#8b5e3c">
            <div class="stat-icon"><i class="bi bi-calendar-check"></i></div>
            <div class="stat-val" style="font-size:.82rem">
                {{ $member->membership_expiry ? $member->membership_expiry->format('d/m/Y') : '-' }}
            </div>
            <div class="stat-label">Masa Berlaku</div>
        </div>
    </div>
</div>

@if($unpaidFines > 0)
<div class="alert d-flex align-items-center gap-2 mb-4"
     style="background:#fef2f2;border:1px solid #fecaca;color:#991b1b">
    <i class="bi bi-exclamation-triangle-fill text-danger"></i>
    Kamu memiliki denda belum dibayar: <strong>Rp {{ number_format($unpaidFines,0,',','.') }}</strong>. Hubungi petugas.
</div>
@endif

<div class="row g-4">
    {{-- Pinjaman Aktif --}}
    <div class="col-lg-5">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-clock me-2" style="color:var(--brown)"></i>Pinjaman Aktif</span>
                <a href="{{ route('peminjam.loans') }}" class="btn btn-sm btn-outline-primary" style="font-size:.75rem">Semua</a>
            </div>
            <div class="card-body p-0">
                @forelse($loans->whereIn('status',['borrowed','overdue']) as $loan)
                <div class="d-flex align-items-center gap-3 px-3 py-3 border-bottom" style="border-color:var(--cream-dark)!important">
                    {{-- Cover buku asli --}}
                    @php $grad = ['linear-gradient(160deg,#8b5e3c,#c49a6c)','linear-gradient(160deg,#5c8a3c,#8bc34a)','linear-gradient(160deg,#c0392b,#e57373)','linear-gradient(160deg,#1565c0,#64b5f6)','linear-gradient(160deg,#6a1b9a,#ce93d8)','linear-gradient(160deg,#e65100,#ffb74d)','linear-gradient(160deg,#00695c,#4db6ac)','linear-gradient(160deg,#37474f,#90a4ae)'][($loan->book_id-1)%8]; @endphp
                    <div class="book-thumb" style="background:{{ $grad }}">
                        @if($loan->book->coverUrl())
                            <img src="{{ $loan->book->coverUrl() }}"
                                 style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;border-radius:3px 6px 6px 3px">
                        @else
                            <i class="bi bi-book-fill" style="color:#fff;font-size:1rem;opacity:.8;position:relative;z-index:1"></i>
                        @endif
                    </div>
                    <div class="flex-grow-1 min-w-0">
                        <div class="fw-600 text-truncate" style="font-size:.85rem;color:var(--brown-dark)">{{ $loan->book->title }}</div>
                        <div style="font-size:.75rem;color:var(--text-muted)">
                            <i class="bi bi-calendar3 me-1"></i>{{ $loan->due_date->format('d M Y') }}
                        </div>
                    </div>
                    <span class="badge badge-status-{{ $loan->status }} rounded-pill" style="font-size:.7rem">
                        {{ ucfirst($loan->status) }}
                    </span>
                </div>
                @empty
                <div class="text-center py-5">
                    <i class="bi bi-bookmark" style="font-size:2.5rem;color:var(--cream-dark);display:block;margin-bottom:.75rem"></i>
                    <div style="color:var(--text-muted);font-size:.85rem">Tidak ada pinjaman aktif</div>
                    <a href="{{ route('peminjam.books') }}" class="btn btn-primary btn-sm mt-2">Cari Buku</a>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Buku Tersedia --}}
    <div class="col-lg-7">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-book me-2" style="color:var(--brown)"></i>Buku Tersedia</span>
                <a href="{{ route('peminjam.books') }}" class="btn btn-sm btn-outline-primary" style="font-size:.75rem">
                    Lihat Semua <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>
            <div class="card-body p-3">
                {{-- Slider wrapper --}}
                <div class="book-slider-wrap">
                    <button class="slider-btn slider-prev" onclick="slideBooks(-1)">
                        <i class="bi bi-chevron-left"></i>
                    </button>
                    <div class="book-slider" id="bookSlider">
                        @foreach($availableBooks as $book)
                        <a href="{{ route('peminjam.book.detail', $book) }}" class="text-decoration-none flex-shrink-0">
                            <div class="slider-book-card">
                                @php $grad = ['linear-gradient(160deg,#8b5e3c,#c49a6c)','linear-gradient(160deg,#5c8a3c,#8bc34a)','linear-gradient(160deg,#c0392b,#e57373)','linear-gradient(160deg,#1565c0,#64b5f6)','linear-gradient(160deg,#6a1b9a,#ce93d8)','linear-gradient(160deg,#e65100,#ffb74d)','linear-gradient(160deg,#00695c,#4db6ac)','linear-gradient(160deg,#37474f,#90a4ae)'][($book->id-1)%8]; @endphp
                                <div class="slider-cover" style="background:{{ $grad }}">
                                    @if($book->coverUrl())
                                        <img src="{{ $book->coverUrl() }}"
                                             style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover"
                                             alt="{{ $book->title }}">
                                    @else
                                        <div style="text-align:center;color:rgba(255,255,255,.85);padding:.5rem;position:relative;z-index:1">
                                            <i class="bi bi-book-fill" style="font-size:1.8rem;display:block;margin-bottom:.3rem"></i>
                                            <div style="font-size:.65rem;font-weight:600;line-height:1.3">{{ Str::limit($book->title,20) }}</div>
                                        </div>
                                    @endif
                                    <span class="slider-badge {{ $book->stock > 0 ? 'avail' : 'unavail' }}">
                                        {{ $book->stock > 0 ? $book->stock.' tersedia' : 'Habis' }}
                                    </span>
                                </div>
                                <div class="slider-info">
                                    <div class="slider-title">{{ $book->title }}</div>
                                    <div class="slider-author">{{ $book->author }}</div>
                                </div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                    <button class="slider-btn slider-next" onclick="slideBooks(1)">
                        <i class="bi bi-chevron-right"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

@push('styles')
<style>

.hero-wrap {
    background: url('{{ asset("images/bukus.jpg") }}') center/cover no-repeat;
    border: none;
    border-radius: 18px;
    padding: 2.5rem 2.5rem;
    display: flex; justify-content: space-between; align-items: center;
    position: relative; overflow: hidden;
    min-height: 200px;
}
.hero-wrap::before {
    content: '';
    position: absolute; inset: 0;
    background: linear-gradient(135deg, rgba(92,61,30,.82) 0%, rgba(139,94,60,.65) 60%, rgba(92,61,30,.4) 100%);
    border-radius: 18px;
    z-index: 0;
}
.hero-wrap > * { position: relative; z-index: 1; }
.hero-badge {
    display: inline-flex; align-items: center;
    background: rgba(255,255,255,.18);
    border: 1px solid rgba(255,255,255,.3);
    color: #fff;
    font-size: .72rem; font-weight: 600;
    padding: .25rem .75rem; border-radius: 20px; margin-bottom: .75rem;
}
.hero-title {
    font-family: 'Playfair Display', serif;
    font-size: 2rem; font-weight: 800;
    color: #fff; margin: 0 0 .4rem;
    text-shadow: 0 2px 8px rgba(0,0,0,.3);
}
.hero-sub { color: rgba(255,255,255,.8); font-size: .9rem; margin: 0; }
.hero-right { align-items: center; justify-content: flex-end; flex-shrink: 0; }

.stat-box {
    background: var(--cream-card);
    border: 1px solid var(--cream-dark);
    border-radius: 14px; padding: 1.1rem;
    text-align: center;
    border-top: 3px solid var(--c);
}
.stat-icon {
    width: 38px; height: 38px;
    background: color-mix(in srgb, var(--c) 12%, white);
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1rem; color: var(--c);
    margin: 0 auto .6rem;
}
.stat-val { font-size: 1.3rem; font-weight: 800; color: var(--brown-dark); line-height: 1; }
.stat-label { font-size: .7rem; color: var(--text-muted); margin-top: .25rem; }

.book-thumb {
    width: 44px; height: 58px;
    border-radius: 3px 6px 6px 3px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
    box-shadow: 2px 2px 8px rgba(139,94,60,.25);
    position: relative;
    overflow: hidden;
}
.book-thumb::before {
    content: ''; position: absolute;
    left: 0; top: 0; bottom: 0; width: 5px;
    background: rgba(0,0,0,.15); border-radius: 3px 0 0 3px;
    z-index: 2;
}

.mini-book-card {
    border: 1px solid var(--cream-dark);
    border-radius: 10px; overflow: hidden;
    background: var(--cream-card); transition: .2s;
    box-shadow: 0 1px 4px rgba(139,94,60,.07);
}
.mini-book-card:hover { transform: translateY(-3px); box-shadow: 0 6px 16px rgba(139,94,60,.15); }
.mini-cover {
    height: 110px; display: flex; align-items: center; justify-content: center;
    position: relative; overflow: hidden;
}
.mini-spine {
    position: absolute; left: 0; top: 0; bottom: 0;
    width: 8px; background: rgba(0,0,0,.2); z-index: 2;
}
.mini-info { padding: .5rem .65rem; }

/* ── Book Slider ── */
.book-slider-wrap {
    position: relative;
    display: flex;
    align-items: center;
    gap: .5rem;
}
.book-slider {
    display: flex;
    gap: .75rem;
    overflow-x: auto;
    scroll-behavior: smooth;
    padding: .25rem .1rem .5rem;
    scrollbar-width: none;
    -ms-overflow-style: none;
    flex: 1;
}
.book-slider::-webkit-scrollbar { display: none; }
.slider-btn {
    width: 32px; height: 32px;
    border-radius: 50%;
    background: var(--cream-card);
    border: 1.5px solid var(--cream-dark);
    color: var(--brown);
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; flex-shrink: 0;
    transition: .18s; font-size: .85rem;
    box-shadow: 0 2px 6px rgba(139,94,60,.1);
}
.slider-btn:hover { background: var(--brown); color: #fff; border-color: var(--brown); }
.slider-book-card {
    width: 120px;
    flex-shrink: 0;
    border-radius: 10px;
    overflow: hidden;
    background: var(--cream-card);
    border: 1px solid var(--cream-dark);
    transition: .2s;
    box-shadow: 0 2px 8px rgba(139,94,60,.08);
}
.slider-book-card:hover { transform: translateY(-4px); box-shadow: 0 8px 20px rgba(139,94,60,.18); }
.slider-cover {
    height: 155px;
    position: relative; overflow: hidden;
    display: flex; align-items: center; justify-content: center;
}
.slider-badge {
    position: absolute; bottom: 6px; left: 50%; transform: translateX(-50%);
    font-size: .6rem; font-weight: 700;
    padding: .15rem .5rem; border-radius: 20px;
    white-space: nowrap; z-index: 2;
}
.slider-badge.avail   { background: rgba(209,250,229,.9); color: #065f46; }
.slider-badge.unavail { background: rgba(254,226,226,.9); color: #991b1b; }
.slider-info { padding: .5rem .6rem; }
.slider-title  { font-size: .73rem; font-weight: 700; color: var(--brown-dark); line-height: 1.3; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; margin-bottom: .15rem; }
.slider-author { font-size: .65rem; color: var(--text-muted); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
</style>
@endpush
@endsection

@push('scripts')
<script>
function slideBooks(dir) {
    const slider = document.getElementById('bookSlider');
    slider.scrollBy({ left: dir * 280, behavior: 'smooth' });
}
const slider = document.getElementById('bookSlider');
if (slider) {
    let isDown = false, startX, scrollLeft;
    slider.addEventListener('mousedown', e => {
        isDown = true; slider.style.cursor = 'grabbing';
        startX = e.pageX - slider.offsetLeft;
        scrollLeft = slider.scrollLeft;
    });
    slider.addEventListener('mouseleave', () => { isDown = false; slider.style.cursor = 'grab'; });
    slider.addEventListener('mouseup',    () => { isDown = false; slider.style.cursor = 'grab'; });
    slider.addEventListener('mousemove',  e => {
        if (!isDown) return;
        e.preventDefault();
        slider.scrollLeft = scrollLeft - (e.pageX - slider.offsetLeft - startX) * 1.5;
    });
    slider.style.cursor = 'grab';
}
</script>
@endpush
