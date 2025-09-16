<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class BookTest extends TestCase
{
  use RefreshDatabase, WithFaker;

  public function test_can_create_book()
  {
    // Create and authenticate user
    $user = User::factory()->create();
    Sanctum::actingAs($user);

    $response = $this->postJson('/api/books', [
      'title' => 'Test Book',
      'author' => 'Test Author',
      'published_year' => 2023,
      'isbn' => '1234567890123',
      'stock' => 5,
    ]);

    $response->assertStatus(201)
      ->assertJson([
        'data' => [
          'title' => 'Test Book',
          'author' => 'Test Author',
          'published_year' => 2023,
          'isbn' => '1234567890123',
          'stock' => 5,
        ]
      ]);
  }

  public function test_cannot_create_book_with_invalid_data()
  {
    $user = User::factory()->create();
    Sanctum::actingAs($user);

    $response = $this->postJson('/api/books', [
      'title' => '',
      'author' => '',
      'published_year' => 'not-a-year',
      'isbn' => '',
      'stock' => -1,
    ]);

    $response->assertStatus(422);
  }

  public function test_can_list_books()
  {
    $user = User::factory()->create();
    Sanctum::actingAs($user);

    Book::factory(5)->create();

    $response = $this->getJson('/api/books');

    $response->assertStatus(200)
      ->assertJsonCount(5, 'data');
  }
}
