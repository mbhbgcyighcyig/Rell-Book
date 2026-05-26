<?php

namespace App\Http\Controllers\Peminjam;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Loan;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    public function index()
    {
        $member = auth()->user()->member;
        if (!$member) return redirect()->route('peminjam.dashboard');

        Loan::where('member_id', $member->id)
            ->where('status', 'borrowed')
            ->where('due_date', '<', Carbon::today())
            ->update(['status' => 'overdue']);

        $loans = Loan::with('book')
            ->where('member_id', $member->id)
            ->latest()
            ->paginate(10);

        return view('peminjam.loans', compact('loans', 'member'));
    }

    public function request(Request $request)
    {
        $request->validate(['book_id' => 'required|exists:books,id']);

        $member = auth()->user()->member;
        $book   = Book::findOrFail($request->book_id);

        if (!$member || !$member->isActive()) {
            return back()->with('error', 'Akun anggota tidak aktif.');
        }

        if ($member->hasOverdueLoans()) {
            return back()->with('error', 'Anda masih memiliki denda yang belum dibayar.');
        }

        // Hitung aktif + pending
        $activePending = Loan::where('member_id', $member->id)
            ->whereIn('status', ['borrowed', 'overdue', 'pending_approval'])
            ->count();

        if ($activePending >= 3) {
            return back()->with('error', 'Batas maksimal peminjaman 3 buku (termasuk yang menunggu konfirmasi).');
        }

        if (!$book->isAvailable()) {
            return back()->with('error', 'Stok buku tidak tersedia saat ini.');
        }

        // Cek duplikat
        if (Loan::where('member_id', $member->id)
            ->where('book_id', $book->id)
            ->whereIn('status', ['borrowed', 'overdue', 'pending_approval'])
            ->exists()) {
            return back()->with('error', 'Anda sudah mengajukan atau meminjam buku ini.');
        }

        $last = Loan::latest()->first();
        $num  = $last ? (int) substr($last->loan_code, 4) + 1 : 1;

        Loan::create([
            'loan_code'   => 'PJM-' . str_pad($num, 5, '0', STR_PAD_LEFT),
            'member_id'   => $member->id,
            'book_id'     => $book->id,
            'user_id'     => auth()->id(),   // peminjam yang request
            'borrower_id' => auth()->id(),   // simpan sebagai borrower
            'loan_date'   => Carbon::today(),
            'due_date'    => Carbon::today()->addDays(7),
            'status'      => 'pending_approval',
        ]);

        // Stok BELUM dikurangi — dikurangi saat petugas konfirmasi

        return redirect()->route('peminjam.loans')
            ->with('success', "Permintaan peminjaman \"{$book->title}\" berhasil diajukan. Tunggu konfirmasi petugas.");
    }

    public function cancelRequest(Loan $loan)
    {
        $member = auth()->user()->member;
        if (!$member || $loan->member_id !== $member->id) abort(403);
        if ($loan->status !== 'pending_approval') {
            return back()->with('error', 'Permintaan tidak bisa dibatalkan.');
        }

        $loan->delete();
        return back()->with('success', 'Permintaan peminjaman dibatalkan.');
    }

    public function nota(Loan $loan)
    {
        $member = auth()->user()->member;
        if (!$member || $loan->member_id !== $member->id) abort(403);
        if (!in_array($loan->status, ['borrowed', 'overdue', 'returned'])) abort(403);

        $loan->load(['book.category', 'member', 'user']);
        return view('peminjam.nota-pinjam', compact('loan'));
    }

    public function show(Loan $loan)
    {
        $member = auth()->user()->member;
        if (!$member || $loan->member_id !== $member->id) abort(403);

        $loan->load('book');
        return view('peminjam.loan-detail', compact('loan'));
    }
}
