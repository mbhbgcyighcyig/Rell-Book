<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use App\Models\Member;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        return view('reports.index');
    }

    public function loans(Request $request)
    {
        $from = $request->from ? Carbon::parse($request->from) : Carbon::now()->startOfMonth();
        $to   = $request->to   ? Carbon::parse($request->to)   : Carbon::now()->endOfMonth();

        $loans = Loan::with(['member', 'book'])
            ->whereBetween('loan_date', [$from, $to])
            ->get();

        $summary = [
            'total'    => $loans->count(),
            'returned' => $loans->where('status', 'returned')->count(),
            'overdue'  => $loans->where('status', 'overdue')->count(),
            'borrowed' => $loans->where('status', 'borrowed')->count(),
            'fines'    => $loans->sum('fine_amount'),
        ];

        return view('reports.loans', compact('loans', 'summary', 'from', 'to'));
    }

    public function popularBooks()
    {
        $books = Book::withCount('loans')->orderByDesc('loans_count')->take(20)->get();
        return view('reports.popular-books', compact('books'));
    }

    public function fines(Request $request)
    {
        // Base query (tanpa filter paid) untuk summary stats
        $baseQuery = Loan::where('fine_amount', '>', 0);

        if ($request->month && $request->year) {
            $baseQuery->whereMonth('return_date', $request->month)
                      ->whereYear('return_date', $request->year);
        } elseif ($request->year) {
            $baseQuery->whereYear('return_date', $request->year);
        } elseif ($request->month) {
            $baseQuery->whereMonth('return_date', $request->month);
        }

        // Summary stats dari base query (date-filtered)
        $summary = [
            'total_amount'  => (clone $baseQuery)->sum('fine_amount'),
            'unpaid_amount' => (clone $baseQuery)->where('fine_paid', false)->sum('fine_amount'),
            'paid_amount'   => (clone $baseQuery)->where('fine_paid', true)->sum('fine_amount'),
            'total_cases'   => (clone $baseQuery)->count(),
            'unpaid_cases'  => (clone $baseQuery)->where('fine_paid', false)->count(),
        ];

        // Paginated query dengan filter paid di atas base
        $query = (clone $baseQuery)->with(['member', 'book']);

        if ($request->paid === '1') $query->where('fine_paid', true);
        if ($request->paid === '0') $query->where('fine_paid', false);

        $loans = $query->latest()->paginate(20)->withQueryString();

        // Backward compat
        $totalUnpaid = Loan::where('fine_amount', '>', 0)->where('fine_paid', false)->sum('fine_amount');

        return view('reports.fines', compact('loans', 'totalUnpaid', 'summary'));
    }
}
