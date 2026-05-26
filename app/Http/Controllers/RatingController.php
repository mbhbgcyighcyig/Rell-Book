<?php

namespace App\Http\Controllers;

use App\Models\BookRating;
use App\Models\Book;
use App\Models\Loan;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function index(Request $request)
    {
        $query = BookRating::with(['book.category', 'user']);

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->whereHas('book', fn($b) => $b->where('title', 'like', "%{$request->search}%"))
                  ->orWhereHas('user', fn($u) => $u->where('name', 'like', "%{$request->search}%"));
            });
        }

        if ($request->rating) {
            $query->where('rating', $request->rating);
        }

        if ($request->book_id) {
            $query->where('book_id', $request->book_id);
        }

        $ratings      = $query->latest()->paginate(15)->withQueryString();
        $books        = Book::orderBy('title')->get(['id', 'title']);
        $totalRatings = BookRating::count();
        $avgRating    = round(BookRating::avg('rating') ?? 0, 1);
        $ratingDist   = BookRating::selectRaw('rating, count(*) as total')
                            ->groupBy('rating')
                            ->orderBy('rating', 'desc')
                            ->pluck('total', 'rating');

        // Top 5 buku paling banyak diulas
        $topBooks = Book::withCount('ratings')
                        ->withAvg('ratings', 'rating')
                        ->having('ratings_count', '>', 0)
                        ->orderByDesc('ratings_count')
                        ->take(5)
                        ->get();

        // Attach loan info ke setiap rating (buku yang sudah dikembalikan)
        foreach ($ratings as $r) {
            $r->loan = Loan::where('borrower_id', $r->user_id)
                           ->where('book_id', $r->book_id)
                           ->where('status', 'returned')
                           ->latest('return_date')
                           ->first();
        }

        return view('ratings.index', compact(
            'ratings', 'books', 'totalRatings', 'avgRating', 'ratingDist', 'topBooks'
        ));
    }

    public function destroy(BookRating $rating)
    {
        $rating->delete();
        return back()->with('success', 'Ulasan berhasil dihapus.');
    }
}
