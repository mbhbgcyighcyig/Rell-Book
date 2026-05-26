<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Login - {{ config('app.name') }}</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,700;0,800;1,700&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<style>
* { margin: 0; padding: 0; box-sizing: border-box; }

body {
    font-family: 'Inter', sans-serif;
    height: 100vh;
    display: flex;
    overflow: hidden;
    background: #f3eadf;
}

/* ── LEFT: FULL IMAGE ── */
.left {
    flex: 1;
    position: relative;
    background: url('{{ asset("images/as.jpg") }}') center/cover no-repeat;
    overflow: hidden;
}

/* Warm overlay — lebih gelap di tepi, terang di tengah */
.left::before {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(
        135deg,
        rgba(92,61,30,.78) 0%,
        rgba(139,94,60,.45) 45%,
        rgba(196,154,108,.3) 70%,
        rgba(243,234,223,.15) 100%
    );
}

/* Vignette kanan biar nyambung ke form */
.left::after {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(to right, transparent 60%, rgba(243,234,223,.9) 100%);
}

.left-content {
    position: absolute;
    inset: 0;
    z-index: 2;
    display: flex;
    flex-direction: column;
    justify-content: center;
    padding: 0 10% 0 8%;
}

.admin-badge {
    display: inline-flex;
    align-items: center;
    gap: .5rem;
    background: rgba(255,255,255,.15);
    backdrop-filter: blur(8px);
    border: 1px solid rgba(255,255,255,.3);
    color: #fde8cc;
    font-size: .75rem;
    font-weight: 600;
    padding: .35rem 1rem;
    border-radius: 20px;
    margin-bottom: 1.6rem;
    width: fit-content;
    letter-spacing: .04em;
    text-transform: uppercase;
}

.left-title {
    font-family: 'Playfair Display', serif;
    font-size: clamp(2.8rem, 4.5vw, 4.2rem);
    font-weight: 800;
    color: #fff;
    line-height: 1.12;
    margin-bottom: 1rem;
    text-shadow: 2px 4px 16px rgba(92,61,30,.4);
}

.left-title em {
    font-style: italic;
    color: #f5d5a8;
}

.left-quote {
    font-size: .88rem;
    color: rgba(255,255,255,.78);
    font-style: italic;
    line-height: 1.75;
    margin-bottom: 2.2rem;
    max-width: 380px;
    border-left: 3px solid rgba(245,213,168,.5);
    padding-left: 14px;
}

.left-features {
    display: flex;
    flex-direction: column;
    gap: .7rem;
}

.feat-row {
    display: flex;
    align-items: center;
    gap: .75rem;
    color: rgba(255,255,255,.85);
    font-size: .82rem;
}

.feat-icon {
    width: 34px;
    height: 34px;
    background: rgba(255,255,255,.15);
    backdrop-filter: blur(6px);
    border: 1px solid rgba(255,255,255,.25);
    border-radius: 9px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #f5d5a8;
    font-size: .9rem;
    flex-shrink: 0;
}

/* ── RIGHT: FORM ── */
.right {
    width: 420px;
    flex-shrink: 0;
    background: rgba(243,234,223,.96);
    backdrop-filter: blur(20px);
    display: flex;
    flex-direction: column;
    justify-content: center;
    padding: 3rem 2.8rem;
    position: relative;
    overflow: hidden;
    border-left: 1px solid rgba(196,154,108,.25);
}

/* Subtle warm circle decoration */
.right::before {
    content: '';
    position: absolute;
    width: 280px;
    height: 280px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(230,165,109,.12) 0%, transparent 70%);
    bottom: -80px;
    right: -80px;
    pointer-events: none;
}

.right::after {
    content: '';
    position: absolute;
    width: 180px;
    height: 180px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(196,154,108,.1) 0%, transparent 70%);
    top: -60px;
    left: -40px;
    pointer-events: none;
}

/* Logo */
.logo-row {
    display: flex;
    align-items: center;
    gap: 2px;
    margin-bottom: 2.2rem;
    position: relative;
    z-index: 1;
}

.logo-row img {
    width: 52px;
    height: 52px;
    object-fit: contain;
}

.logo-text .name {
    font-family: 'Georgia', serif;
    font-weight: 700;
    font-size: 1.05rem;
    color: #d19173;
    letter-spacing: .01em;
    line-height: 1.2;
}

.logo-text .sub {
    font-size: .72rem;
    color: #9c7c5c;
    font-style: italic;
    letter-spacing: .04em;
}

/* Shield */
.shield-wrap {
    width: 52px;
    height: 52px;
    background: linear-gradient(135deg, #e6a56d, #c47a3a);
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.35rem;
    color: #fff;
    margin-bottom: 1.1rem;
    box-shadow: 0 6px 20px rgba(230,165,109,.35);
    position: relative;
    z-index: 1;
}

.form-title {
    font-size: 1.35rem;
    font-weight: 800;
    color: #3d2b1a;
    margin-bottom: .25rem;
    position: relative;
    z-index: 1;
}

.form-sub {
    font-size: .78rem;
    color: #9c7c5c;
    margin-bottom: 1.8rem;
    position: relative;
    z-index: 1;
}

/* Alert */
.alert-err {
    background: rgba(220,38,38,.08);
    border: 1px solid rgba(220,38,38,.2);
    border-radius: 10px;
    color: #b91c1c;
    font-size: .78rem;
    padding: .6rem .9rem;
    margin-bottom: 1.1rem;
    display: flex;
    align-items: center;
    gap: .5rem;
    position: relative;
    z-index: 1;
}

.alert-ok {
    background: rgba(5,150,105,.08);
    border: 1px solid rgba(5,150,105,.2);
    border-radius: 10px;
    color: #065f46;
    font-size: .78rem;
    padding: .6rem .9rem;
    margin-bottom: 1.1rem;
    display: flex;
    align-items: center;
    gap: .5rem;
    position: relative;
    z-index: 1;
}

/* Field */
.field-label {
    display: block;
    font-size: .73rem;
    font-weight: 600;
    color: #7a5c3c;
    margin-bottom: .4rem;
    letter-spacing: .02em;
    position: relative;
    z-index: 1;
}

.input-wrap {
    display: flex;
    align-items: center;
    background: rgba(255,255,255,.7);
    border: 1.5px solid rgba(196,154,108,.3);
    border-radius: 12px;
    margin-bottom: 1rem;
    transition: .2s;
    position: relative;
    z-index: 1;
}

.input-wrap:focus-within {
    background: rgba(255,255,255,.92);
    border-color: #e6a56d;
    box-shadow: 0 0 0 3px rgba(230,165,109,.15);
}

.input-icon {
    padding: 0 10px 0 13px;
    color: #c4956a;
    font-size: .95rem;
    flex-shrink: 0;
}

.input-wrap input {
    flex: 1;
    border: none;
    background: transparent;
    padding: 11px 10px 11px 0;
    font-family: 'Inter', sans-serif;
    font-size: .875rem;
    color: #3d2b1a;
    outline: none;
}

.input-wrap input::placeholder { color: #c4a882; }

.toggle-btn {
    border: none;
    background: none;
    padding: 0 12px;
    cursor: pointer;
    color: #c4956a;
    font-size: .95rem;
    transition: color .2s;
}

.toggle-btn:hover { color: #e6a56d; }

/* Remember */
.remember-row {
    display: flex;
    align-items: center;
    gap: .5rem;
    margin-bottom: 1.4rem;
    position: relative;
    z-index: 1;
}

.remember-row input {
    accent-color: #e6a56d;
    width: 15px;
    height: 15px;
    cursor: pointer;
}

.remember-row label {
    font-size: .78rem;
    color: #7a5c3c;
    cursor: pointer;
}

/* Submit */
.btn-submit {
    width: 100%;
    padding: 13px;
    border-radius: 28px;
    background: #e6a56d;
    color: #fff;
    border: none;
    cursor: pointer;
    transition: .2s;
    font-size: .9rem;
    font-weight: 700;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: .5rem;
    position: relative;
    z-index: 1;
}

.btn-submit:hover {
    background: #d1905c;
    transform: translateY(-1px);
    box-shadow: 0 8px 22px rgba(230,165,109,.35);
}

/* Security note */
.security-note {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: .4rem;
    margin-top: 1.1rem;
    font-size: .68rem;
    color: #b89a7a;
    position: relative;
    z-index: 1;
}

/* Back link */
.back-link {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: .4rem;
    margin-top: .85rem;
    font-size: .75rem;
    color: #b89a7a;
    text-decoration: none;
    transition: color .2s;
    position: relative;
    z-index: 1;
}

.back-link:hover { color: #e6a56d; }

/* Responsive */
@media (max-width: 768px) {
    .left { display: none; }
    .right { width: 100%; padding: 2.5rem 1.8rem; }
}
</style>
</head>
<body>

{{-- LEFT: IMAGE + TEXT --}}
<div class="left">
    <div class="left-content">
        <div class="admin-badge">
            <i class="bi bi-shield-lock-fill"></i> Administrator Access
        </div>

        <h1 class="left-title">
            Perpustakaan<br><em>Digital</em>
        </h1>

        <p class="left-quote">
            "Membaca adalah jendela dunia,<br>dan admin adalah penjaganya."
        </p>

        <div class="left-features">
            <div class="feat-row">
                <div class="feat-icon"><i class="bi bi-collection-fill"></i></div>
                Kelola koleksi buku perpustakaan
            </div>
            <div class="feat-row">
                <div class="feat-icon"><i class="bi bi-people-fill"></i></div>
                Kelola pengguna & petugas
            </div>
            <div class="feat-row">
                <div class="feat-icon"><i class="bi bi-bar-chart-line-fill"></i></div>
                Lihat statistik penggunaan
            </div>
        </div>
    </div>
</div>

{{-- RIGHT: FORM --}}
<div class="right">

    {{-- Logo --}}
    <div class="logo-row">
        <img src="{{ asset('images/pipi.png') }}" alt="Logo">
        <div class="logo-text">
            <div class="name">Rell-Book</div>
            <div class="sub">Digital Library</div>
        </div>
    </div>

    <div class="shield-wrap">
        <i class="bi bi-shield-lock-fill"></i>
    </div>

    <div class="form-title">Administrator Panel</div>
    <div class="form-sub">Akses terbatas &mdash; hanya untuk admin</div>

    @if(session('success'))
    <div class="alert-ok"><i class="bi bi-check-circle-fill"></i> {{ session('success') }}</div>
    @endif

    @if($errors->any())
    <div class="alert-err"><i class="bi bi-shield-exclamation"></i> {{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('admin.login.post') }}">
        @csrf

        <label class="field-label">Email Administrator</label>
        <div class="input-wrap">
            <span class="input-icon"><i class="bi bi-person-badge"></i></span>
            <input type="email" name="email" value="{{ old('email') }}"
                   placeholder="admin@perpus.com" required autofocus>
        </div>

        <label class="field-label">Password</label>
        <div class="input-wrap">
            <span class="input-icon"><i class="bi bi-key-fill"></i></span>
            <input type="password" name="password" id="adminPwd"
                   placeholder="••••••••" required>
            <button type="button" class="toggle-btn" onclick="togglePwd()">
                <i class="bi bi-eye-slash" id="eyeIcon"></i>
            </button>
        </div>

        <div class="remember-row">
            <input type="checkbox" name="remember" id="remember">
            <label for="remember">Ingat sesi ini</label>
        </div>

        <button type="submit" class="btn-submit">
            <i class="bi bi-shield-check"></i> Masuk sebagai Administrator
        </button>
    </form>

    <div class="security-note">
        <i class="bi bi-lock-fill"></i>
        Koneksi aman &bull; Sesi terenkripsi &bull; Akses dicatat
    </div>

    <a href="{{ route('login') }}" class="back-link">
        <i class="bi bi-arrow-left"></i> Kembali ke login umum
    </a>

</div>

<script>
function togglePwd() {
    const input = document.getElementById('adminPwd');
    const icon  = document.getElementById('eyeIcon');
    input.type  = input.type === 'password' ? 'text' : 'password';
    icon.className = 'bi bi-eye' + (input.type === 'text' ? '' : '-slash');
}
</script>
</body>
</html>
