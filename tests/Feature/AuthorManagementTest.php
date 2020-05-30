<?php

namespace Tests\Feature;

use App\Author;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class AuthorManagementTest extends TestCase
{
    use RefreshDatabase;

    public function testAuthorCanBeCreated()
    {
        $this->withoutExceptionHandling();

        $response = $this->post('/author', [
            'name' => 'Sun',
            'dob' => '05/11/1999'
        ]);

        $author = Author::all();

        $this->assertCount(1, $author);
        $this->assertInstanceOf(Carbon::class, $author->first()->dob);
        $this->assertEquals('1999/11/05', $author->first()->dob->format('Y/d/m'));
    }
}

