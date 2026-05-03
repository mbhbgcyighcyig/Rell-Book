<div class="row g-3">
    <div class="col-md-8">
        <label class="form-label fw-semibold">Judul Buku <span class="text-danger">*</span></label>
        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
               value="{{ old('title', $book->title ?? '') }}" required>
        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-4">
        <label class="form-label fw-semibold">Kategori <span class="text-danger">*</span></label>
        <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
            <option value="">Pilih Kategori</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ old('category_id', $book->category_id ?? '') == $cat->id ? 'selected' : '' }}>
                    {{ $cat->name }}
                </option>
            @endforeach
        </select>
        @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-6">
        <label class="form-label fw-semibold">Pengarang <span class="text-danger">*</span></label>
        <input type="text" name="author" class="form-control @error('author') is-invalid @enderror"
               value="{{ old('author', $book->author ?? '') }}" required>
        @error('author')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-6">
        <label class="form-label fw-semibold">ISBN</label>
        <input type="text" name="isbn" class="form-control @error('isbn') is-invalid @enderror"
               value="{{ old('isbn', $book->isbn ?? '') }}" placeholder="978-xxx-xxx-xxx-x">
        @error('isbn')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-6">
        <label class="form-label fw-semibold">Penerbit</label>
        <input type="text" name="publisher" class="form-control"
               value="{{ old('publisher', $book->publisher ?? '') }}">
    </div>

    <div class="col-md-3">
        <label class="form-label fw-semibold">Tahun Terbit</label>
        <input type="number" name="published_year" class="form-control"
               value="{{ old('published_year', $book->published_year ?? '') }}" min="1000" max="{{ date('Y') }}">
    </div>

    <div class="col-md-3">
        <label class="form-label fw-semibold">Lokasi Rak</label>
        <input type="text" name="rack_location" class="form-control"
               value="{{ old('rack_location', $book->rack_location ?? '') }}" placeholder="A-01">
    </div>

    <div class="col-md-3">
        <label class="form-label fw-semibold">Stok <span class="text-danger">*</span></label>
        <input type="number" name="stock" class="form-control @error('stock') is-invalid @enderror"
               value="{{ old('stock', $book->stock ?? 1) }}" min="0" required>
        @error('stock')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    @isset($book)
    <div class="col-md-3">
        <label class="form-label fw-semibold">Total Stok</label>
        <input type="number" name="total_stock" class="form-control"
               value="{{ old('total_stock', $book->total_stock) }}" min="0">
    </div>
    @endisset

    <div class="col-12">
        <label class="form-label fw-semibold">Deskripsi</label>
        <textarea name="description" class="form-control" rows="3"
                  placeholder="Sinopsis atau deskripsi buku...">{{ old('description', $book->description ?? '') }}</textarea>
    </div>

    <div class="col-md-6">
        <label class="form-label fw-semibold">Cover Buku</label>
        <input type="file" name="cover" class="form-control @error('cover') is-invalid @enderror" accept="image/*">
        @error('cover')<div class="invalid-feedback">{{ $message }}</div>@enderror
        @isset($book)
            @if($book->cover)
                <div class="mt-2">
                    <img src="{{ Storage::url($book->cover) }}" height="80" class="rounded border" alt="cover">
                    <small class="text-muted d-block">Cover saat ini</small>
                </div>
            @endif
        @endisset
    </div>
</div>
