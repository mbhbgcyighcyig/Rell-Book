<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - {{ config('app.name') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700;800&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --sw: 272px;
            --th: 66px;
            --brown:       #8b5e3c;
            --brown-dark:  #5c3d1e;
            --brown-light: #c49a6c;
            --cream:       #f5efe6;
            --cream-dark:  #ede0cc;
            --gold:        #d4a843;
            --gold-light:  #f0c96a;
            --sidebar-bg:  #1e1208;
            --accent:      #c47a3a;
        }

        * { box-sizing: border-box; }

        body {
            background: #f0ebe3;
            font-family: 'Inter', sans-serif;
            font-size: .9rem;
            color: #2d1f0f;
        }

        /* ════════════════════════════════
           SIDEBAR
        ════════════════════════════════ */
        .sidebar {
            width: var(--sw);
            height: 100vh;
            position: fixed;
            top: 0; left: 0;
            z-index: 200;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        /* Background gambar perpustakaan */
        .sidebar::before {
            content: '';
            position: absolute;
            inset: 0;
            background: url('{{ asset("images/as.jpg") }}') center/cover no-repeat;
            filter: brightness(.22) saturate(.6);
            z-index: 0;
        }

        /* Warm overlay gradient */
        .sidebar::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(
                180deg,
                rgba(15,8,2,.97) 0%,
                rgba(25,13,4,.93) 35%,
                rgba(35,18,6,.95) 70%,
                rgba(20,10,3,.98) 100%
            );
            z-index: 1;
        }

        /* Gold shimmer line on right edge */
        .sidebar .gold-line {
            position: absolute;
            top: 0; right: 0; bottom: 0;
            width: 1px;
            background: linear-gradient(180deg,
                transparent 0%,
                rgba(212,168,67,.4) 20%,
                rgba(212,168,67,.6) 50%,
                rgba(212,168,67,.4) 80%,
                transparent 100%
            );
            z-index: 3;
        }

        .sidebar > * { position: relative; z-index: 2; }

        /* Brand */
        .sb-brand {
            padding: 1.6rem 1.4rem 1.3rem;
            border-bottom: 1px solid rgba(212,168,67,.12);
            flex-shrink: 0;
            display: flex;
            align-items: center;
            gap: .9rem;
            background: rgba(0,0,0,.2);
        }

        .sb-logo {
            width: 44px; height: 44px;
            border-radius: 12px;
            overflow: hidden;
            flex-shrink: 0;
            border: 1.5px solid rgba(212,168,67,.35);
            box-shadow: 0 4px 16px rgba(0,0,0,.5), 0 0 0 3px rgba(212,168,67,.08);
        }

        .sb-logo img { width: 100%; height: 100%; object-fit: cover; }

        .sb-brand-text .name {
            font-family: 'Playfair Display', serif;
            font-weight: 800;
            font-size: 1.05rem;
            color: #f5d5a8;
            line-height: 1.2;
            letter-spacing: .01em;
        }

        .sb-brand-text .sub {
            font-size: .62rem;
            color: rgba(212,168,67,.45);
            letter-spacing: .12em;
            text-transform: uppercase;
            margin-top: 1px;
        }

        /* Nav scroll area */
        .sb-nav {
            flex: 1;
            overflow-y: auto;
            padding: .5rem 0 1rem;
        }

        .sb-nav::-webkit-scrollbar { width: 2px; }
        .sb-nav::-webkit-scrollbar-thumb { background: rgba(212,168,67,.15); border-radius: 2px; }

        .sb-section {
            font-size: .58rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .18em;
            color: rgba(212,168,67,.35);
            padding: 1.1rem 1.5rem .3rem;
            display: flex;
            align-items: center;
            gap: .6rem;
        }

        .sb-section::after {
            content: '';
            flex: 1;
            height: 1px;
            background: rgba(212,168,67,.1);
        }

        .sb-link {
            display: flex;
            align-items: center;
            gap: .72rem;
            color: rgba(255,255,255,.42);
            text-decoration: none;
            padding: .54rem 1rem;
            margin: 1px 10px;
            border-radius: 9px;
            font-size: .81rem;
            font-weight: 500;
            transition: all .2s;
            letter-spacing: .01em;
        }

        .sb-link i {
            font-size: .92rem;
            width: 18px;
            text-align: center;
            flex-shrink: 0;
            transition: .2s;
        }

        .sb-link:hover {
            background: rgba(212,168,67,.08);
            color: rgba(245,213,168,.85);
        }

        .sb-link:hover i { color: #d4a843; }

        .sb-link.active {
            background: linear-gradient(90deg,
                rgba(196,122,58,.9) 0%,
                rgba(212,168,67,.55) 100%
            );
            color: #fff;
            box-shadow: 0 3px 14px rgba(196,122,58,.3), inset 0 1px 0 rgba(255,255,255,.1);
            border: 1px solid rgba(212,168,67,.22);
        }

        .sb-link.active i { color: #fde68a; }

        /* Sidebar footer */
        .sb-footer {
            padding: 1rem 1.2rem;
            border-top: 1px solid rgba(212,168,67,.1);
            flex-shrink: 0;
            background: rgba(0,0,0,.25);
        }

        .sb-user {
            display: flex;
            align-items: center;
            gap: .75rem;
        }

        .sb-avatar {
            width: 36px; height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--accent), var(--gold));
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-weight: 700; font-size: .82rem;
            overflow: hidden; flex-shrink: 0;
            border: 1.5px solid rgba(212,168,67,.35);
            box-shadow: 0 2px 8px rgba(0,0,0,.3);
        }

        .sb-avatar img { width: 100%; height: 100%; object-fit: cover; }

        .sb-user-name {
            font-size: .81rem;
            font-weight: 600;
            color: #f5d5a8;
            line-height: 1.2;
        }

        .sb-user-role {
            font-size: .65rem;
            color: rgba(212,168,67,.45);
            text-transform: capitalize;
            letter-spacing: .04em;
        }

        /* ════════════════════════════════
           MAIN CONTENT
        ════════════════════════════════ */
        .main-wrap {
            margin-left: var(--sw);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ── Topbar ── */
        .topbar {
            height: var(--th);
            background: rgba(255,255,255,.96);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(237,224,204,.8);
            padding: 0 1.75rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 2px 12px rgba(139,94,60,.07);
        }

        .topbar-title {
            font-weight: 700;
            font-size: 1rem;
            color: #2d1f0f;
            line-height: 1.2;
        }

        .topbar-title small {
            font-weight: 400;
            color: #9c7c5c;
            font-size: .75rem;
            display: block;
        }

        .tb-date {
            display: flex;
            align-items: center;
            gap: .5rem;
            background: #fdf5ec;
            border: 1px solid #ede0cc;
            border-radius: 20px;
            padding: .35rem .9rem;
            font-size: .78rem;
            color: #9c7c5c;
        }

        .tb-user-btn {
            display: flex;
            align-items: center;
            gap: .6rem;
            background: #fdf5ec;
            border: 1.5px solid #ede0cc;
            border-radius: 10px;
            padding: .35rem .85rem .35rem .45rem;
            cursor: pointer;
            transition: .18s;
            color: #2d1f0f;
        }

        .tb-user-btn:hover {
            border-color: var(--brown-light);
            background: #f5efe6;
        }

        .tb-avatar {
            width: 30px; height: 30px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--accent), var(--gold));
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-weight: 700; font-size: .75rem;
            overflow: hidden; flex-shrink: 0;
        }

        .tb-avatar img { width: 100%; height: 100%; object-fit: cover; }

        /* ── Page content ── */
        .page-content {
            padding: 1.75rem;
            flex: 1;
        }

        /* ── Page header ── */
        .page-header {
            border-radius: 16px;
            padding: 1.6rem 1.75rem;
            color: #fff;
            margin-bottom: 1.5rem;
            position: relative;
            overflow: hidden;
        }

        .page-header::before {
            content: '';
            position: absolute;
            inset: 0;
            background: url('{{ asset("images/dgn.jpg") }}') center/cover no-repeat;
            filter: brightness(.35) saturate(.6);
        }

        .page-header::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(
                135deg,
                rgba(92,61,30,.92) 0%,
                rgba(139,94,60,.75) 50%,
                rgba(196,122,58,.6) 100%
            );
        }

        .page-header > * { position: relative; z-index: 1; }
        .page-header h5 { font-weight: 700; margin: 0; font-size: 1.1rem; }
        .page-header small { opacity: .8; font-size: .8rem; }

        /* ── Cards ── */
        .card {
            border: 1px solid rgba(237,224,204,.7);
            border-radius: 14px;
            box-shadow: 0 2px 8px rgba(139,94,60,.06), 0 1px 3px rgba(0,0,0,.04);
            background: #fff;
        }

        .card-header {
            background: #fffaf4;
            border-bottom: 1px solid #f0e6d6;
            font-weight: 600;
            font-size: .88rem;
            border-radius: 14px 14px 0 0 !important;
            padding: 1rem 1.25rem;
            color: #3d2b1a;
        }

        /* ── Stat cards ── */
        .stat-card {
            border-radius: 14px;
            padding: 1.4rem;
            color: #fff;
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            inset: 0;
            background: url('{{ asset("images/dgn.jpg") }}') center/cover no-repeat;
            filter: brightness(.25) saturate(.5);
        }

        .stat-card > * { position: relative; z-index: 1; }

        .stat-card::after {
            content: '';
            position: absolute;
            right: -20px; top: -20px;
            width: 110px; height: 110px;
            border-radius: 50%;
            background: rgba(255,255,255,.07);
            z-index: 0;
        }

        .stat-card .stat-icon {
            width: 48px; height: 48px;
            background: rgba(255,255,255,.18);
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.4rem;
            border: 1px solid rgba(255,255,255,.15);
        }

        /* ── Table ── */
        .table th {
            font-size: .7rem;
            text-transform: uppercase;
            letter-spacing: .07em;
            color: #9c7c5c;
            font-weight: 700;
            border-bottom: 1px solid #f0e6d6;
            padding: .85rem 1rem;
            background: #fffaf4;
        }

        .table td {
            padding: .85rem 1rem;
            vertical-align: middle;
            border-color: #f5ede0;
            color: #2d1f0f;
        }

        .table tbody tr:hover { background: #fdf5ec; }

        /* ── Badges ── */
        .badge-status-borrowed { background: #fef3c7; color: #92400e; }
        .badge-status-returned { background: #d1fae5; color: #065f46; }
        .badge-status-overdue  { background: #fee2e2; color: #991b1b; }
        .badge-status-pending  { background: #e0e7ff; color: #3730a3; }
        .badge-status-rejected { background: #f1f5f9; color: #475569; }

        /* ── Buttons ── */
        .btn-primary {
            background: linear-gradient(135deg, var(--accent), var(--brown-light));
            border: none;
            font-weight: 500;
            color: #fff;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, var(--brown-dark), var(--accent));
            color: #fff;
            transform: translateY(-1px);
            box-shadow: 0 4px 14px rgba(139,94,60,.3);
        }

        .btn { border-radius: 8px; font-size: .85rem; }

        .form-control, .form-select {
            border-radius: 8px;
            border-color: #e8d8c4;
            font-size: .875rem;
            background: #fffaf4;
            color: #2d1f0f;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--brown-light);
            box-shadow: 0 0 0 3px rgba(196,154,108,.15);
            background: #fff;
        }

        /* ── Alerts ── */
        .alert { border: none; border-radius: 10px; font-size: .875rem; }
        .alert-success { background: #f0fdf4; color: #166534; border-left: 3px solid #22c55e; }
        .alert-danger  { background: #fef2f2; color: #991b1b; border-left: 3px solid #ef4444; }

        /* ── Dropdown ── */
        .dropdown-menu {
            border: 1px solid #ede0cc;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(139,94,60,.12);
            background: #fffaf4;
        }

        .dropdown-item:hover { background: #f5efe6; color: #3d2b1a; }
        .dropdown-divider { border-color: #ede0cc; }

        /* ── Responsive ── */
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); transition: .25s cubic-bezier(.4,0,.2,1); }
            .sidebar.show { transform: translateX(0); box-shadow: 8px 0 32px rgba(0,0,0,.4); }
            .main-wrap { margin-left: 0; }
        }
    </style>
    @stack('styles')
</head>
<body>

@auth
{{-- ════ SIDEBAR ════ --}}
<div class="sidebar" id="sidebar">
    <div class="gold-line"></div>

    {{-- Brand --}}
    <div class="sb-brand">
        <div class="sb-logo">
            <img src="{{ asset('images/pipi.png') }}" alt="Logo">
        </div>
        <div class="sb-brand-text">
            <div class="name">Rell-Book</div>
            <div class="sub">Admin Panel</div>
        </div>
    </div>

    {{-- Navigation --}}
    <div class="sb-nav">

        <div class="sb-section">Utama</div>
        <a href="{{ route('dashboard') }}"
           class="sb-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="bi bi-grid-1x2-fill"></i> Dashboard
        </a>

        <div class="sb-section">Koleksi</div>
        <a href="{{ route('books.index') }}"
           class="sb-link {{ request()->routeIs('books.*') ? 'active' : '' }}">
            <i class="bi bi-book-fill"></i> Buku
        </a>
        <a href="{{ route('categories.index') }}"
           class="sb-link {{ request()->routeIs('categories.*') ? 'active' : '' }}">
            <i class="bi bi-tags-fill"></i> Kategori
        </a>

        <div class="sb-section">Sirkulasi</div>
        <a href="{{ route('loans.index') }}"
           class="sb-link {{ request()->routeIs('loans.index') || request()->routeIs('loans.show') ? 'active' : '' }}">
            <i class="bi bi-arrow-left-right"></i> Peminjaman
            @php $pendingLoans = \App\Models\Loan::where('status','pending_approval')->count(); @endphp
            @if($pendingLoans > 0)
            <span class="ms-auto badge rounded-pill"
                  style="background:rgba(212,168,67,.25);color:#f5d5a8;font-size:.6rem;border:1px solid rgba(212,168,67,.3)">
                {{ $pendingLoans }}
            </span>
            @endif
        </a>
        @if(auth()->user()->isPetugas())
        <a href="{{ route('loans.create') }}"
           class="sb-link {{ request()->routeIs('loans.create') ? 'active' : '' }}">
            <i class="bi bi-plus-circle-fill"></i> Pinjam Buku
        </a>
        @endif
        <a href="{{ route('loans.history') }}"
           class="sb-link {{ request()->routeIs('loans.history') ? 'active' : '' }}">
            <i class="bi bi-clock-history"></i> Riwayat
        </a>
        @if(auth()->user()->isPetugas())
        <a href="{{ route('returns.staff.index') }}"
           class="sb-link {{ request()->routeIs('returns.staff.*') ? 'active' : '' }}">
            <i class="bi bi-arrow-return-left"></i> Pengembalian
            @php $pendingReturns = \App\Models\ReturnRequest::where('status','pending')->count(); @endphp
            @if($pendingReturns > 0)
            <span class="ms-auto badge rounded-pill"
                  style="background:rgba(239,68,68,.25);color:#fca5a5;font-size:.6rem;border:1px solid rgba(239,68,68,.3)">
                {{ $pendingReturns }}
            </span>
            @endif
        </a>
        @endif

        <div class="sb-section">Anggota</div>
        <a href="{{ route('members.index') }}"
           class="sb-link {{ request()->routeIs('members.*') ? 'active' : '' }}">
            <i class="bi bi-person-badge-fill"></i> Data Anggota
        </a>

        <div class="sb-section">Laporan</div>
        @if(auth()->user()->isAdmin())
        <a href="{{ route('reports.loans') }}"
           class="sb-link {{ request()->routeIs('reports.loans') ? 'active' : '' }}">
            <i class="bi bi-bar-chart-line-fill"></i> Lap. Peminjaman
        </a>
        <a href="{{ route('reports.fines') }}"
           class="sb-link {{ request()->routeIs('reports.fines') ? 'active' : '' }}">
            <i class="bi bi-cash-coin"></i> Lap. Denda
        </a>
        <a href="{{ route('reports.popular-books') }}"
           class="sb-link {{ request()->routeIs('reports.popular-books') ? 'active' : '' }}">
            <i class="bi bi-trophy-fill"></i> Buku Populer
        </a>
        <a href="{{ route('ratings.index') }}"
           class="sb-link {{ request()->routeIs('ratings.*') ? 'active' : '' }}">
            <i class="bi bi-star-fill"></i> Ulasan & Rating
        </a>
        @endif

        @if(auth()->user()->isAdmin())
        <div class="sb-section">Pengaturan</div>
        <a href="{{ route('users.index') }}"
           class="sb-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
            <i class="bi bi-shield-person-fill"></i> Manajemen User
        </a>
        @endif

    </div>

    {{-- User footer --}}
    <div class="sb-footer">
        <div class="sb-user">
            <div class="sb-avatar">
                @if(auth()->user()->avatar)
                    <img src="{{ auth()->user()->avatarUrl() }}">
                @else
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                @endif
            </div>
            <div class="flex-grow-1 min-w-0">
                <div class="sb-user-name text-truncate">{{ auth()->user()->name }}</div>
                <div class="sb-user-role">{{ auth()->user()->role }}</div>
            </div>
            <form action="{{ auth()->user()->isAdmin() ? route('admin.logout') : route('petugas.logout') }}" method="POST">
                @csrf
                <button class="btn btn-sm p-1" style="color:rgba(212,168,67,.5)" title="Logout">
                    <i class="bi bi-box-arrow-right" style="font-size:1.1rem"></i>
                </button>
            </form>
        </div>
    </div>
</div>

{{-- ════ MAIN ════ --}}
<div class="main-wrap">

    {{-- Topbar --}}
    <div class="topbar">
        <div class="d-flex align-items-center gap-3">
            <button class="btn btn-sm d-lg-none px-2"
                    style="background:#f5efe6;border:1px solid #ede0cc;color:#8b5e3c"
                    onclick="document.getElementById('sidebar').classList.toggle('show')">
                <i class="bi bi-list fs-5"></i>
            </button>
            <div>
                <div class="topbar-title">
                    @yield('title', 'Dashboard')
                    <small>{{ config('app.name') }}</small>
                </div>
            </div>
        </div>

        <div class="d-flex align-items-center gap-2">
            <div class="tb-date d-none d-md-flex">
                <i class="bi bi-calendar3" style="color:var(--brown-light)"></i>
                {{ now()->translatedFormat('d M Y') }}
            </div>

            <div class="dropdown">
                <div class="tb-user-btn" data-bs-toggle="dropdown" style="cursor:pointer">
                    <div class="tb-avatar">
                        @if(auth()->user()->avatar)
                            <img src="{{ auth()->user()->avatarUrl() }}">
                        @else
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        @endif
                    </div>
                    <span class="d-none d-md-inline fw-600" style="font-size:.83rem">
                        {{ auth()->user()->name }}
                    </span>
                    <i class="bi bi-chevron-down" style="font-size:.6rem;color:#9c7c5c"></i>
                </div>
                <ul class="dropdown-menu dropdown-menu-end" style="margin-top:.5rem;min-width:190px">
                    <li class="px-3 py-2">
                        <div class="fw-600 small" style="color:#3d2b1a">{{ auth()->user()->name }}</div>
                        <div style="font-size:.72rem;color:#9c7c5c">{{ auth()->user()->email }}</div>
                    </li>
                    <li><hr class="dropdown-divider my-1"></li>
                    <li>
                        <form action="{{ auth()->user()->isAdmin() ? route('admin.logout') : route('petugas.logout') }}" method="POST">
                            @csrf
                            <button class="dropdown-item d-flex align-items-center gap-2 text-danger">
                                <i class="bi bi-box-arrow-right"></i> Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    {{-- Page content --}}
    <div class="page-content">
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2 mb-3">
            <i class="bi bi-check-circle-fill text-success"></i>
            {{ session('success') }}
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
        </div>
        @endif
        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center gap-2 mb-3">
            <i class="bi bi-exclamation-circle-fill text-danger"></i>
            {{ session('error') }}
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @yield('content')
    </div>
</div>

{{-- Mobile overlay --}}
<div id="sidebarOverlay" class="d-lg-none"
     style="display:none!important;position:fixed;inset:0;background:rgba(0,0,0,.55);z-index:199"
     onclick="document.getElementById('sidebar').classList.remove('show');this.style.display='none'">
</div>

@else
    @yield('content')
@endauth

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');
    if (!sidebar || !overlay) return;
    new MutationObserver(() => {
        overlay.style.display = sidebar.classList.contains('show') ? 'block' : 'none';
    }).observe(sidebar, { attributes: true, attributeFilter: ['class'] });
});
</script>
@stack('scripts')
</body>
</html>
