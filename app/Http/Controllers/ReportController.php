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
        $query = Loan::with(['member', 'book'])
            ->where('fine_amount', '>', 0);

        if ($request->paid === '1') $query->where('fine_paid', true);
        if ($request->paid === '0') $query->where('fine_paid', false);

        $loans = $query->latest()->paginate(20)->withQueryString();
        $totalUnpaid = Loan::where('fine_amount', '>', 0)->where('fine_paid', false)->sum('fine_amount');

        return view('reports.fines', compact('loans', 'totalUnpaid'));
    }
}
