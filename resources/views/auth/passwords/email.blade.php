@extends('layouts.auth')
@section('title', 'Reset Password')

@section('content')
<div class="text-center mb-4">
    <div class="auth-icon mb-3"><i class="bi bi-key"></i></div>
    <h4 class="fw-bold">Lupa Password?</h4>
    <p class="text-muted small">Masukkan email untuk reset password</p>
</div>

@if(session('status'))
    <div class="alert alert-success">{{ session('status') }}</div>
@endif

<form method="POST" action="{{ route('password.email') }}">
    @csrf
    <div class="mb-4">
        <label class="form-label fw-semibold">Email</label>
        <div class="input-group">
            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                   value="{{ old('email') }}" required>
            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
    </div>
    <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
        <i class="bi bi-send me-2"></i>Kirim Link Reset
    </button>
    <div class="text-center mt-3">
        <a href="{{ route('login') }}" class="small text-muted">Kembali ke Login</a>
    </div>
</form>
@endsection
