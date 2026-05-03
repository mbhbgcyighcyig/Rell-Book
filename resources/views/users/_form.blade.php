<div class="row g-3">
    <div class="col-12">
        <label class="form-label fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
               value="{{ old('name', $user->name ?? '') }}" required>
        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-12">
        <label class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
               value="{{ old('email', $user->email ?? '') }}" required>
        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-6">
        <label class="form-label fw-semibold">Role <span class="text-danger">*</span></label>
        <select name="role" class="form-select @error('role') is-invalid @enderror" required>
            <option value="admin"    {{ old('role', $user->role ?? '') == 'admin'    ? 'selected' : '' }}>Admin</option>
            <option value="petugas"  {{ old('role', $user->role ?? '') == 'petugas'  ? 'selected' : '' }}>Petugas</option>
            <option value="peminjam" {{ old('role', $user->role ?? '') == 'peminjam' ? 'selected' : '' }}>Peminjam</option>
        </select>
        @error('role')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-6">
        <label class="form-label fw-semibold">No. Telepon</label>
        <input type="text" name="phone" class="form-control"
               value="{{ old('phone', $user->phone ?? '') }}" placeholder="08xxxxxxxxxx">
    </div>

    <div class="col-12">
        <label class="form-label fw-semibold">
            Password {{ isset($user) ? '(kosongkan jika tidak diubah)' : '' }}
            @if(!isset($user))<span class="text-danger">*</span>@endif
        </label>
        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
               {{ !isset($user) ? 'required' : '' }} placeholder="Min. 8 karakter">
        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-12">
        <label class="form-label fw-semibold">Konfirmasi Password</label>
        <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password">
    </div>
</div>
