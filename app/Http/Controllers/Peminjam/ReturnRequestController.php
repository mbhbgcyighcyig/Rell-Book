<?php

namespace App\Http\Controllers\Peminjam;

use App\Http\Controllers\Controller;
use App\Models\Loan;
use App\Models\ReturnRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReturnRequestController extends Controller
{
    public function index()
    {
        $member = auth()->user()->member;
        if (!$member) return redirect()->route('peminjam.dashboard');

        // Update overdue
        Loan::where('member_id', $member->id)
            ->where('status', 'borrowed')
            ->where('due_date', '<', Carbon::today())
            ->update(['status' => 'overdue']);

        $activeLoans = Loan::with(['book', 'returnRequest'])
            ->where('member_id', $member->id)
            ->whereIn('status', ['borrowed', 'overdue'])
            ->latest()
            ->get();

        $returnHistory = Loan::with(['book', 'returnRequest.confirmedBy'])
            ->where('member_id', $member->id)
            ->where('status', 'returned')
            ->latest('return_date')
            ->paginate(8);

        return view('peminjam.returns', compact('activeLoans', 'returnHistory', 'member'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'loan_id' => 'required|exists:loans,id',
            'notes'   => 'nullable|string|max:300',
        ]);

        $member = auth()->user()->member;
        $loan   = Loan::where('id', $request->loan_id)
            ->where('member_id', $member->id)
            ->whereIn('status', ['borrowed', 'overdue'])
            ->firstOrFail();

        // Cek sudah ada request pending
        if ($loan->returnRequest && $loan->returnRequest->isPending()) {
            return back()->with('error', 'Permintaan pengembalian sudah diajukan, tunggu konfirmasi petugas.');
        }

        ReturnRequest::updateOrCreate(
            ['loan_id' => $loan->id],
            [
                'user_id' => auth()->id(),
                'status'  => 'pending',
                'notes'   => $request->notes,
                'confirmed_at' => null,
                'confirmed_by' => null,
            ]
        );

        return back()->with('success', 'Permintaan pengembalian berhasil diajukan. Tunggu konfirmasi petugas.');
    }

    public function cancel(ReturnRequest $returnRequest)
    {
        if ($returnRequest->user_id !== auth()->id() || !$returnRequest->isPending()) {
            return back()->with('error', 'Tidak bisa membatalkan permintaan ini.');
        }

        $returnRequest->delete();
        return back()->with('success', 'Permintaan pengembalian dibatalkan.');
    }

    public function nota(Loan $loan)
    {
        $member = auth()->user()->member;
        if (!$member || $loan->member_id !== $member->id || $loan->status !== 'returned') {
            abort(403);
        }
        $loan->load(['book.category', 'returnRequest.confirmedBy', 'member']);
        return view('peminjam.nota', compact('loan'));
    }
}
