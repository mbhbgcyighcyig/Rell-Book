@extends('layouts.peminjam')
@section('title', 'Tentang Perpustakaan')

@section('content')

{{-- Hero --}}
<div class="about-hero mb-5">
    <div class="about-hero-content">
        <div class="about-badge mb-3"><i class="bi bi-building me-2"></i>Profil Perpustakaan</div>
        <h2 class="about-title">Perpustakaan Digital</h2>
        <p class="about-sub">
            Pusat ilmu pengetahuan dan literasi masyarakat yang hadir untuk memudahkan
            akses buku dan informasi bagi seluruh lapisan masyarakat.
        </p>
    </div>
    <div class="about-hero-img d-none d-md-flex">
        <img src="{{ asset('images/vitaww.jpeg') }}" alt="Logo" style="width:120px;height:120px;object-fit:cover;border-radius:50%;border:4px solid rgba(255,255,255,.3);box-shadow:0 8px 24px rgba(139,94,60,.3)">
    </div>
</div>

{{-- Stats --}}
<div class="row g-3 mb-5">
    @php
        $totalBooks   = \App\Models\Book::count();
        $totalMembers = \App\Models\User::where('role','peminjam')->count();
        $totalLoans   = \App\Models\Loan::count();
        $totalReturned= \App\Models\Loan::where('status','returned')->count();
    @endphp
    <div class="col-6 col-md-3">
        <div class="about-stat">
            <div class="about-stat-num">{{ $totalBooks }}</div>
            <div class="about-stat-label">Judul Buku</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="about-stat">
            <div class="about-stat-num">{{ $totalMembers }}</div>
            <div class="about-stat-label">Anggota Terdaftar</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="about-stat">
            <div class="about-stat-num">{{ $totalLoans }}</div>
            <div class="about-stat-label">Total Peminjaman</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="about-stat">
            <div class="about-stat-num">{{ $totalReturned }}</div>
            <div class="about-stat-label">Buku Dikembalikan</div>
        </div>
    </div>
</div>

<div class="row g-4 mb-5">
    {{-- Visi Misi --}}
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header">
                <i class="bi bi-eye-fill me-2" style="color:var(--brown)"></i>Visi
            </div>
            <div class="card-body">
                <p style="font-size:.9rem;color:var(--text);line-height:1.8;font-style:italic">
                    "Menjadi pusat literasi digital terdepan yang mendorong budaya membaca
                    dan meningkatkan kualitas sumber daya manusia melalui akses informasi
                    yang mudah, cepat, dan merata."
                </p>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header">
                <i class="bi bi-bullseye me-2" style="color:var(--brown)"></i>Misi
            </div>
            <div class="card-body p-0">Menyediakan koleksi buku yang beragam dan berkualitas','Memberikan layanan peminjaman yang mudah dan efisien','Mendorong budaya membaca di masyaraka
                @foreach(['t','Mengelola sistem perpustakaan secara digital dan modern','Memberikan akses informasi yang merata untuk semua kalangan'] as $i => $misi)
                <div class="d-flex align-items-start gap-3 px-4 py-3 border-bottom" style="border-color:var(--cream-dark)!important">
                    <div style="width:24px;height:24px;background:var(--cream-dark);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:.72rem;font-weight:700;color:var(--brown);flex-shrink:0">{{ $i+1 }}</div>
                    <span style="font-size:.85rem;color:var(--text)">{{ $misi }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

{{-- Layanan --}}
<div class="card mb-5">
    <div class="card-header">
        <i class="bi bi-grid-fill me-2" style="color:var(--brown)"></i>Layanan Kami
    </div>
    <div class="card-body">
        <div class="row g-3">
            @foreach([
                ['bi-book','Peminjaman Buku','Pinjam buku favoritmu dengan mudah, maksimal 3 buku sekaligus selama 7 hari.'],
                ['bi-arrow-return-left','Pengembalian','Ajukan pengembalian online, bawa buku ke perpustakaan dan petugas akan konfirmasi.'],
                ['bi-star-fill','Rating & Ulasan','Berikan penilaian dan ulasan untuk buku yang sudah kamu baca.'],
                ['bi-search','Katalog Digital','Cari dan temukan buku berdasarkan judul, pengarang, atau kategori.'],
                ['bi-cash-coin','Sistem Denda','Denda keterlambatan Rp 1.000/hari dihitung otomatis oleh sistem.'],
                ['bi-person-circle','Akun Anggota','Kelola profil, riwayat pinjaman, dan pantau status keanggotaan.'],
            ] as [$icon, $title, $desc])
            <div class="col-md-4">
                <div class="service-card">
                    <div class="service-icon"><i class="bi {{ $icon }}"></i></div>
                    <div class="service-title">{{ $title }}</div>
                    <div class="service-desc">{{ $desc }}</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

{{-- Aturan --}}
<div class="card mb-5">
    <div class="card-header">
        <i class="bi bi-journal-text me-2" style="color:var(--brown)"></i>Tata Tertib Peminjaman
    </div>
    <div class="card-body">
        <div class="row g-2">
            @foreach([
                'Anggota wajib menunjukkan kartu anggota saat meminjam buku.',
                'Maksimal peminjaman 3 buku per anggota dalam satu waktu.',
                'Durasi peminjaman maksimal 7 hari kalender.',
                'Denda keterlambatan sebesar Rp 1.000 per hari per buku.',
                'Buku yang rusak atau hilang wajib diganti sesuai harga buku.',
                'Anggota yang memiliki denda belum lunas tidak dapat meminjam buku baru.',
                'Perpanjangan peminjaman dapat dilakukan 1x sebelum jatuh tempo.',
                'Buku harus dikembalikan dalam kondisi baik seperti saat dipinjam.',
            ] as $i => $rule)
            <div class="col-md-6">
                <div class="d-flex align-items-start gap-2 p-2 rounded" style="background:var(--cream)">
                    <span style="color:var(--brown);font-weight:700;font-size:.8rem;flex-shrink:0">{{ $i+1 }}.</span>
                    <span style="font-size:.83rem;color:var(--text)">{{ $rule }}</span>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

{{-- Kontak --}}
<div class="card">
    <div class="card-header">
        <i class="bi bi-telephone-fill me-2" style="color:var(--brown)"></i>Informasi Kontak
    </div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-4">
                <div class="contact-item">
                    <i class="bi bi-geo-alt-fill"></i>
                    <div>
                        <div class="contact-label">Alamat</div>
                        <div class="contact-val">Jl. Raya Kedep RT02/RW22</div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="contact-item">
                    <i class="bi bi-clock-fill"></i>
                    <div>
                        <div class="contact-label">Jam Operasional</div>
                        <div class="contact-val">Senin–Jumat: 08.00–16.00<br>Sabtu: 08.00–12.00</div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="contact-item">
                    <i class="bi bi-envelope-fill"></i>
                    <div>
                        <div class="contact-label">Email</div>
                        <div class="contact-val">rellbook@digital.id</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.about-hero { background: url('{{ asset("images/dgn.jpg") }}') center/cover no-repeat; border-radius:18px;padding:2.5rem;display:flex;justify-content:space-between;align-items:center;position:relative;overflow:hidden;min-height:200px; }
.about-hero::before { content:'';position:absolute;inset:0;border-radius:18px;background:linear-gradient(135deg,rgba(92,61,30,.82) 0%,rgba(139,94,60,.65) 60%,rgba(0,0,0,.35) 100%); }
.about-hero > * { position:relative;z-index:1; }
.about-badge { display:inline-flex;align-items:center;background:rgba(255,255,255,.18);border:1px solid rgba(255,255,255,.3);color:#fff;font-size:.75rem;font-weight:600;padding:.3rem .85rem;border-radius:20px; }
.about-title { font-family:'Playfair Display',serif;font-size:2rem;font-weight:800;color:#fff;margin:0 0 .5rem;text-shadow:0 2px 8px rgba(0,0,0,.3); }
.about-sub { color:rgba(255,255,255,.8);font-size:.9rem;line-height:1.7;margin:0;max-width:500px; }

.about-stat { background:var(--cream-card);border:1px solid var(--cream-dark);border-radius:14px;padding:1.25rem;text-align:center; }
.about-stat-num { font-family:'Playfair Display',serif;font-size:2rem;font-weight:800;color:var(--brown-dark);line-height:1; }
.about-stat-label { font-size:.75rem;color:var(--text-muted);margin-top:.3rem; }

.service-card { background:var(--cream);border:1px solid var(--cream-dark);border-radius:12px;padding:1.25rem;height:100%; }
.service-icon { width:40px;height:40px;background:var(--cream-dark);border-radius:10px;display:flex;align-items:center;justify-content:center;color:var(--brown);font-size:1.1rem;margin-bottom:.75rem; }
.service-title { font-weight:700;font-size:.88rem;color:var(--brown-dark);margin-bottom:.35rem; }
.service-desc { font-size:.78rem;color:var(--text-muted);line-height:1.6; }

.contact-item { display:flex;align-items:flex-start;gap:.85rem;padding:.75rem;background:var(--cream);border-radius:10px; }
.contact-item i { font-size:1.1rem;color:var(--brown);margin-top:2px;flex-shrink:0; }
.contact-label { font-size:.7rem;color:var(--text-muted);text-transform:uppercase;letter-spacing:.05em;font-weight:600; }
.contact-val { font-size:.83rem;color:var(--brown-dark);font-weight:500;line-height:1.5; }
</style>
@endpush
@endsection
