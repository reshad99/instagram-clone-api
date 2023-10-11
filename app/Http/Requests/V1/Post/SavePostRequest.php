<?php

namespace App\Http\Requests\V1\Post;

use Illuminate\Foundation\Http\FormRequest;

class SavePostRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'media' => 'required|array',
            'media.*' => 'file|mimes:png,jpg,mp4,jpeg,webp,avi',
            'description' => 'required|max:255',
        ];
    }
}
