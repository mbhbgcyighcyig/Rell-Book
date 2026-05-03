@extends('layouts.app')
@section('title', 'Pinjam Buku')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card">
            <div class="card-header py-3">
                <i class="bi bi-plus-circle me-2 text-primary"></i>Form Peminjaman Buku
            </div>
            <div class="card-body">
                <form action="{{ route('loans.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Anggota <span class="text-danger">*</span></label>
                        <select name="member_id" class="form-select @error('member_id') is-invalid @enderror" required>
                            <option value="">Pilih Anggota</option>
                            @foreach($members as $member)
                                <option value="{{ $member->id }}" {{ old('member_id') == $member->id ? 'selected' : '' }}>
                                    {{ $member->member_code }} - {{ $member->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('member_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Buku <span class="text-danger">*</span></label>
                        <select name="book_id" class="form-select @error('book_id') is-invalid @enderror" required>
                            <option value="">Pilih Buku</option>
                            @foreach($books as $book)
                                <option value="{{ $book->id }}" {{ old('book_id') == $book->id ? 'selected' : '' }}>
                                    {{ $book->title }} - {{ $book->author }} (Stok: {{ $book->stock }})
                                </option>
                            @endforeach
                        </select>
                        @error('book_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Tanggal Pinjam <span class="text-danger">*</span></label>
                            <input type="date" name="loan_date" class="form-control @error('loan_date') is-invalid @enderror"
                                   value="{{ old('loan_date', date('Y-m-d')) }}" required>
                            @error('loan_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Jatuh Tempo <span class="text-danger">*</span></label>
                            <input type="date" name="due_date" class="form-control @error('due_date') is-invalid @enderror"
                                   value="{{ old('due_date', date('Y-m-d', strtotime('+7 days'))) }}" required>
                            @error('due_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Catatan</label>
                        <textarea name="notes" class="form-control" rows="2"
                                  placeholder="Catatan tambahan (opsional)">{{ old('notes') }}</textarea>
                    </div>

                    <div class="p-3 bg-light rounded mb-4 small text-muted">
                        <i class="bi bi-info-circle me-1"></i>
                        Denda keterlambatan: <strong>Rp 1.000/hari</strong> &bull;
                        Maks. pinjaman: <strong>3 buku</strong> per anggota
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-save me-1"></i>Catat Peminjaman
                        </button>
                        <a href="{{ route('loans.index') }}" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
