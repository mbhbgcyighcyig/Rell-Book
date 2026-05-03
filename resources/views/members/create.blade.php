@extends('layouts.app')
@section('title', 'Tambah Petugas')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header py-3">
                <i class="bi bi-person-plus me-2 text-primary"></i>Tambah Akun Petugas
            </div>
            <div class="card-body">
                <form action="{{ route('members.store') }}" method="POST">
                    @csrf
                    @include('members._form')
                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-save me-1"></i>Simpan
                        </button>
                        <a href="{{ route('members.index') }}" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
