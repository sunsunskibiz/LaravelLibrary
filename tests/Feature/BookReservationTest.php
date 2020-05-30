<?php

namespace Tests\Feature;

use App\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookReservationTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testABookCanBeAddedToTheLibrary()
    {
        $response = $this->post('/books', [
            'title' => 'Cool Book Title',
            'author' => 'Sun',
        ]);

        $this->assertCount(1,Book::all());
        $response->assertRedirect('/books/'.Book::first()->id);
    }

    public function testTitleIsRequired()
    {
        $response = $this->post('/books', [
            'title' => '',
            'author' => 'Sun',
        ]);

        $response->assertSessionHasErrors('title');
    }

    public function testAuthorIsRequired()
    {
        $response = $this->post('/books', [
            'title' => 'Cool Book Title',
            'author' => '',
        ]);

        $response->assertSessionHasErrors('author');
    }

    public function testBookCanBeUpdated()
    {
        $this->post('/books', [
            'title' => 'Cool Book Title',
            'author' => 'Sun',
        ]);

        $book = Book::first();

        $response = $this->patch('/books/' . $book->id, [
            'title' => 'New title',
            'author' => 'New author'
        ]);

        $this->assertEquals('New title', Book::first()->title);
        $this->assertEquals('New author', Book::first()->author);
        $response->assertRedirect($book->fresh()->path());
    }

    public function testBookCanBeDeleted()
    {
        $this->post('/books', [
            'title' => 'Cool Book Title',
            'author' => 'Sun',
        ]);

        $book = Book::first();
        $this->assertCount(1, Book::all());

        $response = $this->delete('/books/'.$book->id);
        $this->assertCount(0, Book::all());

        $response->assertRedirect('/books');
    }
}
