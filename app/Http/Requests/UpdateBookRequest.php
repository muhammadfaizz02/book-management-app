<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBookRequest extends FormRequest
{
  public function authorize()
  {
    return true;
  }

  public function rules()
  {
    return [
      'title' => 'sometimes|string|max:255',
      'author' => 'sometimes|string|max:255',
      'published_year' => 'sometimes|digits:4|integer|min:1900|max:' . (date('Y') + 1),
      'isbn' => 'sometimes|string|unique:books,isbn,' . $this->book->id,
      'stock' => 'sometimes|integer|min:0'
    ];
  }
}
