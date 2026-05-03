<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Update overdue status
        Loan::where('status', 'borrowed')
            ->where('due_date', '<', Carbon::today())
            ->update(['status' => 'overdue']);

        $stats = [
            'total_books'    => Book::sum('total_stock'),
            'total_titles'   => Book::count(),
            'total_members'  => \App\Models\User::where('role', 'peminjam')->count(),
            'active_loans'   => Loan::whereIn('status', ['borrowed', 'overdue'])->count(),
            'overdue_loans'  => Loan::where('status', 'overdue')->count(),
            'returned_today' => Loan::whereDate('return_date', Carbon::today())->count(),
        ];

        $recentLoans = Loan::with(['member', 'book'])
            ->latest()
            ->take(8)
            ->get();

        $overdueLoans = Loan::with(['member', 'book'])
            ->where('status', 'overdue')
            ->orderBy('due_date')
            ->take(5)
            ->get();

        $popularBooks = Book::withCount(['loans' => fn($q) => $q->whereMonth('loan_date', Carbon::now()->month)])
            ->orderByDesc('loans_count')
            ->take(5)
            ->get();

        return view('dashboard', compact('stats', 'recentLoans', 'overdueLoans', 'popularBooks'));
    }
}
