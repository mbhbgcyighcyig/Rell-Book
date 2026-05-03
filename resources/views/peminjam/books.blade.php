@extends('layouts.peminjam')
@section('title', 'Katalog Buku')

@section('content')

<div class="catalog-hero mb-4">
    <div class="position-relative" style="z-index:1">
        <h4 style="font-family:'Playfair Display',serif;font-weight:800;color:#fff;margin:0 0 .3rem;font-size:1.6rem;text-shadow:0 2px 8px rgba(0,0,0,.4)">Katalog Buku</h4>
        <p style="color:rgba(255,255,255,.8);font-size:.88rem;margin:0">{{ $books->total() }} buku tersedia di perpustakaan kami</p>
    </div>
</div>

{{-- Filter --}}
<div class="card mb-4">
    <div class="card-body py-3">
        <form method="GET" class="row g-2">
            <div class="col-md-5">
                <div class="input-group">
                    <span class="input-group-text" style="background:#fff9f2;border-color:var(--cream-dark);color:var(--text-muted)">
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
                <button type="submit" class="btn btn-primary flex-fill">Cari</button>
                <a href="{{ route('peminjam.books') }}" class="btn btn-outline-secondary"><i class="bi bi-x"></i></a>
            </div>
        </form>
    </div>
</div>

{{-- Grid --}}
<div class="row g-3">
    @forelse($books as $book)
    <div class="col-6 col-md-4 col-lg-3">
        <a href="{{ route('peminjam.book.detail', $book) }}" class="text-decoration-none">
            <div class="book-card">
                <div class="book-cover" style="background:{{ ['linear-gradient(160deg,#8b5e3c,#c49a6c)','linear-gradient(160deg,#5c8a3c,#8bc34a)','linear-gradient(160deg,#c0392b,#e57373)','linear-gradient(160deg,#1565c0,#64b5f6)','linear-gradient(160deg,#6a1b9a,#ce93d8)','linear-gradient(160deg,#e65100,#ffb74d)','linear-gradient(160deg,#00695c,#4db6ac)','linear-gradient(160deg,#37474f,#90a4ae)'][($book->id-1)%8] }}">
                    @if(!$book->coverUrl())<div class="book-spine"></div>@endif
                    @if($book->coverUrl())
                        <img src="{{ $book->coverUrl() }}" style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover" alt="{{ $book->title }}">
                    @else
                        <div class="book-cover-inner">
                            <i class="bi bi-book-fill"></i>
                            <div>{{ Str::limit($book->title, 18) }}</div>
                        </div>
                    @endif
                    <span class="book-avail-badge {{ $book->stock > 0 ? 'avail' : 'unavail' }}">
                        {{ $book->stock > 0 ? 'Tersedia' : 'Habis' }}
                    </span>
                </div>
                <div class="book-info">
                    <div class="book-title">{{ $book->title }}</div>
                    <div class="book-author">{{ $book->author }}</div>
                    <div class="d-flex align-items-center justify-content-between mt-2">
                        <span class="book-cat">{{ $book->category->name }}</span>
                        <span style="font-size:.7rem;color:{{ $book->stock > 0 ? '#5c8a3c' : '#c0392b' }};font-weight:600">
                            <i class="bi bi-layers me-1"></i>{{ $book->stock }}
                        </span>
                    </div>
                </div>
            </div>
        </a>
    </div>
    @empty
    <div class="col-12 text-center py-5">
        <div style="font-size:3rem;margin-bottom:.75rem">📭</div>
        <div class="fw-600" style="color:var(--text-muted)">Tidak ada buku ditemukan</div>
        <a href="{{ route('peminjam.books') }}" class="btn btn-primary btn-sm mt-2">Reset Pencarian</a>
    </div>
    @endforelse
</div>

<div class="mt-4">{{ $books->links() }}</div>

@push('styles')
<style>
.page-header-cream {
    background: linear-gradient(135deg, #fff9f2, var(--cream));
    border: 1px solid var(--cream-dark);
    border-radius: 14px; padding: 1.5rem 2rem;
    display: flex; justify-content: space-between; align-items: center;
}
.catalog-hero {
    background: url('{{ asset("images/lol.jpg") }}') center/cover no-repeat;
    border-radius: 16px;
    padding: 2.5rem 2rem;
    position: relative;
    overflow: hidden;
    min-height: 140px;
    display: flex;
    align-items: center;
}
.catalog-hero::before {
    content: '';
    position: absolute; inset: 0;
    background: linear-gradient(135deg, rgba(92,61,30,.78) 0%, rgba(139,94,60,.55) 60%, rgba(0,0,0,.3) 100%);
    border-radius: 16px;
}
.page-title {
    font-family: 'Playfair Display', serif;
    font-weight: 800; color: var(--brown-dark); margin: 0 0 .25rem;
}
.page-sub { color: var(--text-muted); font-size: .85rem; margin: 0; }

.book-card {
    border: 1px solid var(--cream-dark);
    border-radius: 12px; overflow: hidden;
    background: var(--cream-card); transition: .22s;
    box-shadow: 0 2px 8px rgba(139,94,60,.07);
}
.book-card:hover { transform: translateY(-5px); box-shadow: 0 10px 28px rgba(139,94,60,.18); }
.book-cover {
    height: 220px; position: relative; overflow: hidden;
    display: flex; align-items: center; justify-content: center;
}
.book-spine {
    position: absolute; left: 0; top: 0; bottom: 0;
    width: 10px; background: rgba(0,0,0,.18); z-index: 2;
}
.book-cover-inner {
    text-align: center; color: rgba(255,255,255,.9);
    padding: 0 1rem; z-index: 1; position: relative;
}
.book-cover-inner i { font-size: 2.8rem; display: block; margin-bottom: .5rem; }
.book-cover-inner div { font-size: .78rem; font-weight: 600; line-height: 1.4; }
.book-avail-badge {
    position: absolute; top: 8px; right: 8px; z-index: 3;
    font-size: .62rem; font-weight: 700;
    padding: .2rem .55rem; border-radius: 20px;
}
.book-avail-badge.avail { background: #d1fae5; color: #065f46; }
.book-avail-badge.unavail { background: #fee2e2; color: #991b1b; }
.book-info { padding: .85rem; }
.book-title { font-size: .85rem; font-weight: 700; color: var(--brown-dark); line-height: 1.3; margin-bottom: .25rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
.book-author { font-size: .75rem; color: var(--text-muted); margin-bottom: .4rem; }
.book-cat { font-size: .65rem; background: var(--cream-dark); color: var(--brown); padding: .15rem .5rem; border-radius: 20px; font-weight: 600; }
</style>
@endpush
@endsection
