<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - {{ config('app.name') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Playfair+Display:wght@700;800&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            height: 100vh;
            display: flex;
            overflow: hidden;
            background: #060b18;
        }

        /* ── LEFT — Teks & Ilustrasi ── */
        .left-panel {
            flex: 1;
            position: relative;
            background: url('https://images.unsplash.com/photo-1507842217343-583bb7270b66?w=1200&q=80') center/cover no-repeat;
            display: flex;
            align-items: center;
            justify-content: flex-start;
            padding: 0 5%;
            overflow: hidden;
        }
        .left-panel::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg,
                rgba(6,11,24,.85) 0%,
                rgba(30,27,75,.75) 50%,
                rgba(6,11,24,.6) 100%);
        }
        /* Grid overlay */
        .left-panel::after {
            content: '';
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(99,102,241,.06) 1px, transparent 1px),
                linear-gradient(90deg, rgba(99,102,241,.06) 1px, transparent 1px);
            background-size: 40px 40px;
        }

        .left-content {
            position: relative;
            z-index: 2;
            max-width: 520px;
        }

        .left-badge {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            background: rgba(99,102,241,.2);
            border: 1px solid rgba(99,102,241,.35);
            color: #a5b4fc;
            font-size: .78rem;
            font-weight: 600;
            padding: .35rem .9rem;
            border-radius: 20px;
            margin-bottom: 1.5rem;
            animation: fadeUp .6s ease both;
        }

        .left-title {
            font-family: 'Playfair Display', serif;
            font-size: clamp(2.5rem, 5vw, 4rem);
            font-weight: 800;
            color: #fff;
            line-height: 1.15;
            margin-bottom: 1rem;
            animation: fadeUp .8s ease both;
        }
        .left-title span {
            background: linear-gradient(135deg, #818cf8, #c084fc);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .left-quote {
            color: #94a3b8;
            font-size: .95rem;
            font-style: italic;
            line-height: 1.7;
            margin-bottom: 2rem;
            animation: fadeUp 1s ease both;
        }

        .left-features {
            display: flex;
            flex-direction: column;
            gap: .75rem;
            animation: fadeUp 1.2s ease both;
        }
        .feature-row {
            display: flex;
            align-items: center;
            gap: .75rem;
            color: #cbd5e1;
            font-size: .85rem;
        }
        .feature-row i {
            width: 32px; height: 32px;
            background: rgba(99,102,241,.2);
            border: 1px solid rgba(99,102,241,.3);
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            color: #818cf8;
            font-size: .9rem;
            flex-shrink: 0;
        }

        /* Floating orbs */
        .orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(60px);
            pointer-events: none;
            z-index: 1;
        }
        .orb-1 { width: 300px; height: 300px; background: rgba(79,70,229,.25); top: -80px; right: -80px; animation: float 8s ease-in-out infinite; }
        .orb-2 { width: 200px; height: 200px; background: rgba(139,92,246,.2); bottom: 10%; left: 30%; animation: float 10s ease-in-out infinite reverse; }

        @keyframes float {
            0%,100% { transform: translate(0,0); }
            50% { transform: translate(20px, -20px); }
        }
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(24px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ── RIGHT — Form ── */
        .right-panel {
            width: 440px;
            flex-shrink: 0;
            background: #0a0f1e;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 2.5rem;
            position: relative;
            overflow: hidden;
            border-left: 1px solid rgba(99,102,241,.15);
        }
        .right-panel::before {
            content: '';
            position: absolute;
            width: 300px; height: 300px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(79,70,229,.12) 0%, transparent 70%);
            bottom: -100px; right: -100px;
        }

        /* Shield icon */
        .shield-wrap {
            width: 60px; height: 60px;
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            border-radius: 16px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.5rem; color: #fff;
            margin-bottom: 1.25rem;
            box-shadow: 0 8px 24px rgba(79,70,229,.4);
            position: relative;
            animation: fadeUp .5s ease both;
        }
        .shield-wrap::after {
            content: '';
            position: absolute;
            inset: -3px;
            border-radius: 19px;
            border: 1px solid rgba(99,102,241,.4);
            animation: pulse 2s ease-in-out infinite;
        }
        @keyframes pulse {
            0%,100% { opacity: .5; transform: scale(1); }
            50% { opacity: 1; transform: scale(1.05); }
        }

        .form-title { color: #f1f5f9; font-weight: 800; font-size: 1.3rem; margin-bottom: .25rem; animation: fadeUp .6s ease both; }
        .form-sub   { color: #475569; font-size: .8rem; margin-bottom: 1.75rem; animation: fadeUp .7s ease both; }

        /* Inputs */
        .field-label { color: #64748b; font-size: .78rem; font-weight: 600; margin-bottom: .4rem; display: block; }
        .input-wrap {
            display: flex;
            background: rgba(30,41,59,.8);
            border: 1.5px solid rgba(99,102,241,.2);
            border-radius: 10px;
            overflow: hidden;
            transition: .2s;
            margin-bottom: 1rem;
        }
        .input-wrap:focus-within {
            border-color: rgba(99,102,241,.6);
            box-shadow: 0 0 0 3px rgba(79,70,229,.12);
        }
        .input-icon {
            width: 42px;
            display: flex; align-items: center; justify-content: center;
            color: #475569; font-size: .9rem; flex-shrink: 0;
        }
        .input-wrap input {
            flex: 1;
            background: transparent;
            border: none;
            outline: none;
            color: #e2e8f0;
            font-size: .875rem;
            padding: .65rem .5rem .65rem 0;
            font-family: 'Inter', sans-serif;
        }
        .input-wrap input::placeholder { color: #334155; }
        .toggle-btn {
            background: none; border: none;
            color: #475569; padding: 0 12px;
            cursor: pointer; transition: .2s;
        }
        .toggle-btn:hover { color: #94a3b8; }

        /* Error */
        .err-msg {
            background: rgba(239,68,68,.1);
            border: 1px solid rgba(239,68,68,.25);
            border-radius: 8px;
            color: #fca5a5;
            font-size: .8rem;
            padding: .65rem .9rem;
            margin-bottom: 1rem;
            display: flex; align-items: center; gap: .5rem;
        }
        .ok-msg {
            background: rgba(16,185,129,.1);
            border: 1px solid rgba(16,185,129,.25);
            border-radius: 8px;
            color: #6ee7b7;
            font-size: .8rem;
            padding: .65rem .9rem;
            margin-bottom: 1rem;
            display: flex; align-items: center; gap: .5rem;
        }

        /* Remember */
        .remember-row { display: flex; align-items: center; gap: .5rem; margin-bottom: 1.25rem; }
        .remember-row input { accent-color: #4f46e5; width: 15px; height: 15px; cursor: pointer; }
        .remember-row label { color: #475569; font-size: .78rem; cursor: pointer; }

        /* Submit */
        .btn-submit {
            width: 100%;
            padding: .75rem;
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            border: none;
            border-radius: 10px;
            color: #fff;
            font-weight: 700;
            font-size: .88rem;
            cursor: pointer;
            transition: .2s;
            display: flex; align-items: center; justify-content: center; gap: .5rem;
        }
        .btn-submit:hover { transform: translateY(-1px); box-shadow: 0 8px 24px rgba(79,70,229,.4); }

        /* Security */
        .security-row {
            display: flex; align-items: center; justify-content: center; gap: .5rem;
            margin-top: 1.25rem;
            color: #1e293b;
            font-size: .7rem;
        }
        .security-row i { color: #4f46e5; }

        /* Back */
        .back-link {
            display: flex; align-items: center; justify-content: center; gap: .4rem;
            margin-top: 1rem;
            color: #334155;
            font-size: .75rem;
            text-decoration: none;
            transition: .2s;
        }
        .back-link:hover { color: #64748b; }

        @media (max-width: 768px) {
            .left-panel { display: none; }
            .right-panel { width: 100%; }
        }
    </style>
</head>
<body>

{{-- LEFT — Teks & Ilustrasi --}}
<div class="left-panel">
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>

    <div class="left-content">
        <div class="left-badge">
            <i class="bi bi-shield-lock-fill"></i> Administrator Access
        </div>

        <h1 class="left-title">
            Perpustakaan<br><span>Digital</span>
        </h1>

        <p class="left-quote">
            "Membaca adalah jendela dunia,<br>dan admin adalah penjaganya."
        </p>

        <div class="left-features">
            <div class="feature-row">
                <i class="bi bi-collection-fill"></i>
                Kelola koleksi buku perpustakaan
            </div>
            <div class="feature-row">
                <i class="bi bi-people-fill"></i>
                Kelola pengguna & petugas
            </div>
            <div class="feature-row">
                <i class="bi bi-bar-chart-line-fill"></i>
                Lihat statistik penggunaan
            </div>
        </div>
    </div>
</div>

{{-- RIGHT — Form --}}
<div class="right-panel">
    <div class="shield-wrap">
        <i class="bi bi-shield-lock-fill"></i>
    </div>

    <div class="form-title">Administrator Panel</div>
    <div class="form-sub">Akses terbatas &mdash; hanya untuk admin</div>

    @if(session('success'))
    <div class="ok-msg"><i class="bi bi-check-circle-fill"></i> {{ session('success') }}</div>
    @endif

    @if($errors->any())
    <div class="err-msg"><i class="bi bi-shield-exclamation"></i> {{ $errors->first() }}</div>
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
                <i class="bi bi-eye" id="eyeIcon"></i>
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

    <div class="security-row">
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
    icon.className = 'bi bi-eye' + (input.type === 'text' ? '-slash' : '');
}
</script>
</body>
</html>
