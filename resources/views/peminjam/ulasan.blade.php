@extends('layouts.peminjam')
@section('title', 'Ulasan Buku')

@section('content')

<div class="ulasan-hero mb-4">
    <div class="position-relative" style="z-index:1">
        <h4 style="font-family:'Playfair Display',serif;font-weight:800;color:#fff;margin:0 0 .3rem;font-size:1.6rem;text-shadow:0 2px 8px rgba(0,0,0,.4)">Ulasan Buku</h4>
        <p style="color:rgba(255,255,255,.8);font-size:.88rem;margin:0">Rating dan ulasan dari komunitas pembaca</p>
    </div>
</div>

{{-- Ulasan Saya --}}
@if($myRatings->count())
<div class="card mb-4">
    <div class="card-header d-flex align-items-center gap-2">
        <i class="bi bi-person-fill" style="color:var(--brown)"></i>
        Ulasan Saya
        <span class="badge ms-1 rounded-pill" style="background:var(--cream-dark);color:var(--brown);font-size:.7rem">{{ $myRatings->count() }}</span>
    </div>
    <div class="card-body">
        <div class="row g-3">
            @foreach($myRatings as $r)
            <div class="col-md-6">
                <div class="my-review-card">
                    <div class="d-flex align-items-start gap-3">
                        <div class="review-book-thumb" style="background:{{ ['linear-gradient(160deg,#8b5e3c,#c49a6c)','linear-gradient(160deg,#5c8a3c,#8bc34a)','linear-gradient(160deg,#c0392b,#e57373)','linear-gradient(160deg,#1565c0,#64b5f6)','linear-gradient(160deg,#6a1b9a,#ce93d8)','linear-gradient(160deg,#e65100,#ffb74d)','linear-gradient(160deg,#00695c,#4db6ac)','linear-gradient(160deg,#37474f,#90a4ae)'][($r->book_id-1)%8] }}">
                            <div style="position:absolute;left:0;top:0;bottom:0;width:5px;background:rgba(0,0,0,.2)"></div>
                            @if($r->book->coverUrl())
                                <img src="{{ $r->book->coverUrl() }}" style="position:absolute;inset:0;width:100%;height:100%;object-fit:contain;background:#fff;padding:2px">
                            @else
                                <i class="bi bi-book-fill text-white" style="font-size:.9rem;opacity:.8;position:relative;z-index:1"></i>
                            @endif
                        </div>
                        <div class="flex-grow-1 min-w-0">
                            <div class="fw-700 text-truncate" style="font-size:.85rem;color:var(--brown-dark)">{{ $r->book->title }}</div>
                            <div style="font-size:.73rem;color:var(--text-muted)">{{ $r->book->author }}</div>
                            <div class="d-flex gap-1 my-1">
                                @for($i=1;$i<=5;$i++)
                                <i class="bi bi-star{{ $i<=$r->rating?'-fill':'' }}" style="color:{{ $i<=$r->rating?'#d97706':'var(--cream-dark)' }};font-size:.8rem"></i>
                                @endfor
                                <span style="font-size:.72rem;color:var(--text-muted);margin-left:.25rem">{{ ['','Buruk','Kurang','Cukup','Bagus','Sangat Bagus'][$r->rating] }}</span>
                            </div>
                            @if($r->review)
                            <p style="font-size:.78rem;color:var(--text);margin:0;font-style:italic">"{{ $r->review }}"</p>
                            @endif
                            <div style="font-size:.68rem;color:var(--text-muted);margin-top:.3rem">{{ $r->created_at->diffForHumans() }}</div>
                        </div>
                        <div class="flex-shrink-0 d-flex flex-column gap-1">
                            <a href="{{ route('peminjam.book.detail', $r->book) }}"
                               class="btn btn-outline-primary btn-sm" style="font-size:.72rem">
                                <i class="bi bi-pencil me-1"></i>Edit
                            </a>
                            <form action="{{ route('peminjam.ratings.destroy') }}" method="POST"
                                  onsubmit="return confirm('Hapus ulasan ini?')">
                                @csrf @method('DELETE')
                                <input type="hidden" name="book_id" value="{{ $r->book_id }}">
                                <button type="submit" class="btn btn-outline-danger btn-sm w-100" style="font-size:.72rem">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif

{{-- Buku yang belum diulas --}}
@if($unratedBooks->count())
<div class="card mb-4">
    <div class="card-header d-flex align-items-center gap-2">
        <i class="bi bi-star" style="color:#d97706"></i>
        Belum Diulas
        <span class="badge ms-1 rounded-pill" style="background:#fef3c7;color:#92400e;font-size:.7rem">{{ $unratedBooks->count() }}</span>
        <span style="font-size:.75rem;color:var(--text-muted);margin-left:.25rem">— buku yang sudah kamu kembalikan</span>
    </div>
    <div class="card-body">
        <div class="row g-3">
            @foreach($unratedBooks as $book)
            <div class="col-md-6">
                <div class="my-review-card d-flex align-items-center gap-3">
                    <div class="review-book-thumb" style="background:{{ ['linear-gradient(160deg,#8b5e3c,#c49a6c)','linear-gradient(160deg,#5c8a3c,#8bc34a)','linear-gradient(160deg,#c0392b,#e57373)','linear-gradient(160deg,#1565c0,#64b5f6)','linear-gradient(160deg,#6a1b9a,#ce93d8)','linear-gradient(160deg,#e65100,#ffb74d)','linear-gradient(160deg,#00695c,#4db6ac)','linear-gradient(160deg,#37474f,#90a4ae)'][($book->id-1)%8] }}">
                        <div style="position:absolute;left:0;top:0;bottom:0;width:5px;background:rgba(0,0,0,.2)"></div>
                        @if($book->coverUrl())
                            <img src="{{ $book->coverUrl() }}" style="position:absolute;inset:0;width:100%;height:100%;object-fit:contain;background:#fff;padding:2px">
                        @else
                            <i class="bi bi-book-fill text-white" style="font-size:.9rem;opacity:.8;position:relative;z-index:1"></i>
                        @endif
                    </div>
                    <div class="flex-grow-1 min-w-0">
                        <div class="fw-700 text-truncate" style="font-size:.85rem;color:var(--brown-dark)">{{ $book->title }}</div>
                        <div style="font-size:.73rem;color:var(--text-muted)">{{ $book->author }}</div>
                        <div class="d-flex gap-1 mt-1">
                            @for($i=1;$i<=5;$i++)
                            <i class="bi bi-star" style="color:var(--cream-dark);font-size:.8rem"></i>
                            @endfor
                            <span style="font-size:.7rem;color:var(--text-muted);margin-left:.25rem">Belum diulas</span>
                        </div>
                    </div>
                    <a href="{{ route('peminjam.book.detail', $book) }}"
                       class="btn btn-primary btn-sm flex-shrink-0" style="font-size:.72rem">
                        <i class="bi bi-star-fill me-1"></i>Ulas
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif

{{-- Ulasan Komunitas --}}
<div class="card">
    <div class="card-header d-flex align-items-center gap-2">
        <i class="bi bi-people-fill" style="color:var(--brown)"></i>
        Ulasan Komunitas
    </div>
    <div class="card-body p-0">
        @forelse($communityRatings as $r)
        <div class="d-flex align-items-start gap-3 px-4 py-3 border-bottom" style="border-color:var(--cream-dark)!important">
            {{-- Avatar --}}
            <div style="width:36px;height:36px;border-radius:50%;background:linear-gradient(135deg,var(--brown),var(--brown-light));display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:.78rem;overflow:hidden;flex-shrink:0">
                @if($r->user->avatar)
                    <img src="{{ $r->user->avatarUrl() }}" style="width:100%;height:100%;object-fit:cover">
                @else
                    {{ strtoupper(substr($r->user->name,0,1)) }}
                @endif
            </div>
            <div class="flex-grow-1 min-w-0">
                <div class="d-flex align-items-center gap-2 flex-wrap mb-1">
                    <span class="fw-600" style="font-size:.84rem;color:var(--brown-dark)">{{ $r->user->name }}</span>
                    <span style="font-size:.72rem;color:var(--text-muted)">tentang</span>
                    <a href="{{ route('peminjam.book.detail', $r->book) }}"
                       style="font-size:.82rem;color:var(--brown);font-weight:600;text-decoration:none">
                        {{ $r->book->title }}
                    </a>
                </div>
                <div class="d-flex gap-1 mb-1">
                    @for($i=1;$i<=5;$i++)
                    <i class="bi bi-star{{ $i<=$r->rating?'-fill':'' }}" style="color:{{ $i<=$r->rating?'#d97706':'var(--cream-dark)' }};font-size:.75rem"></i>
                    @endfor
                    <span style="font-size:.7rem;color:var(--text-muted);margin-left:.2rem">{{ ['','Buruk','Kurang','Cukup','Bagus','Sangat Bagus'][$r->rating] }}</span>
                </div>
                @if($r->review)
                <p style="font-size:.82rem;color:var(--text);margin:0;line-height:1.6">"{{ $r->review }}"</p>
                @endif
            </div>
            <div style="font-size:.7rem;color:var(--text-muted);flex-shrink:0;white-space:nowrap">{{ $r->created_at->diffForHumans() }}</div>
        </div>
        @empty
        <div class="text-center py-5" style="color:var(--text-muted);font-size:.85rem">
            <div style="font-size:2.5rem;margin-bottom:.5rem">💬</div>
            Belum ada ulasan dari komunitas
        </div>
        @endforelse
    </div>
    @if($communityRatings->hasPages())
    <div class="card-body pt-2">{{ $communityRatings->links() }}</div>
    @endif
</div>

@push('styles')
<style>
.page-header-cream { background:linear-gradient(135deg,#fff9f2,var(--cream));border:1px solid var(--cream-dark);border-radius:14px;padding:1.5rem 2rem;display:flex;justify-content:space-between;align-items:center; }
.page-title { font-family:'Playfair Display',serif;font-weight:800;color:var(--brown-dark);margin:0 0 .25rem; }
.page-sub { color:var(--text-muted);font-size:.85rem;margin:0; }
.ulasan-hero {
    background: url('{{ asset("images/as.jpg") }}') center/cover no-repeat;
    border-radius: 16px; padding: 2.5rem 2rem;
    position: relative; overflow: hidden;
    min-height: 140px; display: flex; align-items: center;
}
.ulasan-hero::before {
    content: ''; position: absolute; inset: 0;
    background: linear-gradient(135deg, rgba(92,61,30,.8) 0%, rgba(139,94,60,.6) 60%, rgba(0,0,0,.3) 100%);
    border-radius: 16px;
}
.my-review-card { background:var(--cream);border:1px solid var(--cream-dark);border-radius:12px;padding:1rem; }
.review-book-thumb { width:42px;height:56px;border-radius:3px 6px 6px 3px;flex-shrink:0;position:relative;overflow:hidden;display:flex;align-items:center;justify-content:center; }
</style>
@endpush
@endsection
