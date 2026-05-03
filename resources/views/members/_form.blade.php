<div class="row g-3">
    <div class="col-12">
        <label class="form-label fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
        <input type="text" name="name"
               class="form-control @error('name') is-invalid @enderror"
               value="{{ old('name', $member->name ?? '') }}" required>
        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-12">
        <label class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
        <input type="email" name="email"
               class="form-control @error('email') is-invalid @enderror"
               value="{{ old('email', $member->email ?? '') }}" required>
        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-12">
        <label class="form-label fw-semibold">No. Telepon</label>
        <input type="text" name="phone" class="form-control"
               value="{{ old('phone', $member->phone ?? '') }}" placeholder="08xxxxxxxxxx">
    </div>

    <div class="col-12">
        <label class="form-label fw-semibold">
            Password
            @isset($member) <span class="text-muted small">(kosongkan jika tidak diubah)</span> @endisset
            @unless(isset($member)) <span class="text-danger">*</span> @endunless
        </label>
        <input type="password" name="password"
               class="form-control @error('password') is-invalid @enderror"
               placeholder="Min. 8 karakter"
               {{ isset($member) ? '' : 'required' }}>
        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-12">
        <label class="form-label fw-semibold">Konfirmasi Password</label>
        <input type="password" name="password_confirmation"
               class="form-control" placeholder="Ulangi password">
    </div>
</div>
