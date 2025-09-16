<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookLoan extends Model
{
  use HasFactory;

  protected $table = 'book_loans';

  protected $fillable = [
    'user_id',
    'book_id',
    'loan_date',
    'return_date'
  ];

  protected $casts = [
    'loan_date' => 'date',
    'return_date' => 'date'
  ];

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function book()
  {
    return $this->belongsTo(Book::class);
  }
}
