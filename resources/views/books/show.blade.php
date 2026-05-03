@extends('layouts.app')
@section('title', $book->title)

@section('content')
<div class="row g-4">
    <div class="col-md-3">
        @if($book->cover)
            <img src="{{ Storage::url($book->cover) }}" class="img-fluid rounded shadow" alt="{{ $book->title }}">
        @else
            <div class="d-flex align-items-center justify-content-center bg-light rounded" style="height:280px">
                <i class="bi bi-book text-muted" style="font-size:4rem"></i>
            </div>
        @endif
    </div>
    <div class="col-md-9">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <h4 class="fw-bold mb-1">{{ $book->title }}</h4>
                        <p class="text-muted mb-0">{{ $book->author }}</p>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('books.edit', $book) }}" class="btn btn-outline-primary btn-sm">
                            <i class="bi bi-pencil me-1"></i>Edit
                        </a>
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-6 col-md-3">
                        <div class="small text-muted">Kategori</div>
                        <span class="badge bg-primary">{{ $book->category->name }}</span>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="small text-muted">ISBN</div>
                        <div class="fw-semibold small">{{ $book->isbn ?? '-' }}</div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="small text-muted">Penerbit</div>
                        <div class="fw-semibold small">{{ $book->publisher ?? '-' }}</div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="small text-muted">Tahun</div>
                        <div class="fw-semibold small">{{ $book->published_year ?? '-' }}</div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="small text-muted">Lokasi Rak</div>
                        <div class="fw-semibold small">{{ $book->rack_location ?? '-' }}</div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="small text-muted">Stok Tersedia</div>
                        <span class="badge {{ $book->stock > 0 ? 'bg-success' : 'bg-danger' }} fs-6">
                            {{ $book->stock }} / {{ $book->total_stock }}
                        </span>
                    </div>
                </div>

                @if($book->description)
                <div class="mb-3">
                    <div class="small text-muted mb-1">Deskripsi</div>
                    <p class="small">{{ $book->description }}</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="card mt-4">
    <div class="card-header py-3">
        <i class="bi bi-clock-history me-2 text-primary"></i>Riwayat Peminjaman
    </div>
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Kode</th><th>Anggota</th><th>Tanggal Pinjam</th><th>Jatuh Tempo</th><th>Dikembalikan</th><th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($book->loans as $loan)
                <tr>
                    <td><code class="small">{{ $loan->loan_code }}</code></td>
                    <td class="small">{{ $loan->member->name }}</td>
                    <td class="small">{{ $loan->loan_date->format('d/m/Y') }}</td>
                    <td class="small">{{ $loan->due_date->format('d/m/Y') }}</td>
                    <td class="small">{{ $loan->return_date ? $loan->return_date->format('d/m/Y') : '-' }}</td>
                    <td>
                        <span class="badge badge-status-{{ $loan->status }} rounded-pill px-2">
                            {{ ucfirst($loan->status) }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted py-3">Belum pernah dipinjam</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
