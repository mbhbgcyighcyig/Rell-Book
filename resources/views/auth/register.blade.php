<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - {{ config('app.name', 'Rel-Book') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #F3EBD0 0%, #afafb0 50%, #F3EBD0 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
            position: relative;
            overflow-x: hidden;
        }

        /* Animasi buku berterbangan */
        .floating-book {
            position: fixed;
            pointer-events: none;
            z-index: 0;
            opacity: 0.6;
            animation: floatBook 15s infinite ease-in-out;
        }

        @keyframes floatBook {
            0% {
                transform: translateY(0) rotate(0deg);
                opacity: 0.3;
            }
            50% {
                transform: translateY(-40px) rotate(5deg);
                opacity: 0.7;
            }
            100% {
                transform: translateY(0) rotate(0deg);
                opacity: 0.3;
            }
        }

        /* Efek partikel bintang */
        .star {
            position: fixed;
            background: white;
            border-radius: 50%;
            pointer-events: none;
            z-index: 0;
            animation: twinkle 3s infinite;
        }

        @keyframes twinkle {
            0%, 100% { opacity: 0.2; transform: scale(1); }
            50% { opacity: 1; transform: scale(1.2); }
        }

        /* Container utama - dua kolom */
        .auth-wrapper {
            max-width: 1200px;
            width: 100%;
            display: flex;
            border-radius: 2rem;
            overflow: hidden;
            box-shadow: 0 25px 50px -12px rgba(255, 255, 255, 0.5);
            position: relative;
            z-index: 2;
            backdrop-filter: blur(2px);
        }

        /* Sisi Kiri - Ilustrasi Buku & Info */
        .illustration-side {
            flex: 1;
            background: linear-gradient(135deg, rgba(216, 215, 231, 0.9), rgba(198, 205, 150, 0.85));
            backdrop-filter: blur(10px);
            padding: 2.5rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .illustration-side::before {
            content: '';
            position: absolute;
            width: 200%;
            height: 200%;
            top: -50%;
            left: -50%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: rotateBg 20s linear infinite;
        }

        @keyframes rotateBg {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        .book-stack {
            position: relative;
            z-index: 2;
            text-align: center;
        }

        .book-3d {
            font-size: 6rem;
            filter: drop-shadow(0 10px 20px rgba(0,0,0,0.3));
            animation: bounceBook 3s ease-in-out infinite;
        }

        @keyframes bounceBook {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-15px); }
        }

        .illustration-side h3 {
            font-size: 2rem;
            font-weight: 800;
            color: white;
            margin: 1.5rem 0 0.5rem;
            text-shadow: 0 2px 10px rgba(0,0,0,0.2);
        }

        .illustration-side p {
            color: rgba(255,255,255,0.9);
            font-size: 0.9rem;
            line-height: 1.6;
            margin-bottom: 2rem;
        }

        .feature-list {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            margin-top: 1rem;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            background: rgba(255,255,255,0.15);
            backdrop-filter: blur(4px);
            border-radius: 1rem;
            padding: 0.8rem 1rem;
            border: 1px solid rgba(255,255,255,0.2);
            transition: all 0.3s;
            animation: slideInLeft 0.6s ease-out;
        }

        .feature-item:hover {
            transform: translateX(8px);
            background: rgba(255,255,255,0.25);
        }

        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .feature-item i {
            font-size: 1.3rem;
            color: #FFD700;
        }

        .feature-item span {
            color: white;
            font-size: 0.85rem;
            font-weight: 500;
        }

        /* Sisi Kanan - Form Registrasi */
        .form-side {
            flex: 1;
            background: rgba(255, 255, 255, 0.98);
            padding: 2.5rem;
            backdrop-filter: blur(2px);
            animation: slideInRight 0.6s ease-out;
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .form-header {
            text-align: center;
            margin-bottom: 1.8rem;
        }

        .form-header .logo-mini {
            width: 55px;
            height: 55px;
            background: linear-gradient(135deg, #4f46e5, #818cf8);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            font-size: 1.6rem;
            color: white;
            box-shadow: 0 8px 20px rgba(79,70,229,0.3);
        }

        .form-header h2 {
            font-size: 1.8rem;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 0.3rem;
        }

        .form-header p {
            color: #64748b;
            font-size: 0.85rem;
        }

        /* Social Login */
        .social-row {
            display: flex;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .social-btn {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.6rem;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 0.7rem 0;
            font-size: 0.85rem;
            font-weight: 500;
            color: #1e293b;
            text-decoration: none;
            transition: all 0.3s;
            cursor: pointer;
        }

        .social-btn:hover {
            background: #4f46e5;
            border-color: #4f46e5;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(79,70,229,0.3);
        }

        .social-btn:hover i {
            color: white;
        }

        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            color: #94a3b8;
            font-size: 0.75rem;
            margin: 1rem 0 1.5rem;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #e2e8f0;
        }

        .divider::before { margin-right: 1rem; }
        .divider::after { margin-left: 1rem; }

        /* Form styling */
        .form-group {
            margin-bottom: 1.2rem;
        }

        .form-group label {
            font-size: 0.8rem;
            font-weight: 600;
            color: #334155;
            margin-bottom: 0.4rem;
            display: block;
        }

        .input-wrapper {
            display: flex;
            align-items: center;
            border: 1.5px solid #e2e8f0;
            border-radius: 12px;
            background: white;
            transition: all 0.3s;
        }

        .input-wrapper:focus-within {
            border-color: #F3EBD0;
            box-shadow: 0 0 0 3px rgba(79,70,229,0.1);
            transform: translateY(-1px);
        }

        .input-icon {
            padding-left: 1rem;
            color: #94a3b8;
            font-size: 1rem;
        }

        .input-wrapper input {
            border: none;
            background: transparent;
            padding: 0.8rem 0.8rem 0.8rem 0.5rem;
            font-size: 0.9rem;
            width: 100%;
            outline: none;
            font-family: 'Inter', sans-serif;
            color: #1e293b;
        }

        .input-wrapper input::placeholder {
            color: #cbd5e1;
        }

        .toggle-pwd {
            background: transparent;
            border: none;
            padding-right: 1rem;
            color: #94a3b8;
            cursor: pointer;
            transition: color 0.2s;
        }

        .toggle-pwd:hover {
            color: #4f46e5;
        }

        .row-group {
            display: flex;
            gap: 1rem;
            margin-bottom: 1.2rem;
        }

        .row-group .form-group {
            flex: 1;
            margin-bottom: 0;
        }

        .btn-register {
            background: linear-gradient(135deg, #e3ffab, #919191);
            border: none;
                    border-radius: 12px;
                    padding: 0.9rem;
                    font-weight: 700;
                    font-size: 0.95rem;
            color: white;
            width: 100%;
            margin-top: 0.5rem;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.6rem;
            cursor: pointer;
        }

        .btn-register:hover {
            background: linear-gradient(135deg, #dfdee9, #4f46e5);
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(79,70,229,0.4);
        }

        .login-link {
            text-align: center;
            margin-top: 1.8rem;
            font-size: 0.85rem;
            color: #64748b;
        }

        .login-link a {
            color: #cccccd;
            font-weight: 700;
            text-decoration: none;
            transition: color 0.2s;
        }

        .login-link a:hover {
            color: #dee2ccc8;
            text-decoration: underline;
        }

        .invalid-feedback {
            font-size: 0.7rem;
            color: #ef4444;
            margin-top: 0.25rem;
        }

        /* Responsive */
        @media (max-width: 900px) {
            .auth-wrapper {
                flex-direction: column;
                max-width: 550px;
            }
            .illustration-side {
                text-align: center;
                padding: 2rem;
            }
            .feature-item {
                justify-content: center;
            }
        }

        @media (max-width: 550px) {
            .form-side {
                padding: 1.8rem;
            }
            .social-row {
                flex-direction: column;
            }
            .row-group {
                flex-direction: column;
                gap: 1.2rem;
            }
        }

        /* Animasi input focus */
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.7; }
        }
    </style>
</head>
<body>

<!-- Floating Books Animation -->
<div class="floating-book" style="top: 10%; left: 5%; font-size: 3rem;">📚</div>
<div class="floating-book" style="top: 70%; left: 85%; font-size: 2.5rem; animation-delay: -3s;">📖</div>
<div class="floating-book" style="top: 40%; left: 90%; font-size: 2rem; animation-delay: -6s;">📕</div>
<div class="floating-book" style="top: 80%; left: 10%; font-size: 3.5rem; animation-delay: -2s;">📘</div>
<div class="floating-book" style="top: 20%; left: 80%; font-size: 2.8rem; animation-delay: -5s;">📗</div>
<div class="floating-book" style="top: 60%; left: 3%; font-size: 2.2rem; animation-delay: -4s;">📙</div>
<div class="floating-book" style="top: 85%; left: 92%; font-size: 2rem; animation-delay: -1s;">📚</div>

<script>
    // Bintang bertebaran
    for (let i = 0; i < 50; i++) {
        const star = document.createElement('div');
        star.className = 'star';
        star.style.left = Math.random() * 100 + '%';
        star.style.top = Math.random() * 100 + '%';
        star.style.width = Math.random() * 3 + 1 + 'px';
        star.style.height = star.style.width;
        star.style.animationDelay = Math.random() * 5 + 's';
        star.style.animationDuration = Math.random() * 3 + 2 + 's';
        document.body.appendChild(star);
    }
</script>

<div class="auth-wrapper">
    <!-- Sisi Kiri: Ilustrasi Buku -->
    <div class="illustration-side">
        <div class="book-stack">
            <div class="book-3d">
                <i class="bi bi-book-half"></i>
                <i class="bi bi-journal-bookmark-fill" style="margin-left: 0.5rem;"></i>
                <i class="bi bi-bookmark-star-fill" style="margin-left: 0.5rem;"></i>
            </div>
            <h3>Rel-Book<br>Library</h3>
            <p>Temukan ribuan koleksi buku terbaik. Baca, pinjam, dan kelola perpustakaan digital dengan mudah.</p>
        </div>

        <div class="feature-list">
            <div class="feature-item" style="animation-delay: 0.1s;">
                <i class="bi bi-collection"></i>
                <span>📚 10.000+ Koleksi Buku</span>
            </div>
            <div class="feature-item" style="animation-delay: 0.2s;">
                <i class="bi bi-arrow-repeat"></i>
                <span>🔄 Peminjaman & Pengembalian Otomatis</span>
            </div>
            <div class="feature-item" style="animation-delay: 0.3s;">
                <i class="bi bi-graph-up"></i>
                <span>📊 Laporan Statistik Real-time</span>
            </div>
            <div class="feature-item" style="animation-delay: 0.4s;">
                <i class="bi bi-shield-check"></i>
                <span>🔐 3 Level Akses (Admin, Petugas, Anggota)</span>
            </div>
            <div class="feature-item" style="animation-delay: 0.5s;">
                <i class="bi bi-wifi"></i>
                <span>🌐 Baca Online & Offline</span>
            </div>
        </div>
    </div>

    <!-- Sisi Kanan: Form Registrasi -->
    <div class="form-side">
        <div class="form-header">
            <div class="logo-mini">
                <i class="bi bi-person-plus-fill"></i>
            </div>
            <h2>Buat Akun Baru</h2>
            <p>Daftar sekarang dan nikmati kemudahan membaca</p>
        </div>

        <!-- Social Login -->
        <div class="social-row">
            <a href="#" class="social-btn" onclick="event.preventDefault(); alert('Demo: Daftar dengan Google');">
                <i class="bi bi-google"></i> Google
            </a>
            <a href="#" class="social-btn" onclick="event.preventDefault(); alert('Demo: Daftar dengan GitHub');">
                <i class="bi bi-github"></i> GitHub
            </a>
        </div>

        <div class="divider">atau daftar dengan email</div>

        <!-- Form Registrasi Laravel (Logika Tetap) -->
        <form method="POST" action="{{ route('register') }}" id="registerForm" enctype="multipart/form-data">
            @csrf

            <!-- Foto Profil -->
            <div class="form-group">
                <label>Foto Profil</label>
                <div style="display:flex;align-items:center;gap:12px">
                    <div id="avatarPreview"
                         style="width:64px;height:64px;border-radius:50%;overflow:hidden;flex-shrink:0;
                                background:linear-gradient(135deg,#4f46e5,#818cf8);
                                display:flex;align-items:center;justify-content:center;
                                font-size:1.4rem;color:#fff;font-weight:700;border:2px solid #e2e8f0">
                        <span id="avatarInitial">?</span>
                        <img id="avatarImg" src="" style="display:none;width:100%;height:100%;object-fit:cover">
                    </div>
                    <div style="flex:1">
                        <label for="avatarInput"
                               style="display:inline-flex;align-items:center;gap:6px;cursor:pointer;
                                      background:#f8fafc;border:1.5px dashed #cbd5e1;border-radius:8px;
                                      padding:8px 14px;font-size:.8rem;color:#64748b;transition:.2s"
                               onmouseover="this.style.borderColor='#4f46e5';this.style.color='#4f46e5'"
                               onmouseout="this.style.borderColor='#cbd5e1';this.style.color='#64748b'">
                            <i class="bi bi-camera"></i> Pilih Foto
                        </label>
                        <input type="file" name="avatar" id="avatarInput"
                               accept="image/*" style="display:none"
                               onchange="previewAvatar(this)">
                        <div style="font-size:.7rem;color:#94a3b8;margin-top:4px">JPG/PNG, maks 2MB (opsional)</div>
                        @error('avatar')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            <!-- Nama Lengkap -->
            <div class="form-group">
                <label>Nama Lengkap</label>
                <div class="input-wrapper">
                    <span class="input-icon"><i class="bi bi-person"></i></span>
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="Masukkan nama lengkap" required autofocus>
                </div>
                @error('name')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
            </div>

            <!-- Email -->
            <div class="form-group">
                <label>Alamat Email</label>
                <div class="input-wrapper">
                    <span class="input-icon"><i class="bi bi-envelope"></i></span>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="email@contoh.com" required>
                </div>
                @error('email')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
            </div>

            <!-- Phone & Address -->
            <div class="row-group">
                <div class="form-group">
                    <label>No. Telepon</label>
                    <div class="input-wrapper">
                        <span class="input-icon"><i class="bi bi-telephone"></i></span>
                        <input type="text" name="phone" value="{{ old('phone') }}" placeholder="08xx">
                    </div>
                    @error('phone')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label>Alamat</label>
                    <div class="input-wrapper">
                        <span class="input-icon"><i class="bi bi-geo-alt"></i></span>
                        <input type="text" name="address" value="{{ old('address') }}" placeholder="Alamat (opsional)">
                    </div>
                    @error('address')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div>
            </div>

            <!-- Password -->
            <div class="form-group">
                <label>Password</label>
                <div class="input-wrapper">
                    <span class="input-icon"><i class="bi bi-lock"></i></span>
                    <input type="password" name="password" id="regPassword" placeholder="Minimal 8 karakter" required>
                    <button type="button" class="toggle-pwd" onclick="togglePassword('regPassword', this)">
                        <i class="bi bi-eye-slash"></i>
                    </button>
                </div>
                @error('password')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
            </div>

            <!-- Konfirmasi Password -->
            <div class="form-group">
                <label>Konfirmasi Password</label>
                <div class="input-wrapper">
                    <span class="input-icon"><i class="bi bi-shield-lock"></i></span>
                    <input type="password" name="password_confirmation" id="confirmPassword" placeholder="Ulangi password" required>
                    <button type="button" class="toggle-pwd" onclick="togglePassword('confirmPassword', this)">
                        <i class="bi bi-eye-slash"></i>
                    </button>
                </div>
            </div>

            <button type="submit" class="btn-register">
                <i class="bi bi-person-check-fill"></i> Daftar Sekarang
            </button>
        </form>

        <div class="login-link">
            Sudah punya akun? <a href="{{ route('login') }}">Masuk ke Dashboard</a>
        </div>
    </div>
</div>

<script>
    function togglePassword(fieldId, btnElement) {
        const input = document.getElementById(fieldId);
        if (!input) return;
        const type = input.type === 'password' ? 'text' : 'password';
        input.type = type;
        const icon = btnElement.querySelector('i');
        if (icon) {
            if (type === 'text') {
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            } else {
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            }
        }
    }

    // Preview avatar sebelum upload
    function previewAvatar(input) {
        const file = input.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = function(e) {
            const img    = document.getElementById('avatarImg');
            const init   = document.getElementById('avatarInitial');
            img.src      = e.target.result;
            img.style.display   = 'block';
            init.style.display  = 'none';
        };
        reader.readAsDataURL(file);
    }

    // Update inisial saat nama diketik
    document.addEventListener('DOMContentLoaded', function() {
        const nameInput = document.querySelector('input[name="name"]');
        const initial   = document.getElementById('avatarInitial');
        if (nameInput && initial) {
            nameInput.addEventListener('input', function() {
                const img = document.getElementById('avatarImg');
                if (img.style.display === 'none') {
                    initial.textContent = this.value.charAt(0).toUpperCase() || '?';
                }
            });
        }
    });

    // Validasi password match
    const form = document.getElementById('registerForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            const pass = document.getElementById('regPassword').value;
            const confirm = document.getElementById('confirmPassword').value;
            if (pass !== confirm) {
                e.preventDefault();
                alert('Password dan konfirmasi password tidak cocok!');
            }
        });
    }

    // Social buttons prevent default
    document.querySelectorAll('.social-btn').forEach(btn => {
        btn.addEventListener('click', (e) => e.preventDefault());
    });

    // Efek floating book position adjustment
    window.addEventListener('resize', () => {
        console.log('Responsive adjusted');
    });
</script>
</body>
</html>