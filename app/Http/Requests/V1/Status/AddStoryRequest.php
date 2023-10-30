<?php

namespace App\Http\Requests\V1\Status;

use Illuminate\Foundation\Http\FormRequest;

class AddStoryRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'text' => 'required|max:255',
            'media' => 'required|file|mimes:png,jpg,jpeg,webp',
        ];
    }
}
