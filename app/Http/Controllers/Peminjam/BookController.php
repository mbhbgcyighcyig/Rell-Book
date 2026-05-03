<?php

namespace App\Http\Controllers\Peminjam;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::with('category');

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', "%{$request->search}%")
                  ->orWhere('author', 'like', "%{$request->search}%")
                  ->orWhere('isbn', 'like', "%{$request->search}%");
            });
        }

        if ($request->category_id) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->availability === 'available') {
            $query->where('stock', '>', 0);
        }

        $books      = $query->latest()->paginate(12)->withQueryString();
        $categories = Category::all();

        return view('peminjam.books', compact('books', 'categories'));
    }

    public function show(Book $book)
    {
        $book->load(['category', 'ratings.user']);

        $userRating   = $book->ratings()->where('user_id', auth()->id())->first();
        $avgRating    = $book->averageRating();
        $ratingCount  = $book->ratingCount();

        // Cek apakah user pernah meminjam buku ini
        $hasBorrowed = \App\Models\Loan::where('user_id', auth()->id())
            ->where('book_id', $book->id)
            ->where('status', 'returned')
            ->exists();

        return view('peminjam.book-detail', compact('book', 'userRating', 'avgRating', 'ratingCount', 'hasBorrowed'));
    }
}
