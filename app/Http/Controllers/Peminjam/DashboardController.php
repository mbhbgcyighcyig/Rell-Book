<?php

namespace App\Http\Controllers\Peminjam;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Loan;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $member = auth()->user()->member;

        if (!$member) {
            return view('peminjam.dashboard', ['member' => null, 'loans' => collect(), 'availableBooks' => collect()]);
        }

        // Update overdue
        Loan::where('member_id', $member->id)
            ->where('status', 'borrowed')
            ->where('due_date', '<', Carbon::today())
            ->update(['status' => 'overdue']);

        $loans = Loan::with('book')
            ->where('member_id', $member->id)
            ->latest()
            ->take(5)
            ->get();

        $activeLoans = Loan::where('member_id', $member->id)
            ->whereIn('status', ['borrowed', 'overdue'])
            ->count();

        $availableBooks = Book::with('category')
            ->where('stock', '>', 0)
            ->latest()
            ->take(8)
            ->get();

        $unpaidFines = Loan::where('member_id', $member->id)
            ->where('fine_paid', false)
            ->where('fine_amount', '>', 0)
            ->sum('fine_amount');

        return view('peminjam.dashboard', compact('member', 'loans', 'availableBooks', 'activeLoans', 'unpaidFines'));
    }
}
