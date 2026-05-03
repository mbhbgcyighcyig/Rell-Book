@extends('layouts.peminjam')
@section('title', 'Profil Saya')

@section('content')

<div class="profile-hero mb-4">
    <div class="position-relative" style="z-index:1">
        <h4 style="font-family:'Playfair Display',serif;font-weight:800;color:#fff;margin:0 0 .3rem;font-size:1.6rem;text-shadow:0 2px 8px rgba(0,0,0,.4)">Profil Saya</h4>
        <p style="color:rgba(255,255,255,.8);font-size:.88rem;margin:0">Kelola informasi akun dan keamanan</p>
    </div>
    <div class="d-none d-md-block" style="font-size:2.5rem;opacity:.6;position:relative;z-index:1"></div>
</div>

<div class="row g-4">
    {{-- Sidebar profil --}}
    <div class="col-md-4">
        <div class="card text-center p-4">
            <div class="profile-avatar mx-auto mb-3">
                @if($user->avatar)
                    <img src="{{ $user->avatarUrl() }}" id="profilePreviewImg" style="width:100%;height:100%;object-fit:cover">
                @else
                    <div class="d-flex align-items-center justify-content-center h-100 fw-bold text-white" style="font-size:2rem" id="profilePreviewInit">
                        {{ strtoupper(substr($user->name,0,1)) }}
                    </div>
                    <img id="profilePreviewImg" src="" style="display:none;width:100%;height:100%;object-fit:cover">
                @endif
            </div>
            <h5 style="font-family:'Playfair Display',serif;font-weight:700;color:var(--brown-dark);margin-bottom:.25rem">{{ $user->name }}</h5>
            <span class="badge rounded-pill px-3" style="background:var(--cream-dark);color:var(--brown);font-size:.75rem">Peminjam</span>
            @if($member)
            <div class="mt-2"><code style="font-size:.78rem;color:var(--text-muted)">{{ $member->member_code }}</code></div>
            <div style="font-size:.75rem;color:var(--text-muted);margin-top:.25rem">
                Berlaku s/d {{ $member->membership_expiry ? $member->membership_expiry->format('d M Y') : '-' }}
            </div>
            @endif
        </div>

        {{-- Info singkat --}}
        <div class="card mt-3">
            <div class="card-body p-3">
                <div class="mb-2 pb-2 border-bottom" style="border-color:var(--cream-dark)!important">
                    <div style="font-size:.7rem;color:var(--text-muted);text-transform:uppercase;letter-spacing:.05em">Email</div>
                    <div style="font-size:.83rem;font-weight:600;color:var(--brown-dark)">{{ $user->email }}</div>
                </div>
                <div class="mb-2 pb-2 border-bottom" style="border-color:var(--cream-dark)!important">
                    <div style="font-size:.7rem;color:var(--text-muted);text-transform:uppercase;letter-spacing:.05em">Telepon</div>
                    <div style="font-size:.83rem;font-weight:600;color:var(--brown-dark)">{{ $user->phone ?? '-' }}</div>
                </div>
                <div>
                    <div style="font-size:.7rem;color:var(--text-muted);text-transform:uppercase;letter-spacing:.05em">Bergabung</div>
                    <div style="font-size:.83rem;font-weight:600;color:var(--brown-dark)">{{ $user->created_at->format('d M Y') }}</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Form --}}
    <div class="col-md-8">
        {{-- Edit Profil --}}
        <div class="card mb-4">
            <div class="card-header"><i class="bi bi-person me-2" style="color:var(--brown)"></i>Edit Profil</div>
            <div class="card-body">
                <form action="{{ route('peminjam.profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf @method('PUT')
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-600" style="font-size:.82rem;color:var(--brown-dark)">Foto Profil</label>
                            <div class="d-flex align-items-center gap-3">
                                <div class="profile-avatar-sm">
                                    @if($user->avatar)
                                        <img src="{{ $user->avatarUrl() }}" id="profilePreviewImg2" style="width:100%;height:100%;object-fit:cover;border-radius:50%">
                                    @else
                                        <div class="d-flex align-items-center justify-content-center h-100 fw-bold text-white" style="font-size:1.1rem" id="profilePreviewInit2">
                                            {{ strtoupper(substr($user->name,0,1)) }}
                                        </div>
                                        <img id="profilePreviewImg2" src="" style="display:none;width:100%;height:100%;object-fit:cover;border-radius:50%">
                                    @endif
                                </div>
                                <div>
                                    <input type="file" name="avatar" id="avatarInput2" accept="image/*" style="display:none"
                                           onchange="previewAvatar2(this)">
                                    <label for="avatarInput2" class="btn btn-outline-primary btn-sm" style="cursor:pointer">
                                        <i class="bi bi-camera me-1"></i>Ganti Foto
                                    </label>
                                    <div style="font-size:.7rem;color:var(--text-muted);margin-top:.3rem">JPG/PNG, maks 2MB</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-600" style="font-size:.82rem;color:var(--brown-dark)">Nama Lengkap</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name',$user->name) }}" required>
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-600" style="font-size:.82rem;color:var(--brown-dark)">Email</label>
                            <input type="email" class="form-control" value="{{ $user->email }}" disabled style="background:var(--cream)">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-600" style="font-size:.82rem;color:var(--brown-dark)">No. Telepon</label>
                            <input type="text" name="phone" class="form-control"
                                   value="{{ old('phone',$user->phone) }}" placeholder="08xxxxxxxxxx">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-600" style="font-size:.82rem;color:var(--brown-dark)">Alamat</label>
                            <textarea name="address" class="form-control" rows="2">{{ old('address',$user->address) }}</textarea>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3 px-4">
                        <i class="bi bi-save me-1"></i>Simpan Perubahan
                    </button>
                </form>
            </div>
        </div>

        {{-- Ganti Password --}}
        <div class="card">
            <div class="card-header"><i class="bi bi-lock me-2" style="color:var(--brown)"></i>Ganti Password</div>
            <div class="card-body">
                <form action="{{ route('peminjam.profile.password') }}" method="POST">
                    @csrf @method('PUT')
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label fw-600" style="font-size:.82rem;color:var(--brown-dark)">Password Lama</label>
                            <input type="password" name="current_password" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-600" style="font-size:.82rem;color:var(--brown-dark)">Password Baru</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-600" style="font-size:.82rem;color:var(--brown-dark)">Konfirmasi</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-outline-primary mt-3 px-4">
                        <i class="bi bi-key me-1"></i>Ganti Password
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.page-header-cream { background:linear-gradient(135deg,#fff9f2,var(--cream));border:1px solid var(--cream-dark);border-radius:14px;padding:1.5rem 2rem;display:flex;justify-content:space-between;align-items:center; }
.page-title { font-family:'Playfair Display',serif;font-weight:800;color:var(--brown-dark);margin:0 0 .25rem; }
.page-sub { color:var(--text-muted);font-size:.85rem;margin:0; }
.profile-hero {
    background: url('{{ asset("images/ou.jpg") }}') center/cover no-repeat;
    border-radius: 16px; padding: 2.5rem 2rem;
    position: relative; overflow: hidden;
    min-height: 140px; display: flex;
    align-items: center; justify-content: space-between;
}
.profile-hero::before {
    content: ''; position: absolute; inset: 0;
    background: linear-gradient(135deg, rgba(92,61,30,.82) 0%, rgba(139,94,60,.65) 60%, rgba(0,0,0,.35) 100%);
    border-radius: 16px;
}
.profile-avatar { width:90px;height:90px;border-radius:50%;background:linear-gradient(135deg,var(--brown),var(--brown-light));overflow:hidden;border:3px solid var(--cream-dark); }
.profile-avatar-sm { width:52px;height:52px;border-radius:50%;background:linear-gradient(135deg,var(--brown),var(--brown-light));overflow:hidden;flex-shrink:0; }
</style>
@endpush

@push('scripts')
<script>
function previewAvatar2(input) {
    const file = input.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = e => {
        const img  = document.getElementById('profilePreviewImg2');
        const init = document.getElementById('profilePreviewInit2');
        if (img)  { img.src = e.target.result; img.style.display = 'block'; }
        if (init) init.style.display = 'none';
    };
    reader.readAsDataURL(file);
}
</script>
@endpush
@endsection
