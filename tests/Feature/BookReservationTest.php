<?php

namespace Tests\Feature;

use App\Author;
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
        $response = $this->post('/books', $this->setUpData());

        $this->assertCount(1,Book::all());
        $response->assertRedirect('/books/'.Book::first()->id);
    }

    public function testTitleIsRequired()
    {
        $response = $this->post('/books', array_merge($this->setUpData(), ['title' => '']));

        $response->assertSessionHasErrors('title');
    }

    public function testAuthorIsRequired()
    {
        $response = $this->post('/books', array_merge($this->setUpData(), ['author_id' => '']));

        $response->assertSessionHasErrors('author_id');
    }

    public function testBookCanBeUpdated()
    {
        $this->withoutExceptionHandling();

        $this->post('/books', $this->setUpData());

        $book = Book::first();

        $response = $this->patch('/books/' . $book->id, [
            'title' => 'New title',
            'author_id' => 'New author'
        ]);

        $this->assertEquals('New title', Book::first()->title);
        $this->assertEquals(2, Book::first()->author_id);
        $response->assertRedirect($book->fresh()->path());
    }

    public function testBookCanBeDeleted()
    {
        $this->post('/books', $this->setUpData());

        $book = Book::first();
        $this->assertCount(1, Book::all());

        $response = $this->delete('/books/'.$book->id);
        $this->assertCount(0, Book::all());

        $response->assertRedirect('/books');
    }

    public function testNewAuthorIsAutomatically_added()
    {
        $this->post('/books', $this->setUpData());

        $book = Book::first();
        $author = Author::first();

        $this->assertCount(1, Author::all());
        $this->assertEquals($author->id, $book->author_id);
    }

    protected function setUpData()
    {
        return [
            'title'  => 'Cool Book Title',
            'author_id' => 'Sun',
        ];
    }
}
