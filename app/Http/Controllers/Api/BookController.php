<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Http\Resources\BookResource;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
  public function index(Request $request)
  {
    $query = Book::query();

    // Filter by author
    if ($request->has('author')) {
      $query->where('author', 'like', '%' . $request->author . '%');
    }

    // Filter by year
    if ($request->has('year')) {
      $query->where('published_year', $request->year);
    }

    // Search by title
    if ($request->has('search')) {
      $query->where('title', 'like', '%' . $request->search . '%');
    }

    $books = $query->paginate(10);

    return BookResource::collection($books);
  }

  public function store(StoreBookRequest $request)
  {
    $book = Book::create($request->validated());

    return new BookResource($book);
  }

  public function show(Book $book)
  {
    return new BookResource($book);
  }

  public function update(UpdateBookRequest $request, Book $book)
  {
    $book->update($request->validated());

    return new BookResource($book);
  }

  public function destroy(Book $book)
  {
    $book->delete();

    return response()->json(null, 204);
  }
}
