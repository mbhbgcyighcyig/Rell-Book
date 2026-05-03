@extends('layouts.app')
@section('title', 'Manajemen User')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="fw-bold mb-0">Manajemen User</h5>
        <small class="text-muted">{{ $users->total() }} akun terdaftar &mdash; admin hanya dapat menghapus akun</small>
    </div>
</div>

<div class="card mb-4">
    <div class="card-body py-3">
        <form method="GET" class="row g-2">
            <div class="col-md-6">
                <input type="text" name="search" class="form-control"
                       placeholder="Cari nama atau email..."
                       value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <select name="role" class="form-select">
                    <option value="">Semua Role</option>
                    <option value="admin"    {{ request('role') == 'admin'    ? 'selected' : '' }}>Admin</option>
                    <option value="petugas"  {{ request('role') == 'petugas'  ? 'selected' : '' }}>Petugas</option>
                    <option value="peminjam" {{ request('role') == 'peminjam' ? 'selected' : '' }}>Peminjam</option>
                </select>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-primary flex-fill">
                    <i class="bi bi-search me-1"></i>Cari
                </button>
                <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-x"></i>
                </a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Telepon</th>
                    <th>Terdaftar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold flex-shrink-0"
                                 style="width:34px;height:34px;font-size:.82rem;
                                        background:{{ $user->isAdmin() ? 'linear-gradient(135deg,#dc2626,#f87171)' : ($user->isPetugas() ? 'linear-gradient(135deg,#4f46e5,#818cf8)' : 'linear-gradient(135deg,#059669,#34d399)') }}">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <div>
                                <div class="fw-semibold small">{{ $user->name }}</div>
                                @if($user->id === auth()->id())
                                    <span style="font-size:.65rem;color:#94a3b8">(akun Anda)</span>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td>
                        {{-- Email disensor untuk privasi --}}
                        @php
                            $parts = explode('@', $user->email);
                            $name  = $parts[0];
                            $domain = $parts[1] ?? '';
                            $masked = substr($name, 0, 2) . str_repeat('*', max(strlen($name) - 2, 3)) . '@' . $domain;
                        @endphp
                        <span class="small text-muted font-monospace">{{ $masked }}</span>
                    </td>
                    <td>
                        <span class="badge rounded-pill px-2"
                              style="font-size:.72rem;
                                     background:{{ $user->isAdmin() ? '#fee2e2' : ($user->isPetugas() ? '#ede9fe' : '#dcfce7') }};
                                     color:{{ $user->isAdmin() ? '#dc2626' : ($user->isPetugas() ? '#6d28d9' : '#15803d') }}">
                            {{ ucfirst($user->role) }}
                        </span>
                    </td>
                    <td class="small text-muted">
                        {{-- Telepon disensor --}}
                        @if($user->phone)
                            {{ substr($user->phone, 0, 4) . str_repeat('*', strlen($user->phone) - 4) }}
                        @else
                            -
                        @endif
                    </td>
                    <td class="small text-muted">{{ $user->created_at->format('d/m/Y') }}</td>
                    <td>
                        @if($user->id !== auth()->id())
                        <form action="{{ route('users.destroy', $user) }}" method="POST"
                              onsubmit="return confirm('Hapus akun {{ $user->name }}? Tindakan ini tidak bisa dibatalkan.')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-trash me-1"></i>Hapus
                            </button>
                        </form>
                        @else
                        <span class="text-muted small">—</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-5">
                        <i class="bi bi-people fs-1 d-block mb-2"></i>Tidak ada user ditemukan
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-4">{{ $users->links() }}</div>
@endsection
