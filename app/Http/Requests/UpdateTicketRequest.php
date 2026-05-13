<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTicketRequest extends FormRequest
{
    public function authorize() { return true; }

    public function rules()
    {
        return [
            'movie_title' => 'sometimes|string',
            'show_time' => 'sometimes|date',
            'price' => 'sometimes|numeric',
        ];
    }
}
