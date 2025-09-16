<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Book extends Model
{
  use HasFactory;

  protected $fillable = [
    'title',
    'author',
    'published_year',
    'isbn',
    'stock'
  ];

  protected $casts = [
    'published_year' => 'integer',
    'stock' => 'integer'
  ];

  public function users(): BelongsToMany
  {
    return $this->belongsToMany(User::class, 'book_loans')
      ->withPivot('loan_date', 'return_date')
      ->withTimestamps();
  }

  public function currentLoans()
  {
    return $this->users()->wherePivot('return_date', null);
  }
}
