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
        $myRatings = BookRating::with('book.category')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        $communityRatings = BookRating::with(['book', 'user'])
            ->latest()
            ->paginate(12);

        return view('peminjam.ulasan', compact('myRatings', 'communityRatings'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'rating'  => 'required|integer|min:1|max:5',
            'review'  => 'nullable|string|max:500',
        ]);

        $hasBorrowed = Loan::where('user_id', auth()->id())
            ->where('book_id', $request->book_id)
            ->where('status', 'returned')
            ->exists();

        if (!$hasBorrowed) {
            return back()->with('error', 'Kamu hanya bisa memberi rating buku yang sudah pernah dipinjam.');
        }

        BookRating::updateOrCreate(
            ['book_id' => $request->book_id, 'user_id' => auth()->id()],
            ['rating'  => $request->rating, 'review' => $request->review]
        );

        return back()->with('success', 'Rating berhasil disimpan!');
    }

    public function destroy(Request $request)
    {
        BookRating::where('book_id', $request->book_id)
            ->where('user_id', auth()->id())
            ->delete();

        return back()->with('success', 'Rating berhasil dihapus.');
    }
}
