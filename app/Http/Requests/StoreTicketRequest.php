<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTicketRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'movie_title' => 'required|string|max:255',
            'seat_number' => 'required|string|max:10',
            'price' => 'required|numeric',
        ];
    }
}
