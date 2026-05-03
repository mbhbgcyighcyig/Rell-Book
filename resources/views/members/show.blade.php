@extends('layouts.app')
@section('title', 'Detail Petugas')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body text-center py-4">
                <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold mx-auto mb-3"
                     style="width:72px;height:72px;font-size:1.8rem;background:linear-gradient(135deg,#4f46e5,#818cf8)">
                    {{ strtoupper(substr($member->name, 0, 1)) }}
                </div>
                <h5 class="fw-bold mb-1">{{ $member->name }}</h5>
                <span class="badge rounded-pill px-3" style="background:#ede9fe;color:#6d28d9">Petugas</span>

                <div class="mt-4 text-start">
                    <div class="mb-2 d-flex justify-content-between border-bottom pb-2">
                        <span class="text-muted small">Email</span>
                        <span class="small fw-semibold">{{ $member->email }}</span>
                    </div>
                    <div class="mb-2 d-flex justify-content-between border-bottom pb-2">
                        <span class="text-muted small">Telepon</span>
                        <span class="small fw-semibold">{{ $member->phone ?? '-' }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted small">Terdaftar</span>
                        <span class="small fw-semibold">{{ $member->created_at->format('d M Y') }}</span>
                    </div>
                </div>

                <div class="d-flex gap-2 mt-4">
                    <a href="{{ route('members.edit', $member) }}" class="btn btn-primary flex-fill">
                        <i class="bi bi-pencil me-1"></i>Edit
                    </a>
                    <a href="{{ route('members.index') }}" class="btn btn-outline-secondary flex-fill">
                        Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
