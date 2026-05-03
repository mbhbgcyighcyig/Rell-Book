<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\ReturnRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReturnRequestController extends Controller
{
    public function index(Request $request)
    {
        $query = ReturnRequest::with(['loan.member', 'loan.book', 'user'])
            ->where('status', 'pending');

        $requests = $query->latest()->paginate(15);
        $totalPending = ReturnRequest::where('status', 'pending')->count();

        return view('returns.index', compact('requests', 'totalPending'));
    }

    public function confirm(ReturnRequest $returnRequest)
    {
        if (!$returnRequest->isPending()) {
            return back()->with('error', 'Permintaan ini sudah diproses.');
        }

        $loan = $returnRequest->loan;

        if ($loan->status === 'returned') {
            return back()->with('error', 'Buku sudah dikembalikan.');
        }

        $returnDate = Carbon::today();
        $fine = $loan->calculateFine();

        // Proses pengembalian
        $loan->update([
            'return_date' => $returnDate,
            'status'      => 'returned',
            'fine_days'   => $fine['days'],
            'fine_amount' => $fine['amount'],
            'fine_paid'   => $fine['amount'] == 0,
        ]);

        $loan->book->increment('stock');

        // Update return request
        $returnRequest->update([
            'status'       => 'confirmed',
            'confirmed_at' => now(),
            'confirmed_by' => auth()->id(),
        ]);

        $msg = "Pengembalian buku \"{$loan->book->title}\" berhasil dikonfirmasi.";
        if ($fine['amount'] > 0) {
            $msg .= " Denda: Rp " . number_format($fine['amount'], 0, ',', '.');
        }

        return back()->with('success', $msg);
    }

    public function reject(Request $request, ReturnRequest $returnRequest)
    {
        if (!$returnRequest->isPending()) {
            return back()->with('error', 'Permintaan ini sudah diproses.');
        }

        $returnRequest->update([
            'status'       => 'rejected',
            'confirmed_at' => now(),
            'confirmed_by' => auth()->id(),
            'notes'        => $request->reason ?? 'Ditolak oleh petugas.',
        ]);

        return back()->with('success', 'Permintaan pengembalian ditolak.');
    }
}
