<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
  public function toArray(Request $request): array
  {
    return [
      'id' => $this->id,
      'title' => $this->title,
      'author' => $this->author,
      'published_year' => $this->published_year,
      'isbn' => $this->isbn,
      'stock' => $this->stock,
      'available' => $this->stock > 0,
      'created_at' => $this->created_at,
      'updated_at' => $this->updated_at,
    ];
  }
}
