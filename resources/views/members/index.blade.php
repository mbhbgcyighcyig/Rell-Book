@extends('layouts.app')
@section('title', 'Data Petugas')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="fw-bold mb-0">Data Petugas</h5>
        <small class="text-muted">{{ $total }} akun petugas terdaftar</small>
    </div>
    <a href="{{ route('members.create') }}" class="btn btn-primary">
        <i class="bi bi-person-plus me-1"></i>Tambah Petugas
    </a>
</div>

<div class="card mb-4">
    <div class="card-body py-3">
        <form method="GET" class="row g-2">
            <div class="col-md-8">
                <input type="text" name="search" class="form-control"
                       placeholder="Cari nama atau email petugas..."
                       value="{{ request('search') }}">
            </div>
            <div class="col-md-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary flex-fill">
                    <i class="bi bi-search me-1"></i>Cari
                </button>
                <a href="{{ route('members.index') }}" class="btn btn-outline-secondary">
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
                                 style="width:34px;height:34px;font-size:.82rem;background:linear-gradient(135deg,#4f46e5,#818cf8)">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <div>
                                <div class="fw-semibold small">{{ $user->name }}</div>
                                <span class="badge rounded-pill" style="background:#ede9fe;color:#6d28d9;font-size:.65rem">Petugas</span>
                            </div>
                        </div>
                    </td>
                    <td class="small">{{ $user->email }}</td>
                    <td class="small">{{ $user->phone ?? '-' }}</td>
                    <td class="small">{{ $user->created_at->format('d/m/Y') }}</td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('members.edit', $user) }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-pencil"></i>
                            </a>
                            @if($user->id !== auth()->id())
                            <form action="{{ route('members.destroy', $user) }}" method="POST"
                                  onsubmit="return confirm('Hapus akun petugas ini?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted py-5">
                        <i class="bi bi-people fs-1 d-block mb-2"></i>
                        Belum ada akun petugas
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-4">{{ $users->links() }}</div>
@endsection
