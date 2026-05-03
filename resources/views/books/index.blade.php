@extends('layouts.app')
@section('title', 'Daftar Buku')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="fw-bold mb-0">Koleksi Buku</h5>
        <small class="text-muted">{{ $books->total() }} buku ditemukan</small>
    </div>
    <a href="{{ route('books.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i>Tambah Buku
    </a>
</div>

{{-- Filter --}}
<div class="card mb-4">
    <div class="card-body py-3">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-5">
                <input type="text" name="search" class="form-control" placeholder="Cari judul, pengarang, ISBN..."
                       value="{{ request('search') }}">
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
                    <option value="unavailable" {{ request('availability') == 'unavailable' ? 'selected' : '' }}>Habis</option>
                </select>
            </div>
            <div class="col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-primary flex-fill"><i class="bi bi-search"></i></button>
                <a href="{{ route('books.index') }}" class="btn btn-outline-secondary"><i class="bi bi-x"></i></a>
            </div>
        </form>
    </div>
</div>

<div class="row g-3">
    @forelse($books as $book)
    <div class="col-md-6 col-lg-4 col-xl-3">
        <div class="card h-100">
            <div class="position-relative">
                @if($book->cover)
                    <img src="{{ Storage::url($book->cover) }}" class="card-img-top" style="height:180px;object-fit:cover" alt="{{ $book->title }}">
                @else
                    <div class="d-flex align-items-center justify-content-center bg-light" style="height:180px">
                        <i class="bi bi-book text-muted" style="font-size:3rem"></i>
                    </div>
                @endif
                <span class="position-absolute top-0 end-0 m-2 badge {{ $book->stock > 0 ? 'bg-success' : 'bg-danger' }}">
                    {{ $book->stock > 0 ? 'Tersedia ('.$book->stock.')' : 'Habis' }}
                </span>
            </div>
            <div class="card-body d-flex flex-column">
                <h6 class="card-title fw-semibold mb-1 text-truncate" title="{{ $book->title }}">{{ $book->title }}</h6>
                <p class="text-muted small mb-1">{{ $book->author }}</p>
                <span class="badge bg-light text-dark border mb-2 align-self-start">{{ $book->category->name }}</span>
                <div class="mt-auto d-flex gap-1">
                    <a href="{{ route('books.show', $book) }}" class="btn btn-sm btn-outline-primary flex-fill">
                        <i class="bi bi-eye"></i>
                    </a>
                    <a href="{{ route('books.edit', $book) }}" class="btn btn-sm btn-outline-secondary flex-fill">
                        <i class="bi bi-pencil"></i>
                    </a>
                    <form action="{{ route('books.destroy', $book) }}" method="POST"
                          onsubmit="return confirm('Hapus buku ini?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="text-center py-5 text-muted">
            <i class="bi bi-book-x fs-1 d-block mb-2"></i>
            Tidak ada buku ditemukan.
            <a href="{{ route('books.create') }}">Tambah buku baru</a>
        </div>
    </div>
    @endforelse
</div>

<div class="mt-4">{{ $books->links() }}</div>
@endsection
