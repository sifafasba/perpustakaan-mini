<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::with('category');

        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('author', 'like', '%' . $request->search . '%');
        }

        if ($request->has('category_id') && $request->category_id != '') {
            $query->where('category_id', $request->category_id);
        }

        $books = $query->paginate(10);
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
        $request->validate([
            'title' => 'required|min:3',
            'author' => 'required',
            'year' => 'required|integer|min:1900|max:' . date('Y'),
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'isbn' => 'nullable|unique:books,isbn',
        ]);

        Book::create($request->all());

        return redirect()->route('books.index')
            ->with('success', 'Buku berhasil ditambahkan');
    }

    public function show(Book $book)
    {
        return view('books.show', compact('book'));
    }

    public function edit(Book $book)
    {
        $categories = Category::all();
        return view('books.edit', compact('book', 'categories'));
    }

    public function update(Request $request, Book $book)
    {
        $request->validate([
            'title' => 'required|min:3',
            'author' => 'required',
            'year' => 'required|integer|min:1900|max:' . date('Y'),
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'isbn' => 'nullable|unique:books,isbn,' . $book->id,
        ]);

        $book->update($request->all());

        return redirect()->route('books.index')
            ->with('success', 'Buku berhasil diperbarui');
    }

    public function destroy(Book $book)
    {
        $book->delete();
        return redirect()->route('books.index')
            ->with('success', 'Buku berhasil dihapus');
    }
}
