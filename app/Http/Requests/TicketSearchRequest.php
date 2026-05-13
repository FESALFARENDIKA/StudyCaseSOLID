<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TicketSearchRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'search' => 'sometimes|string',
            'limit' => 'sometimes|integer|min:1',
            'orderBy' => 'sometimes|string|in:id,movie_title,created_at',
            'sortBy' => 'sometimes|string|in:ASC,DESC',
        ];
    }
}
