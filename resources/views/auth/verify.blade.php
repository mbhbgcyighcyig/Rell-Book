@extends('layouts.auth')
@section('title', 'Verifikasi Email')

@section('content')
<div class="text-center mb-4">
    <div class="auth-icon mb-3"><i class="bi bi-envelope-check"></i></div>
    <h4 class="fw-bold">Verifikasi Email</h4>
    <p class="text-muted small">Cek email kamu untuk link verifikasi.</p>
</div>

@if(session('resent'))
    <div class="alert alert-success small">Link verifikasi baru sudah dikirim.</div>
@endif

<form method="POST" action="{{ route('verification.resend') }}">
    @csrf
    <button type="submit" class="btn btn-primary w-100">Kirim Ulang Email Verifikasi</button>
</form>
@endsection
