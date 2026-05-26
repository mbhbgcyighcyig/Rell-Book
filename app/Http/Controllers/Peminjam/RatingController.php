<?php

namespace App\Http\Controllers\Peminjam;

use App\Http\Controllers\Controller;
use App\Models\BookRating;
use App\Models\Loan;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        $myRatings = BookRating::with('book.category')
            ->where('user_id', $userId)
            ->latest()
            ->get();

        // Buku yang sudah dikembalikan tapi belum dirating
        $returnedBookIds = Loan::where('borrower_id', $userId)
            ->where('status', 'returned')
            ->pluck('book_id')
            ->unique();

        $ratedBookIds = BookRating::where('user_id', $userId)->pluck('book_id');

        $unratedBooks = \App\Models\Book::with('category')
            ->whereIn('id', $returnedBookIds->diff($ratedBookIds))
            ->get();

        $communityRatings = BookRating::with(['book', 'user'])
            ->latest()
            ->paginate(12);

        return view('peminjam.ulasan', compact('myRatings', 'unratedBooks', 'communityRatings'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'rating'  => 'required|integer|min:1|max:5',
            'review'  => 'nullable|string|max:500',
        ]);

        $userId = auth()->id();

        // Hanya boleh rating jika sudah pernah mengembalikan buku ini
        $hasReturned = Loan::where('borrower_id', $userId)
            ->where('book_id', $request->book_id)
            ->where('status', 'returned')
            ->exists();

        if (!$hasReturned) {
            return back()->with('error', 'Kamu hanya bisa memberi rating buku yang sudah dikembalikan.');
        }

        BookRating::updateOrCreate(
            ['book_id' => $request->book_id, 'user_id' => $userId],
            ['rating'  => $request->rating, 'review' => $request->review]
        );

        return back()->with('success', 'Rating berhasil disimpan!');
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
        ]);

        BookRating::where('book_id', $request->book_id)
            ->where('user_id', auth()->id())
            ->delete();

        return back()->with('success', 'Rating berhasil dihapus.');
    }
}
