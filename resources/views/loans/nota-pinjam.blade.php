<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota Peminjaman - {{ $loan->loan_code }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@700;800&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: #f5efe6; display: flex; justify-content: center; align-items: flex-start; min-height: 100vh; padding: 2rem; }
        .nota-wrap { width: 100%; max-width: 480px; }
        .print-actions { display: flex; gap: .75rem; margin-bottom: 1.5rem; }
        .btn-print { background: #8b5e3c; color: #fff; border: none; border-radius: 8px; padding: .6rem 1.5rem; font-size: .85rem; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: .5rem; }
        .btn-back  { background: #fff; color: #8b5e3c; border: 1px solid #c49a6c; border-radius: 8px; padding: .6rem 1.5rem; font-size: .85rem; font-weight: 600; cursor: pointer; text-decoration: none; display: flex; align-items: center; gap: .5rem; }
        .nota { background: #fff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 24px rgba(139,94,60,.15); }
        .nota-header { background: linear-gradient(135deg, #5c3d1e, #8b5e3c); color: #fff; padding: 1.75rem 2rem; text-align: center; position: relative; }
        .nota-header::after { content: ''; position: absolute; bottom: -12px; left: 0; right: 0; height: 24px; background: #fff; border-radius: 50% 50% 0 0 / 100% 100% 0 0; }
        .nota-logo { width: 56px; height: 56px; border-radius: 50%; object-fit: cover; border: 3px solid rgba(255,255,255,.4); margin-bottom: .75rem; }
        .nota-org { font-family: 'Playfair Display', serif; font-size: 1.2rem; font-weight: 800; }
        .nota-sub { font-size: .75rem; opacity: .75; margin-top: .2rem; }
        .nota-body { padding: 2rem; }
        .nota-title { text-align: center; font-family: 'Playfair Display', serif; font-size: 1rem; font-weight: 700; color: #5c3d1e; border-bottom: 2px dashed #ede0cc; padding-bottom: .75rem; margin-bottom: 1.25rem; letter-spacing: .05em; text-transform: uppercase; }
        .nota-code { text-align: center; font-size: .75rem; color: #9c7c5c; margin-bottom: 1.5rem; }
        .nota-code span { background: #f5efe6; border: 1px solid #ede0cc; border-radius: 6px; padding: .25rem .75rem; font-weight: 600; color: #5c3d1e; }
        .nota-section { margin-bottom: 1.25rem; }
        .nota-section-title { font-size: .65rem; font-weight: 700; text-transform: uppercase; letter-spacing: .1em; color: #c49a6c; margin-bottom: .6rem; }
        .nota-row { display: flex; justify-content: space-between; align-items: flex-start; padding: .35rem 0; border-bottom: 1px solid #f5efe6; gap: 1rem; }
        .nota-row:last-child { border-bottom: none; }
        .nota-key { font-size: .78rem; color: #9c7c5c; flex-shrink: 0; }
        .nota-val { font-size: .82rem; font-weight: 600; color: #3d2b1f; text-align: right; }
        .status-box { border-radius: 10px; padding: .85rem 1rem; margin: 1.25rem 0; display: flex; justify-content: space-between; align-items: center; background: #f0fdf4; border: 1px solid #bbf7d0; }
        .status-label { font-size: .78rem; font-weight: 600; color: #166534; }
        .status-val { font-size: 1rem; font-weight: 800; color: #166534; }
        .zigzag { height: 12px; background: repeating-linear-gradient(90deg, #f5efe6 0, #f5efe6 10px, #fff 10px, #fff 20px); margin: 1rem -2rem; }
        .nota-footer { text-align: center; padding: 1rem 2rem 1.5rem; border-top: 2px dashed #ede0cc; }
        .nota-footer p { font-size: .75rem; color: #9c7c5c; line-height: 1.6; }
        .nota-footer .thanks { font-family: 'Playfair Display', serif; font-size: .95rem; color: #5c3d1e; font-weight: 700; margin-bottom: .35rem; }
        .badge-borrowed { background: #fef3c7; color: #92400e; padding: .2rem .6rem; border-radius: 20px; font-size: .72rem; font-weight: 700; }
        @media print {
            body { background: #fff; padding: 0; }
            .print-actions { display: none !important; }
            .nota { box-shadow: none; border-radius: 0; }
            .nota-wrap { max-width: 100%; }
        }
    </style>
</head>
<body>
<div class="nota-wrap">
    <div class="print-actions">
        <button class="btn-print" onclick="window.print()">🖨️ Cetak Nota</button>
        <a href="{{ url()->previous() }}" class="btn-back">← Kembali</a>
    </div>

    <div class="nota">
        <div class="nota-header">
            <img src="{{ asset('images/pip-removebg-preview.png') }}" alt="Logo" class="nota-logo">
            <div class="nota-org">Perpustakaan Digital</div>
            <div class="nota-sub">Sistem Manajemen Perpustakaan</div>
        </div>

        <div class="nota-body">
            <div class="nota-title">Nota Peminjaman Buku</div>
            <div class="nota-code">No. <span>{{ $loan->loan_code }}</span></div>

            <div class="nota-section">
                <div class="nota-section-title">Data Anggota</div>
                <div class="nota-row">
                    <span class="nota-key">Nama</span>
                    <span class="nota-val">{{ $loan->member->name }}</span>
                </div>
                <div class="nota-row">
                    <span class="nota-key">Kode Anggota</span>
                    <span class="nota-val">{{ $loan->member->member_code }}</span>
                </div>
            </div>

            <div class="nota-section">
                <div class="nota-section-title">Data Buku</div>
                <div class="nota-row">
                    <span class="nota-key">Judul</span>
                    <span class="nota-val">{{ $loan->book->title }}</span>
                </div>
                <div class="nota-row">
                    <span class="nota-key">Pengarang</span>
                    <span class="nota-val">{{ $loan->book->author }}</span>
                </div>
                <div class="nota-row">
                    <span class="nota-key">Kategori</span>
                    <span class="nota-val">{{ $loan->book->category->name }}</span>
                </div>
                @if($loan->book->isbn)
                <div class="nota-row">
                    <span class="nota-key">ISBN</span>
                    <span class="nota-val">{{ $loan->book->isbn }}</span>
                </div>
                @endif
            </div>

            <div class="nota-section">
                <div class="nota-section-title">Detail Peminjaman</div>
                <div class="nota-row">
                    <span class="nota-key">Tanggal Pinjam</span>
                    <span class="nota-val">{{ $loan->loan_date->format('d M Y') }}</span>
                </div>
                <div class="nota-row">
                    <span class="nota-key">Jatuh Tempo</span>
                    <span class="nota-val">{{ $loan->due_date->format('d M Y') }}</span>
                </div>
                <div class="nota-row">
                    <span class="nota-key">Durasi</span>
                    <span class="nota-val">7 hari</span>
                </div>
                <div class="nota-row">
                    <span class="nota-key">Dikonfirmasi oleh</span>
                    <span class="nota-val">{{ $loan->user->name ?? 'Petugas' }}</span>
                </div>
                <div class="nota-row">
                    <span class="nota-key">Status</span>
                    <span class="nota-val"><span class="badge-borrowed">Dipinjam</span></span>
                </div>
            </div>

            <div class="status-box">
                <div class="status-label">✓ Peminjaman Dikonfirmasi</div>
                <div class="status-val">Aktif</div>
            </div>

            <div class="nota-row" style="border-bottom:none;margin-top:.5rem">
                <span class="nota-key">Denda keterlambatan</span>
                <span class="nota-val">Rp 1.000 / hari</span>
            </div>

            <div class="zigzag"></div>
        </div>

        <div class="nota-footer">
            <div class="thanks">Selamat Membaca!</div>
            <p>
                Nota dicetak pada {{ now()->format('d M Y, H:i') }}<br>
                Kembalikan buku sebelum <strong>{{ $loan->due_date->format('d M Y') }}</strong><br>
                <strong>Perpustakaan Digital</strong>
            </p>
        </div>
    </div>
</div>
</body>
</html>
