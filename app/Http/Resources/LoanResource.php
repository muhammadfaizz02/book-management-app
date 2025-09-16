<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LoanResource extends JsonResource
{
  public function toArray(Request $request): array
  {
    return [
      'id' => $this->id,
      'user_id' => $this->user_id,
      'book_id' => $this->book_id,
      'book_title' => $this->book->title,
      'loan_date' => $this->loan_date,
      'return_date' => $this->return_date,
      'created_at' => $this->created_at,
      'updated_at' => $this->updated_at,
    ];
  }
}
