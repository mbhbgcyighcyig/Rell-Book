<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Daftar Akun - {{ config('app.name', 'Rel-Book') }}</title>

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@700;800&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<style>
* { margin: 0; padding: 0; box-sizing: border-box; }

body {
    font-family: 'Inter', sans-serif;
    min-height: 100vh;
    background: #f3eadf;
    display: flex;
}

/* ── LAYOUT ── */
.container {
    display: flex;
    width: 100%;
    min-height: 100vh;
}

/* ── LEFT: FORM ── */
.left {
    width: 52%;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 40px 48px;
    overflow-y: auto;
}

.form-box {
    width: 100%;
    max-width: 520px;
    padding: 44px 52px;
    background: rgba(255,255,255,0.42);
    backdrop-filter: blur(18px);
    -webkit-backdrop-filter: blur(18px);
    border-radius: 28px;
    border: 1px solid rgba(255,255,255,0.55);
    box-shadow: 0 24px 60px rgba(0,0,0,0.09);
}

.form-box h1 {
    font-size: 1.85rem;
    color: #e6a56d;
    font-weight: 700;
    margin-bottom: 4px;
}

.form-box .subtitle {
    font-size: 0.82rem;
    color: #9c7c5c;
    margin-bottom: 22px;
}

/* ── AVATAR PICKER ── */
.avatar-row {
    display: flex;
    align-items: center;
    gap: 14px;
    margin-bottom: 18px;
}

.avatar-circle {
    width: 62px;
    height: 62px;
    border-radius: 50%;
    overflow: hidden;
    flex-shrink: 0;
    background: linear-gradient(135deg, #e6a56d, #c47a3a);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: #fff;
    font-weight: 700;
    border: 2.5px solid rgba(255,255,255,0.7);
    box-shadow: 0 4px 12px rgba(230,165,109,0.3);
    cursor: pointer;
    transition: 0.2s;
}

.avatar-circle:hover { transform: scale(1.05); }

.avatar-circle img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: none;
}

.avatar-label {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    cursor: pointer;
    background: rgba(255,255,255,0.6);
    border: 1.5px dashed #d4a574;
    border-radius: 10px;
    padding: 7px 14px;
    font-size: 0.78rem;
    color: #9c7c5c;
    transition: 0.2s;
}

.avatar-label:hover {
    border-color: #e6a56d;
    color: #e6a56d;
    background: rgba(255,255,255,0.8);
}

/* ── FORM ROWS ── */
.row-2 {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px;
}

.group {
    margin-bottom: 13px;
}

.group label {
    display: block;
    font-size: 0.75rem;
    font-weight: 600;
    color: #7a5c3c;
    margin-bottom: 5px;
    letter-spacing: 0.02em;
}

/* ── INPUT ── */
.input-wrap {
    display: flex;
    align-items: center;
    background: rgba(255,255,255,0.65);
    border-radius: 12px;
    border: 1.5px solid transparent;
    transition: 0.2s;
}

.input-wrap:focus-within {
    background: rgba(255,255,255,0.88);
    border-color: #e6a56d;
    box-shadow: 0 0 0 3px rgba(230,165,109,0.15);
}

.input-wrap .icon {
    padding: 0 10px 0 13px;
    color: #c4956a;
    font-size: 0.95rem;
    flex-shrink: 0;
}

.input-wrap input {
    flex: 1;
    border: none;
    background: transparent;
    padding: 11px 10px 11px 0;
    font-family: 'Inter', sans-serif;
    font-size: 0.875rem;
    color: #3d2b1a;
    outline: none;
}

.input-wrap input::placeholder { color: #c4a882; }

.input-wrap .toggle-btn {
    border: none;
    background: none;
    padding: 0 12px;
    cursor: pointer;
    color: #c4956a;
    font-size: 0.95rem;
    transition: color 0.2s;
}

.input-wrap .toggle-btn:hover { color: #e6a56d; }

.invalid-feedback {
    font-size: 0.7rem;
    color: #dc2626;
    margin-top: 4px;
}

/* ── DIVIDER ── */
.divider {
    display: flex;
    align-items: center;
    gap: 10px;
    margin: 16px 0;
    font-size: 0.75rem;
    color: #b89a7a;
}

.divider::before,
.divider::after {
    content: '';
    flex: 1;
    height: 1px;
    background: rgba(180,140,100,0.25);
}

/* ── SOCIAL ── */
.social {
    display: flex;
    gap: 10px;
    margin-bottom: 4px;
}

.social div {
    flex: 1;
    height: 42px;
    background: rgba(255,255,255,0.65);
    border-radius: 11px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 7px;
    font-size: 0.8rem;
    color: #7a5c3c;
    font-weight: 500;
    box-shadow: 0 2px 6px rgba(0,0,0,0.05);
    cursor: pointer;
    transition: 0.2s;
    border: 1px solid rgba(255,255,255,0.5);
}

.social div:hover {
    background: rgba(255,255,255,0.9);
    transform: translateY(-2px);
    box-shadow: 0 5px 14px rgba(0,0,0,0.08);
}

/* ── BUTTON ── */
.btn-submit {
    width: 100%;
    padding: 13px;
    border-radius: 28px;
    background: #e6a56d;
    color: white;
    border: none;
    margin-top: 14px;
    cursor: pointer;
    transition: 0.2s;
    font-size: 0.92rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}

.btn-submit:hover {
    background: #d1905c;
    transform: translateY(-1px);
    box-shadow: 0 8px 20px rgba(230,165,109,0.35);
}

/* ── LINK ── */
.link {
    text-align: center;
    margin-top: 16px;
    font-size: 0.8rem;
    color: #9c7c5c;
}

.link a {
    color: #e6a56d;
    text-decoration: none;
    font-weight: 600;
}

.link a:hover { text-decoration: underline; }

/* ── RIGHT: IMAGE ── */
.right {
    width: 48%;
    position: relative;
    background-image: url('{{ asset("images/photo-1507842217343-583bb7270b66.jfif") }}');
    background-repeat: no-repeat;
    background-size: cover;
    background-position: center;
    overflow: hidden;
}

.right::before {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(
        135deg,
        rgba(243,234,223,0.72) 0%,
        rgba(196,154,108,0.35) 50%,
        rgba(92,61,30,0.45) 100%
    );
}

.right-content {
    position: absolute;
    inset: 0;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 52px 48px;
    z-index: 1;
    text-align: center;
}

.right-content .tagline {
    font-family: 'Playfair Display', serif;
    font-size: 3.2rem;
    font-weight: 800;
    color: #fff;
    line-height: 1.15;
    text-shadow:
        3px 3px 0 rgba(139,94,60,.3),
        6px 6px 16px rgba(92,61,30,.25),
        0 0 40px rgba(196,154,108,.2);
    margin-bottom: 16px;
}

.right-content .tagline span {
    color: #f5d5a8;
}

.right-content .desc {
    font-size: 0.88rem;
    color: rgba(255,255,255,0.85);
    line-height: 1.7;
    max-width: 320px;
    margin: 0 auto;
    text-shadow: 0 1px 4px rgba(0,0,0,0.2);
}

.right-content .badges {
    display: flex;
    gap: 10px;
    margin-top: 20px;
    flex-wrap: wrap;
}

.right-content .badge-item {
    background: rgba(255,255,255,0.18);
    backdrop-filter: blur(8px);
    border: 1px solid rgba(255,255,255,0.3);
    border-radius: 20px;
    padding: 6px 14px;
    font-size: 0.75rem;
    color: #fff;
    font-weight: 500;
}

/* ── LOGO ── */
.logo {
    position: fixed;
    top: 20px;
    left: 44px;
    z-index: 999;
    display: flex;
    align-items: center;
    gap: 1px;
}

.logo img {
    width: 100%;
    height: 100%;
    object-fit: contain;
}

.logo-text .name {
    font-family: 'Georgia', serif;
    font-weight: 700;
    font-size: 1.15rem;
    color: #d19173;
    text-shadow: 0 1px 4px rgba(255,255,255,.6);
    letter-spacing: .01em;
}

.logo-text .sub {
    font-size: .8rem;
    color: #9c7c5c;
    font-style: italic;
    letter-spacing: .04em;
}

/* ── RESPONSIVE ── */
@media (max-width: 960px) {
    .container { flex-direction: column; }
    .left, .right { width: 100%; }
    .right { min-height: 260px; }
    .right-content { padding: 32px; }
    .right-content .tagline { font-size: 2.2rem; }
    .left { padding: 32px 20px; }
    .form-box { padding: 32px 28px; }
}

@media (max-width: 520px) {
    .row-2 { grid-template-columns: 1fr; }
    .form-box { padding: 28px 20px; }
}
</style>
</head>
<body>

{{-- Logo --}}
<div class="logo">
    <div style="width:200px;height:150px;padding:6px">
        <img src="{{ asset('images/pipi.png') }}" alt="Logo">
    </div>
    <div class="logo-text">
        <div class="name">Rell-Book</div>
        <div class="sub">Digital Library</div>
    </div>
</div>

<div class="container">

    {{-- LEFT: FORM --}}
    <div class="left">
        <div class="form-box">

            <h1>Buat Akun</h1>
            <p class="subtitle">Bergabung dan mulai perjalanan membacamu</p>

            {{-- Social --}}
            <div class="social">
                <div onclick="alert('Google sign-up coming soon')">
                    <i class="bi bi-google"></i> Google
                </div>
                <div onclick="alert('GitHub sign-up coming soon')">
                    <i class="bi bi-github"></i> GitHub
                </div>
            </div>

            <div class="divider">atau daftar dengan email</div>

            <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" id="registerForm">
                @csrf

                {{-- Avatar --}}
                <div class="avatar-row">
                    <div class="avatar-circle" onclick="document.getElementById('avatarInput').click()" title="Klik untuk pilih foto">
                        <span id="avatarInitial">?</span>
                        <img id="avatarImg" src="" alt="avatar">
                    </div>
                    <div>
                        <label for="avatarInput" class="avatar-label">
                            <i class="bi bi-camera"></i> Pilih Foto Profil
                        </label>
                        <input type="file" name="avatar" id="avatarInput" accept="image/*"
                               style="display:none" onchange="previewAvatar(this)">
                        <div style="font-size:.68rem;color:#b89a7a;margin-top:5px">JPG/PNG, maks 2MB (opsional)</div>
                        @error('avatar')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                {{-- Nama --}}
                <div class="group">
                    <label>Nama Lengkap <span style="color:#e6a56d">*</span></label>
                    <div class="input-wrap">
                        <span class="icon"><i class="bi bi-person"></i></span>
                        <input type="text" name="name" value="{{ old('name') }}"
                               placeholder="Nama lengkap kamu" required autofocus>
                    </div>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                {{-- Email --}}
                <div class="group">
                    <label>Alamat Email <span style="color:#e6a56d">*</span></label>
                    <div class="input-wrap">
                        <span class="icon"><i class="bi bi-envelope"></i></span>
                        <input type="email" name="email" value="{{ old('email') }}"
                               placeholder="email@contoh.com" required>
                    </div>
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                {{-- Phone & Address --}}
                <div class="row-2">
                    <div class="group">
                        <label>No. Telepon</label>
                        <div class="input-wrap">
                            <span class="icon"><i class="bi bi-telephone"></i></span>
                            <input type="text" name="phone" value="{{ old('phone') }}"
                                   placeholder="08xx">
                        </div>
                        @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="group">
                        <label>Alamat</label>
                        <div class="input-wrap">
                            <span class="icon"><i class="bi bi-geo-alt"></i></span>
                            <input type="text" name="address" value="{{ old('address') }}"
                                   placeholder="Kota / Alamat">
                        </div>
                        @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                {{-- Password --}}
                <div class="group">
                    <label>Password <span style="color:#e6a56d">*</span></label>
                    <div class="input-wrap">
                        <span class="icon"><i class="bi bi-lock"></i></span>
                        <input type="password" name="password" id="regPassword"
                               placeholder="Minimal 8 karakter" required>
                        <button type="button" class="toggle-btn" onclick="togglePwd('regPassword', this)">
                            <i class="bi bi-eye-slash"></i>
                        </button>
                    </div>
                    @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                {{-- Konfirmasi Password --}}
                <div class="group">
                    <label>Konfirmasi Password <span style="color:#e6a56d">*</span></label>
                    <div class="input-wrap">
                        <span class="icon"><i class="bi bi-shield-lock"></i></span>
                        <input type="password" name="password_confirmation" id="confirmPassword"
                               placeholder="Ulangi password" required>
                        <button type="button" class="toggle-btn" onclick="togglePwd('confirmPassword', this)">
                            <i class="bi bi-eye-slash"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn-submit">
                    <i class="bi bi-person-check-fill"></i> Daftar Sekarang
                </button>
            </form>

            <div class="link">
                Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a>
            </div>

        </div>
    </div>

    {{-- RIGHT: IMAGE + TEXT --}}
    <div class="right">
        <div class="right-content">
            <div class="tagline">
                Join the<br>
                <span>reading</span><br>
                community
            </div>
            <p class="desc">
                Ribuan buku menunggumu. Pinjam, baca, dan bagikan ulasanmu bersama komunitas pembaca Rell-Book.
            </p>
            <div class="badges">
                <span class="badge-item">📚 Koleksi Lengkap</span>
                <span class="badge-item">🔄 Pinjam Mudah</span>
                <span class="badge-item">⭐ Beri Ulasan</span>
            </div>
        </div>
    </div>

</div>

<script>
function togglePwd(id, btn) {
    const input = document.getElementById(id);
    const icon  = btn.querySelector('i');
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.replace('bi-eye-slash', 'bi-eye');
    } else {
        input.type = 'password';
        icon.classList.replace('bi-eye', 'bi-eye-slash');
    }
}

function previewAvatar(input) {
    const file = input.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = e => {
        const img  = document.getElementById('avatarImg');
        const init = document.getElementById('avatarInitial');
        img.src          = e.target.result;
        img.style.display   = 'block';
        init.style.display  = 'none';
    };
    reader.readAsDataURL(file);
}

// Update inisial saat nama diketik
document.querySelector('input[name="name"]')?.addEventListener('input', function () {
    const img  = document.getElementById('avatarImg');
    const init = document.getElementById('avatarInitial');
    if (img.style.display === 'none' || !img.src) {
        init.textContent = this.value.charAt(0).toUpperCase() || '?';
    }
});

// Validasi password match
document.getElementById('registerForm')?.addEventListener('submit', function (e) {
    const pass    = document.getElementById('regPassword').value;
    const confirm = document.getElementById('confirmPassword').value;
    if (pass !== confirm) {
        e.preventDefault();
        alert('Password dan konfirmasi password tidak cocok!');
    }
});
</script>

</body>
</html>
