@extends('layouts.app')
@section('title', 'Ulasan & Rating')

@section('content')

{{-- Header --}}
<div class="page-header mb-4">
    <div class="d-flex align-items-center justify-content-between position-relative" style="z-index:1">
        <div>
            <h5 class="mb-1 fw-700"><i class="bi bi-star-fill me-2"></i>Ulasan & Rating Buku</h5>
            <small style="opacity:.85">Track record semua ulasan dari anggota perpustakaan</small>
        </div>
        <div class="d-flex gap-2">
            <div class="px-3 py-2 rounded-3 text-center" style="background:rgba(255,255,255,.15);min-width:80px">
                <div style="font-size:1.5rem;font-weight:800;line-height:1">{{ $avgRating }}</div>
                <div class="d-flex justify-content-center gap-1 mt-1">
                    @for($i=1;$i<=5;$i++)
                    <i class="bi bi-star{{ $i<=round($avgRating)?'-fill':'' }}"
                       style="font-size:.55rem;color:{{ $i<=round($avgRating)?'#fde68a':'rgba(255,255,255,.3)' }}"></i>
                    @endfor
                </div>
                <div style="font-size:.65rem;opacity:.75;margin-top:2px">Rata-rata</div>
            </div>
            <div class="px-3 py-2 rounded-3 text-center" style="background:rgba(255,255,255,.15);min-width:80px">
                <div style="font-size:1.5rem;font-weight:800;line-height:1">{{ $totalRatings }}</div>
                <div style="font-size:.65rem;opacity:.75;margin-top:6px">Total Ulasan</div>
            </div>
            <div class="px-3 py-2 rounded-3 text-center" style="background:rgba(255,255,255,.15);min-width:80px">
                <div style="font-size:1.5rem;font-weight:800;line-height:1">{{ $ratingDist[5] ?? 0 }}</div>
                <div style="font-size:.65rem;opacity:.75;margin-top:6px">⭐ 5 Bintang</div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">

    {{-- Distribusi Rating --}}
    <div class="col-lg-3">
        <div class="card mb-4">
            <div class="card-header">
                <i class="bi bi-bar-chart-fill me-2 text-warning"></i>Distribusi Rating
            </div>
            <div class="card-body">
                @for($star = 5; $star >= 1; $star--)
                @php
                    $count  = $ratingDist[$star] ?? 0;
                    $pct    = $totalRatings > 0 ? round($count / $totalRatings * 100) : 0;
                    $colors = [1=>'#ef4444',2=>'#f97316',3=>'#94a3b8',4=>'#84cc16',5=>'#f59e0b'];
                @endphp
                <div class="d-flex align-items-center gap-2 mb-3">
                    <span style="font-size:.72rem;font-weight:700;color:#64748b;width:10px;flex-shrink:0">{{ $star }}</span>
                    <i class="bi bi-star-fill" style="font-size:.65rem;color:{{ $colors[$star] }};flex-shrink:0"></i>
                    <div class="flex-grow-1">
                        <div class="progress" style="height:7px;border-radius:4px;background:#f1f5f9">
                            <div class="progress-bar" style="width:{{ $pct }}%;background:{{ $colors[$star] }};border-radius:4px;transition:.6s"></div>
                        </div>
                    </div>
                    <span style="font-size:.72rem;color:#64748b;width:28px;text-align:right;flex-shrink:0">{{ $count }}</span>
                </div>
                @endfor

                <hr style="border-color:#f1f5f9">

                <div class="text-center mt-2">
                    <div style="font-size:3rem;font-weight:800;color:#1e293b;line-height:1">{{ $avgRating }}</div>
                    <div class="d-flex justify-content-center gap-1 my-2">
                        @for($i=1;$i<=5;$i++)
                        <i class="bi bi-star{{ $i<=round($avgRating)?'-fill':'' }}"
                           style="color:{{ $i<=round($avgRating)?'#f59e0b':'#e2e8f0' }};font-size:1rem"></i>
                        @endfor
                    </div>
                    <div style="font-size:.75rem;color:#94a3b8">dari {{ $totalRatings }} ulasan</div>
                </div>
            </div>
        </div>

        {{-- Top Buku Terulas --}}
        <div class="card">
            <div class="card-header">
                <i class="bi bi-trophy me-2 text-warning"></i>Buku Paling Diulas
            </div>
            <div class="card-body p-0">
                @forelse($topBooks as $book)
                <div class="d-flex align-items-center gap-3 px-3 py-2 border-bottom" style="border-color:#f8fafc!important">
                    <div style="width:32px;height:42px;border-radius:3px 5px 5px 3px;flex-shrink:0;
                                background:{{ ['linear-gradient(160deg,#8b5e3c,#c49a6c)','linear-gradient(160deg,#5c8a3c,#8bc34a)','linear-gradient(160deg,#c0392b,#e57373)','linear-gradient(160deg,#1565c0,#64b5f6)','linear-gradient(160deg,#6a1b9a,#ce93d8)','linear-gradient(160deg,#e65100,#ffb74d)','linear-gradient(160deg,#00695c,#4db6ac)','linear-gradient(160deg,#37474f,#90a4ae)'][($book->id-1)%8] }};
                                position:relative;overflow:hidden;display:flex;align-items:center;justify-content:center">
                        @if($book->coverUrl())
                            <img src="{{ $book->coverUrl() }}" style="position:absolute;inset:0;width:100%;height:100%;object-fit:contain;background:#fff">
                        @else
                            <i class="bi bi-book-fill text-white" style="font-size:.6rem;opacity:.8"></i>
                        @endif
                    </div>
                    <div class="flex-grow-1 min-w-0">
                        <div class="text-truncate fw-600" style="font-size:.78rem;color:#1e293b">{{ $book->title }}</div>
                        <div style="font-size:.68rem;color:#94a3b8">
                            <i class="bi bi-chat-square-text me-1"></i>{{ $book->ratings_count }} ulasan
                            &bull;
                            <i class="bi bi-star-fill me-1" style="color:#f59e0b"></i>{{ round($book->ratings_avg_rating,1) }}
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-3" style="font-size:.8rem;color:#94a3b8">Belum ada data</div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Tabel Ulasan --}}
    <div class="col-lg-9">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <span><i class="bi bi-chat-quote me-2"></i>Semua Ulasan</span>
                <span class="badge bg-primary rounded-pill">{{ $ratings->total() }}</span>
            </div>

            {{-- Filter --}}
            <div class="card-body border-bottom pb-3" style="border-color:#f1f5f9!important">
                <form method="GET" class="row g-2">
                    <div class="col-md-4">
                        <input type="text" name="search" class="form-control form-control-sm"
                               placeholder="Cari judul buku / nama anggota..."
                               value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3">
                        <select name="book_id" class="form-select form-select-sm">
                            <option value="">Semua Buku</option>
                            @foreach($books as $b)
                            <option value="{{ $b->id }}" {{ request('book_id') == $b->id ? 'selected' : '' }}>
                                {{ Str::limit($b->title, 35) }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select name="rating" class="form-select form-select-sm">
                            <option value="">Semua Rating</option>
                            @for($i=5;$i>=1;$i--)
                            <option value="{{ $i }}" {{ request('rating') == $i ? 'selected' : '' }}>
                                {{ $i }} Bintang
                            </option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-md-3 d-flex gap-2">
                        <button type="submit" class="btn btn-primary btn-sm flex-fill">
                            <i class="bi bi-search me-1"></i>Filter
                        </button>
                        <a href="{{ route('ratings.index') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="bi bi-x"></i>
                        </a>
                    </div>
                </form>
            </div>

            {{-- List Ulasan --}}
            <div class="card-body p-0">
                @forelse($ratings as $r)
                <div class="d-flex align-items-start gap-3 px-4 py-3 border-bottom"
                     style="border-color:#f8fafc!important">

                    {{-- Avatar --}}
                    <div style="width:40px;height:40px;border-radius:50%;
                                background:linear-gradient(135deg,#4f46e5,#818cf8);
                                display:flex;align-items:center;justify-content:center;
                                color:#fff;font-weight:700;font-size:.82rem;
                                overflow:hidden;flex-shrink:0;box-shadow:0 2px 8px rgba(79,70,229,.2)">
                        @if($r->user->avatar)
                            <img src="{{ $r->user->avatarUrl() }}" style="width:100%;height:100%;object-fit:cover">
                        @else
                            {{ strtoupper(substr($r->user->name, 0, 1)) }}
                        @endif
                    </div>

                    {{-- Konten --}}
                    <div class="flex-grow-1 min-w-0">

                        {{-- Baris 1: User → Buku --}}
                        <div class="d-flex align-items-center flex-wrap gap-2 mb-1">
                            <span class="fw-700" style="font-size:.85rem;color:#1e293b">
                                {{ $r->user->name }}
                            </span>
                            <span style="font-size:.72rem;color:#94a3b8">mengulas</span>
                            <a href="{{ route('books.show', $r->book) }}"
                               class="fw-600 text-decoration-none"
                               style="font-size:.85rem;color:#4f46e5">
                                {{ $r->book->title }}
                            </a>
                            <span class="badge rounded-pill"
                                  style="background:#f1f5f9;color:#64748b;font-size:.62rem;font-weight:600">
                                {{ $r->book->category->name }}
                            </span>
                        </div>

                        {{-- Baris 2: Bintang + label + waktu --}}
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <div class="d-flex gap-1">
                                @for($i=1;$i<=5;$i++)
                                <i class="bi bi-star{{ $i<=$r->rating?'-fill':'' }}"
                                   style="color:{{ $i<=$r->rating?'#f59e0b':'#e2e8f0' }};font-size:.78rem"></i>
                                @endfor
                            </div>
                            <span class="badge rounded-pill"
                                  style="font-size:.62rem;font-weight:700;
                                         background:{{ $r->rating>=4?'#fef3c7':($r->rating==3?'#f1f5f9':'#fee2e2') }};
                                         color:{{ $r->rating>=4?'#92400e':($r->rating==3?'#475569':'#991b1b') }}">
                                {{ ['','Buruk','Kurang','Cukup','Bagus','Sangat Bagus'][$r->rating] }}
                            </span>
                            <span style="font-size:.7rem;color:#94a3b8">
                                <i class="bi bi-clock me-1"></i>{{ $r->created_at->diffForHumans() }}
                            </span>
                            {{-- Info loan terkait --}}
                            @if($r->loan)
                            <span style="font-size:.7rem;color:#94a3b8">
                                &bull; <i class="bi bi-calendar-check me-1"></i>Dikembalikan {{ $r->loan->return_date?->format('d M Y') }}
                            </span>
                            @endif
                        </div>

                        {{-- Baris 3: Teks ulasan --}}
                        @if($r->review)
                        <p style="font-size:.82rem;color:#475569;margin:0;
                                  background:#f8fafc;border-left:3px solid #e2e8f0;
                                  padding:.45rem .85rem;border-radius:0 8px 8px 0;
                                  font-style:italic;line-height:1.6">
                            "{{ $r->review }}"
                        </p>
                        @else
                        <span style="font-size:.75rem;color:#cbd5e1;font-style:italic">
                            <i class="bi bi-dash me-1"></i>Tidak ada teks ulasan
                        </span>
                        @endif
                    </div>

                    {{-- Hapus --}}
                    <form action="{{ route('ratings.destroy', $r) }}" method="POST"
                          onsubmit="return confirm('Hapus ulasan ini?')"
                          class="flex-shrink-0">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger" title="Hapus ulasan">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </div>
                @empty
                <div class="text-center py-5" style="color:#94a3b8">
                    <i class="bi bi-chat-square-text fs-1 d-block mb-2 opacity-25"></i>
                    <div style="font-size:.88rem">Belum ada ulasan</div>
                    @if(request()->hasAny(['search','book_id','rating']))
                    <a href="{{ route('ratings.index') }}" class="btn btn-sm btn-outline-secondary mt-2">Reset Filter</a>
                    @endif
                </div>
                @endforelse
            </div>

            @if($ratings->hasPages())
            <div class="card-body pt-2">{{ $ratings->links() }}</div>
            @endif
        </div>
    </div>
</div>

@endsection
