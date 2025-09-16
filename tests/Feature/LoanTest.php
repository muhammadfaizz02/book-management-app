<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class LoanTest extends TestCase
{
  use RefreshDatabase;

  public function test_can_borrow_book()
  {
    $user = User::factory()->create();
    Sanctum::actingAs($user);

    $book = Book::factory()->create(['stock' => 5]);

    $response = $this->postJson('/api/loans', [
      'book_id' => $book->id,
    ]);

    // Ubah status menjadi 201 karena resource baru dibuat
    $response->assertStatus(201);
    $this->assertEquals(4, $book->fresh()->stock);
  }

  public function test_cannot_borrow_out_of_stock_book()
  {
    $user = User::factory()->create();
    Sanctum::actingAs($user);

    $book = Book::factory()->create(['stock' => 0]);

    $response = $this->postJson('/api/loans', [
      'book_id' => $book->id,
    ]);

    $response->assertStatus(422)
      ->assertJson(['message' => 'Book is out of stock']);
  }

  public function test_can_view_user_loans()
  {
    $user = User::factory()->create();
    Sanctum::actingAs($user);

    $book = Book::factory()->create(['stock' => 5]);

    // Borrow a book first
    $this->postJson('/api/loans', ['book_id' => $book->id]);

    // View user loans
    $response = $this->getJson("/api/loans/{$user->id}");

    $response->assertStatus(200)
      ->assertJsonCount(1);
  }
}
