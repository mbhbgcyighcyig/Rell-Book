@extends('layouts.app')
@section('title', 'Permintaan Pengembalian')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="fw-bold mb-0">Permintaan Pengembalian</h5>
        <small class="text-muted">{{ $totalPending }} permintaan menunggu konfirmasi</small>
    </div>
</div>

@if($totalPending > 0)
<div class="alert d-flex align-items-center gap-2 mb-4"
     style="background:#fef9ec;border:1px solid #f5d98b;color:#7c5a00">
    <i class="bi bi-bell-fill" style="color:#d97706"></i>
    Ada <strong>{{ $totalPending }}</strong> permintaan pengembalian yang perlu dikonfirmasi.
</div>
@endif

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Anggota</th>
                    <th>Buku</th>
                    <th>Tgl Pinjam</th>
                    <th>Jatuh Tempo</th>
                    <th>Status Pinjam</th>
                    <th>Catatan</th>
                    <th>Diajukan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($requests as $req)
                <tr class="{{ $req->loan->status=='overdue'?'table-warning':'' }}">
                    <td>
                        <div class="fw-semibold small">{{ $req->loan->member->name }}</div>
                        <div class="text-muted" style="font-size:.72rem">{{ $req->loan->member->member_code }}</div>
                    </td>
                    <td>
                        <div class="fw-semibold small">{{ $req->loan->book->title }}</div>
                        <div class="text-muted" style="font-size:.72rem">{{ $req->loan->book->author }}</div>
                    </td>
                    <td class="small">{{ $req->loan->loan_date->format('d/m/Y') }}</td>
                    <td class="small {{ $req->loan->status=='overdue'?'text-danger fw-semibold':'' }}">
                        {{ $req->loan->due_date->format('d/m/Y') }}
                        @if($req->loan->status=='overdue')
                        <br><small>{{ $req->loan->due_date->diffForHumans() }}</small>
                        @endif
                    </td>
                    <td>
                        <span class="badge badge-status-{{ $req->loan->status }} rounded-pill px-2" style="font-size:.72rem">
                            {{ ucfirst($req->loan->status) }}
                        </span>
                        @if($req->loan->status=='overdue')
                        @php $fine = $req->loan->calculateFine(); @endphp
                        <div class="text-danger" style="font-size:.7rem">Denda: Rp {{ number_format($fine['amount'],0,',','.') }}</div>
                        @endif
                    </td>
                    <td class="small text-muted">{{ $req->notes ?? '-' }}</td>
                    <td class="small text-muted">{{ $req->created_at->diffForHumans() }}</td>
                    <td>
                        <div class="d-flex gap-1">
                            <form action="{{ route('returns.staff.confirm', $req) }}" method="POST"
                                  onsubmit="return confirm('Konfirmasi pengembalian buku ini?')">
                                @csrf @method('PATCH')
                                <button class="btn btn-sm btn-success" title="Konfirmasi">
                                    <i class="bi bi-check-lg"></i>
                                </button>
                            </form>
                            <button class="btn btn-sm btn-outline-danger" title="Tolak"
                                    onclick="rejectModal({{ $req->id }})">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center text-muted py-5">
                        <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                        Tidak ada permintaan pengembalian
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-4">{{ $requests->links() }}</div>

{{-- Reject Modal --}}
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Tolak Permintaan</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="rejectForm" method="POST">
                @csrf @method('PATCH')
                <div class="modal-body">
                    <label class="form-label small fw-semibold">Alasan penolakan</label>
                    <textarea name="reason" class="form-control" rows="2" placeholder="Opsional..."></textarea>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger btn-sm">Tolak</button>
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
function rejectModal(id) {
    document.getElementById('rejectForm').action = '/return-requests/' + id + '/reject';
    new bootstrap.Modal(document.getElementById('rejectModal')).show();
}
</script>
@endpush
@endsection
