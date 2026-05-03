<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        } elseif ($request->availability === 'unavailable') {
            $query->where('stock', 0);
        }

        $books = $query->latest()->paginate(12)->withQueryString();
        $categories = Category::all();

        return view('books.index', compact('books', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('books.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'          => 'required|string|max:255',
            'author'         => 'required|string|max:255',
            'isbn'           => 'nullable|string|unique:books,isbn',
            'category_id'    => 'required|exists:categories,id',
            'publisher'      => 'nullable|string|max:255',
            'published_year' => 'nullable|integer|min:1000|max:' . date('Y'),
            'stock'          => 'required|integer|min:0',
            'description'    => 'nullable|string',
            'cover'          => 'nullable|image|max:2048',
            'rack_location'  => 'nullable|string|max:50',
        ]);

        $data['total_stock'] = $data['stock'];

        if ($request->hasFile('cover')) {
            $data['cover'] = $request->file('cover')->store('covers', 'public');
        }

        Book::create($data);

        return redirect()->route('books.index')->with('success', 'Buku berhasil ditambahkan.');
    }

    public function show(Book $book)
    {
        $book->load(['category', 'loans' => fn($q) => $q->with('member')->latest()->take(10)]);
        return view('books.show', compact('book'));
    }

    public function edit(Book $book)
    {
        $categories = Category::all();
        return view('books.edit', compact('book', 'categories'));
    }

    public function update(Request $request, Book $book)
    {
        $data = $request->validate([
            'title'          => 'required|string|max:255',
            'author'         => 'required|string|max:255',
            'isbn'           => 'nullable|string|unique:books,isbn,' . $book->id,
            'category_id'    => 'required|exists:categories,id',
            'publisher'      => 'nullable|string|max:255',
            'published_year' => 'nullable|integer|min:1000|max:' . date('Y'),
            'stock'          => 'required|integer|min:0',
            'total_stock'    => 'required|integer|min:0',
            'description'    => 'nullable|string',
            'cover'          => 'nullable|image|max:2048',
            'rack_location'  => 'nullable|string|max:50',
        ]);

        if ($request->hasFile('cover')) {
            if ($book->cover) Storage::disk('public')->delete($book->cover);
            $data['cover'] = $request->file('cover')->store('covers', 'public');
        }

        $book->update($data);

        return redirect()->route('books.index')->with('success', 'Buku berhasil diperbarui.');
    }

    public function destroy(Book $book)
    {
        if ($book->loans()->whereIn('status', ['borrowed', 'overdue'])->exists()) {
            return back()->with('error', 'Buku sedang dipinjam, tidak bisa dihapus.');
        }

        if ($book->cover) Storage::disk('public')->delete($book->cover);
        $book->delete();

        return redirect()->route('books.index')->with('success', 'Buku berhasil dihapus.');
    }
}
