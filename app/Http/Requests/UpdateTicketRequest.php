<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTicketRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'movie_title' => 'sometimes|string|max:255',
            'seat_number' => 'sometimes|string|max:10',
            'price' => 'sometimes|numeric',
        ];
    }
}
