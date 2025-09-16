<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLoanRequest;
use App\Http\Resources\LoanResource;
use App\Jobs\SendLoanNotification;
use App\Models\Book;
use App\Models\BookLoan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LoanController extends Controller
{
  public function store(StoreLoanRequest $request)
  {
    $book = Book::findOrFail($request->book_id);

    if ($book->stock <= 0) {
      return response()->json([
        'message' => 'Book is out of stock'
      ], 422);
    }

    $loan = DB::transaction(function () use ($request, $book) {
      // Create loan record
      $loan = BookLoan::create([
        'user_id' => $request->user()->id, // Gunakan user yang terautentikasi
        'book_id' => $request->book_id,
        'loan_date' => now(),
      ]);

      // Decrement book stock
      $book->decrement('stock');

      return $loan;
    });

    // Dispatch job to send notification
    SendLoanNotification::dispatch($loan->load('book', 'user'));

    return new LoanResource($loan->load('book'));
  }

  public function show($user_id, Request $request)
  {
    // Pastikan user hanya bisa melihat pinjamannya sendiri
    if ($request->user()->id != $user_id) {
      return response()->json([
        'message' => 'Unauthorized'
      ], 403);
    }

    $loans = BookLoan::where('user_id', $user_id)
      ->whereNull('return_date')
      ->with('book')
      ->get();

    return LoanResource::collection($loans);
  }
}
