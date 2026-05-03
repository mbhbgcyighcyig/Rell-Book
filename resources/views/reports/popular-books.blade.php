@extends('layouts.app')
@section('title', 'Buku Populer')

@section('content')
<div class="card">
    <div class="card-header py-3">
        <i class="bi bi-trophy me-2 text-warning"></i>20 Buku Paling Banyak Dipinjam
    </div>
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr><th>#</th><th>Judul</th><th>Pengarang</th><th>Kategori</th><th>Total Dipinjam</th></tr>
            </thead>
            <tbody>
                @forelse($books as $i => $book)
                <tr>
                    <td>
                        @if($i < 3)
                            <span class="badge {{ ['bg-warning text-dark','bg-secondary','bg-danger'][$i] }} rounded-pill">{{ $i+1 }}</span>
                        @else
                            <span class="text-muted">{{ $i+1 }}</span>
                        @endif
                    </td>
                    <td class="fw-semibold">{{ $book->title }}</td>
                    <td class="small text-muted">{{ $book->author }}</td>
                    <td><span class="badge bg-light text-dark border">{{ $book->category->name }}</span></td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="progress flex-grow-1" style="height:6px">
                                <div class="progress-bar bg-primary" style="width:{{ $books->first()->loans_count > 0 ? ($book->loans_count / $books->first()->loans_count * 100) : 0 }}%"></div>
                            </div>
                            <span class="badge bg-primary rounded-pill">{{ $book->loans_count }}x</span>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center text-muted py-4">Belum ada data peminjaman</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
