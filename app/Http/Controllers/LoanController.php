<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use App\Models\Member;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    public function index(Request $request)
    {
        // Auto-update overdue
        Loan::where('status', 'borrowed')
            ->where('due_date', '<', Carbon::today())
            ->update(['status' => 'overdue']);

        $query = Loan::with(['member', 'book', 'user']);

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('loan_code', 'like', "%{$request->search}%")
                  ->orWhereHas('member', fn($m) => $m->where('name', 'like', "%{$request->search}%"))
                  ->orWhereHas('book', fn($b) => $b->where('title', 'like', "%{$request->search}%"));
            });
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $loans = $query->latest()->paginate(15)->withQueryString();
        $pendingCount = Loan::where('status', 'pending_approval')->count();

        return view('loans.index', compact('loans', 'pendingCount'));
    }

    // Konfirmasi peminjaman dari peminjam
    public function confirmLoan(Loan $loan)
    {
        if ($loan->status !== 'pending_approval') {
            return back()->with('error', 'Peminjaman ini tidak dalam status menunggu konfirmasi.');
        }

        if (!$loan->book->isAvailable()) {
            return back()->with('error', 'Stok buku tidak tersedia.');
        }

        $loan->update([
            'status'    => 'borrowed',
            'user_id'   => auth()->id(), // petugas yang konfirmasi
            'loan_date' => Carbon::today(),
            'due_date'  => Carbon::today()->addDays(7),
        ]);

        $loan->book->decrement('stock');

        return back()->with('success', "Peminjaman {$loan->loan_code} berhasil dikonfirmasi.");
    }

    // Tolak peminjaman dari peminjam
    public function rejectLoan(Loan $loan)
    {
        if ($loan->status !== 'pending_approval') {
            return back()->with('error', 'Peminjaman ini tidak dalam status menunggu konfirmasi.');
        }

        $loan->update(['status' => 'rejected']);

        return back()->with('success', "Peminjaman {$loan->loan_code} ditolak.");
    }

    // Nota peminjaman (staff)
    public function notaLoan(Loan $loan)
    {
        if (!in_array($loan->status, ['borrowed', 'overdue', 'returned'])) {
            return back()->with('error', 'Nota hanya tersedia untuk peminjaman yang sudah dikonfirmasi.');
        }
        $loan->load(['member', 'book.category', 'user']);
        return view('loans.nota-pinjam', compact('loan'));
    }

    public function create()
    {
        if (auth()->user()->isAdmin()) abort(403, 'Admin tidak bisa meminjam buku.');

        $members = Member::where('status', 'active')->get();
        $books = Book::where('stock', '>', 0)->get();
        return view('loans.create', compact('members', 'books'));
    }

    public function store(Request $request)
    {
        if (auth()->user()->isAdmin()) abort(403, 'Admin tidak bisa meminjam buku.');
        $data = $request->validate([
            'member_id' => 'required|exists:members,id',
            'book_id'   => 'required|exists:books,id',
            'loan_date' => 'required|date',
            'due_date'  => 'required|date|after:loan_date',
            'notes'     => 'nullable|string',
        ]);

        $member = Member::findOrFail($data['member_id']);
        $book = Book::findOrFail($data['book_id']);

        if (!$member->isActive()) {
            return back()->with('error', 'Anggota tidak aktif.')->withInput();
        }

        if ($member->hasOverdueLoans()) {
            return back()->with('error', 'Anggota masih memiliki denda yang belum dibayar.')->withInput();
        }

        if ($member->activeLoans()->count() >= 3) {
            return back()->with('error', 'Anggota sudah meminjam 3 buku (batas maksimal).')->withInput();
        }

        if (!$book->isAvailable()) {
            return back()->with('error', 'Stok buku tidak tersedia.')->withInput();
        }

        // Check duplicate active loan
        if (Loan::where('member_id', $member->id)->where('book_id', $book->id)->whereIn('status', ['borrowed', 'overdue'])->exists()) {
            return back()->with('error', 'Anggota sudah meminjam buku ini.')->withInput();
        }

        $data['loan_code'] = Loan::generateCode();
        $data['user_id'] = auth()->id();
        $data['status'] = 'borrowed';

        Loan::create($data);
        $book->decrement('stock');

        return redirect()->route('loans.index')->with('success', "Peminjaman {$data['loan_code']} berhasil dicatat.");
    }

    public function show(Loan $loan)
    {
        $loan->load(['member', 'book', 'user']);
        return view('loans.show', compact('loan'));
    }

    public function returnBook(Loan $loan)
    {
        if ($loan->status === 'returned') {
            return back()->with('error', 'Buku sudah dikembalikan.');
        }

        $returnDate = Carbon::today();
        $fine = $loan->calculateFine();

        $loan->update([
            'return_date'  => $returnDate,
            'status'       => 'returned',
            'fine_days'    => $fine['days'],
            'fine_amount'  => $fine['amount'],
            'fine_paid'    => $fine['amount'] == 0,
        ]);

        $loan->book->increment('stock');

        $msg = "Buku berhasil dikembalikan.";
        if ($fine['amount'] > 0) {
            $msg .= " Denda: Rp " . number_format($fine['amount'], 0, ',', '.');
        }

        return redirect()->route('loans.index')->with('success', $msg);
    }

    public function payFine(Loan $loan)
    {
        if ($loan->fine_amount <= 0 || $loan->fine_paid) {
            return back()->with('error', 'Tidak ada denda yang perlu dibayar.');
        }

        $loan->update(['fine_paid' => true]);

        return back()->with('success', 'Denda berhasil dibayar.');
    }

    public function history(Request $request)
    {
        $query = Loan::with(['member', 'book'])->where('status', 'returned');

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('loan_code', 'like', "%{$request->search}%")
                  ->orWhereHas('member', fn($m) => $m->where('name', 'like', "%{$request->search}%"));
            });
        }

        $loans = $query->latest('return_date')->paginate(15)->withQueryString();

        return view('loans.history', compact('loans'));
    }
}
