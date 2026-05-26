@extends('layouts.peminjam')
@section('title', 'Katalog Buku')

@push('styles')
<style>
/* ── Catalog Hero ── */
.cat-hero {
    border-radius: 22px; overflow: hidden;
    position: relative; min-height: 180px;
    display: flex; align-items: center;
    margin-bottom: 1.75rem;
}
.cat-hero .chbg {
    position: absolute; inset: 0;
    background: url('{{ asset("images/lol.jpg") }}') center/cover no-repeat;
    filter: brightness(.35) saturate(.7);
}
.cat-hero .chov {
    position: absolute; inset: 0;
    background: linear-gradient(120deg, rgba(45,22,8,.95) 0%, rgba(92,61,30,.78) 50%, rgba(139,94,60,.45) 100%);
}
.cat-hero .chdeco {
    position: absolute; border-radius: 50%;
    border: 1px solid rgba(201,151,58,.1);
}
.cat-hero .ch-content {
    position: relative; z-index: 1;
    padding: 2rem 2.5rem;
    display: flex; align-items: center; justify-content: space-between;
    width: 100%; flex-wrap: wrap; gap: 1rem;
}

/* ── Filter Panel ── */
.filter-panel {
    background: rgba(253,248,242,.92);
    border: 1px solid rgba(196,154,108,.22);
    border-radius: 16px;
    backdrop-filter: blur(12px);
    overflow: hidden;
    margin-bottom: 1.75rem;
}
.filter-panel .fp-head {
    padding: .7rem 1.4rem;
    background: rgba(245,239,230,.6);
    border-bottom: 1px solid rgba(196,154,108,.15);
    font-size: .72rem; font-weight: 700;
    color: var(--text-muted); letter-spacing: .08em;
    text-transform: uppercase;
    display: flex; align-items: center; gap: .5rem;
}
.filter-panel .fp-body { padding: .9rem 1.4rem; }

/* ── Book Grid ── */
.book-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(175px, 1fr)); gap: 1.25rem; }

/* ── Book Card ── */
.bk-card {
    border-radius: 14px; overflow: hidden;
    background: rgba(253,248,242,.9);
    border: 1px solid rgba(196,154,108,.2);
    backdrop-filter: blur(8px);
    transition: transform .22s, box-shadow .22s;
    box-shadow: 0 2px 10px rgba(92,61,30,.06);
    display: flex; flex-direction: column;
}
.bk-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 14px 32px rgba(92,61,30,.16);
    border-color: rgba(196,154,108,.4);
}
.bk-cover {
    height: 220px; position: relative; overflow: hidden;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
.bk-cover .bk-spine {
    position: absolute; left: 0; top: 0; bottom: 0;
    width: 10px; background: rgba(0,0,0,.18); z-index: 2;
}
.bk-cover .bk-inner {
    text-align: center; color: rgba(255,255,255,.9);
    padding: 0 1rem; z-index: 1; position: relative;
}
.bk-cover .bk-inner i { font-size: 2.8rem; display: block; margin-bottom: .5rem; }
.bk-cover .bk-inner div { font-size: .78rem; font-weight: 600; line-height: 1.4; }
.bk-badge {
    position: absolute; top: 9px; right: 9px; z-index: 3;
    font-size: .6rem; font-weight: 700;
    padding: .22rem .6rem; border-radius: 20px;
}
.bk-badge.avail { background: rgba(209,250,229,.95); color: #065f46; }
.bk-badge.unavail { background: rgba(254,226,226,.95); color: #991b1b; }
.bk-info { padding: .9rem; flex: 1; display: flex; flex-direction: column; }
.bk-title {
    font-size: .84rem; font-weight: 700; color: var(--brown-dark);
    line-height: 1.35; margin-bottom: .25rem;
    display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
}
.bk-author { font-size: .74rem; color: var(--text-muted); margin-bottom: .5rem; }
.bk-cat {
    font-size: .62rem; background: rgba(196,154,108,.15);
    color: var(--brown); padding: .18rem .55rem;
    border-radius: 20px; font-weight: 600;
    border: 1px solid rgba(196,154,108,.25);
    align-self: flex-start;
}
.bk-stock {
    font-size: .68rem; color: var(--text-muted);
    font-weight: 600; margin-top: auto; padding-top: .4rem;
}
</style>
@endpush

@section('content')

{{-- ── Hero ── --}}
<div class="cat-hero">
    <div class="chbg"></div>
    <div class="chov"></div>
    <div class="chdeco" style="width:280px;height:280px;right:-60px;top:-60px"></div>
    <div class="chdeco" style="width:150px;height:150px;left:-30px;bottom:-40px"></div>
    <div class="ch-content">
        <div>
            <div style="font-size:.65rem;letter-spacing:.14em;text-transform:uppercase;color:rgba(201,151,58,.75);margin-bottom:.4rem;font-weight:700">
                <i class="bi bi-book-fill me-1"></i>Perpustakaan Digital
            </div>
            <h3 style="font-family:'Playfair Display',serif;font-weight:800;color:#fff;margin:0 0 .35rem;font-size:1.8rem;text-shadow:0 2px 10px rgba(0,0,0,.3)">
                Katalog Buku
            </h3>
            <p style="color:rgba(255,255,255,.65);font-size:.84rem;margin:0">
                {{ $books->total() }} buku tersedia di perpustakaan kami
            </p>
        </div>
        <div class="d-none d-md-flex align-items-center gap-3">
            <div style="text-align:center;background:rgba(255,255,255,.1);border:1px solid rgba(255,255,255,.15);border-radius:12px;padding:.75rem 1.2rem">
                <div style="font-family:'Playfair Display',serif;font-size:1.6rem;font-weight:800;color:#f5d5a8;line-height:1">{{ $books->total() }}</div>
                <div style="font-size:.65rem;color:rgba(255,255,255,.55);text-transform:uppercase;letter-spacing:.08em">Koleksi</div>
            </div>
        </div>
    </div>
</div>

{{-- ── Filter ── --}}
<div class="filter-panel">
    <div class="fp-head">
        <i class="bi bi-funnel-fill" style="color:var(--gold)"></i>
        Filter & Pencarian
    </div>
    <div class="fp-body">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-5">
                <div class="input-group">
                    <span class="input-group-text"
                          style="background:rgba(245,239,230,.8);border-color:rgba(196,154,108,.3);color:var(--text-muted)">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" name="search" class="form-control"
                           placeholder="Cari judul, pengarang, ISBN..."
                           value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-3">
                <select name="category_id" class="form-select">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select name="availability" class="form-select">
                    <option value="">Semua</option>
                    <option value="available" {{ request('availability') == 'available' ? 'selected' : '' }}>Tersedia</option>
                </select>
            </div>
            <div class="col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-primary flex-fill">
                    <i class="bi bi-search me-1"></i>Cari
                </button>
                <a href="{{ route('peminjam.books') }}" class="btn"
                   style="background:rgba(245,239,230,.8);border:1px solid rgba(196,154,108,.3);color:var(--brown)">
                    <i class="bi bi-x"></i>
                </a>
            </div>
        </form>
    </div>
</div>

{{-- ── Book Grid ── --}}
<div class="book-grid">
    @forelse($books as $book)
    <a href="{{ route('peminjam.book.detail', $book) }}" class="text-decoration-none">
        <div class="bk-card">
            <div class="bk-cover" style="background:{{ ['linear-gradient(160deg,#8b5e3c,#c49a6c)','linear-gradient(160deg,#5c8a3c,#8bc34a)','linear-gradient(160deg,#c0392b,#e57373)','linear-gradient(160deg,#1565c0,#64b5f6)','linear-gradient(160deg,#6a1b9a,#ce93d8)','linear-gradient(160deg,#e65100,#ffb74d)','linear-gradient(160deg,#00695c,#4db6ac)','linear-gradient(160deg,#37474f,#90a4ae)'][($book->id-1)%8] }}">
                @if($book->coverUrl())
                    <img src="{{ $book->coverUrl() }}"
                         style="position:absolute;inset:0;width:100%;height:100%;object-fit:contain;background:#fff;padding:4px"
                         alt="{{ $book->title }}">
                @else
                    <div class="bk-spine"></div>
                    <div class="bk-inner">
                        <i class="bi bi-book-fill"></i>
                        <div>{{ Str::limit($book->title, 18) }}</div>
                    </div>
                @endif
                <span class="bk-badge {{ $book->stock > 0 ? 'avail' : 'unavail' }}">
                    {{ $book->stock > 0 ? 'Tersedia ('.$book->stock.')' : 'Habis' }}
                </span>
            </div>
            <div class="bk-info">
                <div class="bk-title">{{ $book->title }}</div>
                <div class="bk-author">{{ $book->author }}</div>
                <span class="bk-cat">{{ $book->category->name }}</span>
            </div>
        </div>
    </a>
    @empty
    <div style="grid-column:1/-1;text-align:center;padding:4rem 0">
        <i class="bi bi-book-x" style="font-size:3rem;color:rgba(196,154,108,.3);display:block;margin-bottom:.75rem"></i>
        <div style="color:var(--text-muted);font-size:.9rem;margin-bottom:.75rem">Tidak ada buku ditemukan</div>
        <a href="{{ route('peminjam.books') }}" class="btn btn-primary btn-sm px-3">Reset Pencarian</a>
    </div>
    @endforelse
</div>

<div class="mt-4">{{ $books->links() }}</div>

@endsection
