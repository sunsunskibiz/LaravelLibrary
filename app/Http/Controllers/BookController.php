<?php

namespace App\Http\Controllers;

use App\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function store(Request $request)
    {
        Book::create([
            'title' => $request->get('title'),
            'author' => $request->get('author')
        ]);
    }
}
