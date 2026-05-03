@extends('layouts.peminjam')
@section('title', $book->title)

@section('content')

<nav style="font-size:.8rem;color:var(--text-muted);margin-bottom:1.5rem">
    <a href="{{ route('peminjam.books') }}" style="color:var(--brown);text-decoration:none">Katalog</a>
    <span class="mx-2">/</span> {{ $book->title }}
</nav>

<div class="row g-4">
    {{-- Cover --}}
    <div class="col-md-3">
        <div class="detail-cover" style="background:{{ ['linear-gradient(160deg,#8b5e3c,#c49a6c)','linear-gradient(160deg,#5c8a3c,#8bc34a)','linear-gradient(160deg,#c0392b,#e57373)','linear-gradient(160deg,#1565c0,#64b5f6)','linear-gradient(160deg,#6a1b9a,#ce93d8)','linear-gradient(160deg,#e65100,#ffb74d)','linear-gradient(160deg,#00695c,#4db6ac)','linear-gradient(160deg,#37474f,#90a4ae)'][($book->id-1)%8] }}">
            @if(!$book->cover)<div class="detail-spine"></div>@endif
            @if($book->cover)
                <img src="{{ $book->coverUrl() }}" style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover" alt="{{ $book->title }}">
            @else
                <div class="text-center text-white position-relative" style="z-index:1;padding:1rem">
                    <i class="bi bi-book-fill" style="font-size:3rem;opacity:.8;display:block;margin-bottom:.5rem"></i>
                    <div style="font-size:.82rem;font-weight:600;line-height:1.4">{{ $book->title }}</div>
                </div>
            @endif
        </div>

        {{-- Rating summary --}}
        <div class="card mt-3 text-center p-3">
            <div style="font-size:2.2rem;font-weight:800;color:var(--brown-dark);line-height:1">
                {{ $avgRating ?: '—' }}
            </div>
            <div class="d-flex justify-content-center gap-1 my-1">
                @for($i=1;$i<=5;$i++)
                <i class="bi bi-star{{ $i<=round($avgRating)?'-fill':'' }}"
                   style="color:{{ $i<=round($avgRating)?'#d97706':'var(--cream-dark)' }};font-size:.85rem"></i>
                @endfor
            </div>
            <div style="font-size:.73rem;color:var(--text-muted)">{{ $ratingCount }} ulasan</div>
        </div>

        {{-- Stok --}}
        <div class="card mt-3 p-3 text-center">
            <div class="fw-800" style="font-size:1.6rem;color:{{ $book->stock>0?'#5c8a3c':'#c0392b' }}">{{ $book->stock }}</div>
            <div style="font-size:.75rem;color:var(--text-muted)">dari {{ $book->total_stock }} tersedia</div>
            <div class="progress mt-2" style="height:5px;background:var(--cream-dark)">
                <div class="progress-bar" style="width:{{ $book->total_stock>0?($book->stock/$book->total_stock*100):0 }}%;background:{{ $book->stock>0?'#5c8a3c':'#c0392b' }}"></div>
            </div>
        </div>
    </div>

    {{-- Detail --}}
    <div class="col-md-9">
        <div class="card mb-4">
            <div class="card-body p-4">
                <span class="badge mb-2" style="background:var(--cream-dark);color:var(--brown);font-size:.73rem">{{ $book->category->name }}</span>
                <h4 style="font-family:'Playfair Display',serif;font-weight:800;color:var(--brown-dark);margin-bottom:.3rem">{{ $book->title }}</h4>
                <div style="color:var(--text-muted);font-size:.9rem" class="mb-3">oleh <strong style="color:var(--brown)">{{ $book->author }}</strong></div>

                <div class="row g-2 mb-4">
                    @if($book->publisher)
                    <div class="col-6 col-md-3">
                        <div class="info-chip">
                            <i class="bi bi-building" style="color:var(--brown)"></i>
                            <div><div class="chip-label">Penerbit</div><div class="chip-val">{{ $book->publisher }}</div></div>
                        </div>
                    </div>
                    @endif
                    @if($book->published_year)
                    <div class="col-6 col-md-3">
                        <div class="info-chip">
                            <i class="bi bi-calendar3" style="color:#d97706"></i>
                            <div><div class="chip-label">Tahun</div><div class="chip-val">{{ $book->published_year }}</div></div>
                        </div>
                    </div>
                    @endif
                    @if($book->isbn)
                    <div class="col-6 col-md-3">
                        <div class="info-chip">
                            <i class="bi bi-upc" style="color:#1565c0"></i>
                            <div><div class="chip-label">ISBN</div><div class="chip-val">{{ $book->isbn }}</div></div>
                        </div>
                    </div>
                    @endif
                    @if($book->rack_location)
                    <div class="col-6 col-md-3">
                        <div class="info-chip">
                            <i class="bi bi-geo-alt" style="color:#c0392b"></i>
                            <div><div class="chip-label">Rak</div><div class="chip-val">{{ $book->rack_location }}</div></div>
                        </div>
                    </div>
                    @endif
                </div>

                @if($book->description)
                <div class="mb-4 p-3 rounded-3" style="background:var(--cream);border-left:3px solid var(--brown-light)">
                    <p style="font-size:.875rem;color:var(--text);line-height:1.7;margin:0">{{ $book->description }}</p>
                </div>
                @endif

                @if($book->stock > 0)
                <form action="{{ route('peminjam.loans.request') }}" method="POST">
                    @csrf
                    <input type="hidden" name="book_id" value="{{ $book->id }}">
                    <div class="p-3 rounded-3 mb-3" style="background:#f0fdf4;border:1px solid #bbf7d0;font-size:.82rem;color:#166534">
                        <i class="bi bi-info-circle-fill me-1" style="color:#5c8a3c"></i>
                        Durasi <strong>7 hari</strong> &bull; Denda <strong>Rp 1.000/hari</strong>
                    </div>
                    <button type="submit" class="btn btn-primary px-4 py-2"
                            onclick="return confirm('Pinjam buku ini?')">
                        <i class="bi bi-bookmark-plus-fill me-2"></i>Pinjam Buku Ini
                    </button>
                </form>
                @else
                <button class="btn btn-secondary px-4" disabled>
                    <i class="bi bi-x-circle me-2"></i>Stok Habis
                </button>
                @endif
            </div>
        </div>

        {{-- Rating --}}
        <div class="card">
            <div class="card-header d-flex align-items-center gap-2">
                <i class="bi bi-star-fill" style="color:#d97706"></i> Rating & Ulasan
            </div>
            <div class="card-body">
                @if($hasBorrowed)
                <div class="p-3 rounded-3 mb-4" style="background:var(--cream);border:1px solid var(--cream-dark)">
                    <div class="fw-600 mb-2" style="font-size:.85rem;color:var(--brown-dark)">
                        {{ $userRating ? 'Ubah rating kamu' : 'Beri rating untuk buku ini' }}
                    </div>
                    <form action="{{ route('peminjam.ratings.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="book_id" value="{{ $book->id }}">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="d-flex gap-1" id="starPicker">
                                @for($i=1;$i<=5;$i++)
                                <span class="star-pick {{ $userRating && $userRating->rating>=$i?'active':'' }}"
                                      data-val="{{ $i }}" onclick="setRating({{ $i }})">
                                    <i class="bi bi-star{{ $userRating && $userRating->rating>=$i?'-fill':'' }}"></i>
                                </span>
                                @endfor
                            </div>
                            <span id="ratingLabel" style="font-size:.8rem;color:var(--text-muted)">
                                {{ $userRating ? ['','Buruk','Kurang','Cukup','Bagus','Sangat Bagus'][$userRating->rating] : 'Pilih bintang' }}
                            </span>
                        </div>
                        <input type="hidden" name="rating" id="ratingInput" value="{{ $userRating->rating ?? '' }}">
                        <textarea name="review" class="form-control mb-3" rows="2"
                                  placeholder="Tulis ulasanmu (opsional)..."
                                  style="font-size:.85rem">{{ $userRating->review ?? '' }}</textarea>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary btn-sm px-3">
                                <i class="bi bi-send me-1"></i>{{ $userRating ? 'Update' : 'Kirim' }} Rating
                            </button>
                            @if($userRating)
                            <form action="{{ route('peminjam.ratings.destroy') }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <input type="hidden" name="book_id" value="{{ $book->id }}">
                                <button type="submit" class="btn btn-outline-danger btn-sm"
                                        onclick="return confirm('Hapus rating?')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                            @endif
                        </div>
                    </form>
                </div>
                @else
                <div class="p-3 rounded-3 mb-4 text-center" style="background:var(--cream);border:1px dashed var(--cream-dark);font-size:.82rem;color:var(--text-muted)">
                    <i class="bi bi-lock me-1"></i>Rating tersedia setelah kamu meminjam & mengembalikan buku ini.
                </div>
                @endif

                @forelse($book->ratings->sortByDesc('created_at') as $r)
                <div class="d-flex gap-3 py-3 border-bottom" style="border-color:var(--cream-dark)!important">
                    <div style="width:36px;height:36px;border-radius:50%;background:linear-gradient(135deg,var(--brown),var(--brown-light));display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:.78rem;overflow:hidden;flex-shrink:0">
                        @if($r->user->avatar)
                            <img src="{{ $r->user->avatarUrl() }}" style="width:100%;height:100%;object-fit:cover">
                        @else
                            {{ strtoupper(substr($r->user->name,0,1)) }}
                        @endif
                    </div>
                    <div class="flex-grow-1">
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <span class="fw-600" style="font-size:.84rem;color:var(--brown-dark)">{{ $r->user->name }}</span>
                            <div class="d-flex gap-1">
                                @for($i=1;$i<=5;$i++)
                                <i class="bi bi-star{{ $i<=$r->rating?'-fill':'' }}"
                                   style="color:{{ $i<=$r->rating?'#d97706':'var(--cream-dark)' }};font-size:.7rem"></i>
                                @endfor
                            </div>
                            <span style="font-size:.7rem;color:var(--text-muted)">{{ $r->created_at->diffForHumans() }}</span>
                        </div>
                        @if($r->review)
                        <p style="font-size:.82rem;color:var(--text);margin:0">{{ $r->review }}</p>
                        @endif
                    </div>
                </div>
                @empty
                <div class="text-center py-3" style="font-size:.84rem;color:var(--text-muted)">Belum ada ulasan.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.detail-cover { height:340px;border-radius:12px;position:relative;overflow:hidden;display:flex;align-items:center;justify-content:center;box-shadow:6px 6px 20px rgba(139,94,60,.2); }
.detail-spine { position:absolute;left:0;top:0;bottom:0;width:16px;background:rgba(0,0,0,.2);z-index:2; }
.info-chip { display:flex;align-items:flex-start;gap:.6rem;background:var(--cream);border:1px solid var(--cream-dark);border-radius:10px;padding:.65rem; }
.info-chip i { font-size:1rem;margin-top:1px;flex-shrink:0; }
.chip-label { font-size:.65rem;color:var(--text-muted);text-transform:uppercase;letter-spacing:.05em;font-weight:600; }
.chip-val { font-size:.8rem;font-weight:600;color:var(--brown-dark); }
.star-pick { font-size:1.4rem;cursor:pointer;color:var(--cream-dark);transition:.15s; }
.star-pick.active,.star-pick:hover { color:#d97706; }
.star-pick i { pointer-events:none; }
</style>
@endpush

@push('scripts')
<script>
const labels = ['','Buruk','Kurang','Cukup','Bagus','Sangat Bagus'];
function setRating(val) {
    document.getElementById('ratingInput').value = val;
    document.getElementById('ratingLabel').textContent = labels[val];
    document.querySelectorAll('.star-pick').forEach((s,i) => {
        const on = i < val;
        s.classList.toggle('active', on);
        s.querySelector('i').className = 'bi bi-star' + (on ? '-fill' : '');
    });
}
document.querySelectorAll('.star-pick').forEach((s,i) => {
    s.addEventListener('mouseenter', () => {
        document.querySelectorAll('.star-pick').forEach((ss,j) => {
            ss.querySelector('i').className = 'bi bi-star' + (j<=i?'-fill':'');
            ss.style.color = j<=i ? '#d97706' : 'var(--cream-dark)';
        });
    });
    s.addEventListener('mouseleave', () => {
        const cur = parseInt(document.getElementById('ratingInput').value)||0;
        document.querySelectorAll('.star-pick').forEach((ss,j) => {
            const on = j < cur;
            ss.querySelector('i').className = 'bi bi-star'+(on?'-fill':'');
            ss.style.color = on ? '#d97706' : 'var(--cream-dark)';
        });
    });
});
</script>
@endpush
@endsection
