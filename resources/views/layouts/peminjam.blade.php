<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Perpustakaan') - {{ config('app.name') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700;800&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --cream:      #f5efe6;
            --cream-dark: #ede0cc;
            --cream-card: #fdf8f2;
            --brown:      #8b5e3c;
            --brown-light:#c49a6c;
            --brown-dark: #5c3d1e;
            --text:       #3d2b1f;
            --text-muted: #9c7c5c;
            --nav-h:      68px;
        }
        * { box-sizing: border-box; }
        body {
            background: var(--cream);
            font-family: 'Inter', sans-serif;
            font-size: .9rem;
            color: var(--text);
            padding-top: var(--nav-h);
            position: relative;
            overflow-x: hidden;
        }

        /* ── Background Image + Cream Overlay ── */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background: url('{{ asset("images/uanh.jpg") }}') center/cover no-repeat fixed;
            z-index: -2;
            filter: saturate(0.85) brightness(0.95);
        }
        body::after {
            content: '';
            position: fixed;
            inset: 0;
            background:
                radial-gradient(ellipse at 50% 40%, rgba(245,239,230,0.45) 0%, rgba(237,224,204,0.68) 55%, rgba(220,200,175,0.88) 100%);
            z-index: -1;
        }

        /* ── Animated Background ── */
        .bg-canvas {
            position: fixed;
            inset: 0;
            z-index: 0;
            pointer-events: none;
            overflow: hidden;
        }

        /* Subtle paper texture */
        .bg-canvas::before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                radial-gradient(ellipse 80% 60% at 10% 20%, rgba(196,154,108,.12) 0%, transparent 60%),
                radial-gradient(ellipse 60% 80% at 90% 80%, rgba(139,94,60,.08) 0%, transparent 60%),
                radial-gradient(ellipse 50% 50% at 50% 50%, rgba(245,239,230,.6) 0%, transparent 100%);
        }

        /* Floating book icons */
        .float-book {
            position: absolute;
            font-family: 'Playfair Display', serif;
            color: rgba(139,94,60,.35);
            font-weight: 800;
            user-select: none;
            animation: floatUp linear infinite;
        }

        /* Floating quotes */
        .float-quote {
            position: absolute;
            font-family: 'Playfair Display', serif;
            font-style: italic;
            color: rgba(92,61,30,.55);
            font-weight: 800;
            user-select: none;
            white-space: nowrap;
            animation: floatDrift linear infinite;
            text-shadow: 0 1px 6px rgba(255,249,242,.6);
            letter-spacing: .01em;
        }

        @keyframes floatUp {
            0%   { transform: translateY(110vh) rotate(-8deg); opacity: 0; }
            5%   { opacity: 1; }
            95%  { opacity: 1; }
            100% { transform: translateY(-15vh) rotate(8deg); opacity: 0; }
        }
        @keyframes floatDrift {
            0%   { transform: translateX(-20vw) translateY(0) rotate(-3deg); opacity: 0; }
            8%   { opacity: 1; }
            92%  { opacity: 1; }
            100% { transform: translateX(110vw) translateY(-30px) rotate(3deg); opacity: 0; }
        }

        /* Page content sits above bg */
        .p-page, .p-navbar, .p-footer { position: relative; z-index: 1; }

        /* ── Navbar ── */
        .p-navbar {
            height: var(--nav-h);
            background: rgba(255,249,242,0.92);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(237,224,204,0.8);
            position: fixed; top: 0; left: 0; right: 0;
            z-index: 1000;
            display: flex; align-items: center;
            padding: 0 2rem;
            box-shadow: 0 2px 16px rgba(139,94,60,.08);
        }
        .p-brand {
            display: flex; align-items: center; gap: .65rem;
            text-decoration: none; flex-shrink: 0;
        }
        .p-brand-icon {
            width: 38px; height: 38px;
            background: linear-gradient(135deg, var(--brown), var(--brown-light));
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-size: 1rem;
            box-shadow: 0 3px 8px rgba(139,94,60,.3);
        }
        .p-brand-name {
            font-family: 'Playfair Display', serif;
            font-weight: 700; font-size: 1.05rem;
            color: var(--brown-dark);
        }
        .p-brand-name span { color: var(--brown); }

        .p-nav-links {
            display: flex; align-items: center; gap: .15rem;
            margin: 0 1.5rem; flex: 1;
        }
        .p-nav-link {
            display: flex; align-items: center; gap: .45rem;
            color: var(--text-muted); text-decoration: none;
            padding: .5rem .9rem; border-radius: 8px;
            font-size: .84rem; font-weight: 500; transition: .18s;
        }
        .p-nav-link:hover { background: var(--cream-dark); color: var(--brown); }
        .p-nav-link.active {
            background: var(--cream-dark);
            color: var(--brown-dark); font-weight: 600;
        }
        .p-nav-dot {
            width: 6px; height: 6px; border-radius: 50%;
            background: #dc2626; flex-shrink: 0;
        }

        .p-search {
            display: flex; align-items: center;
            background: var(--cream);
            border: 1.5px solid var(--cream-dark);
            border-radius: 10px; padding: .4rem .85rem;
            gap: .5rem; width: 210px; transition: .2s;
        }
        .p-search:focus-within {
            border-color: var(--brown-light);
            box-shadow: 0 0 0 3px rgba(196,154,108,.15);
            background: #fff;
        }
        .p-search input {
            border: none; background: transparent; outline: none;
            font-size: .82rem; color: var(--text); width: 100%;
        }
        .p-search input::placeholder { color: var(--text-muted); }
        .p-search i { color: var(--text-muted); font-size: .85rem; }

        .p-user-btn {
            display: flex; align-items: center; gap: .6rem;
            background: var(--cream); border: 1.5px solid var(--cream-dark);
            border-radius: 10px; padding: .4rem .85rem .4rem .5rem;
            cursor: pointer; transition: .18s; text-decoration: none;
            color: var(--text); margin-left: .75rem;
        }
        .p-user-btn:hover { border-color: var(--brown-light); background: var(--cream-dark); }
        .p-avatar {
            width: 30px; height: 30px; border-radius: 50%;
            background: linear-gradient(135deg, var(--brown), var(--brown-light));
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-weight: 700; font-size: .75rem;
            overflow: hidden; flex-shrink: 0;
        }
        .p-avatar img { width: 100%; height: 100%; object-fit: cover; }
        .p-user-name { font-size: .82rem; font-weight: 600; max-width: 110px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }

        /* ── Content ── */
        .p-page { min-height: calc(100vh - var(--nav-h)); }
        .p-container { max-width: 1180px; margin: 0 auto; padding: 2rem 1.5rem; }

        /* ── Cards ── */
        .card {
            border: 1px solid rgba(237,224,204,0.7);
            border-radius: 14px;
            background: rgba(253,248,242,0.82);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            box-shadow: 0 2px 12px rgba(139,94,60,.08);
        }
        .card-header {
            background: rgba(255,249,242,0.85);
            border-bottom: 1px solid rgba(237,224,204,0.6);
            font-weight: 600; font-size: .88rem;
            border-radius: 14px 14px 0 0 !important;
            padding: 1rem 1.25rem;
            color: var(--brown-dark);
        }

        /* ── Badges ── */
        .badge-status-borrowed { background: #fef3c7; color: #92400e; }
        .badge-status-returned { background: #d1fae5; color: #065f46; }
        .badge-status-overdue  { background: #fee2e2; color: #991b1b; }

        /* ── Buttons ── */
        .btn-primary {
            background: linear-gradient(135deg, var(--brown), var(--brown-light));
            border: none; border-radius: 8px; font-weight: 500; color: #fff;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, var(--brown-dark), var(--brown));
            transform: translateY(-1px); color: #fff;
            box-shadow: 0 4px 12px rgba(139,94,60,.3);
        }
        .btn-outline-primary {
            border-color: var(--brown-light); color: var(--brown);
        }
        .btn-outline-primary:hover {
            background: var(--brown); border-color: var(--brown); color: #fff;
        }
        .btn { border-radius: 8px; font-size: .85rem; }
        .form-control, .form-select {
            border-radius: 8px; border-color: var(--cream-dark);
            background: #fff9f2; font-size: .875rem; color: var(--text);
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--brown-light);
            box-shadow: 0 0 0 3px rgba(196,154,108,.15);
            background: #fff;
        }
        .alert { border: none; border-radius: 10px; font-size: .875rem; }
        .table th {
            font-size: .72rem; text-transform: uppercase;
            letter-spacing: .06em; color: var(--text-muted); font-weight: 600;
            background: #fff9f2;
        }
        .table td { vertical-align: middle; border-color: var(--cream-dark); }
        .table tbody tr:hover { background: #fdf5ec; }

        /* ── Star Rating ── */
        .star-pick { font-size: 1.4rem; cursor: pointer; color: var(--cream-dark); transition: .15s; }
        .star-pick.active, .star-pick:hover { color: #d97706; }

        /* ── Footer ── */
        .p-footer {
            background: var(--brown-dark);
            color: rgba(255,255,255,.4);
            text-align: center; padding: 1.5rem;
            font-size: .75rem; margin-top: 3rem;
        }
        .p-footer span { color: rgba(255,255,255,.7); }

        /* Dropdown */
        .dropdown-menu {
            border: 1px solid var(--cream-dark);
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(139,94,60,.12);
            background: #fff9f2;
        }
        .dropdown-item:hover { background: var(--cream-dark); color: var(--brown-dark); }
        .dropdown-divider { border-color: var(--cream-dark); }

        @media (max-width: 768px) {
            .p-nav-links, .p-search { display: none !important; }
            .p-navbar { padding: 0 1rem; }
        }
    </style>
    @stack('styles')
</head>
<body>

{{-- ── Animated Background ── --}}
<div class="bg-canvas" aria-hidden="true">
    <svg class="float-book" style="left:5%;animation-duration:22s;animation-delay:0s;top:0" width="60" height="80" viewBox="0 0 60 80">
        <rect x="8" y="0" width="52" height="72" rx="4" fill="rgba(139,94,60,.38)" stroke="rgba(139,94,60,.55)" stroke-width="1.5"/>
        <rect x="8" y="0" width="9" height="72" rx="3" fill="rgba(92,61,30,.45)"/>
        <rect x="22" y="14" width="28" height="3" rx="1.5" fill="rgba(255,255,255,.35)"/>
        <rect x="22" y="22" width="20" height="2" rx="1" fill="rgba(255,255,255,.25)"/>
        <rect x="22" y="34" width="26" height="1.5" rx=".75" fill="rgba(255,255,255,.2)"/>
        <rect x="22" y="40" width="22" height="1.5" rx=".75" fill="rgba(255,255,255,.2)"/>
    </svg>
    <svg class="float-book" style="left:20%;animation-duration:28s;animation-delay:4s;top:0" width="45" height="62" viewBox="0 0 45 62">
        <rect x="6" y="0" width="39" height="56" rx="3" fill="rgba(196,154,108,.42)" stroke="rgba(196,154,108,.6)" stroke-width="1.5"/>
        <rect x="6" y="0" width="7" height="56" rx="2" fill="rgba(139,94,60,.5)"/>
        <rect x="17" y="10" width="22" height="2.5" rx="1.25" fill="rgba(255,255,255,.3)"/>
        <rect x="17" y="26" width="20" height="1.5" rx=".75" fill="rgba(255,255,255,.22)"/>
        <rect x="17" y="32" width="18" height="1.5" rx=".75" fill="rgba(255,255,255,.22)"/>
    </svg>
    <svg class="float-book" style="left:42%;animation-duration:35s;animation-delay:8s;top:0" width="70" height="95" viewBox="0 0 70 95">
        <rect x="10" y="0" width="60" height="88" rx="5" fill="rgba(139,94,60,.32)" stroke="rgba(139,94,60,.5)" stroke-width="1.5"/>
        <rect x="10" y="0" width="11" height="88" rx="3" fill="rgba(92,61,30,.42)"/>
        <rect x="26" y="16" width="34" height="3.5" rx="1.75" fill="rgba(255,255,255,.32)"/>
        <rect x="26" y="26" width="24" height="2" rx="1" fill="rgba(255,255,255,.22)"/>
        <rect x="26" y="40" width="30" height="1.5" rx=".75" fill="rgba(255,255,255,.18)"/>
        <rect x="26" y="47" width="26" height="1.5" rx=".75" fill="rgba(255,255,255,.18)"/>
    </svg>
    <svg class="float-book" style="left:65%;animation-duration:25s;animation-delay:12s;top:0" width="50" height="68" viewBox="0 0 50 68">
        <rect x="7" y="0" width="43" height="62" rx="4" fill="rgba(92,61,30,.35)" stroke="rgba(92,61,30,.52)" stroke-width="1.5"/>
        <rect x="7" y="0" width="8" height="62" rx="2" fill="rgba(60,35,10,.45)"/>
        <rect x="19" y="12" width="25" height="3" rx="1.5" fill="rgba(255,255,255,.3)"/>
        <rect x="19" y="30" width="22" height="1.5" rx=".75" fill="rgba(255,255,255,.2)"/>
        <rect x="19" y="37" width="19" height="1.5" rx=".75" fill="rgba(255,255,255,.2)"/>
    </svg>
    <svg class="float-book" style="left:82%;animation-duration:30s;animation-delay:2s;top:0" width="40" height="55" viewBox="0 0 40 55">
        <rect x="5" y="0" width="35" height="50" rx="3" fill="rgba(196,154,108,.4)" stroke="rgba(196,154,108,.58)" stroke-width="1.5"/>
        <rect x="5" y="0" width="6" height="50" rx="2" fill="rgba(139,94,60,.48)"/>
        <rect x="15" y="9" width="20" height="2.5" rx="1.25" fill="rgba(255,255,255,.28)"/>
        <rect x="15" y="24" width="17" height="1.5" rx=".75" fill="rgba(255,255,255,.2)"/>
        <rect x="15" y="30" width="15" height="1.5" rx=".75" fill="rgba(255,255,255,.2)"/>
    </svg>

    <div class="float-quote" style="top:15%;font-size:1.4rem;animation-duration:40s;animation-delay:0s">"Membaca adalah jendela dunia"</div>
    <div class="float-quote" style="top:40%;font-size:1.25rem;animation-duration:50s;animation-delay:10s">"A reader lives a thousand lives"</div>
    <div class="float-quote" style="top:65%;font-size:1.3rem;animation-duration:45s;animation-delay:20s">"Buku adalah guru terbaik"</div>
    <div class="float-quote" style="top:80%;font-size:1.2rem;animation-duration:55s;animation-delay:5s">"Not all those who wander are lost"</div>
    <div class="float-quote" style="top:28%;font-size:1.35rem;animation-duration:48s;animation-delay:15s">"Ilmu adalah cahaya kehidupan"</div>
</div>

<nav class="p-navbar">
    <a href="{{ route('peminjam.dashboard') }}" class="p-brand">
        <div class="p-brand-icon" style="overflow:hidden;padding:0">
            <img src="{{ asset('images/pipi.png') }}"
                 style="width:100%;height:100%;object-fit:cover;border-radius:10px"
                 alt="Logo Perpustakaan">
        </div>
        <div class="p-brand-name">Perpus<span>Digital</span></div>
    </a>

    <div class="p-nav-links">
        <a href="{{ route('peminjam.dashboard') }}"
           class="p-nav-link {{ request()->routeIs('peminjam.dashboard') ? 'active' : '' }}">
            <i class="bi bi-house-fill"></i> Beranda
        </a>
        <a href="{{ route('peminjam.books') }}"
           class="p-nav-link {{ request()->routeIs('peminjam.books') || request()->routeIs('peminjam.book.detail') ? 'active' : '' }}">
            <i class="bi bi-book-fill"></i> Katalog
        </a>
        <a href="{{ route('peminjam.loans') }}"
           class="p-nav-link {{ request()->routeIs('peminjam.loans') ? 'active' : '' }}">
            <i class="bi bi-bookmark-fill"></i> Pinjaman Saya
            @auth
            @php $od = auth()->user()->member?->loans()->where('status','overdue')->count() ?? 0; @endphp
            @if($od > 0)<span class="p-nav-dot ms-1"></span>@endif
            @endauth
        </a>
        <a href="{{ route('peminjam.returns.index') }}"
           class="p-nav-link {{ request()->routeIs('peminjam.returns.index') ? 'active' : '' }}">
            <i class="bi bi-arrow-return-left"></i> Pengembalian
        </a>
        <a href="{{ route('peminjam.ulasan.index') }}"
           class="p-nav-link {{ request()->routeIs('peminjam.ulasan.index') ? 'active' : '' }}">
            <i class="bi bi-star-fill"></i> Ulasan
        </a>
        <a href="{{ route('peminjam.about') }}"
           class="p-nav-link {{ request()->routeIs('peminjam.about') ? 'active' : '' }}">
            <i class="bi bi-info-circle-fill"></i> Tentang
        </a>
    </div>

    <form action="{{ route('peminjam.books') }}" method="GET" class="p-search d-none d-md-flex">
        <i class="bi bi-search"></i>
        <input type="text" name="search" placeholder="Cari buku..." value="{{ request('search') }}">
    </form>

    @auth
    <div class="dropdown">
        <div class="p-user-btn" data-bs-toggle="dropdown">
            <div class="p-avatar">
                @if(auth()->user()->avatar)
                    <img src="{{ auth()->user()->avatarUrl() }}">
                @else
                    {{ strtoupper(substr(auth()->user()->name,0,1)) }}
                @endif
            </div>
            <span class="p-user-name d-none d-md-block">{{ auth()->user()->name }}</span>
            <i class="bi bi-chevron-down" style="font-size:.65rem;color:var(--text-muted)"></i>
        </div>
        <ul class="dropdown-menu dropdown-menu-end" style="margin-top:.5rem">
            @if(auth()->user()->member)
            <li class="px-3 py-2">
                <div class="fw-600 small" style="color:var(--brown-dark)">{{ auth()->user()->name }}</div>
                <div style="font-size:.72rem;color:var(--text-muted)">{{ auth()->user()->member->member_code }}</div>
            </li>
            <li><hr class="dropdown-divider my-1"></li>
            @endif
            <li>
                <a class="dropdown-item d-flex align-items-center gap-2" href="{{ route('peminjam.profile') }}">
                    <i class="bi bi-person" style="color:var(--brown)"></i> Profil Saya
                </a>
            </li>
            <li><hr class="dropdown-divider my-1"></li>
            <li>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="dropdown-item d-flex align-items-center gap-2 text-danger">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </button>
                </form>
            </li>
        </ul>
    </div>
    @endauth
</nav>

<div class="p-page">
    <div class="p-container">
        @if(session('success'))
        <div class="alert d-flex align-items-center gap-2 mb-3"
             style="background:#fef9ec;border:1px solid #f5d98b;color:#7c5a00">
            <i class="bi bi-check-circle-fill" style="color:#d97706"></i>
            {{ session('success') }}
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
        </div>
        @endif
        @if(session('error'))
        <div class="alert d-flex align-items-center gap-2 mb-3"
             style="background:#fef2f2;border:1px solid #fecaca;color:#991b1b">
            <i class="bi bi-exclamation-circle-fill text-danger"></i>
            {{ session('error') }}
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @yield('content')
    </div>
</div>

<div class="p-footer">
    &copy; {{ date('Y') }} <span>Rell-Book Digital</span> — Sistem Manajemen Perpustakaan
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
