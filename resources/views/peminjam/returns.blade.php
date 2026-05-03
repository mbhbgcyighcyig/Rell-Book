@extends('layouts.peminjam')
@section('title', 'Pengembalian Buku')

@section('content')

<div class="returns-hero mb-4">
    <div class="position-relative" style="z-index:1">
        <h4 style="font-family:'Playfair Display',serif;font-weight:800;color:#fff;margin:0 0 .3rem;font-size:1.6rem;text-shadow:0 2px 8px rgba(0,0,0,.4)">Pengembalian Buku</h4>
        <p style="color:rgba(255,255,255,.8);font-size:.88rem;margin:0">Ajukan pengembalian buku yang sedang kamu pinjam</p>
    </div>
</div>

{{-- Info cara kerja --}}
<div class="card mb-4" style="border-left:3px solid var(--brown-light)">
    <div class="card-body py-3">
        <div class="d-flex align-items-start gap-3">
            <i class="bi bi-info-circle-fill mt-1" style="color:var(--brown);font-size:1.1rem;flex-shrink:0"></i>
            <div style="font-size:.83rem;color:var(--text-muted)">
                <strong style="color:var(--brown-dark)">Cara pengembalian:</strong>
                Ajukan permintaan pengembalian di bawah → Bawa buku ke perpustakaan → Petugas konfirmasi pengembalian.
                Denda keterlambatan dihitung otomatis saat petugas mengkonfirmasi.
            </div>
        </div>
    </div>
</div>

{{-- Pinjaman Aktif --}}
<div class="card mb-4">
    <div class="card-header">
        <i class="bi bi-arrow-return-left me-2" style="color:var(--brown)"></i>
        Buku yang Sedang Dipinjam
        <span class="badge ms-2 rounded-pill" style="background:var(--cream-dark);color:var(--brown);font-size:.72rem">
            {{ $activeLoans->count() }}
        </span>
    </div>
    <div class="card-body p-0">
        @forelse($activeLoans as $loan)
        @php $req = $loan->returnRequest; @endphp
        <div class="d-flex align-items-center gap-3 px-4 py-3 border-bottom {{ $loan->status=='overdue'?'bg-danger bg-opacity-5':'' }}"
             style="border-color:var(--cream-dark)!important">

            {{-- Cover --}}
            <div class="return-cover" style="background:{{ ['linear-gradient(160deg,#8b5e3c,#c49a6c)','linear-gradient(160deg,#5c8a3c,#8bc34a)','linear-gradient(160deg,#c0392b,#e57373)','linear-gradient(160deg,#1565c0,#64b5f6)','linear-gradient(160deg,#6a1b9a,#ce93d8)','linear-gradient(160deg,#e65100,#ffb74d)','linear-gradient(160deg,#00695c,#4db6ac)','linear-gradient(160deg,#37474f,#90a4ae)'][($loan->book_id-1)%8] }}">
                @if($loan->book->coverUrl())
                    <img src="{{ $loan->book->coverUrl() }}" style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover">
                @else
                    <i class="bi bi-book-fill text-white" style="font-size:.9rem;opacity:.8;position:relative;z-index:1"></i>
                @endif
            </div>

            {{-- Info --}}
            <div class="flex-grow-1 min-w-0">
                <div class="fw-700" style="font-size:.88rem;color:var(--brown-dark)">{{ $loan->book->title }}</div>
                <div style="font-size:.75rem;color:var(--text-muted)">{{ $loan->book->author }}</div>
                <div class="d-flex flex-wrap gap-2 mt-1">
                    <span style="font-size:.72rem;color:var(--text-muted)">
                        <i class="bi bi-calendar3 me-1"></i>Pinjam: {{ $loan->loan_date->format('d M Y') }}
                    </span>
                    <span style="font-size:.72rem;color:{{ $loan->status=='overdue'?'#c0392b':'var(--text-muted)' }};font-weight:{{ $loan->status=='overdue'?'600':'400' }}">
                        <i class="bi bi-alarm me-1"></i>Jatuh tempo: {{ $loan->due_date->format('d M Y') }}
                        @if($loan->status=='overdue')
                            <span class="badge bg-danger ms-1" style="font-size:.62rem">{{ $loan->due_date->diffForHumans() }}</span>
                        @endif
                    </span>
                </div>
                @if($req && $req->isPending())
                <div class="mt-1 d-inline-flex align-items-center gap-1 px-2 py-1 rounded"
                     style="background:#fef9ec;border:1px solid #f5d98b;font-size:.72rem;color:#7c5a00">
                    <i class="bi bi-hourglass-split"></i> Menunggu konfirmasi petugas
                </div>
                @endif
            </div>

            {{-- Status & Aksi --}}
            <div class="d-flex flex-column align-items-end gap-2 flex-shrink-0">
                <span class="badge badge-status-{{ $loan->status }} rounded-pill" style="font-size:.7rem">
                    {{ ucfirst($loan->status) }}
                </span>

                @if(!$req || $req->status === 'rejected')
                <button class="btn btn-primary btn-sm px-3"
                        onclick="toggleForm({{ $loan->id }})">
                    <i class="bi bi-arrow-return-left me-1"></i>Ajukan Kembali
                </button>
                {{-- Inline form --}}
                <div id="returnForm{{ $loan->id }}" style="display:none;margin-top:.5rem">
                    <form action="{{ route('peminjam.returns.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="loan_id" value="{{ $loan->id }}">
                        <textarea name="notes" class="form-control mb-2" rows="2"
                                  placeholder="Catatan kondisi buku (opsional)..."
                                  style="font-size:.78rem;border-color:var(--cream-dark)"></textarea>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary btn-sm px-3">
                                <i class="bi bi-send me-1"></i>Ajukan
                            </button>
                            <button type="button" class="btn btn-outline-secondary btn-sm"
                                    onclick="toggleForm({{ $loan->id }})">Batal</button>
                        </div>
                    </form>
                </div>
                @elseif($req->isPending())
                <form action="{{ route('peminjam.returns.cancel', $req) }}" method="POST"
                      onsubmit="return confirm('Batalkan permintaan pengembalian?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-outline-secondary btn-sm px-3">
                        <i class="bi bi-x me-1"></i>Batalkan
                    </button>
                </form>
                @endif
            </div>
        </div>
        @empty
        <div class="text-center py-5">
            <div style="font-size:3rem;margin-bottom:.75rem">✅</div>
            <div class="fw-600" style="color:var(--text-muted)">Tidak ada buku yang sedang dipinjam</div>
            <a href="{{ route('peminjam.books') }}" class="btn btn-primary btn-sm mt-2">Cari Buku</a>
        </div>
        @endforelse
    </div>
</div>

{{-- Riwayat Pengembalian --}}
<div class="card">
    <div class="card-header">
        <i class="bi bi-clock-history me-2" style="color:var(--brown)"></i>Riwayat Pengembalian
    </div>
    <div class="card-body p-0">
        @forelse($returnHistory as $loan)
        <div class="d-flex align-items-center gap-3 px-4 py-3 border-bottom" style="border-color:var(--cream-dark)!important">
            <div class="return-cover" style="background:{{ ['linear-gradient(160deg,#8b5e3c,#c49a6c)','linear-gradient(160deg,#5c8a3c,#8bc34a)','linear-gradient(160deg,#c0392b,#e57373)','linear-gradient(160deg,#1565c0,#64b5f6)','linear-gradient(160deg,#6a1b9a,#ce93d8)','linear-gradient(160deg,#e65100,#ffb74d)','linear-gradient(160deg,#00695c,#4db6ac)','linear-gradient(160deg,#37474f,#90a4ae)'][($loan->book_id-1)%8] }}">
                @if($loan->book->coverUrl())
                    <img src="{{ $loan->book->coverUrl() }}" style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover">
                @else
                    <i class="bi bi-book-fill text-white" style="font-size:.9rem;opacity:.8;position:relative;z-index:1"></i>
                @endif
            </div>
            <div class="flex-grow-1 min-w-0">
                <div class="fw-700" style="font-size:.88rem;color:var(--brown-dark)">{{ $loan->book->title }}</div>
                <div style="font-size:.75rem;color:var(--text-muted)">{{ $loan->book->author }}</div>
                <div class="d-flex flex-wrap gap-3 mt-1">
                    <span style="font-size:.72rem;color:var(--text-muted)">
                        <i class="bi bi-calendar3 me-1"></i>{{ $loan->loan_date->format('d M Y') }} — {{ $loan->return_date->format('d M Y') }}
                    </span>
                    @if($loan->returnRequest?->confirmedBy)
                    <span style="font-size:.72rem;color:var(--text-muted)">
                        <i class="bi bi-person-check me-1"></i>Dikonfirmasi oleh {{ $loan->returnRequest->confirmedBy->name }}
                    </span>
                    @endif
                </div>
            </div>
            <div class="d-flex flex-column align-items-end gap-1 flex-shrink-0">
                <span class="badge badge-status-returned rounded-pill" style="font-size:.7rem">Dikembalikan</span>
                @if($loan->fine_amount > 0)
                <span class="badge rounded-pill {{ $loan->fine_paid?'bg-success':'bg-danger' }}" style="font-size:.68rem">
                    Denda Rp {{ number_format($loan->fine_amount,0,',','.') }}
                    {{ $loan->fine_paid?'(lunas)':'(belum bayar)' }}
                </span>
                @endif
                <a href="{{ route('peminjam.returns.nota', $loan) }}" target="_blank"
                   class="btn btn-outline-primary btn-sm mt-1" style="font-size:.72rem">
                    <i class="bi bi-printer me-1"></i>Cetak Nota
                </a>
            </div>
        </div>
        @empty
        <div class="text-center py-4" style="font-size:.85rem;color:var(--text-muted)">
            Belum ada riwayat pengembalian
        </div>
        @endforelse
    </div>
    @if($returnHistory->hasPages())
    <div class="card-body pt-0">{{ $returnHistory->links() }}</div>
    @endif
</div>

@push('styles')
<style>
.page-header-cream { background:linear-gradient(135deg,#fff9f2,var(--cream));border:1px solid var(--cream-dark);border-radius:14px;padding:1.5rem 2rem;display:flex;justify-content:space-between;align-items:center; }
.page-title { font-family:'Playfair Display',serif;font-weight:800;color:var(--brown-dark);margin:0 0 .25rem; }
.page-sub { color:var(--text-muted);font-size:.85rem;margin:0; }
.returns-hero {
    background: url('{{ asset("images/pop.jpg") }}') center/cover no-repeat;
    border-radius: 16px; padding: 2.5rem 2rem;
    position: relative; overflow: hidden;
    min-height: 140px; display: flex; align-items: center;
}
.returns-hero::before {
    content: ''; position: absolute; inset: 0;
    background: linear-gradient(135deg, rgba(92,61,30,.8) 0%, rgba(139,94,60,.6) 60%, rgba(0,0,0,.3) 100%);
    border-radius: 16px;
}
.return-cover { width:44px;height:58px;border-radius:3px 7px 7px 3px;flex-shrink:0;position:relative;overflow:hidden;display:flex;align-items:center;justify-content:center;box-shadow:2px 2px 8px rgba(0,0,0,.12); }
.inline-form { background:var(--cream);border:1px solid var(--cream-dark);border-radius:10px;padding:.85rem;margin-top:.5rem; }
</style>
@endpush

@push('scripts')
<script>
function toggleForm(loanId) {
    const el = document.getElementById('returnForm' + loanId);
    el.style.display = el.style.display === 'none' ? 'block' : 'none';
}
</script>
@endpush
@endsection
