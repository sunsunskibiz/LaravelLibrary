<?php

namespace App\Http\Controllers;

use App\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function store(Request $request)
    {
        Book::create($this->getValidate($request));
    }

    public function update(Request $request, Book $book)
    {
        $book->update($this->getValidate($request));
    }

    protected function getValidate(Request $request): array
    {
        return $request->validate([
            'title'  => 'required',
            'author' => 'required',
        ]);
    }
}
