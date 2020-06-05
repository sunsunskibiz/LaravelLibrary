<?php

namespace App\Http\Controllers;

use App\Book;

class CheckoutBookController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Book $book)
    {
        $book->checkOut(auth()->user());
    }
}
