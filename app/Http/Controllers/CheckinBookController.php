<?php

namespace App\Http\Controllers;

use App\Book;

class CheckinBookController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Book $book)
    {
        $book->checkIn(auth()->user());
    }
}
