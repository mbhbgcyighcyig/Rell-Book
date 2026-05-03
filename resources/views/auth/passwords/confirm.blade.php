@extends('layouts.auth')
@section('title', 'Konfirmasi Password')

@section('content')
<div class="text-center mb-4">
    <div class="auth-icon mb-3"><i class="bi bi-shield-check"></i></div>
    <h4 class="fw-bold">Konfirmasi Password</h4>
    <p class="text-muted small">Masukkan password untuk melanjutkan.</p>
</div>

<form method="POST" action="{{ route('password.confirm') }}">
    @csrf
    <div class="mb-4">
        <label class="form-label fw-semibold">Password</label>
        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">Konfirmasi</button>
</form>
@endsection
