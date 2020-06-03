<?php

namespace Tests\Unit;

use App\Book;
use App\Reservation;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookReservationTest extends TestCase
{
    use RefreshDatabase;

    public function testBookCanBeCheckedOut()
    {
        $book = factory(Book::class)->create();
        $user = factory(User::class)->create();

        $book->checkout($user);

        $this->assertCount(1, Reservation::all());
        $this->assertEquals($book->id, Reservation::first()->book_id);
        $this->assertEquals($user->id, Reservation::first()->user_id);
        $this->assertEquals(now(), Reservation::first()->checked_out_at);
    }

    // a book can be returned
    public function testBookCanBeReturned()
    {
        $book = factory(Book::class)->create();
        $user = factory(User::class)->create();

        $book->checkout($user);
        $book->checkin($user);

        $this->assertCount(1, Reservation::all());
        $this->assertEquals($book->id, Reservation::first()->book_id);
        $this->assertEquals($user->id, Reservation::first()->user_id);
        $this->assertNotNull(Reservation::first()->checked_in_at);
        $this->assertEquals(now(), Reservation::first()->checked_in_at);
    }

    // if not check out exception is thrown
    public function testIfNotCheckOutBeforeCheckIn()
    {
        $this->expectException(\Exception::class);

        $user = factory(User::class)->create();
        $book = factory(Book::class)->create();

        $book->checkout($user);
        $book->checkin($user);
        $book->checkin($user);

    }


    // a user can check out a book twice
    public function testUserCanCheckOutBookTwice()
    {
        $book = factory(Book::class)->create();
        $user = factory(User::class)->create();

        $book->checkout($user);
        $book->checkin($user);

        $book->checkout($user);

        $this->assertCount(2, Reservation::all());
        $this->assertEquals($book->id, Reservation::find(2)->book_id);
        $this->assertEquals($user->id, Reservation::find(2)->user_id);
        $this->assertEquals(now(), Reservation::first()->checked_in_at);
        $this->assertEquals(now(), Reservation::find(2)->checked_out_at);
        $this->assertNull(Reservation::find(2)->checked_in_at);
    }
}
