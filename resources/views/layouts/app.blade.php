<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - {{ config('app.name') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --sidebar-width: 265px;
            --primary: #4f46e5;
            --primary-dark: #4338ca;
            --sidebar-bg: #0f172a;
            --topbar-h: 64px;
        }
        * { box-sizing: border-box; }
        body {
            background: #f0f2f8;
            font-family: 'Inter', 'Segoe UI', sans-serif;
            font-size: .9rem;
        }

        /* ── Sidebar ── */
        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            background: var(--sidebar-bg);
            position: fixed;
            top: 0; left: 0;
            z-index: 200;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }
        .sidebar-brand {
            padding: 1.4rem 1.25rem 1.2rem;
            border-bottom: 1px solid rgba(255,255,255,.06);
            flex-shrink: 0;
        }
        .sidebar-brand .brand-logo {
            width: 38px; height: 38px;
            background: linear-gradient(135deg, var(--primary), #818cf8);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.1rem; color: #fff; flex-shrink: 0;
        }
        .sidebar-brand h6 { color: #fff; font-weight: 700; margin: 0; font-size: .95rem; }
        .sidebar-brand small { color: #64748b; font-size: .72rem; }
        .sidebar-nav { flex: 1; overflow-y: auto; padding: .75rem 0; }
        .sidebar-nav::-webkit-scrollbar { width: 4px; }
        .sidebar-nav::-webkit-scrollbar-thumb { background: #334155; border-radius: 4px; }
        .nav-section {
            color: #475569;
            font-size: .65rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .1em;
            padding: .9rem 1.25rem .3rem;
        }
        .sidebar .nav-link {
            color: #94a3b8;
            padding: .55rem 1rem;
            border-radius: 8px;
            margin: 1px 10px;
            font-size: .83rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: .65rem;
            transition: all .18s;
            position: relative;
        }
        .sidebar .nav-link i { font-size: 1rem; width: 18px; text-align: center; }
        .sidebar .nav-link:hover { background: rgba(255,255,255,.06); color: #e2e8f0; }
        .sidebar .nav-link.active {
            background: linear-gradient(90deg, var(--primary), #6366f1);
            color: #fff;
            box-shadow: 0 4px 12px rgba(79,70,229,.35);
        }
        .sidebar-footer {
            padding: 1rem 1.25rem;
            border-top: 1px solid rgba(255,255,255,.06);
            flex-shrink: 0;
        }

        /* ── Main ── */
        .main-content { margin-left: var(--sidebar-width); min-height: 100vh; display: flex; flex-direction: column; }

        /* ── Topbar ── */
        .topbar {
            height: var(--topbar-h);
            background: #fff;
            border-bottom: 1px solid #e8eaf0;
            padding: 0 1.75rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 1px 4px rgba(0,0,0,.04);
        }
        .topbar-title { font-weight: 700; font-size: 1rem; color: #1e293b; }
        .topbar-title small { font-weight: 400; color: #94a3b8; font-size: .78rem; display: block; }
        .user-avatar {
            width: 34px; height: 34px;
            background: linear-gradient(135deg, var(--primary), #818cf8);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-weight: 700; font-size: .82rem;
            flex-shrink: 0;
        }

        .page-content { padding: 1.75rem; flex: 1; }

        .card {
            border: none;
            border-radius: 14px;
            box-shadow: 0 1px 4px rgba(0,0,0,.06), 0 4px 16px rgba(0,0,0,.04);
            background: #fff;
        }
        .card-header {
            background: #fff;
            border-bottom: 1px solid #f1f5f9;
            font-weight: 600;
            font-size: .88rem;
            border-radius: 14px 14px 0 0 !important;
            padding: 1rem 1.25rem;
        }

        .stat-card {
            border-radius: 14px;
            padding: 1.4rem;
            color: #fff;
            position: relative;
            overflow: hidden;
        }
        .stat-card::after {
            content: '';
            position: absolute;
            right: -20px; top: -20px;
            width: 100px; height: 100px;
            border-radius: 50%;
            background: rgba(255,255,255,.08);
        }
        .stat-card::before {
            content: '';
            position: absolute;
            right: 20px; bottom: -30px;
            width: 80px; height: 80px;
            border-radius: 50%;
            background: rgba(255,255,255,.05);
        }
        .stat-card .stat-icon {
            width: 48px; height: 48px;
            background: rgba(255,255,255,.2);
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.4rem;
        }

        .table th {
            font-size: .72rem;
            text-transform: uppercase;
            letter-spacing: .06em;
            color: #94a3b8;
            font-weight: 600;
            border-bottom: 1px solid #f1f5f9;
            padding: .85rem 1rem;
        }
        .table td { padding: .85rem 1rem; vertical-align: middle; border-color: #f8fafc; }
        .table tbody tr:hover { background: #fafbff; }

        .badge-status-borrowed { background: #ede9fe; color: #6d28d9; }
        .badge-status-returned { background: #dcfce7; color: #15803d; }
        .badge-status-overdue  { background: #fee2e2; color: #dc2626; }


        .btn-primary { background: var(--primary); border-color: var(--primary); font-weight: 500; }
        .btn-primary:hover { background: var(--primary-dark); border-color: var(--primary-dark); }
        .btn { border-radius: 8px; font-size: .85rem; }
        .form-control, .form-select {
            border-radius: 8px;
            border-color: #e2e8f0;
            font-size: .875rem;
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(79,70,229,.12);
        }

        .page-header {
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            border-radius: 16px;
            padding: 1.5rem 1.75rem;
            color: #fff;
            margin-bottom: 1.5rem;
            position: relative;
            overflow: hidden;
        }
        .page-header::after {
            content: '';
            position: absolute;
            right: -40px; top: -40px;
            width: 180px; height: 180px;
            border-radius: 50%;
            background: rgba(255,255,255,.07);
        }
        .page-header h5 { font-weight: 700; margin: 0; font-size: 1.1rem; }
        .page-header small { opacity: .75; font-size: .8rem; }

        /* ── Alerts ── */
        .alert { border: none; border-radius: 10px; font-size: .875rem; }
        .alert-success { background: #f0fdf4; color: #166534; }
        .alert-danger  { background: #fef2f2; color: #991b1b; }

        /* ── Responsive ── */
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); transition: .25s cubic-bezier(.4,0,.2,1); }
            .sidebar.show { transform: translateX(0); box-shadow: 8px 0 32px rgba(0,0,0,.3); }
            .main-content { margin-left: 0; }
        }
    </style>
    @stack('styles')
</head>
<body>

@auth
<div class="sidebar" id="sidebar">
    {{-- Brand --}}
    <div class="sidebar-brand d-flex align-items-center gap-3">
        <div class="brand-logo"><i class="bi bi-book-half"></i></div>
        <div>
            <h6>Perpustakaan</h6>
            <small>Digital Library System</small>
        </div>
    </div>

    {{-- Nav --}}
    <div class="sidebar-nav">
        <div class="nav-section">Utama</div>
        <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="bi bi-grid-1x2"></i> Dashboard
        </a>

        <div class="nav-section">Koleksi</div>
        <a href="{{ route('books.index') }}" class="nav-link {{ request()->routeIs('books.*') ? 'active' : '' }}">
            <i class="bi bi-book"></i> Buku
        </a>
        <a href="{{ route('categories.index') }}" class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}">
            <i class="bi bi-tags"></i> Kategori
        </a>

        <div class="nav-section">Sirkulasi</div>
        <a href="{{ route('loans.index') }}" class="nav-link {{ request()->routeIs('loans.index') || request()->routeIs('loans.show') ? 'active' : '' }}">
            <i class="bi bi-arrow-left-right"></i> Peminjaman
            @php $pendingLoans = \App\Models\Loan::where('status','pending_approval')->count(); @endphp
            @if($pendingLoans > 0)
            <span class="ms-auto badge bg-warning text-dark rounded-pill" style="font-size:.62rem">{{ $pendingLoans }}</span>
            @endif
        </a>
        @if(auth()->user()->isPetugas())
        <a href="{{ route('loans.create') }}" class="nav-link {{ request()->routeIs('loans.create') ? 'active' : '' }}">
            <i class="bi bi-plus-circle"></i> Pinjam Buku
        </a>
        @endif
        <a href="{{ route('loans.history') }}" class="nav-link {{ request()->routeIs('loans.history') ? 'active' : '' }}">
            <i class="bi bi-clock-history"></i> Riwayat
        </a>
        @if(auth()->user()->isPetugas())
        <a href="{{ route('returns.staff.index') }}" class="nav-link {{ request()->routeIs('returns.staff.*') ? 'active' : '' }}">
            <i class="bi bi-arrow-return-left"></i> Pengembalian
            @php $pending = \App\Models\ReturnRequest::where('status','pending')->count(); @endphp
            @if($pending > 0)
            <span class="ms-auto badge bg-danger rounded-pill" style="font-size:.62rem">{{ $pending }}</span>
            @endif
        </a>
        @endif

        <div class="nav-section">Petugas</div>
        <a href="{{ route('members.index') }}" class="nav-link {{ request()->routeIs('members.*') ? 'active' : '' }}">
            <i class="bi bi-person-badge"></i> Data Petugas
        </a>

        <div class="nav-section">Laporan</div>
        <a href="{{ route('reports.loans') }}" class="nav-link {{ request()->routeIs('reports.loans') ? 'active' : '' }}">
            <i class="bi bi-bar-chart-line"></i> Lap. Peminjaman
        </a>
        <a href="{{ route('reports.fines') }}" class="nav-link {{ request()->routeIs('reports.fines') ? 'active' : '' }}">
            <i class="bi bi-cash-coin"></i> Lap. Denda
        </a>
        <a href="{{ route('reports.popular-books') }}" class="nav-link {{ request()->routeIs('reports.popular-books') ? 'active' : '' }}">
            <i class="bi bi-trophy"></i> Buku Populer
        </a>

        @if(auth()->user()->isAdmin())
        <div class="nav-section">Pengaturan</div>
        <a href="{{ route('users.index') }}" class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
            <i class="bi bi-shield-person"></i> Manajemen User
        </a>
        @endif
    </div>

    {{-- Footer --}}
    <div class="sidebar-footer">
        <div class="d-flex align-items-center gap-2">
            <div class="user-avatar">
            @if(auth()->user()->avatar)
                <img src="{{ auth()->user()->avatarUrl() }}" style="width:100%;height:100%;object-fit:cover;border-radius:50%">
            @else
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            @endif
        </div>
            <div class="flex-grow-1 min-w-0">
                <div class="text-white fw-600 small text-truncate" style="font-size:.82rem">{{ auth()->user()->name }}</div>
                <div style="font-size:.7rem;color:#64748b">{{ ucfirst(auth()->user()->role) }}</div>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="btn btn-sm p-1" style="color:#64748b" title="Logout">
                    <i class="bi bi-box-arrow-right fs-5"></i>
                </button>
            </form>
        </div>
    </div>
</div>

<div class="main-content">
    {{-- Topbar --}}
    <div class="topbar">
        <div class="d-flex align-items-center gap-3">
            <button class="btn btn-sm btn-light d-lg-none px-2"
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
        <div class="d-flex align-items-center gap-3">
            <div class="d-none d-md-flex align-items-center gap-2 px-3 py-1 rounded-pill"
                 style="background:#f1f5f9;font-size:.8rem;color:#64748b">
                <i class="bi bi-calendar3"></i>
                {{ now()->translatedFormat('d M Y') }}
            </div>
            <div class="dropdown">
                <button class="btn btn-sm d-flex align-items-center gap-2 px-2 py-1"
                        style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:10px"
                        data-bs-toggle="dropdown">
                    <div class="user-avatar" style="width:28px;height:28px;font-size:.75rem;overflow:hidden">
                        @if(auth()->user()->avatar)
                            <img src="{{ auth()->user()->avatarUrl() }}" style="width:100%;height:100%;object-fit:cover;border-radius:50%">
                        @else
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        @endif
                    </div>
                    <span class="d-none d-md-inline fw-500" style="font-size:.83rem;color:#1e293b">
                        {{ auth()->user()->name }}
                    </span>
                    <i class="bi bi-chevron-down" style="font-size:.65rem;color:#94a3b8"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0" style="border-radius:12px;min-width:180px">
                    <li class="px-3 py-2">
                        <div class="fw-600 small">{{ auth()->user()->name }}</div>
                        <div class="text-muted" style="font-size:.75rem">{{ auth()->user()->email }}</div>
                    </li>
                    <li><hr class="dropdown-divider my-1"></li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button class="dropdown-item text-danger d-flex align-items-center gap-2">
                                <i class="bi bi-box-arrow-right"></i> Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    {{-- Content --}}
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
     style="display:none!important;position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:199"
     onclick="document.getElementById('sidebar').classList.remove('show');this.style.display='none'"></div>

@else
    @yield('content')
@endauth

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Show overlay when sidebar opens on mobile
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        if (!sidebar || !overlay) return;
        const observer = new MutationObserver(() => {
            overlay.style.display = sidebar.classList.contains('show') ? 'block' : 'none';
        });
        observer.observe(sidebar, { attributes: true, attributeFilter: ['class'] });
    });
</script>
@stack('scripts')
</body>
</html>
