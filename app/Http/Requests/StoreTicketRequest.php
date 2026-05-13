<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTicketRequest extends FormRequest
{
    public function authorize() { return true; }

    public function rules()
    {
        return [
            'movie_title' => 'required|string',
            'show_time' => 'required|date',
            'price' => 'required|numeric',
        ];
    }
}
