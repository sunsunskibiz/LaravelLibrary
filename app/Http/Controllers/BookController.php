<?php

namespace App\Http\Controllers;

use App\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function store(Request $request)
    {
        $book = Book::create($this->getValidate($request));
        return redirect($book->path());
    }

    public function update(Request $request, Book $book)
    {
        $book->update($this->getValidate($request));
        return redirect($book->path());
    }

    public function destroy(Book $book)
    {
        $book->delete();
        return redirect('/books');
    }

    protected function getValidate(Request $request): array
    {
        return $request->validate([
            'title'  => 'required',
            'author' => 'required',
        ]);
    }
}
